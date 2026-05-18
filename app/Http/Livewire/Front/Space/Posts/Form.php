<?php

namespace App\Http\Livewire\Front\Space\Posts;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Enums\{AnimalSexes, AnimalStates, ProtrusionTypes, PublicationStates};

use App\Models\{Animal, Company, Crossing, Litter, Media, Mediable, Offer, Post, PostType, Subscription, User};

class Form extends Component
{
	// Entities
	public Animal $animal;
	public Company $company;
	public Litter $litter;
	public Mediable $mediable;
	public Offer $offer;
	public Post $post;
	public PostType $postType;
	public Subscription $subscription;
	public User $user;

	// Properties
	public $postTypes;
	public $speciesSelected;
	public $postTypeSelected;
	public $litterType;
	public $expectedBirthDate;
	public $birthDate;
	public $availabilityDate;
	public $litterNumber;
	public $birthPlace = 'company';
	public $birthPlaceValue;
	public $maleCount = 0;
	public $femaleCount = 0;
	public $litterChildren;
	public $socialNetworkDescription;
	public $changeHasBeenMade = false;
	public $lastPublication;
	public $postState;
	public $active = 1;
	public $totalSteps = 2;
	public $subComponentKey = 0;
	public $secondMaleToLitter = 'no';
	public $onlyPureBreed = false;
	public $allowUpdate = true;
	public $creditAvailable = 0;
	public $canCreateLitters;
	public $canCreateLitter;
	public $canCreateLitterYetToCome;

	// For Retired-breeder & stud
	public $breedersAvailable;
	public $animalSelected;
	public $retiredBreeder;
	public $isSterilized = false;
	public $price;
	public $description;
	public $mediasLeft;
	public $photoCount;

	// For Stud
	public $stud;
	public $quotation = 1;
	public $protrusionTypes;
	public $protrusionType = [];
	public $enhancer;
	public $geneColor;
	public $averageLitterSize;

	// For litter and litter-yet-to-come
	public $mediableClassPhoto;
	public $mediableIdPhoto;

	// Female
	public $femalesAvailable;
	public $femaleSelected;
	public $female;
	public $breedOfFemale;
	public $isFemaleLOF = false;

	// Males
	public $firstBreedersOfUsersCompanyAvailable;
	public $secondBreedersOfUsersCompanyAvailable;
	public $firstMalesBreedersOfBreedAvailable;
	public $secondMalesBreedersOfBreedAvailable;

	// First male
	public $firstMaleOwnership = 'yes';
	public $firstMaleSelected;
	public $firstMale;
	public $hideFirstMale = 'no';
	public $breedsAvailableForFirstMale = [];

	// Second male
	public $secondMaleOwnership = 'yes';
	public $secondMaleSelected;
	public $secondMale;
	public $hideSecondMale = 'no';
	public $breedsAvailableForSecondMale = [];

	// User Values
	public $userInterestedIn;

	protected function rules()
	{
		return [
			'speciesSelected' => [],
			'postTypeSelected' => [],
			'litterType' => [],
			'female' => [],
			'firstMale' => [],
			'secondMale' => [],
			'birthDate' => [],
			'availabilityDate' => [],
			'litterNumber' => [],
			'maleCount' => [],
			'femaleCount' => [],
			'socialNetworkDescription' => [],
			'retiredBreeder' => [],
			'isSterilized' => [],
			'price' => [],
			'description' => [],
			'quotation' => [],
			'protrusionType' => [],
			'enhancer' => [],
			'geneColor' => [],
			'averageLitterSize' => []
		];
	}

	#[On('new-breeder-associated')]
	public function newBreederAssociated(string $slug)
	{
		$animal = Animal::findBySlug($slug);

		if($animal && $animal->company && $animal->company->id == $this->user->company->id) {
			$this->user->load('company');

			if($this->postType->getTranslation('slug', 'en') == 'litter' || $this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				if($animal->values->get('sex') === AnimalSexes::Female->value) {
					if($this->user->hasRole('professionnal_breeder')) $this->femalesAvailable = $this->user->company->getFemaleBreedersOfSpecies($this->speciesSelected);
					elseif($this->user->hasRole('individual_breeder')) $this->femalesAvailable = $this->user->company->getPureBreedFemaleBreedersOfSpecies($this->speciesSelected);
				}
				$this->loadBreedersOfUsersCompany();
			}
			elseif($this->postType->getTranslation('slug', 'en') == 'retired-breeder') $this->getCompanyInactiveBreedersOfSpecies();
			elseif($this->postType->getTranslation('slug', 'en') == 'stud') $this->getActiveBreedersOfSpecies();

			session()->flash('success', __('Breeder :animal created successfully', ['animal' => $animal->getConstructedName()]));
		}
	}

	#[On('animal-without-company-created')]
	public function newAnimalWithoutCompany()
	{
		$this->loadBreedersOfBreedAvailable();
	}

	#[On('media-added')]
	public function mediaAdded()
	{
		$this->countPostPhotos();
	}

	#[On('media-deleted')]
	public function mediaDeleted()
	{
		$this->countPostPhotos();
	}

	public function goto($index)
	{
		$this->active = $index;
	}

	public function previous()
	{
		if($this->postState == 'create' && $this->active == 3) return redirect()->route('space.posts.update', ['post' => $this->post->slug]);

		$this->active--;
	}

