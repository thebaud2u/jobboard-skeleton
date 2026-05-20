<?php

namespace App\Http\Controllers\Front\Space\Responses;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Models\{Company, Post, Response};

class ResponseController extends Controller
{
	public function myMessages(?Response $response)
	{
		$responses = new Collection();

		if($response->id) {
			if($response->from->id != Auth::guard('web')->user()->id && $response->to->id != Auth::guard('web')->user()->id) {
				return redirect()->route('home')->withError(__('You don\'t have access to this conversation'));
			}

			if(!$response->thread) {
				$thread = Thread::create([
					'subject' => $response->model->name
				]);

				$response->thread_id = $thread->id;
				$response->save();

				Participant::create([
					'thread_id' => $thread->id,
					'user_id' => $response->from->id,
					'last_read' => new Carbon()
				]);

				Participant::create([
					'thread_id' => $thread->id,
					'user_id' => $response->to->id,
					'last_read' => new Carbon()
				]);
			}

			$response->load('thread');
		}
		else {
			$applications = Auth::guard('web')->user()
				->applications;

			$applicants = Auth::guard('web')->user()
				->applicants;

			$responses = $applications->merge($applicants);
		}

		return view('front.space.responses.my-messages', compact('response', 'responses'));
	}

	public function createConversation(Request $request)
	{
		$target = Company::find($request->target);

		if($target) {
			$response = new Response;
			$response->model()->associate($target);
			$response->from()->associate(Auth::guard('web')->user());
			$response->to()->associate($target->user);
			$response->values = new Collection();
			$response->save();

			return redirect(route('space.responses.my-messages', ['response' => $response]));
		}
	}

	public function create($element)
	{
		$isAnimal = Animal::findBySlug($element);
		$isPost = Post::findBySlug($element);

		if($isAnimal || $isPost) {
			if($isAnimal) {
				$type = 'animal';
				$element = $isAnimal;
				$post = $element->getPostFromLitter();
			}
			elseif($isPost) {
				$type = 'post';
				$post = $isPost;
				$element = $isPost;
			}

			$latestPublication = $post->lastPublication;

			if(
				($latestPublication->isDraft() || $latestPublication->isDraftWaitingModerationForPublication()) &&
				((!Auth::guard('web')->check() || $post->user->id != Auth::guard('web')->user()->id) && !Auth::guard('admin')->check())
			) {
				return redirect()->route('home')->withError(__(':element is not yet published', ['element' => __('This post')]));
			}
			elseif(
				($latestPublication->isArchived() || $latestPublication->isDeleted()) &&
				((!Auth::guard('web')->check() || $post->user->id != Auth::guard('web')->user()->id) && !Auth::guard('admin')->check())
			) {
				abort(410);
			}
			else {
				return view('front.space.responses.create', [
					'type' => $type,
					'element' => $element
				]);
			}
		}
		else return redirect()->route('home')->withError(__('Invalid url'));
	}
}
