<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

use Spatie\MediaLibrary\Conversions\FileManipulator;

use App\Enums\{AnimalStates, ModerationStates, PublicationStates, ResponseTypes, CommentStates};

use App\Models\{Animal, Breed, Company, Moderation, Post, ProfessionnalActivity, Response, Species, Comment, User, UsersViews};

use App\Support\{ModerationAnimalDenyReasons, ModerationCompanyDenyReasons, ModerationPostDenyReasons, ModerationProfessionnalActivityDenyReasons, ModerationCommentDenyReasons, ModerationUserDenyReasons};

class ModerationController extends Controller
{
	/**
	 * Moderation index
	 */
	public function index(): view
	{
		return view('admin.moderations.index');
	}

	public function moderate(Moderation $moderation): View
	{
		if($moderation->model instanceof Animal) {
			$type = 'animal';
			$reasons = ModerationAnimalDenyReasons::options();
		}
		elseif($moderation->model instanceof Company) {
			$type = 'company';
			$reasons = ModerationCompanyDenyReasons::options();
		}
		elseif($moderation->model instanceof Post) {
			$type = 'post';
			$reasons = ModerationPostDenyReasons::options();
		}
		elseif($moderation->model instanceof ProfessionnalActivity) {
			$type = 'professionnal-activity';
			$reasons = ModerationProfessionnalActivityDenyReasons::options();
		}
		elseif($moderation->model instanceof Comment) {
			$type = 'comment';
			$reasons = ModerationCommentDenyReasons::options();
		}
		elseif($moderation->model instanceof User) {
			$type = 'user';
			$reasons = ModerationUserDenyReasons::options();
		}

		return view('admin.moderations.moderate', [
			'moderation' => $moderation,
			'type' => $type,
			'reasons' => $reasons
		]);
	}

	public function updateComment(Request $request): RedirectResponse
	{
		$moderation = Moderation::find($request->moderation_id);

		if($moderation) {
			$moderation->model->content = $request->input('newContent');
			$moderation->model->save();

			return redirect()->route('admin.moderations.moderate', ['moderation' => $moderation]);
		}
	}

	public function preview(Moderation $moderation): View
	{
		$company = $moderation->model;
		$name = data_get($moderation->model->values, 'for_moderation.name') ? data_get($moderation->model->values, 'for_moderation.name') : $moderation->model->name;
		$userId = $moderation->model->user->id;
		$breeds = data_get($moderation->model->values, 'for_moderation.breeds') ? $moderation->model->constructBreedsFromModeration() : $moderation->model->breeds;
		$addressMain = $moderation->model->addressForModeration ? $moderation->model->displayPartOfAddressForModeration('department+country') : $moderation->model->displayPartOfAddress('department+country');
		$addressPart = $moderation->model->addressForModeration ? $moderation->model->displayPartOfAddressForModeration('department+zipcode+city') : $moderation->model->displayPartOfAddress('department+zipcode+city');
		$medias = [];
		$hasContacted = false;
		$response = new Response;

		if($company->offer()->hasOption('contact-button')) {
			if(Auth::guard('web')->check()) {
				$hasContacted = Auth::guard('web')->user()->hasContacted($company);

				if($hasContacted) {
					$response = Response::whereHasMorph('model', [Company::class], function($whereHasMorph) use($company) {
							$whereHasMorph->where('id', $company->id);
						})
						->whereHas('from', function($whereHas) {
							$whereHas->where('id', Auth::guard('web')->user()->id);
						})
						->whereHas('to', function($whereHas) use($company) {
							$whereHas->where('id', $company->user->id);
						})
						->where('type', ResponseTypes::Messaging)
						->first();
				}

				UsersViews::firstOrCreate([
					'user_id' => Auth::guard('web')->user()->id,
					'element_type' => Company::class,
					'element_id' => $company->id
				]);
			}
		}

		foreach($company->getMedia('photos') as $photo) {
			array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
		}

		if($company->values->has('videos')) {
			foreach($company->values->get('videos') as $value) {
				array_push($medias, ['type' => 'video', 'url' => $value]);
			}
		}

		$companiesUrl = $company->species->first()->getTranslation('slug', 'en') === 'dog' ? 'company-search.dog-companies' : 'company-search.cat-companies';
		$breadcrumb = [
			['title' => 'Élevages', 'url' => $companiesUrl],
		];

		return view('admin.moderations.preview', [
			'addressMain' => $addressMain,
			'addressPart' => $addressPart,
			'breadcrumb' => $breadcrumb,
			'company' => $company,
			'breeds' => $breeds,
			'description' => $moderation->model->description,
			'hasContacted' => $hasContacted,
			'logo' => $company->getFirstMedia('logo'),
			'medias' => json_encode($medias),
			'name' => $name,
			'photos' => $company->getMedia('photos'),
			'response' => $response,
			'userId' => $moderation->model->user->id,
		]);
	}

