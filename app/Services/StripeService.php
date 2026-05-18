<?php

namespace App\Services;

use Stripe\StripeClient;

use App\Models\User;

class StripeService
{
	protected $stripeClient;

	public function __construct()
	{
		$this->stripeClient = new StripeClient(config('services.stripe.secret'));
	}

	// Charge
	public function retrieveCharge($chargeId)
	{
		return $this->stripeClient->charges->retrieve($chargeId);
	}

	// Checkout session
	public function listallCheckoutSession()
	{
		return $this->stripeClient->checkout->sessions->all();
	}

	public function retrieveCheckoutSession($checkoutSessionId)
	{
		return $this->stripeClient->checkout->sessions->retrieve($checkoutSessionId, []);
	}

	public function retrieveLineItemsFromCheckoutSession($checkoutSessionId)
	{
		return $this->stripeClient->checkout->sessions->allLineItems($checkoutSessionId);
	}

	public function retrieveCheckoutSessionsFromUser(User $user)
	{
		if(is_null($user->customer_id)) $customerId = $this->createCustomer($user)->id;
		else $customerId = $user->customer_id;

		return $this->stripeClient->checkout->sessions->all(['customer' => $customerId]);
	}

	public function createCheckoutSession(User $user, $priceId, $successUrl, $cancelUrl)
	{
		if(is_null($user->customer_id)) $customerId = $this->createCustomer($user)->id;
		else $customerId = $user->customer_id;

		return $this->stripeClient->checkout->sessions->create([
			'customer' => $customerId,
			'line_items' => [
				[
					'price' => $priceId,
					'quantity' => 1,
				],
			],
			'success_url' => $successUrl,
			'cancel_url' => $cancelUrl,
			'allow_promotion_codes' => true,
			'mode' => 'payment',
			'billing_address_collection' => 'required',
			'shipping_address_collection' => [
				'allowed_countries' => ['FR', 'BE'],
			],
			'customer_update' => ['shipping' => 'auto'],
			'automatic_tax' => ['enabled' => true],
			'invoice_creation' => ['enabled' => true]
		]);
	}

	public function expireCheckoutSession($checkoutSessionId)
	{
		return $this->stripeClient->checkout->sessions->expire($checkoutSessionId, []);
	}

	public function expireAllCheckoutSession()
	{
		$checkoutSessions = $this->listallCheckoutSession();

		foreach($checkoutSessions->data as $checkoutSession) {
			if($checkoutSession->status != 'expired') $stripe->expireCheckoutSession($checkoutSession->id);
		}
	}

	// Customers
	public function listAllCustomers()
	{
		return $this->stripeClient->customers->all();
	}

	public function retrieveCustomer(User $user)
	{
		if(is_null($user->customer_id)) {
			$newCustomer = $this->createCustomer($user);
			$customerId = $newCustomer->id;
		}
		else $customerId = $user->customer_id;

		return $this->stripeClient->customers->retrieve($customerId);
	}

	public function createCustomer(User $user)
	{
		$params = array(
			'name' => $user->name,
			'email' => $user->email,
			'phone' => $user->phone,
		);

		if($user->address) {
			$address = $user->address;

			$params['address'] = [
				'city' => $address->city->name ?? $address->custom_city ?? null,
				'country' => $address->country->iso_code ?? 'FR',
				'line1' => $address->street ?? null,
				'line2' => $address->addtional_1 ?? null,
				'postal_code' => $address->city->zip_code ?? $address->custom_postcode ?? null,
				'state' => $address->custom_province ?? $address->department->name ?? null
			];
		}

		$newCustomer = $this->stripeClient->customers->create($params);
		$user->customer_id = $newCustomer->id;
		$user->save();

		return $newCustomer;
	}

	public function retrieveInvoiceFromCheckoutSession($checkoutSessionId)
	{
		$session = $this->retrieveCheckoutSession($checkoutSessionId);

		if($session->invoice) $invoice = $this->stripeClient->invoices->retrieve($session->invoice);
		else $invoice = null;

		return $invoice;
	}

	// Payment intent
	public function retrievePaymentIntent($paymentIntentId)
	{
		return $this->stripeClient->paymentIntents->retrieve($paymentIntentId);
	}

	public function retrievePaymentMethod($paymentMethodId)
	{
		return $this->stripeClient->paymentMethods->retrieve($paymentMethodId);
	}

	// Prices
	public function retrievePrice($priceId)
	{
		return $this->stripeClient->prices->retrieve($priceId);
	}

	// Products
	public function listAllProducts()
	{
		return $this->stripeClient->products->all(['active' => true]);
	}

	public function retrieveProduct($productId)
	{
		return $this->stripeClient->products->retrieve($productId);
	}

	public function retrieveProductPrices($productId)
	{
		return $this->stripeClient->prices->all([
			'product' => $productId,
			'active' => true
		]);
	}
}
