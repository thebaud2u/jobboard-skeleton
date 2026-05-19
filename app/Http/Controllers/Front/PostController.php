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

use App\Models\{Company, Message, Post, PostType, Response, Search, User, UsersViews};
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

				$postType = $post->type;
				$medias = [];
				$src = null;

				$photo = $post->getFirstMedia('photos'.$post->id);

				foreach($post->getMedia('photos'.$post->id) as $photo) {
					array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
				}

				$description = $post->values->get('description');

				$company = $post->model->company;

				// If there is no photo of the litter
				if(is_null($photo)) {
					$photo = true;
					$src = asset('storage/litter-yet-to-come-for-dogs.png');
				}

				if(is_null($src)) $src = $photo->getAvailableUrl(['optimized']);

				if($company->address->country->code == 'FRA') $addressInFrance = true;
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

				return view('front.posts.show', [
					'addressInFrance' => $addressInFrance,
					'breadcrumb' => $breadcrumb,
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
					'src' => $src,
				]);
			}
		}
		else abort(410);
	}
}