	public function validateAnimal(Animal $animal, $withPostValidation = false): void
	{
		if($animal->values->has('for_moderation')) {
			$forModerationValues = $animal->values->get('for_moderation');
			$values = $animal->values;

			if(isset($forModerationValues['name'])) $animal->name = $forModerationValues['name'];
			if(isset($forModerationValues['description'])) $animal->description = $forModerationValues['description'];
			if(isset($forModerationValues['identification'])) $values->put('identification', $forModerationValues['identification']);
			if(isset($forModerationValues['lof_number'])) $values->put('lof_number', $forModerationValues['lof_number']);
			if(isset($forModerationValues['price'])) $values->put('price', $forModerationValues['price']);

			$animal->removeValue('for_moderation');
			$animal->save();
		}

		if($withPostValidation) {
			$animal->published_at = Carbon::now();
			$animal->refreshed_at = Carbon::now();
			$animal->save();
		}
	}

	public function denyAnimal(Animal $animal): void
	{
		if($animal->values->has('for_moderation')) {
			$animal->removeValue('for_moderation');
			$animal->save();
		}
	}

	public function validateCompany(Company $company): void
	{
		$lastPublication = $company->lastPublication;
		$creditConsumed = false;
		$updateOnly = false;

		// Si l'offre est gratuite on a un crédit à consomer dans tous les cas
		// si c'est une modification de contenu de la page entreprise, on doit pas retirer de crédit
		// mais on doit ajouter une ligne de publication avec la date précédente
		// donc si c'est une publication, ou un upgrade, c'est +1 an
		// sinon, on garde la date de la publication précédente
		if($lastPublication->state != PublicationStates::PublishedUpdatedWaitingModeration) $creditConsumed = $company->consumeCredit();
		else $updateOnly = true;

		if($creditConsumed || $updateOnly) {
			if($creditConsumed) {
				$endDate = $lastPublication->subscription->offer->free ? null : Carbon::now()->addYear();
				$subscription = $creditConsumed;
			}
			elseif($updateOnly) {
				$subscription = $lastPublication->subscription;
				$endDate = $subscription->offer->free ? null : $subscription->end_date;
			}

			$company->publications()->create([
				'user_id' => $company->user->id,
				'subscription_id' => $subscription->id,
				'state' => PublicationStates::Published,
				'end_date' => $endDate
			]);

			if($company->breeders->isNotEmpty()) {
				foreach($company->breeders as $breeder) {
					if(!$breeder->lastModeration) {
						$breeder->markForModeration();
						$breeder->load('lastModeration');
					}

					if($breeder->lastModeration->isWaiting()) {
						$breeder->moderations()->create([
							'admin_id' => Auth::guard('admin')->user()->id,
							'state' => ModerationStates::Validated
						]);

						$this->validateAnimal($breeder);
					}
				}
			}

			if($company->values->has('for_moderation')) {
				$forModerationValues = $company->values->get('for_moderation');
				$values = $company->values;

				if(isset($forModerationValues['name'])) {
					$company->name = $forModerationValues['name'];
					$company->generateSlug();
				}

				if(isset($forModerationValues['description'])) $company->description = $forModerationValues['description'];

				if(isset($forModerationValues['affix']) || isset($forModerationValues['affix_name'])) {
					if(isset($forModerationValues['affix'])) $values->put('affix', $forModerationValues['affix']);
					if(isset($forModerationValues['affix_name'])) $values->put('affix_name', $forModerationValues['affix_name']);

					if($company->animals->isNotEmpty()) {
						foreach($company->animals as $animal) {
							$animalValues = $animal->values;

							if(isset($forModerationValues['affix'])) $animalValues->put('affix', $forModerationValues['affix']);
							if(isset($forModerationValues['affix_name'])) $animalValues->put('affix_name', $forModerationValues['affix_name']);

							$animal->values = $animalValues;
							$animal->save();
						}
					}
				}

				if(isset($forModerationValues['cat_facebook'])) $values->put('cat_facebook', $forModerationValues['cat_facebook']);
				if(isset($forModerationValues['cat_instagram'])) $values->put('cat_instagram', $forModerationValues['cat_instagram']);
				if(isset($forModerationValues['dog_facebook'])) $values->put('dog_facebook', $forModerationValues['dog_facebook']);
				if(isset($forModerationValues['dog_instagram'])) $values->put('dog_instagram', $forModerationValues['dog_instagram']);
				if(isset($forModerationValues['videos'])) $values->put('videos', $forModerationValues['videos']);
				if(isset($forModerationValues['breeds'])) {
					$company->breeds()->detach();

					foreach($forModerationValues['breeds'] as $slug) {
						$breed = Breed::findBySlug($slug);

						if($breed) $company->breeds()->syncWithoutDetaching($breed->id);
					}
				}

				$company->values = $values;
				$company->removeValue('for_moderation');
				$company->save();
			}

			if($company->addressForModeration) {
				$company->address->delete();
				$company->addressForModeration()->update(['for_moderation' => false]);
			}
		}
		else $company->markForModeration();
	}

