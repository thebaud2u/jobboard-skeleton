<?php

namespace App\Http\Controllers\Front\Space\Companies;

use App\Http\Controllers\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Carbon;

use App\Enums\PublicationStates;

use App\Models\{Animal, Company, Offer};

use App\Services\StripeService;

class CompanyController extends Controller
{
	/**
	 * Display the user's company
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function index(): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->profileCompletionPercentage() < 100 && (!$user->values->has('identifiant') && !$user->hasBeenValidated())) return redirect(route('space.profile.complete-my-profile'))->with('error', __('You must complete your profile in order to create a company'));
			else {
				$viewParameters = ['company' => $user->company];

				if($user->company) {
					$company = $user->company;

					$dateDiffForArchiving = null;
					$lastPublication = $company->lastPublication;
					$forModeration = $company->values->get('for_moderation');
					$isPublished = $company->isPublished();
					$offer = $company->offer();

					$source = isset($forModeration['breeds']) ? $company->constructBreedsFromModeration() : $company->breeds;

					if($source->isNotEmpty()) {
						foreach($source as $breed) {
							$breeds[$breed->slug] = $breed->name;
						}
					}
					else $breeds = [];

					// Current offer end date
					if($isPublished && !$offer->free) {
						$companyOfferEndsAtDate = $lastPublication->end_date->startOfDay();
						$now = now()->startOfDay();
						$dateDiffForArchiving = $now->diffInDays($companyOfferEndsAtDate);
					}

					$viewParameters = [
						'company' => $company,
						'lastPublication' => $lastPublication,
						'offer' => $offer,
						'offerLastPublication' => $lastPublication->subscription->offer,
						'forModeration' => $forModeration,
						'address' => $company->addressForModeration ? $company->displayFullAddressForModeration() : $company->displayFullAddress(),
						'isPublished' => $isPublished,
						'canDisplayBreeders' => $company->offer()->hasOption('display-breeders'),
						'photos' => $company->getMedia('photos'),
						'logo' => $company->getMedia('logo'),
						'name' => isset($forModeration['name']) ? $forModeration['name'] : $company->name,
						'dateDiffForArchiving' => $dateDiffForArchiving,
						'breeds' => $breeds
					];
				}
				elseif($user->countCompanyCreditAvailable() > 0) {
					$credits = $user->getCompanyCreditAvailable();

					if(count($credits) == 1) {
						$offer = Offer::where('name', $credits[0]['offer'])
							->first();

						return redirect(route('space.companies.create', ['offer' => $offer->slug]));
					}
				}

				return view('front.space.companies.my-company', $viewParameters);
			}
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the company show-offer view
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function showOffers(?Company $company): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if(!$user->company) {
				if($user->countCompanyCreditAvailable() > 0) {
					$credits = $user->getCompanyCreditAvailable();

					if(count($credits) == 1) {
						$offer = Offer::where('name', $credits[0]['offer'])
							->first();

						return redirect(route('space.companies.create', ['offer' => $offer->slug]));
					}
				}
			}

			return view('front.space.companies.show-offers', [
				'company' => $company
			]);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function checkout(string $type, Offer $offer, $priceKey)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			if($offer->type == 'pack') {
				if($offer->slug == 'pack-premium') $offerForRedirect = Offer::findBySlug('page-elevage-premium');
				elseif($offer->slug == 'pack-master') $offerForRedirect = Offer::findBySlug('page-elevage-master');

				$productType = 'pack';
			}
			else {
				$offerForRedirect = $offer;
				$productType = 'page_seule';
			}

			$user = Auth::guard('web')->user();
			$subscription = $user->getLastSubscriptionForOffer($offerForRedirect->slug);
			$transactionId = $subscription->checkout_session_id;
			$paymentType = $subscription->values->get('payment_method');

			$price = 0;
			$discount = 0;
			$offerPrices = $offer->getPrices();
			if($offerPrices) {
				$prices = array_filter($offerPrices, function($item) use($priceKey) {
					return $item['id'] === $priceKey;
				});

				$prices = reset($prices);
				$price = $prices['price'];
				$discount = $prices['instead_of'] - $prices['price'];
			}

			$quantity = 1;
			$itemName = $offer->name;
			$itemId = $offer->id;


			if($user->company) {
				if($type == 'upgrade') {
					$url = route('space.companies.upgrade', ['offer' => $offerForRedirect->slug, 'company' => $user->company->slug]);
					$buttonLabel = __('Upgrade my page visibility');
				}
				elseif($type == 'extend') {
					$url = route('space.companies.extend-offer', ['company' => $user->company->slug]);
					$buttonLabel = __('Extend the publication period');
				}
				elseif($type == 'create') {
					$url = route('space.companies.my-company', ['offer' => $offerForRedirect->slug]);
					$buttonLabel = __('Manage my company');
				}
			}
			elseif($type == 'create') {
				$url = route('space.companies.create', ['offer' => $offerForRedirect->slug]);
				$buttonLabel = __('Create my company page');
			}

			return view('front.space.checkout', [
				'url' => $url,
				'buttonLabel' => $buttonLabel,
				'transactionId' => $transactionId,
				'paymentType' => $paymentType,
				'discount' => $discount,
				'price' => $price,
				'quantity' => $quantity,
				'itemName' => $itemName,
				'itemId' => $itemId,
				'productType' => $productType
			]);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function offerChosen(Request $request)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();
			$offer = Offer::findBySlug($request->offer);
			$priceKey = $offer->getPrices()[0]['id'];

			if($request->type == 'upgrade') {
				$company = Company::findBySlug($request->company);

				if($user->id == $company->user->id) $successUrl = route('space.companies.checkout', ['type' => 'upgrade', 'offer' => $offer->slug, 'price' => $priceKey]);
				else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
			}
			else $successUrl = route('space.companies.checkout', ['type' => 'create', 'offer' => $offer->slug, 'price' => $priceKey]);

			$cancelUrl = route('space.companies.show-offers');

			$stripe = new StripeService;

			header('Content-Type: application/json');

			$checkout = $stripe->createCheckoutSession($user, $priceKey, $successUrl, $cancelUrl);

			header("HTTP/1.1 303 See Other");
			header("Location: " . $checkout->url);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function upgrade(Offer $offer, Company $company): RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->id == $company->user->id) {
				$lastPublication = $company->lastPublication;

				if($lastPublication->isDraft() || $lastPublication->isDraftWaitingModerationForPublication()) {
					$company->publications()->create([
						'user_id' => $user->id,
						'subscription_id' => $user->hasOfferSubscription($offer->slug)->id,
						'state' => $lastPublication->state
					]);
				}
				elseif($lastPublication->isPublished()) {
					$company->publications()->create([
						'user_id' => $user->id,
						'subscription_id' => $user->hasOfferSubscription($offer->slug)->id,
						'state' => PublicationStates::PublishedUpgradedWaitingModeration
					]);

					$company->markForModeration();
				}

				return redirect()->route('space.companies.update', ['company' => $company->slug])->with('success', __('Upgrade complete, you can update your company page'));
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	public function extendOffer(Company $company)
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			$user = Auth::guard('web')->user();

			if($user->id == $company->user->id) {
				$subscriptionUsed = $company->consumeCredit();
				$lastPublication = $company->lastPublication;

				if($subscriptionUsed) {
					$company->publications()->create([
						'user_id' => $company->user->id,
						'subscription_id' => $subscriptionUsed->id,
						'state' => PublicationStates::Published,
						'end_date' => $lastPublication->end_date->addYear(1)
					]);

					$company->load('lastPublication');

					return redirect()->route('space.companies.my-company')->with('success', __('Extension complete, new end date :date', ['date' => $company->lastPublication->end_date->format('d/m/Y')]));
				}
				else {
					$offer = $lastPublication->subscription->offer;
					$priceKey = $offer->getPrices()[0]['id'];

					$successUrl = route('space.companies.checkout', ['type' => 'extend', 'offer' => $offer->slug, 'price' => $priceKey]);
					$cancelUrl = route('space.companies.show-offers');

					$stripe = new StripeService;

					header('Content-Type: application/json');

					$checkout = $stripe->createCheckoutSession(Auth::guard('web')->user(), $priceKey, $successUrl, $cancelUrl);

					header("HTTP/1.1 303 See Other");
					header("Location: " . $checkout->url);
				}
			}
			else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the company creation form
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
				if($user->company) return redirect(route('space.companies.update', ['company' => $user->company->slug]));
				else {
					return view('front.space.companies.create', [
						'offer' => $offer,
						'company' => new Company
					]);
				}
			}
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}

	/**
	 * Display the company update form
	 *
	 * @return \Illuminate\View\View
	 * or @return Illuminate\Http\RedirectResponse
	 */
	public function update(Company $company): View|RedirectResponse
	{
		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder']) && Auth::guard('web')->user()->id == $company->user->id) {
			return view('front.space.companies.update', [
				'company' => $company
			]);
		}
		else return redirect()->route('home')->with('error', __('You don\'t have access to this page'));
	}
}
