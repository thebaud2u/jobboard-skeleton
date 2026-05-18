<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Offer;

use App\Services\StripeService;

class OfferSeeder extends Seeder
{
	public function run(): void
	{
		$stripe = new StripeService;
		$products = $stripe->listAllProducts();

		foreach($products->data as $product) {
			$pricesArray = array();

			$newOffer = new Offer;
			$newOffer->name = $product->name;
			$newOffer->product_id = $product->id;
			$newOffer->description = $product->description;
			$newOffer->type = $product->metadata->type;

			$prices = $stripe->retrieveProductPrices($product->id);

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

			$newOffer->prices = $pricesArray;
			$newOffer->save();
		}

		$newOffer = new Offer;
		$newOffer->name = 'Page entreprise Standard';
		$newOffer->type = 'company';
		$newOffer->free = true;
		$newOffer->save();
	}
}