	public function countPostPhotos()
	{
		if($this->postState == 'create') $this->photoCount = Auth::guard('web')->user()->mediable->find($this->mediableIdPhoto)->media->count();
		elseif($this->postState == 'update') $this->photoCount = $this->post->getMedia('photos'.$this->post->id)->count();

		$this->mediasLeft = $this->post->values?->has('identifiant') ? 20 - $this->photoCount : $this->offer->getMaxPhoto() - $this->photoCount;
	}

	public function getCompanyInactiveBreedersOfSpecies()
	{
		$this->breedersAvailable = $this->user->company->getInativeBreedersOfSpecies($this->speciesSelected);
	}

	public function getActiveBreedersOfSpecies()
	{
		$this->breedersAvailable = $this->user->company->getActiveBreedersOfSpecies($this->speciesSelected);
	}

	public function setRetiredBreeder()
	{
		if($this->animalSelected) {
			$this->retiredBreeder = Animal::findBySlug($this->animalSelected);
			$this->description = $this->retiredBreeder->description;
			$this->mediaAdded();
		}
	}

	public function setStud()
	{
		if($this->animalSelected) {
			$this->stud = Animal::findBySlug($this->animalSelected);
			$this->description = $this->stud->description;
			$this->mediaAdded();
		}
	}

	public function setBreedsAvailable($forSecondMale)
	{
		if($forSecondMale) $ownerShip = $this->secondMaleOwnership;
		else $ownerShip = $this->firstMaleOwnership;

		if($ownerShip == 'yes') {
			$breedsOfCompany = $this->user->company->getSpeciesBreeds($this->speciesSelected)->pluck('slug');

			$crossings = Crossing::where(function($where) use($breedsOfCompany) {
					$where->whereHas('firstBreed', function($whereHas) use($breedsOfCompany) {
						$whereHas->whereIn('slug', $breedsOfCompany);
					})
					->whereHas('secondBreed', function($whereHas) {
						$whereHas->where('slug', $this->breedOfFemale);
					});
				})
				->orWhere(function($orWhere) use($breedsOfCompany) {
					$orWhere->whereHas('firstBreed', function($whereHas) {
						$whereHas->where('slug', $this->breedOfFemale);
					})
					->whereHas('secondBreed', function($whereHas) use($breedsOfCompany) {
						$whereHas->whereIn('slug', $breedsOfCompany);
					});
				})
				->with(['firstBreed', 'secondBreed'])
				->get();

			if($crossings->isNotEmpty()) {
				$breedsAvailable = $crossings->flatMap(fn($crossing) => [
					$crossing->firstBreed?->slug,
					$crossing->secondBreed?->slug,
				])
				->filter(fn($slug) => in_array($slug, $breedsOfCompany->toArray()))
				->unique()
				->values()
				->toArray();
			}
			else $breedsAvailable[] = $this->breedOfFemale;
		}
		else {
			$crossings = Crossing::whereHas('firstBreed', function($whereHas) {
					$whereHas->where('slug', $this->breedOfFemale);
				})
				->orWhereHas('secondBreed', function($whereHas) {
					$whereHas->where('slug', $this->breedOfFemale);
				})
				->with(['firstBreed', 'secondBreed'])
				->get();

			if($crossings->isNotEmpty()) {
				$breedsAvailable = $crossings->pluck('firstBreed.slug')
					->merge($crossings->pluck('secondBreed.slug'))
					->unique()
					->values()
					->toArray();
			}
			else $breedsAvailable[] = $this->breedOfFemale;
		}

		if($forSecondMale) $this->breedsAvailableForSecondMale = $breedsAvailable;
		else $this->breedsAvailableForFirstMale = $breedsAvailable;
	}

	// Assigns the selected Female
	public function setFemale()
	{
		if($this->femaleSelected) {
			$this->female = Animal::findBySlug($this->femaleSelected);

			$this->breedOfFemale = $this->female->breed->slug;
			$this->setBreedsAvailable(false);
			$this->isFemaleLOF = $this->female->values->get('pure_breed');

			$this->firstBreedersOfUsersCompanyAvailable = $this->user->company->getMaleBreedersOfBreeds($this->breedsAvailableForFirstMale);
		}
	}

	// Loads the breeders of user's company
	public function loadBreedersOfUsersCompany()
	{
		$this->setBreedsAvailable(false);

		// First list of user's company's male available
		$this->firstBreedersOfUsersCompanyAvailable = $this->user->company->activeBreeders()->whereHas('breed', function($whereHas) {
				$whereHas->whereIn('slug', $this->breedsAvailableForFirstMale);
			})
			->where('values->sex', AnimalSexes::Male->value);

		if($this->secondMale) $this->firstBreedersOfUsersCompanyAvailable = $this->firstBreedersOfUsersCompanyAvailable->where('slug', '<>', $this->secondMale->slug);

		$this->firstBreedersOfUsersCompanyAvailable = $this->firstBreedersOfUsersCompanyAvailable->get();

		$this->setBreedsAvailable(true);

		// Second list of user's company's male available
		$this->secondBreedersOfUsersCompanyAvailable = $this->user->company->activeBreeders()->whereHas('breed', function($whereHas) {
				$whereHas->whereIn('slug', $this->breedsAvailableForSecondMale);
			})
			->where('values->sex', AnimalSexes::Male->value);

		if($this->firstMale) $this->secondBreedersOfUsersCompanyAvailable = $this->secondBreedersOfUsersCompanyAvailable->where('slug', '<>', $this->firstMale->slug);

		$this->secondBreedersOfUsersCompanyAvailable = $this->secondBreedersOfUsersCompanyAvailable->get();
	}

