<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Carbon;

use Stripe\Stripe;
use Stripe\Webhook;

use App\Models\{Offer, Subscription, User};
use App\Services\StripeService;

class StripeWebHookController extends Controller
{
	public function handle(Request $request)
	{
		$payload = $request->getContent();
		$sigHeader = $request->header('Stripe-Signature');
		$secret = config('services.stripe.webhook_secret');

		try {
			$event = Webhook::constructEvent($payload, $sigHeader, $secret);
		} catch (\UnexpectedValueException $e) {
			// Invalid payload
			Log::error('Invalid Stripe payload');
			return response('Invalid payload', 400);
		} catch (\Stripe\Exception\SignatureVerificationException $e) {
			// Invalid signature
			Log::error('Invalid Stripe signature');
			return response('Invalid signature', 400);
		}

		$stripe = new StripeService;

		// Gérer les événements
		switch ($event->type) {
			case 'checkout.session.completed':
				$checkoutSession = $event->data->object;
				Log::info('Stripe log ->Checkout captured : '.$checkoutSession->id);

				$user = User::where('customer_id', $checkoutSession->customer)
					->first();

				if($user) {
					Log::info('Stripe log ->Customer found : '.$user->id);

					$paymentIntent = $stripe->retrievePaymentIntent($checkoutSession->payment_intent);
					$paymentMethod = $stripe->retrievePaymentMethod($paymentIntent->payment_method);
					$lineItems = $stripe->retrieveLineItemsFromCheckoutSession($checkoutSession->id);

					$values = new Collection();
					$values->put('payment_intent_id', $paymentIntent->id)
						->put('payment_method_id', $paymentMethod->id)
						->put('payment_method', $paymentMethod->type)
						->put('payment_status', $paymentIntent->status)
						->put('created', $checkoutSession->created);

					Log::info('Stripe log ->Data array built');

					foreach($lineItems->data as $item) {
						$offer = Offer::where('product_id', $item->price->product)
							->first();

						if($offer) {
							Log::info('Stripe log ->Offer found : '.$offer->slug);

							if($offer->type == 'pack') {
								if($offer->slug == 'pack-premium') {
									$offerCompanyPremium = Offer::findBySlug('page-elevage-premium');

									$newSubscription = new Subscription;
									$newSubscription->checkout_session_id = $checkoutSession->id;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $offerCompanyPremium->id;
									$newSubscription->quantity = 1;
									$newSubscription->remaining_quantity = 1;
									$newSubscription->end_date = Carbon::now()->addYear();
									$newSubscription->values = $values;
									$newSubscription->save();

									$offerPostPremium = Offer::findBySlug('annonce-premium');

									$newSubscription = new Subscription;
									$newSubscription->checkout_session_id = $checkoutSession->id;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $offerPostPremium->id;
									$newSubscription->quantity = 5;
									$newSubscription->remaining_quantity = 5;
									$newSubscription->end_date = Carbon::now()->addYear();
									$newSubscription->values = $values;
									$newSubscription->save();
								}
								elseif($offer->slug == 'pack-master') {
									$offerCompanyMaster = Offer::findBySlug('page-elevage-master');

									$newSubscription = new Subscription;
									$newSubscription->checkout_session_id = $checkoutSession->id;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $offerCompanyMaster->id;
									$newSubscription->quantity = 1;
									$newSubscription->remaining_quantity = 1;
									$newSubscription->end_date = Carbon::now()->addYear();
									$newSubscription->values = $values;
									$newSubscription->save();

									$offerPostMaster = Offer::findBySlug('annonce-master');

									$newSubscription = new Subscription;
									$newSubscription->checkout_session_id = $checkoutSession->id;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $offerPostMaster->id;
									$newSubscription->quantity = 10;
									$newSubscription->remaining_quantity = 10;
									$newSubscription->end_date = Carbon::now()->addYear();
									$newSubscription->values = $values;
									$newSubscription->save();
								}

								Log::info("Subscription created for : {$offer->slug}, quantity: 1, user: {$user->id}");
							}
							else {
								if($offer->type == 'company') $quantity = 1;
								else $quantity = $item->price->metadata->quantity;

								$newSubscription = new Subscription;
								$newSubscription->checkout_session_id = $checkoutSession->id;
								$newSubscription->user_id = $user->id;
								$newSubscription->offer_id = $offer->id;
								$newSubscription->quantity = $quantity;
								$newSubscription->remaining_quantity = $quantity;
								$newSubscription->end_date = Carbon::now()->addYear();
								$newSubscription->values = $values;
								$newSubscription->save();

								Log::info("Subscription created for : {$offer->slug}, quantity: {$quantity}, user: {$user->id}");
							}

							Log::info("Checkout session completed");
						}
						else Log::info('Stripe log ->Offer not found : '.$item->price->product);
					}
				}
				else Log::info('Stripe log ->Customer not found : '.$checkoutSession->customer);

				break;
			case 'checkout.session.async_payment_succeeded':
				$checkoutSession = $event->data->object;
				Log::info('Stripe log ->Checkout captured : ' . $checkoutSession->id);

				$paymentIntent = $stripe->retrievePaymentIntent($checkoutSession->payment_intent);
				$paymentMethod = $stripe->retrievePaymentMethod($paymentIntent->payment_method);

				$subscriptions = Subscription::where('checkout_session_id', $checkoutSession->id)
					->get();

				if($subscriptions->isNotEmpty()) {
					foreach($subscriptions as $subscription) {
						Log::info('Stripe log ->Subscription found : ' . $subscription->id);

						$subscription->updateValue('payment_status', $paymentIntent->status);
						$subscription->values->put('updated', $checkoutSession->created);
						$subscription->save();
					}

					$subscription->user->sendAutomaticEmail('bank-transfer-received', $subscription->id);

					Log::info('Stripe log ->Async payment update completed');
				}
				else Log::info('Stripe log ->Subscription not found : ' . $checkoutSession->id);

				break;
			case 'price.updated':
				$price = $event->data->object;

				Log::info('Stripe log ->Price updated : '.$price->id);

				$offer = Offer::where('product_id', $price->product)
					->first();

				if($offer) {
					Log::info('Stripe log ->Offer found : '.$offer->id);

					$product = $stripe->retrieveProduct($price->product);
					$prices = $stripe->retrieveProductPrices($product);

					foreach($prices->data as $price) {
						$priceArray = [
							'id' => $price->id,
							'price' => $price->unit_amount / 100
						];

						if(isset($product->metadata->instead_of)) $priceArray['instead_of'] = $product->metadata->instead_of;
						if(isset($price->metadata->instead_of)) $priceArray['instead_of'] = $price->metadata->instead_of;
						if(isset($price->metadata->label)) $priceArray['label'] = $price->metadata->label;
						if(isset($price->metadata->quantity)) $priceArray['quantity'] = $price->metadata->quantity;

						$pricesArray[] = $priceArray;
					}

					$offer->prices = $pricesArray;
					$offer->save();

					Log::info('Stripe log ->Offer updated successfully');
				}
				else Log::info('Stripe log ->Offer not found : '.$price->product);

				break;
			default:
				Log::info('Stripe log ->Unhandled event type : '.$event->type);
		}

		return response('Webhook handled', Response::HTTP_OK);
	}
}
