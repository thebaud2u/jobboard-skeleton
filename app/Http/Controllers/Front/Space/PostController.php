<?php

namespace App\Http\Controllers\Front\Space\Posts;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

use App\Enums\PublicationStates;

use App\Models\{Offer, Post};

use App\Services\StripeService;

class PostController extends Controller
{
	/**
	 * Display the user's posts
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function index()
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->profileCompletionPercentage() < 100 && (!$user->values->has('identifiant') && !$user->hasBeenValidated())) return redirect(route('space.profile.complete-my-profile'))->with('error', __('You must complete your profile in order to create a post'));
			else {
				return view('front.space.posts.my-posts', [
					'company' => $user->company,
					'posts' => $user->posts
				]);
			}
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display a user specific post
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function show(Post $post)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			if($post->user->id == Auth::guard('web')->user()->id) {
				if($post->type->getTranslation('slug', 'en') == 'litter' || $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $animal = $post->model->mother;
				elseif($post->type->getTranslation('slug', 'en') == 'retired-breeder' || $post->type->getTranslation('slug', 'en') == 'stud') $animal = $post->model;

				if(!$animal) $animal = $post->model;

				$type = $post->type;
				$species = $post->model->species;
				$breed = $post->model->breed;
				$postValues = $post->values;
				$animalValues = $animal->values;
				$isPureBreed = $animalValues->get('pure_breed');
				$address = $post->model->company->address;
				$lastPublication = $post->lastPublication;
				$isPublished = $post->isPublished();

				return view('front.space.posts.my-post', [
					'post' => $post,
					'animal' => $animal,
					'type' => $type,
					'species' => $species,
					'breed' => $breed,
					'animalValues' => $animalValues,
					'postValues' => $postValues,
					'isPureBreed' => $isPureBreed,
					'address' => $address,
					'lastPublication' => $lastPublication,
					'isPublished' => $isPublished
				]);
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function checkout(string $type, $data, $priceKey)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();
			$argumentsReady = false;

			if($type == 'extend' || $type == 'buy-to-publish') {
				$post = Post::findBySlug($data);

				if($post) {
					$offer = $post->lastPublication->subscription->offer;
					$argumentsReady = true;

					if($type == 'extend') {
						$url = route('space.posts.extend-offer', ['post' => $post->slug]);
						$buttonLabel = __('Extend the publication period');
					}
					elseif($type == 'buy-to-publish') {
						$url = route('space.posts.buy-to-publish', ['post' => $post->slug]);
						$buttonLabel = __('Publish my post');
					}
				}
			}
			elseif($type == 'create') {
				$offer = Offer::findBySlug($data);

				if($offer) {
					$argumentsReady = true;
					$url = route('space.posts.create', ['offer' => $offer->slug]);
					$buttonLabel = __('Create my post');
				}
			}

			if($argumentsReady) {
				$subscription = $user->getLastSubscriptionForOffer($offer->slug);
				$transactionId = $subscription->checkout_session_id;
				$paymentType = $subscription->values->get('payment_method');

				$prices = array_filter($offer->getPrices(), function($item) use($priceKey) {
					return $item['id'] === $priceKey;
				});

				$prices = reset($prices);
				$price = $prices['price'];
				$quantity = $prices['quantity'];
				$discount = ($quantity > 1) ?  $prices['instead_of'] - $price : 0;
				$itemName = $offer->name;
				$itemId = $offer->id;
				$productType = 'credit';

				return view('front.space.checkout', [
					'url' => $url,
					'buttonLabel' => $buttonLabel,
					'transactionId' => $transactionId,
					'paymentType' => $paymentType,
					'price' => $price,
					'quantity' => $quantity,
					'itemName' => $itemName,
					'itemId' => $itemId,
					'productType' => $productType,
					'discount' => $discount
				]);
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the post show-offer view
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function showOffers(?Post $post, $postState = null): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->company) {
				if($post->exists) {
					$offers = Offer::where('slug', $post->offer()->slug)
						->get();
				}
				else {
					$post = new Post;

					$offersSlug = Offer::where('type', 'post')
						->orderBy('slug', 'DESC')
						->pluck('slug')
						->toArray();

					$offers = Offer::where('type', 'post')
						->orderByRaw("FIELD(slug, '" . implode("','", $offersSlug) . "')")
						->get();
				}

				return view('front.space.posts.show-offers', ['offers' => $offers, 'user' => $user, 'post' => $post, 'postState' => $postState]);
			}
			else return redirect(route('space.companies.show-offers'))->with('error', __('You must create a company first'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	// Méthode alternative d'utilisation d'un crédit pour lancer la création d'une annonce
	public function submitForm(Request $request)
	{
		$offer = Offer::find($request->id_offer);

		if($offer) return redirect()->route('space.posts.create', ['offer' => $offer->slug]);
		else session()->flash('error', __('The given offer doesn\'t exist'));
	}

	public function offerChosen(Request $request)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();
			$offer = Offer::findBySlug($request->offer);
			$prices = $offer->getPrices();
			$priceKey = $prices[$request->price]['id'];

			if($request->type == 'extend' || $request->type == 'buy-to-publish') {
				$post = Post::findBySlug($request->post);

				if($request->type == 'extend') {
					if($user->id == $post->user->id) {
						$successUrl = route('space.posts.checkout', ['type' => 'extend', 'data' => $post->slug, 'price' => $priceKey]);
						$cancelUrl = route('space.posts.extend-offer', ['post' => $post->slug]);
					}
					else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
				}
				elseif($request->type == 'buy-to-publish') {
					$successUrl = route('space.posts.checkout', ['type' => 'buy-to-publish', 'data' => $post->slug, 'price' => $priceKey]);
					$cancelUrl = route('space.posts.buy-to-publish', ['post' => $post->slug]);
				}
			}
			elseif($request->type == 'create') {
				$successUrl = route('space.posts.checkout', ['type' => 'create', 'data' => $offer->slug, 'price' => $priceKey]);
				$cancelUrl = route('space.posts.show-offers');
			}

			$stripe = new StripeService;

			header('Content-Type: application/json');

			$checkout = $stripe->createCheckoutSession(Auth::guard('web')->user(), $priceKey, $successUrl, $cancelUrl);

			header("HTTP/1.1 303 See Other");
			header("Location: " . $checkout->url);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function extendOffer(Post $post)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->id == $post->user->id) {
				$subscriptionUsed = $post->consumeCredit();
				$lastPublication = $post->lastPublication;

				if($subscriptionUsed) {
					$post->publications()->create([
						'user_id' => $post->user->id,
						'subscription_id' => $subscriptionUsed->id,
						'state' => PublicationStates::Published,
						'end_date' => Carbon::now()->addMonths(3)
					]);

					$post->published_at = Carbon::now();
					$post->archived_at = Carbon::now()->addMonths(3);
					$post->save();

					$post->load('lastPublication');

					return redirect()->route('space.posts.my-post', ['post' => $post->slug])->with('success', __('Extension complete, new end date : :date', ['date' => $post->lastPublication->end_date->format('d/m/Y')]));
				}
				else return $this->showOffers($post, 'extend');
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function buyToPublish(Post $post)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->id == $post->user->id) {
				$lastPublication = $post->lastPublication;

				if($user->countCreditAvailable($lastPublication->subscription->offer->slug) > 0) {
					$subscription = $user->getLastSubscriptionForOffer($lastPublication->subscription->offer->slug);

					foreach($post->publications as $publication) {
						$publication->subscription_id = $subscription->id;
						$publication->save();
					}

					$post->publications()->create([
						'user_id' => $post->user->id,
						'subscription_id' => $subscription->id,
						'state' => PublicationStates::DraftWaitingModerationForPublication
					]);

					$post->markForModeration();
					session()->flash('post_published');
					session()->flash('post_type', $post->type->getTranslation('slug', 'en'));

					return redirect()->route('space.posts.my-posts')->with('success', __(':element has been updated successfully', ['element' => __('Your post')]));
				}
				else return $this->showOffers($post, 'buy-to-publish');
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the post creation form
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function create(?Offer $offer): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->profileCompletionPercentage() < 100 && (!$user->values->has('identifiant') && !$user->hasBeenValidated())) return redirect(route('space.profile.complete-my-profile'))->with('error', __('You must complete your profile in order to create a company'));
			else {
				if($user->company) {
					if($user->company->lastPublication->isDraft()) return redirect(route('space.companies.update', ['company' => $user->company->slug]))->with('error', __('You must have a published company page in order to publish posts'));
					else {
						return view('front.space.posts.create', [
							'offer' => $offer,
							'post' => new Post
						]);
					}
				}
				else return redirect(route('space.companies.show-offers'))->with('error', __('You must create a company first'));
			}
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the post update form
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function update(Post $post): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder']) && Auth::guard('web')->user()->id == $post->user->id) {
			return view('front.space.posts.update', [
				'post' => $post
			]);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function destroy(Post $post)
	{
		if(Auth::guard('web')->user()->id == $post->user->id) {
			if($post->lastModeration?->isWaiting()) $post->lastModeration->delete();

			$post->delete();

			return redirect()->route('space.posts.my-posts')->withSuccess(__('Post deleted successfully.'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function unpublish(Post $post)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder']) && Auth::guard('web')->user()->id == $post->user->id) {
			$post->publications()->create([
				'user_id' => Auth::guard('web')->user()->id,
				'subscription_id' => $post->lastPublication->subscription->id,
				'end_date' => $post->lastPublication->end_date,
				'state' => PublicationStates::Archived
			]);

			$post->archived_at = now();
			$post->save();

			return redirect()->route('space.posts.my-post', ['post' => $post->slug])->withSuccess(__('Your post has been unpublished successfully'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}
}