	// Loads the breeders of other companies
	public function loadBreedersOfBreedAvailable()
	{
		$this->setBreedsAvailable(false);

		$this->firstMalesBreedersOfBreedAvailable = Animal::whereHas('breed', function($whereHas) {
				$whereHas->whereIn('slug', $this->breedsAvailableForFirstMale);
			})
			->where('values->sex', AnimalSexes::Male->value)
			->where('values->breeder_status', 'active')
			->where(function($where) {
				$where->whereHas('company', function($whereHas) {
					$whereHas->where('slug', '<>', $this->user->company->slug);
				})
				->orWhereDoesntHave('company');
			});

		if($this->secondMale) $this->firstMalesBreedersOfBreedAvailable = $this->firstMalesBreedersOfBreedAvailable->where('slug', '<>', $this->secondMale->slug);

		$this->firstMalesBreedersOfBreedAvailable = $this->firstMalesBreedersOfBreedAvailable->get();

		$this->setBreedsAvailable(true);

		$this->secondMalesBreedersOfBreedAvailable = Animal::whereHas('breed', function($whereHas) {
				$whereHas->whereIn('slug', $this->breedsAvailableForSecondMale);
			})
			->where('values->sex', AnimalSexes::Male->value)
			->where('values->breeder_status', 'active')
			->where(function($where) {
				$where->whereHas('company', function($whereHas) {
					$whereHas->where('slug', '<>', $this->user->company->slug);
				})
				->orWhereNull('company_id');
			});

		if($this->firstMale) $this->secondMalesBreedersOfBreedAvailable = $this->secondMalesBreedersOfBreedAvailable->where('slug', '<>', $this->firstMale->slug);

		$this->secondMalesBreedersOfBreedAvailable = $this->secondMalesBreedersOfBreedAvailable->get();
	}

	// Reloads the list of breeders available that are not coming from the user's company
	public function firstMaleOwnsershipChecked()
	{
		if($this->firstMaleOwnership == 'no') {
			$this->animal = new Animal;
			$this->company = new Company;
			$this->loadBreedersOfBreedAvailable();
		}
		else $this->loadBreedersOfUsersCompany();

		if($this->firstMale) {
			$this->firstMale = new Animal;
			$this->firstMaleSelected = null;
		}
	}

	// Assigns the selected first male
	public function setFirstMale()
	{
		if($this->firstMaleSelected) $this->firstMale = Animal::findBySlug($this->firstMaleSelected);

		// Reinit des listes, pour exclure le père sélectionné des autres listes
		if($this->secondMaleOwnership == 'no') $this->loadBreedersOfBreedAvailable();
		else $this->loadBreedersOfUsersCompany();
	}

	// Is there a second male in the litter ?
	public function secondMaleToLitterChecked()
	{
		if($this->secondMaleToLitter == 'no') $this->secondMaleOwnership = 'no';
		else $this->secondMaleOwnsershipChecked();

		if($this->secondMale) {
			$this->secondMale = new Animal;
			$this->secondMaleSelected = null;
		}
	}

	// Reloads the list of breeders available that are not coming from the user's company
	public function secondMaleOwnsershipChecked()
	{
		if($this->secondMaleOwnership == 'no') {
			$this->animal = new Animal;
			$this->company = new Company;
			$this->loadBreedersOfBreedAvailable();
		}
		else $this->loadBreedersOfUsersCompany();

		if($this->secondMale) {
			$this->secondMale = new Animal;
			$this->secondMaleSelected = null;
		}
	}

	// Assigns the selected second male
	public function setSecondMale()
	{
		if($this->secondMaleSelected) $this->secondMale = Animal::findBySlug($this->secondMaleSelected);

		// Reinit des listes, pour exclure le père sélectionné des autres listes
		if($this->firstMaleOwnership == 'no') $this->loadBreedersOfBreedAvailable();
		else $this->loadBreedersOfUsersCompany();
	}

	public function incrementLitterCount(string $sex)
	{
		if($sex == 'male') $this->maleCount++;
		elseif($sex == 'female') $this->femaleCount++;
	}

	public function decrementLitterCount(string $sex)
	{
		if($sex == 'male' && $this->maleCount > 0) $this->maleCount--;
		elseif($sex == 'female' && $this->femaleCount > 0) $this->femaleCount--;
	}

	public function refreshLastPublication()
	{
		$this->post->load('lastPublication');

		$this->lastPublication = $this->post->lastPublication;

		if($this->lastPublication) {
			$this->subscription = $this->lastPublication->subscription;
			$this->offer = $this->subscription->offer;
		}
		else $this->subscription = $this->user->hasOfferSubscription($this->offer->slug);
	}

	public function setPublication($status)
	{
		$this->refreshLastPublication();

		if($this->postState == 'create') {
			if($status == 'publish') {
				if($this->active < $this->totalSteps) {
					if($this->post->publications()->count() == 0) {
						$this->post->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::Draft
						]);
					}
				}
				elseif($this->active == $this->totalSteps) {
					$this->post->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::DraftWaitingModerationForPublication
					]);