	public function denyCompany(Company $company): void
	{
		if($company->values->has('for_moderation')) {
			$company->removeValue('for_moderation');
			$company->save();
		}
	}

	public function validatePost(Post $post, bool $canSendEmail = false): void
	{
		$lastPublication = $post->lastPublication;
		$creditConsumed = false;
		$updateOnly = false;

		// Si l'offre est gratuite on a un crédit à consomer dans tous les cas
		// si c'est une modification de contenu de l'annonce, on doit pas retirer de crédit
		// mais on doit ajouter une ligne de publication avec la date précédente
		// donc si c'est une publication c'est +3 mois
		// sinon, on garde la date de la publication précédente
		if($lastPublication->state != PublicationStates::PublishedUpdatedWaitingModeration) $creditConsumed = $post->consumeCredit();
		else $updateOnly = true;

		if($creditConsumed || $updateOnly) {
			if($creditConsumed) {
				$endDate = $lastPublication->subscription->offer->free ? null : Carbon::now()->addMonths(3);
				$subscription = $creditConsumed;
			}
			elseif($updateOnly) {
				$subscription = $lastPublication->subscription;
				$endDate = $subscription->offer->free ? null : $subscription->end_date;
			}

			$post->publications()->create([
				'user_id' => $post->user->id,
				'subscription_id' => $subscription->id,
				'state' => PublicationStates::Published,
				'end_date' => $endDate
			]);

			// In a post of type 'litter', we need to add a validated moderation to every animal composing the post that are waiting for a moderation
			if($post->type->getTranslation('slug', 'en') == 'litter' || $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				$mother = $post->model->mother;

				if(!$mother->lastModeration) {
					$mother->markForModeration();
					$mother->load('lastModeration');
				}

				if($mother->lastModeration->isWaiting()) {
					$mother->moderations()->create([
						'admin_id' => Auth::guard('admin')->user()->id,
						'state' => ModerationStates::Validated
					]);

					$this->validateAnimal($mother);
				}

				$father = $post->model->father;

				if(!$father->lastModeration) {
					$father->markForModeration();
					$father->load('lastModeration');
				}

				if($father->lastModeration->isWaiting()) {
					$father->moderations()->create([
						'admin_id' => Auth::guard('admin')->user()->id,
						'state' => ModerationStates::Validated
					]);

					$this->validateAnimal($father);
				}

				if($post->model->secondFather) {
					$secondFather = $post->model->secondFather;

					if(!$secondFather->lastModeration) {
						$secondFather->markForModeration();
						$secondFather->load('lastModeration');
					}

					if($secondFather->lastModeration->isWaiting()) {
						$secondFather->moderations()->create([
							'admin_id' => Auth::guard('admin')->user()->id,
							'state' => ModerationStates::Validated
						]);

						$this->validateAnimal($secondFather);
					}
				}

				if($post->type->getTranslation('slug', 'en') == 'litter') {
					foreach($post->model->animals as $child) {
						if(!$child->lastModeration) {
							$child->markForModeration();
							$child->load('lastModeration');
						}

						if($child->lastModeration->isWaiting()) {
							$child->moderations()->create([
								'admin_id' => Auth::guard('admin')->user()->id,
								'state' => ModerationStates::Validated
							]);

							$this->validateAnimal($child, true);
						}
					}

					if($post->model->values->has('for_moderation')) {
						$forModerationValues = $post->model->values->get('for_moderation');
						$values = $post->model->values;

						if(isset($forModerationValues['description'])) $values->put('description', $forModerationValues['description']);
						if(isset($forModerationValues['litter_number'])) $values->put('litter_number', $forModerationValues['litter_number']);
						if(isset($forModerationValues['birth_place'])) $values->put('birth_place', $forModerationValues['birth_place']);
						if(isset($forModerationValues['birth_place_value'])) $values->put('birth_place_value', $forModerationValues['birth_place_value']);
						if(isset($forModerationValues['social_network_description'])) $values->put('social_network_description', $forModerationValues['social_network_description']);

						$post->model->removeValue('for_moderation');
						$post->model->save();
					}
				}
				elseif($post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					if($post->model->values->has('for_moderation')) {
						$forModerationValues = $post->model->values->get('for_moderation');
						$values = $post->model->values;

						if(isset($forModerationValues['description'])) $values->put('description', $forModerationValues['description']);
						if(isset($forModerationValues['expected_birth_date'])) $values->put('expected_birth_date', $forModerationValues['expected_birth_date']);
						if(isset($forModerationValues['price'])) $values->put('price', $forModerationValues['price']);
						if(isset($forModerationValues['social_network_description'])) $values->put('social_network_description', $forModerationValues['social_network_description']);

						$post->model->removeValue('for_moderation');
						$post->model->save();
					}
				}
			}
			elseif($post->type->getTranslation('slug', 'en') == 'retired-breeder') {
				$retiredBreeder = $post->model;

				if(!$retiredBreeder->lastModeration) {
					$retiredBreeder->markForModeration();
					$retiredBreeder->load('lastModeration');
				}

				if($retiredBreeder->lastModeration->isWaiting()) {
					$retiredBreeder->moderations()->create([
						'admin_id' => Auth::guard('admin')->user()->id,
						'state' => ModerationStates::Validated
					]);

					$this->validateAnimal($retiredBreeder, true);
				}

				if($post->values->has('for_moderation')) {
					$forModerationValues = $post->values->get('for_moderation');
					$values = $post->values;

					if(isset($forModerationValues['price'])) $values->put('price', $forModerationValues['price']);
					if(isset($forModerationValues['description'])) $values->put('description', $forModerationValues['description']);
					if(isset($forModerationValues['social_network_description'])) $values->put('social_network_description', $forModerationValues['social_network_description']);

					$post->removeValue('for_moderation');
					$post->save();
				}
			}
			elseif($post->type->getTranslation('slug', 'en') == 'stud') {
				$stud = $post->model;

				if(!$stud->lastModeration) {
					$stud->markForModeration();
					$stud->load('lastModeration');
				}

				if($stud->lastModeration->isWaiting()) {
					$stud->moderations()->create([
						'admin_id' => Auth::guard('admin')->user()->id,
						'state' => ModerationStates::Validated
					]);

					$this->validateAnimal($stud, true);
				}

				if($post->values->has('for_moderation')) {
					$forModerationValues = $post->values->get('for_moderation');
					$values = $post->values;

					if(isset($forModerationValues['price'])) $values->put('price', $forModerationValues['price']);
					if(isset($forModerationValues['description'])) $values->put('description', $forModerationValues['description']);
					if(isset($forModerationValues['social_network_description'])) $values->put('social_network_description', $forModerationValues['social_network_description']);

					$post->removeValue('for_moderation');
					$post->save();
				}
			}

			$post->published_at = Carbon::now();
			$post->refreshed_at = Carbon::now();
			$post->archived_at = $endDate;
			$post->save();

			if($canSendEmail) $post->sendPublicationEmail();
		}
		else $post->markForModeration();
	}

