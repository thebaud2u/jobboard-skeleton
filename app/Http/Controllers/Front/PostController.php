<?php

namespace App\Http\Controllers\Front\Posts;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

use Cmgmyr\Messenger\Models\{Thread, Participant};

use App\Enums\{PublicationStates, ResponseStates, ResponseTypes};

use App\Models\{Animal, Breed, Company, DataChoise, Message, Post, PostType, Response, Search, Species, User, UsersViews};
use App\Notifications\CustomChoiseBreedEmail;
use App\Notifications\CustomCompareBreedEmail;
use App\Notifications\Notifiable\TempNotifiable;
use App\Services\BrevoService;

class PostController extends Controller
{
	protected $brevoService;

	public function index(?PostType $postType)
	{
		if(is_null($postType)) $postType = new PostType;

		return view('front.posts.index', compact('postType'));
	}

	/**
	 * Display the specified post
	 *
	 * @param  \App\Models\Post  $post
	 * @return \Illuminate\View\View
	 */
	public function show(Company $company, Post $post)
	{
		$lastPublication = $post->lastPublication;

		if($lastPublication) {
			if(
				($lastPublication->isDraft() || $lastPublication->isDraftWaitingModerationForPublication()) &&
				((!Auth::guard('web')->check() || $post->user->id != Auth::guard('web')->user()->id) && !Auth::guard('admin')->check())
			) {
				return redirect()->route('home')->withError(__(':element is not yet published', ['element' => __('This post')]));
			}
			elseif(
				!$post->user ||
				!$post->model ||
				$lastPublication->isArchived() ||
				$lastPublication->isDeleted()
			) {
				abort(410);
			}
			else {
				views($post)->record();

				if(!session()->has('show_warning_sensitive_animal_modal')) {
					if(Auth::guard('web')->check() && Auth::guard('web')->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder'])) $showWarningSensitiveAnimalModal = false;
					else $showWarningSensitiveAnimalModal = true;
				}
				else $showWarningSensitiveAnimalModal = false;

				$postType = $post->type;
				$medias = [];
				$src = null;
				if($postType->getTranslation('slug', 'en') == 'litter' || $postType->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					$animal = $post->model->mother;
					$photo = $post->getFirstMedia('photos'.$post->id);

					foreach($post->getMedia('photos'.$post->id) as $photo) {
						array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
					}

					if($post->model->description) $description = $post->model->description;
					else $description = $post->values->get('description');
				}
				elseif($postType->getTranslation('slug', 'en') == 'retired-breeder' || $post->type->getTranslation('slug', 'en') == 'stud') {
					$animal = $post->model;
					$photo = $post->getFirstMedia('photos'.$post->id);

					foreach($post->getMedia('photos'.$post->id) as $photo) {
						array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
					}

					if(!$photo) $photo = $animal->getFirstMedia('photos'.$animal->id);

					if(empty($medias)) {
						foreach($animal->getMedia('photos'.$animal->id) as $photo) {
							array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
						}
					}

					$description = $post->values->get('description');
				}

				if(!$animal) $animal = $post->model;

				$species = $post->model->species;
				$breed = $post->model->breed;
				$company = $post->model->company;

				// If there is no photo of the litter
				if(is_null($photo)) {
					$photo = true;

					if($species->getTranslation('slug', 'en') == 'dog') $src = asset('storage/litter-yet-to-come-for-dogs.png');
					elseif($species->getTranslation('slug', 'en') == 'cat') $src = asset('storage/litter-yet-to-come-for-cats.png');
				}

				if(is_null($src)) $src = $photo->getAvailableUrl(['optimized']);

				if($animal->company->address->country->code == 'FRA') $addressInFrance = true;
				else $addressInFrance = false;

				$hasApplyied = false;
				$response = new Response;

				if(Auth::guard('web')->check()) {
					if(Auth::guard('web')->user()->hasRole('adopter')) {
						$hasApplyied = Auth::guard('web')->user()->hasApplied($post);

						if($hasApplyied) {
							$response = Response::whereHasMorph('model', [Post::class], function($whereHasMorph) use($post) {
									$whereHasMorph->where('id', $post->id);
								})
								->whereHas('from', function($whereHas) {
									$whereHas->where('id', Auth::guard('web')->user()->id);
								})
								->whereHas('to', function($whereHas) use($post) {
									$whereHas->where('id', $post->user->id);
								})
								->where('type', ResponseTypes::Application)
								->first();
						}
					}

					UsersViews::firstOrCreate([
						'user_id' => Auth::guard('web')->user()->id,
						'element_type' => Post::class,
						'element_id' => $post->id
					]);
				}

				$companiesUrl = $company->species->first()->getTranslation('slug', 'en') === 'dog' ? 'company-search.dog-companies' : 'company-search.cat-companies';
				$breadcrumb = [
					['title' =>  'Élevages', 'url' => $companiesUrl],
					['title' =>  $post->model->company->name, 'url' => 'company-search.company.show', 'params' => $post->model->company->slug],
				];

				$postSearchUrl = $post->model->species->name === 'dog' ? 'post-search.dog-posts-with-post-type' : 'post-search.cat-posts-with-post-type';
				array_push($breadcrumb, ['title' => ucfirst(__($postType->name)), 'url' => $postSearchUrl, 'params' => $postType->getTranslation('slug', 'fr')]);
				array_push($breadcrumb, ['title' =>  $post->model->breed->name, 'url' => 'breed-search.'.$company->species->first()->getTranslation('slug', 'en').'-breeds.show', 'params' => $post->model->breed->slug]);

				return view('front.posts.show', [
					'addressInFrance' => $addressInFrance,
					'animal' => $animal,
					'animalValues' => $animal->values,
					'breadcrumb' => $breadcrumb,
					'breed' => $breed,
					'company' => $company,
					'description' => $description,
					'displayType' => 'post',
					'hasApplyied' => $hasApplyied,
					'medias' => json_encode($medias),
					'photo' => $photo,
					'post' => $post,
					'postValues' => $post->values,
					'postType' => $postType,
					'response' => $response,
					'showWarningSensitiveAnimalModal' => $showWarningSensitiveAnimalModal,
					'species' => $species,
					'src' => $src,
				]);
			}
		}
		else abort(410);
	}
}