					$this->post->markForModeration();
					$message = __(':element has been created successfully', ['element' => __('Your post')]);
					session()->flash('post_published');
					session()->flash('post_type', $this->postType->getTranslation('slug', 'en'));
				}
			}
			elseif($status == 'draft') {
				if($this->post->publications()->count() == 0) {
					$this->post->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::Draft
					]);
				}

				$message = __(':element has been saved as draft successfully', ['element' => __('Your post')]);
			}
		}
		elseif($this->postState == 'update') {
			if($this->lastPublication->isDraft()) {
				if($status == 'publish') {
					if($this->active == $this->totalSteps) {
						$this->post->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::DraftWaitingModerationForPublication
						]);

						$this->post->markForModeration();
						session()->flash('post_published');
						session()->flash('post_type', $this->postType->getTranslation('slug', 'en'));
					}
				}
				elseif($status == 'buy-and-publish') return redirect()->route('space.posts.buy-to-publish', ['post' => $this->post->slug]);
			}
			elseif($this->lastPublication->isPublished() && $this->changeHasBeenMade) {
				$endDate = null;

				if(!$this->offer->free) $endDate = $this->lastPublication->end_date;

				$this->post->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::PublishedUpdatedWaitingModeration,
					'end_date' => $endDate
				]);

				$this->post->markForModeration();
				session()->flash('post_published_modified');
				session()->flash('post_type', $this->postType->getTranslation('slug', 'en'));
			}
			elseif($this->lastPublication->isWaitingToBePublished() && $this->post->lastModeration->isDenied()) {
				$this->post->markForModeration();
				session()->flash('post_published_modified');
				session()->flash('post_type', $this->postType->getTranslation('slug', 'en'));
			}

			$message = __(':element has been updated successfully', ['element' => __('Your post')]);
		}

		if($status == 'draft' || ($status == 'publish' && $this->active == $this->totalSteps)) return redirect()->route('space.posts.my-posts')->with('success', $message);
	}

	public function submitPostForm($status)
	{
		if($this->active == 1) {
			$rules = [
				'speciesSelected' => ['required'],
				'postTypeSelected' => ['required'],
				'litterType' => ['required_if:postTypeSelected,litter']
			];

			$messages = [
				'speciesSelected.required' => __(':element is mandatory', ['element' => __('The species')]),
				'postTypeSelected.required' => __(':element is mandatory', ['element' => __('The post type')]),
				'litterType.required_if' => __(':element is mandatory', ['element' => __('The litter type')])
			];

			$this->validate($rules, $messages);

			if($this->postState == 'create') {
				$this->postType = PostType::findBySlug($this->postTypeSelected, 'en');

				if($this->postType->getTranslation('slug', 'en') == 'litter') {
					if($this->litterType == 'yet-to-come') $this->postType = PostType::findBySlug('litter-yet-to-come', 'en');

					if($this->user->hasRole('professionnal_breeder')) $this->femalesAvailable = $this->user->company->getFemaleBreedersOfSpecies($this->speciesSelected);
					elseif($this->user->hasRole('individual_breeder')) $this->femalesAvailable = $this->user->company->getPureBreedFemaleBreedersOfSpecies($this->speciesSelected);
				}
				elseif($this->postType->getTranslation('slug', 'en') == 'retired-breeder') $this->getCompanyInactiveBreedersOfSpecies();
				elseif($this->postType->getTranslation('slug', 'en') == 'stud') {
					$this->protrusionTypes = ProtrusionTypes::asHumanArray();
					$this->getActiveBreedersOfSpecies();
				}
			}
		}
		elseif($this->active == 2) {
			if($this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come' || $this->postType->getTranslation('slug', 'en') == 'litter') {
				$rules = [
					'female' => ['required'],
					'firstMale' => ['required'],
					'secondMale' => ['required_if:secondMaleToLitter,yes']
				];

				$messages = [
					'female.required' => __(':element is mandatory', ['element' => __('The female breeder')]),
					'firstMale.required' => __(':element is mandatory', ['element' => __('The first male breeder')]),
					'secondMale.required_if' => __(':element is mandatory', ['element' => __('The second male breeder')])
				];

				if($this->postType->getTranslation('slug', 'en') == 'litter') {
					$rules['birthDate'] = ['required', 'date'];
					$rules['availabilityDate'] = ['required', 'date', 'after_or_equal:'.Carbon::parse($this->birthDate)->addWeeks($this->speciesSelected == 'dog' ? 8: 12)->format('Y-m-d')];
					$rules['birthPlace'] = ['required'];
					$rules['birthPlaceValue'] = ['required_if:birthPlace,other'];

					/*if($this->speciesSelected == 'cat') {
						$rules['litterNumber'] = [
							'required_if:isFemaleLOF,true',
							'regex:/^LOOF-\d{8}-\d{4}-\d{1}$/'
						];
					}

					if($this->speciesSelected == 'dog') {
						$rules['litterNumber'] = [
							'required_if:isFemaleLOF,true',
							'regex:/^LOF-[A-Za-z0-9]{8}-\d{4}-[A-Za-z0-9]{3}$/'
						];
					}*/

					$messages['birthDate.required'] = __(':element is expected', ['element' => __('The litter\'s birth date')]);
					$messages['birthDate.date'] = __(':element is expected', ['element' => __('A date (dd/mm/yyyy)')]);
					$messages['availabilityDate.required'] = __(':element is expected', ['element' => __('The litter\'s availability date')]);
					$messages['availabilityDate.date'] = __(':element is expected', ['element' => __('A date (dd/mm/yyyy)')]);
					$messages['availabilityDate.after_or_equal'] = __('The litter can only be available after :x weeks from the litter\'s birth date', ['x' => $this->speciesSelected == 'dog' ? 8 : 12]);
					// $messages['litterNumber.regex'] = $this->speciesSelected == 'cat' ? __('The format must be LOOF-xxxxxxxx-AAAA-n') : __('The format must be LOF-nnnnnnnn-AAAA-xxx');
					$messages['birthPlace.required'] = __(':element is expected', ['element' => __('The place of birth')]);
					$messages['birthPlaceValue.required_if'] = __(':element is expected', ['element' => __('The place of birth')]);
				}
				elseif($this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					$rules['expectedBirthDate'] = ['required'];

					$messages['expectedBirthDate.required'] = __(':element is expected', ['element' => __('The expected birth date')]);
				}

				$this->validate($rules, $messages);

				if($this->postType->getTranslation('slug', 'en') == 'litter' && $this->maleCount == 0 && $this->femaleCount == 0) {
					$this->addError('maleCount', __(':element is expected', ['element' => __('There must be at least one :species in the litter', ['species' => $this->speciesSelected == 'dog' ? __('puppy') : __('kitty')])]));
					$this->addError('femaleCount', __(':element is expected', ['element' => __('There must be at least one :species in the litter', ['species' => $this->speciesSelected == 'dog' ? __('puppy') : __('kitty')])]));
					return;
				}

				if($this->postState == 'create') {
					$this->litter = new Litter;
					$this->post = new Post;
					$this->post->user_id = $this->user->id;
					$this->post->post_type_id = $this->postType->id;
					$this->post->name = Carbon::now();
					$this->post->values = [];

					$this->litter->species_id = $this->female->breed->species->id;
					$this->litter->company_id = $this->user->company->id;
					$this->litter->mother_id = $this->female->id;
					$this->litter->father_id = $this->firstMale->id;

					if($this->secondMaleToLitter == 'yes') $this->litter->second_father_id = $this->secondMale->id;

					$values = new Collection();
					$values->put('description', $this->description)
						->put('hide_first_male', $this->hideFirstMale)
						->put('hide_second_male', $this->hideSecondMale);

					if($this->postType->getTranslation('slug', 'en') == 'litter') {
						$values->put('birth_date', $this->birthDate)
							->put('availability', $this->availabilityDate)
							->put('litter_number', $this->litterNumber)
							->put('female_count', $this->femaleCount)
							->put('male_count', $this->maleCount)
							->put('birth_place', $this->birthPlace);

						if($this->birthPlace == 'other') $values->put('birth_place_value', $this->birthPlaceValue);
					}
					elseif($this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') $values->put('expected_birth_date', $this->expectedBirthDate);

					$this->litter->values = $values;
					$this->litter->save();

					$this->litter->breeds()->syncWithoutDetaching($this->female->breed);
					$this->litter->breeds()->syncWithoutDetaching($this->firstMale->breed);

					if($this->secondMaleToLitter == 'yes') $this->litter->breeds()->syncWithoutDetaching($this->secondMale->breed);

					$this->litter->post()->save($this->post);
					$this->post->name = ucfirst(__('post')) . ' ' . $this->post->id . ' ' . __($this->postType->name);

					$mediablePhotos = Auth::guard('web')->user()->mediable->find($this->mediableIdPhoto);
					$mediaPhotos = $mediablePhotos->media;
					if($mediaPhotos->isNotEmpty()) {
						foreach($mediaPhotos as $mediaPhoto) {
							$this->post->addMedia($mediaPhoto->getPath())
								->usingName($mediaPhoto->name)
								->usingFileName($mediaPhoto->file_name)
								->toMediaCollection('photos'.$this->post->id);

							$mediaPhoto->delete();
						}

						$mediablePhotos->delete();
					}
				}
				elseif($this->postState == 'update') {
					$this->litter->breeds()->detach();

					$this->litter->mother_id = $this->female->id;
					$this->litter->breeds()->syncWithoutDetaching($this->female->breed);
					$this->litter->father_id = $this->firstMale->id;
					$this->litter->breeds()->syncWithoutDetaching($this->firstMale->breed);

					if($this->secondMaleToLitter == 'yes') {
						$this->litter->second_father_id = $this->secondMale->id;
						$this->litter->breeds()->syncWithoutDetaching($this->secondMale->breed);
					}

					$values = $this->litter->values;
					$values->put('birth_date', $this->birthDate)
						->put('availability', $this->availabilityDate)
						->put('hide_first_male', $this->hideFirstMale)
						->put('hide_second_male', $this->hideSecondMale);

					if($this->postType->getTranslation('slug', 'en') == 'litter') {
						if($this->litter->animals->isNotEmpty()) {
							foreach($this->litter->animals as $animal) {
								$this->litter->breeds()->syncWithoutDetaching($animal->breed);
							}
						}

						if($this->allowUpdate) {
							$values->put('female_count', $this->femaleCount)
								->put('male_count', $this->maleCount);
						}

						if(
							$this->description != $values->get('description') ||
							$this->litterNumber != $values->get('litter_number')
						) {
							$forModeration = $values->get('for_moderation', []);
							$this->changeHasBeenMade = true;

							if($this->description != $values->get('description')) $forModeration['description'] = $this->description;
							if($this->litterNumber != $values->get('litter_number')) $forModeration['litter_number'] = $this->litterNumber;

							$values->put('for_moderation', $forModeration);
						}
					}
					elseif($this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if(
							$this->description != $values->get('description') ||
							$this->expectedBirthDate != $values->get('expected_birth_date')
						) {
							$forModeration = $values->get('for_moderation', []);
							$this->changeHasBeenMade = true;

							if($this->description != $values->get('description')) $forModeration['description'] = $this->description;
							if($this->expectedBirthDate != $values->get('expected_birth_date')) $forModeration['expected_birth_date'] = $this->expectedBirthDate;

							$values->put('for_moderation', $forModeration);
						}
					}

					$this->litter->values = $values;
					$this->litter->save();
				}
			}
			elseif($this->postType->getTranslation('slug', 'en') == 'retired-breeder') {
				$rules = [
					'retiredBreeder' => ['required'],
					'price' => ['required', 'integer'],
					'description' => ['required'],
					'birthPlace' => ['required'],
					'birthPlaceValue' => ['required_if:birthPlace,other']
				];

				$messages = [
					'retiredBreeder.required' => __(':element is mandatory', ['element' => __('The retired breeder')]),
					'price.required' => __(':element is mandatory', ['element' => __('The selling price')]),
					'price.integer' => __('Only integer'),
					'description.required' => __(':element is mandatory', ['element' => __('The description')]),
					'birthPlace.required' => __(':element is expected', ['element' => __('The place of birth')]),
					'birthPlaceValue.required_if' => __(':element is expected', ['element' => __('The place of birth')])
				];

				$this->validate($rules, $messages);

				if($this->postState == 'create') {
					$values = new Collection();

					$values->put('description', $this->description)
						->put('price', $this->price)
						->put('sterilized', $this->isSterilized)
						->put('birth_place', $this->birthPlace);

					if($this->birthPlace == 'other') $values->put('birth_place_value', $this->birthPlaceValue);

					$this->post = new Post;
					$this->post->user_id = $this->user->id;
					$this->post->post_type_id = $this->postType->id;
					$this->post->name = Carbon::now();

					$this->retiredBreeder->post()->save($this->post);
					$this->post->save();

					$this->post->name = ucfirst(__('post')) . ' ' . $this->post->id . ' ' . __($this->postType->name);

					$this->user->company->life()->create([
						'animal_id' => $this->retiredBreeder->id,
						'state' => AnimalStates::Available
					]);

					$mediablePhotos = Auth::guard('web')->user()->mediable->find($this->mediableIdPhoto);
					$mediaPhotos = $mediablePhotos->media;
					if($mediaPhotos->isNotEmpty()) {
						foreach($mediaPhotos as $mediaPhoto) {
							$this->post->addMedia($mediaPhoto->getPath())
								->usingName($mediaPhoto->name)
								->usingFileName($mediaPhoto->file_name)
								->toMediaCollection('photos'.$this->post->id);

							$mediaPhoto->delete();
						}

						$mediablePhotos->delete();
					}
				}
				elseif($this->postState == 'update') {
					$values = $this->post->values;
					$values->put('sterilized', $this->isSterilized)
						->put('birth_place', $this->birthPlace);

					if($this->birthPlace == 'other') $values->put('birth_place_value', $this->birthPlaceValue);

					if(
						$this->description != $values->get('description') ||
						$this->price != $values->get('price')
					) {
						$forModeration = $values->get('for_moderation', []);
						$this->changeHasBeenMade = true;

						if($this->description != $values->get('description')) $forModeration['description'] = $this->description;
						if($this->price != $values->get('price')) $forModeration['price'] = $this->price;

						$values->put('for_moderation', $forModeration);
					}
				}

				$this->post->values = $values;
			}
			elseif($this->postType->getTranslation('slug', 'en') == 'stud') {
				$rules = [
					'stud' => ['required'],
					'quotation' => ['integer', 'min:1', 'max:6'],
					'price' => ['required', 'integer'],
					'description' => ['required']
				];

				$messages = [
					'stud.required' => __(':element is mandatory', ['element' => __('The stud')]),
					'quotation.min' => __('Minimum 1'),
					'quotation.max' => __('Maximum 6'),
					'price.required' => __(':element is mandatory', ['element' => __('The selling price')]),
					'price.integer' => __('Only integer'),
					'description.required' => __(':element is mandatory', ['element' => __('The description')])
				];

				$this->validate($rules, $messages);

				if($this->postState == 'create') {
					$values = new Collection();

					$values->put('quotation', $this->quotation)
						->put('price', $this->price)
						->put('protrusion_types', $this->protrusionType)
						->put('average_litter_size', $this->averageLitterSize)
						->put('enhancer', $this->enhancer)
						->put('gene_color', $this->geneColor)
						->put('description', $this->description);

					$this->post = new Post;
					$this->post->user_id = $this->user->id;
					$this->post->post_type_id = $this->postType->id;
					$this->post->name = Carbon::now();

					$this->stud->post()->save($this->post);
					$this->post->save();

					$this->post->name = ucfirst(__('post')) . ' ' . $this->post->id . ' ' . __($this->postType->name);

					$mediablePhotos = Auth::guard('web')->user()->mediable->find($this->mediableIdPhoto);
					$mediaPhotos = $mediablePhotos->media;
					if($mediaPhotos->isNotEmpty()) {
						foreach($mediaPhotos as $mediaPhoto) {
							$this->post->addMedia($mediaPhoto->getPath())
								->usingName($mediaPhoto->name)
								->usingFileName($mediaPhoto->file_name)
								->toMediaCollection('photos'.$this->post->id);

							$mediaPhoto->delete();
						}

						$mediablePhotos->delete();
					}
				}
				elseif($this->postState == 'update') {
					$values = $this->post->values;

					$values->put('quotation', $this->quotation)
						->put('protrusion_types', $this->protrusionType)
						->put('average_litter_size', $this->averageLitterSize)
						->put('enhancer', $this->enhancer)
						->put('gene_color', $this->geneColor);

					if(
						$this->price != $values->get('price') ||
						$this->description != $values->get('description'))
					{
						$forModeration = $values->get('for_moderation', []);
						$this->changeHasBeenMade = true;

						if($this->price != $values->get('price')) $forModeration['price'] = $this->price;
						if($this->description != $values->get('description')) $forModeration['description'] = $this->description;

						$values->put('for_moderation', $forModeration);
					}
				}

				$this->post->values = $values;
			}

			$this->post->save();

			$this->refreshLastPublication();

			if($this->postState == 'create') {
				$this->post->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::Draft
				]);
			}
		}
		elseif($this->active == 3 || ($this->active == 4 && $this->postType->getTranslation('slug', 'en') == 'litter')) {
			if($this->active == 3 && $this->postType->getTranslation('slug', 'en') == 'litter') {
				$this->litter->load('animals');

				if($this->litter->canAnyLitterAnimalBeCreated()) {
					$rules = [
						'litterChildren' => ['required']
					];

					$messages = [
						'litterChildren.required' => __('Some animals are missing from the litter')
					];

					$this->validate($rules, $messages);
				}
				elseif($this->litter->hasLitterTooManyAnimalsCreated()) {
					$rules = [
						'litterChildren' => ['required']
					];

					$messages = [
						'litterChildren.required' => __('There are too many animals in this litter')
					];

					$this->validate($rules, $messages);
				}
				else {
					$this->litter->load('animals');

					foreach($this->litter->animals as $animal) {
						$animal->updateValue('birth_date', $this->litter->values->get('birth_date'));
						$animal->save();

						$this->litter->breeds()->syncWithoutDetaching($animal->breed);
					}
				}
			}
			/*else {
				$rules = [
					'socialNetworkDescription' => ['required']
				];

				$messages = [
					'socialNetworkDescription.required' => __('You must enter a summary for the social network broadcasting')
				];

				$this->validate($rules, $messages);

				$values = $this->post->values;

				if($this->postState == 'create') $values->put('social_network_description', $this->socialNetworkDescription);
				elseif($this->postState == 'update' && $this->socialNetworkDescription != $values->get('social_network_description')) {
					$this->changeHasBeenMade = true;

					$forModeration = $values->get('for_moderation', []);
					$forModeration['social_network_description'] = $this->socialNetworkDescription;

					$values->put('for_moderation', $forModeration);
				}

				$this->post->values = $values;
				$this->post->save();
			}*/
		}

		if($this->active > 1) $this->setPublication($status);

		if($this->active < $this->totalSteps && $status == 'publish') $this->active++;
		if($this->active == $this->totalSteps) {
			$this->creditAvailable = $this->user->countCreditAvailable($this->offer->slug);

			if($this->postState == 'update' && $this->lastPublication->isDraftWaitingModerationForPublication()) $this->creditAvailable++;
		}
	}

	public function mount()
	{
		$this->postTypes = PostType::where('slug->en', '<>', 'litter-yet-to-come')
			->get();
		$this->user = Auth::guard('web')->user();
		$this->company = $this->user->company;
		$this->userInterestedIn = $this->user->values->get('interested_in');

		if($this->user->hasRole('professionnal_breeder')) $this->onlyPureBreed = false;
		elseif($this->user->hasRole('individual_breeder')) $this->onlyPureBreed = true;

		$this->mediableClassPhoto = Mediable::class;
		$postMediablePhoto =  Mediable::firstOrCreate([
			'user_id' => $this->user->id,
			'type' => 'post-photo'
		]);
		$this->mediableIdPhoto = $postMediablePhoto->id;

		if($this->post->id) {
			$this->active = 2;
			$this->postState = 'update';
			$this->postType = $this->post->type;
			$this->mediableClassPhoto = Post::class;
			$this->mediableIdPhoto = $this->post->id;
			$this->refreshLastPublication();

			if($this->post->isPublished() && !$this->post->values->has('identifiant')) $this->allowUpdate = false;

			if($this->postType->getTranslation('slug', 'en') == 'litter' || $this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				$this->postTypeSelected = 'litter';
				$this->litter = $this->post->model;
				$this->speciesSelected = $this->litter->species->getTranslation('slug', 'en');

				if($this->user->hasRole('professionnal_breeder')) $this->femalesAvailable = $this->user->company->getFemaleBreedersOfSpecies($this->speciesSelected);
				elseif($this->user->hasRole('individual_breeder')) $this->femalesAvailable = $this->user->company->getPureBreedFemaleBreedersOfSpecies($this->speciesSelected);

				if($this->litter->mother) {
					$this->femaleSelected = $this->litter->mother->slug;
					$this->female = $this->litter->mother;
					$this->breedOfFemale = $this->litter->mother->breed->slug;
				}
				else $this->breedOfFemale = $this->litter->breed->slug;

				if(data_get($this->litter->values, 'for_moderation.description')) $this->description = data_get($this->litter->values, 'for_moderation.description');
				else $this->description = $this->litter->values->get('description');

				$this->hideFirstMale = $this->litter->values->get('hide_first_male') ?? 'no';
				$this->hideSecondMale = $this->litter->values->get('hide_second_male') ?? 'no';

				if($this->litter->father?->company && $this->litter->father?->company->user->id == $this->user->id) $this->firstMaleOwnership = 'yes';
				else $this->firstMaleOwnership = 'no';

				$this->firstMaleOwnsershipChecked();

				if($this->litter->father) {
					$this->firstMaleSelected = $this->litter->father->slug;
					$this->firstMale = $this->litter->father;
				}

				if($this->litter->secondFather) {
					$this->secondMaleToLitter = 'yes';

					if($this->litter->secondFather->company && $this->litter->secondFather->company->user->id == $this->user->id) $this->secondMaleOwnership = 'yes';
					else $this->secondMaleOwnership = 'no';

					$this->secondMaleOwnsershipChecked();

					$this->secondMaleSelected = $this->litter->secondFather->slug;
					$this->secondMale = $this->litter->secondFather;
				}

				if($this->postType->getTranslation('slug', 'en') == 'litter') {
					$this->litterType = 'born';

					$this->birthDate = $this->litter->values->get('birth_date');
					$this->availabilityDate = $this->litter->values->get('availability');
					$this->femaleCount = $this->litter->values->get('female_count') ?? 0;
					$this->maleCount = $this->litter->values->get('male_count') ?? 0;

					if(data_get($this->litter->values, 'for_moderation.litter_number')) $this->litterNumber = data_get($this->litter->values, 'for_moderation.litter_number');
					else $this->litterNumber = $this->litter->values->get('litter_number');

					if(data_get($this->litter->values, 'for_moderation.birth_place')) $this->birthPlace = data_get($this->litter->values, 'for_moderation.birth_place');
					else $this->birthPlace = $this->litter->values->get('birth_place');

					if(data_get($this->litter->values, 'for_moderation.birth_place_value')) $this->birthPlaceValue = data_get($this->litter->values, 'for_moderation.birth_place_value');
					else $this->birthPlaceValue = $this->litter->values->get('birth_place_value');
				}
				elseif($this->postType->getTranslation('slug', 'en') == 'litter-yet-to-come') $this->expectedBirthDate = $this->litter->values->get('expected_birth_date');
			}
			elseif($this->postType->getTranslation('slug', 'en') == 'retired-breeder') {
				$this->postTypeSelected = 'litter';
				$this->retiredBreeder = $this->post->model;
				$this->animalSelected = $this->retiredBreeder->slug;
				$this->speciesSelected = $this->retiredBreeder->species->getTranslation('slug', 'en');

				$this->getCompanyInactiveBreedersOfSpecies();

				$this->isSterilized = $this->post->values->get('sterilized');

				if(data_get($this->post->values, 'for_moderation.price')) $this->price = data_get($this->post->values, 'for_moderation.price');
				else $this->price = $this->post->values->get('price');

				if(data_get($this->post->values, 'for_moderation.description')) $this->description = data_get($this->post->values, 'for_moderation.description');
				else $this->description = $this->post->values->get('description');
			}
			elseif($this->postType->getTranslation('slug', 'en') == 'stud') {
				$this->stud = $this->post->model;
				$this->animalSelected = $this->stud->slug;
				$this->speciesSelected = $this->stud->species->getTranslation('slug', 'en');
				$this->protrusionTypes = ProtrusionTypes::asHumanArray();

				$this->getActiveBreedersOfSpecies();

				if(data_get($this->post->values, 'for_moderation.quotation')) $this->quotation = data_get($this->post->values, 'for_moderation.quotation');
				else $this->quotation = $this->post->values->get('quotation');

				if(data_get($this->post->values, 'for_moderation.price')) $this->price = data_get($this->post->values, 'for_moderation.price');
				else $this->price = $this->post->values->get('price');

				if(data_get($this->post->values, 'for_moderation.protrusion_types')) $this->protrusionType = data_get($this->post->values, 'for_moderation.protrusion_types');
				else $this->protrusionType = $this->post->values->get('protrusion_types');

				if(data_get($this->post->values, 'for_moderation.average_litter_size')) $this->averageLitterSize = data_get($this->post->values, 'for_moderation.average_litter_size');
				else $this->averageLitterSize = $this->post->values->get('average_litter_size');

				if(data_get($this->post->values, 'for_moderation.enhancer')) $this->enhancer = data_get($this->post->values, 'for_moderation.enhancer');
				else $this->enhancer = $this->post->values->get('enhancer');

				if(data_get($this->post->values, 'for_moderation.gene_color')) $this->geneColor = data_get($this->post->values, 'for_moderation.gene_color');
				else $this->geneColor = $this->post->values->get('gene_color');

				if(data_get($this->post->values, 'for_moderation.description')) $this->description = data_get($this->post->values, 'for_moderation.description');
				else $this->description = $this->post->values->get('description');
			}

			if($this->offer->hasOption('social-network-broadcasting')) {
				if(data_get($this->post->values, 'for_moderation.social_network_description')) $this->socialNetworkDescription = data_get($this->post->values, 'for_moderation.social_network_description');
				else $this->socialNetworkDescription = $this->post->values->get('social_network_description');
			}

			$this->countPostPhotos();

			if($this->active == $this->totalSteps) {
				$this->creditAvailable = $this->user->countCreditAvailable($this->offer->slug);

				if($this->postState == 'update' && $this->lastPublication->isDraftWaitingModerationForPublication()) $this->creditAvailable++;
			}
		}
		else {
			$this->postState = 'create';
			$this->canCreateLitters = $this->user->canCreateLitters();
			$this->canCreateLitter = $this->user->canCreateLitter();
			$this->canCreateLitterYetToCome = $this->user->canCreateLitterYetToCome();
		}
	}

	public function render()
	{
		if($this->postTypeSelected == 'litter' && $this->litterType == 'born') {
			$this->totalSteps = 3;

			if($this->offer->hasOption('social-network-broadcasting')) $this->totalSteps = 4;
		}
		elseif($this->offer->hasOption('social-network-broadcasting')) $this->totalSteps = 3;

		$this->subComponentKey++;

		return view('livewire.front.space.posts.form');
	}
}