	public function denyPost(Post $post): void
	{
		// In a post of type 'litter', we need to add a denied moderation to every animal composing the post that are waiting for a moderation
		if($post->type->getTranslation('slug', 'en') == 'litter'|| $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
			if($post->model->values->has('for_moderation')) {
				$post->model->removeValue('for_moderation');
				$post->model->save();
			}
		}
		elseif($post->type->getTranslation('slug', 'en') == 'retired-breeder' || $post->type->getTranslation('slug', 'en') == 'stud') {
			if($post->values->has('for_moderation')) {
				$post->removeValue('for_moderation');
				$post->save();
			}
		}
	}

	public function validateProfessionnalActivity(ProfessionnalActivity $professionnalActivity, bool $canSendEmail = false): void
	{
		$lastPublication = $professionnalActivity->lastPublication;
		$creditConsumed = false;
		$updateOnly = false;

		// Si l'offre est gratuite on a un crédit à consomer dans tous les cas
		// si c'est une modification de contenu de l'annonce, on doit pas retirer de crédit
		// mais on doit ajouter une ligne de publication avec la date précédente
		// donc si c'est une publication c'est +3 mois
		// sinon, on garde la date de la publication précédente
		if($lastPublication->state != PublicationStates::PublishedUpdatedWaitingModeration) $creditConsumed = $professionnalActivity->consumeCredit();
		else $updateOnly = true;

		if($creditConsumed || $updateOnly) {
			if($creditConsumed) {
				$endDate = $lastPublication->subscription->offer->free ? null : Carbon::now()->addYears(1);
				$subscription = $creditConsumed;
			}
			elseif($updateOnly) {
				$subscription = $lastPublication->subscription;
				$endDate = $subscription->offer->free ? null : $subscription->end_date;
			}

			$professionnalActivity->publications()->create([
				'user_id' => $professionnalActivity->user->id,
				'subscription_id' => $subscription->id,
				'state' => PublicationStates::Published,
				'end_date' => $endDate
			]);

			if($professionnalActivity->values->has('for_moderation')) {
				$forModerationValues = $professionnalActivity->values->get('for_moderation');
				$values = $professionnalActivity->values;

				if(isset($forModerationValues['name'])) $professionnalActivity->name = $forModerationValues['name'];
				if(isset($forModerationValues['description'])) $professionnalActivity->description = $forModerationValues['description'];
				if(isset($forModerationValues['website'])) $values->put('website', $forModerationValues['website']);
				if(isset($forModerationValues['instagram'])) $values->put('instagram', $forModerationValues['instagram']);
				if(isset($forModerationValues['facebook'])) $values->put('facebook', $forModerationValues['facebook']);
				if(isset($forModerationValues['activity_solution_details'])) $values->put('activity_solution_details', $forModerationValues['activity_solution_details']);
				if(isset($forModerationValues['species'])) {
					$professionnalActivity->species()->detach();
					$professionnalActivity->species()->syncWithoutDetaching($forModerationValues['species']);
				}

				if(isset($forModerationValues['activity_solutions'])) {
					$professionnalActivity->activitySolutions()->detach();
					$professionnalActivity->activitySolutions()->syncWithoutDetaching($forModerationValues['activity_solutions']);
				}

				$professionnalActivity->removeValue('for_moderation');
				$professionnalActivity->save();
			}

			if($professionnalActivity->addressForModeration) {
				$collection = $professionnalActivity->addressForModeration->collection;
					$professionnalActivity->address()->where('collection', $collection)->delete();
					$professionnalActivity->addressForModeration()->where('collection', $collection)->update(['for_moderation' => false]);
			}

			$professionnalActivity->published_at = Carbon::now();
			$professionnalActivity->archived_at = $endDate;
			$professionnalActivity->save();

			if($canSendEmail) $professionnalActivity->sendPublicationEmail();
		}
		else $professionnalActivity->markForModeration();
	}

	public function denyProfessionnalActivity(ProfessionnalActivity $professionnalActivity): void
	{
		if($professionnalActivity->values->has('for_moderation')) {
			$professionnalActivity->removeValue('for_moderation');
			$professionnalActivity->save();
		}
	}

	public function validateUser(User $user): void
	{
		if($user->hasRole(['professionnal', 'professionnal_breeder'])) {
			if($user->values->has('for_moderation')) {
				$forModerationValues = $user->values->get('for_moderation');
				$values = $user->values;

				if(isset($forModerationValues['siret'])) $values->put('siret', $forModerationValues['siret']);
				if(isset($forModerationValues['company_name'])) $values->put('company_name', $forModerationValues['company_name']);

				$user->values = $values;
				$user->removeValue('for_moderation');
				$user->save();
			}
		}
	}

	public function denyUser(User $user): void
	{
		if($user->hasRole(['professionnal', 'professionnal_breeder'])) {
			if($user->values->has('for_moderation')) {
				$user->removeValue('for_moderation');
				$user->save();
			}
		}
	}

	public function decision(Request $request): RedirectResponse
	{
		$moderation = Moderation::find($request->moderation_id);

		if($moderation) {
			$newModeration = new Moderation;
			$newModeration->model()->associate($moderation->model);

			if($request->decision == 'validated') {
				$newModeration->state = ModerationStates::Validated;

				if($moderation->model instanceof Animal) $this->validateAnimal($moderation->model);
				elseif($moderation->model instanceof Company) {
					// First ever publication of the company, so we need to check if the user has been validated in order to publish the company
					if($moderation->model->user->lastModeration?->isValidated()) {
						// In a company, we need to add a validated moderation to every animal composing the company that are waiting for a moderation
						$this->validateCompany($moderation->model);

						if($moderation->model->hasBeenPublished()) {
							$postsWaitingFirstPublication = $moderation->model->user->posts()->whereHas('lastModeration', function($whereHas) {
									$whereHas->where('state', ModerationStates::Validated);
								})
								->whereHas('lastPublication', function($whereHas) {
									$whereHas->where('state', PublicationStates::DraftWaitingModerationForPublication);
								})
								->get();

							if($postsWaitingFirstPublication->isNotEmpty()) {
								foreach($postsWaitingFirstPublication as $post) {
									$this->validatePost($post, true);
								}
							}
						}
					}
				}
				elseif($moderation->model instanceof Post) {
					// In order to publish a post, the company and the user must have been moderated (and validated)
					if(($moderation->model->user->company && $moderation->model->user->company->hasBeenValidated() && $moderation->model->user->company->isPublished()) && $moderation->model->user->hasBeenValidated()) {
						$this->validatePost($moderation->model);
					}
				}
				elseif($moderation->model instanceof ProfessionnalActivity) {
					// In order to publish a professionnal activity, the user must have been moderated (and validated)
					if(($moderation->model->user->hasRole(['professionnal_breeder', 'individual_breeder']) && $moderation->model->user->hasBeenValidated()) || $moderation->model->user->hasRole('professionnal')) $this->validateProfessionnalActivity($moderation->model);
				}
				elseif($moderation->model instanceof Comment) {
					if($request->input('newContent')) $moderation->model->content = $request->input('newContent');

					$moderation->model->state = CommentStates::Published;
					$moderation->model->save();
				}
				elseif($moderation->model instanceof User) {
					$this->validateUser($moderation->model);

					if($moderation->model->hasRole(['professionnal_breeder', 'individual_breeder'])) {
						// If the user has a company we check if it was waiting for the user moderation in order to be published
						if($moderation->model->company && $moderation->model->company->lastPublication->isDraftWaitingModerationForPublication() && $moderation->model->company->lastModeration->isValidated()) {
							$this->validateCompany($moderation->model->company);

							// If there are posts that are waiting for publication because of the moderation of the user
							$postsWaitingFirstPublication = $moderation->model->posts()->whereHas('lastModeration', function($whereHas) {
									$whereHas->where('state', ModerationStates::Validated);
								})
								->whereHas('lastPublication', function($whereHas) {
									$whereHas->where('state', PublicationStates::DraftWaitingModerationForPublication);
								})
								->get();

							if($postsWaitingFirstPublication->isNotEmpty()) {
								foreach($postsWaitingFirstPublication as $post) {
									$this->validatePost($post, true);
								}
							}

							// If there are activities that are waiting for publication because of the moderation of the user
							$professionnalActivitiesWaitingFirstPublication = $moderation->model->professionnalActivities()->whereHas('lastModeration', function($whereHas) {
									$whereHas->where('state', ModerationStates::Validated);
								})
								->whereHas('lastPublication', function($whereHas) {
									$whereHas->where('state', PublicationStates::DraftWaitingModerationForPublication);
								})
								->get();

							if($professionnalActivitiesWaitingFirstPublication->isNotEmpty()) {
								foreach($professionnalActivitiesWaitingFirstPublication as $professionnalActivity) {
									$this->validateProfessionnalActivity($professionnalActivity, true);
								}
							}
						}
					}
				}
			}
			elseif($request->decision == 'denied') {
				$newModeration->state = ModerationStates::Denied;
				$newModeration->reason = $request->reason;
				$newModeration->description = $request->description;

				if($moderation->model instanceof Animal) $this->denyAnimal($moderation->model);
				elseif($moderation->model instanceof Company) $this->denyCompany($moderation->model);
				elseif($moderation->model instanceof Post) $this->denyPost($moderation->model);
				elseif($moderation->model instanceof ProfessionnalActivity) $this->denyProfessionnalActivity($moderation->model);
				elseif($moderation->model instanceof Comment) {
					$moderation->model->state = CommentStates::Denied;
					$moderation->model->save();
				}
				elseif($moderation->model instanceof User) $this->denyUser($moderation->model);
			}

			// We clean the sensitive files whatever the decision.
			if($moderation->model instanceof User) {
				if($moderation->model->hasRole(['professionnal_breeder', 'individual_breeder', 'professionnal'])) {
					if(!is_null($moderation->model->values->get('identity_card')) && Storage::disk('private')->exists($moderation->model->values->get('identity_card'))) {
						Storage::disk('private')->delete($moderation->model->values->get('identity_card'));
					}

					if(!is_null($moderation->model->values->get('siren_document')) && Storage::disk('private')->exists($moderation->model->values->get('siren_document'))) {
						Storage::disk('private')->delete($moderation->model->values->get('siren_document'));
					}

					if(!is_null($moderation->model->values->get('home_document')) && Storage::disk('private')->exists($moderation->model->values->get('home_document'))) {
						Storage::disk('private')->delete($moderation->model->values->get('home_document'));
					}

					if(!empty($moderation->model->values->get('acaced_certificates'))) {
						foreach($moderation->model->values->get('acaced_certificates') as $acacedCertificate) {
							if(!is_null($acacedCertificate)) {
								if(Storage::disk('private')->exists($acacedCertificate)) Storage::disk('private')->delete($acacedCertificate);
							}
						}

						$moderation->model->save();
					}

					$moderation->save();
				}
			}

			$newModeration->admin_id = Auth::guard('admin')->user()->id;
			$newModeration->save();

			return redirect(route('admin.moderations.index'))->with('success', __('Moderation saved successfully'));
		}
		else return redirect(route('admin.moderations.index'))->with('error', __('Moderation not found'));
	}
}
