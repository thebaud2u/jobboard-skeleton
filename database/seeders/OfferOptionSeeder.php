<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Offer;
use App\Models\Option;

class OfferOptionSeeder extends Seeder
{
	public function run(): void
	{
		$data = [
			[
				'offer' => [
					'slug' => 'page-elevage-standard',
					'type' => 'company'
				],
				'offer_options'=> [
					'1-breed',
					'description',
					'localisation',
					'1-photo'
				]
			],
			[
				'offer' => [
					'slug' => 'page-elevage-premium',
					'type' => 'company'
				],
				'offer_options'=> [
					'3-breed',
					'description',
					'localisation',
					'10-photo',
					'posts-refresh',
					'display-posts',
				]
			],
			[
				'offer' => [
					'slug' => 'page-elevage-master',
					'type' => 'company'
				],
				'offer_options'=> [
					'unlimited-breed',
					'description',
					'localisation',
					'15-photo',
					'posts-refresh',
					'display-posts',
					'4-video',
					'contact-button',
					'display-breeders',
					'weekly-refresh',
				]
			],
			[
				'offer' => [
					'slug' => 'annonce-standard',
					'type' => 'post'
				],
				'offer_options'=> [
					'credit-validity',
					'diffusion-time',
					'company-page-link',
					'1-photo'
				]
			],
			[
				'offer' => [
					'slug' => 'annonce-premium',
					'type' => 'post'
				],
				'offer_options'=> [
					'credit-validity',
					'diffusion-time',
					'company-page-link',
					'3-photo',
					'monthly-refresh',
					'visibility-framed'
				]
			],
			[
				'offer' => [
					'slug' => 'annonce-master',
					'type' => 'post'
				],
				'offer_options'=> [
					'credit-validity',
					'diffusion-time',
					'company-page-link',
					'5-photo',
					'weekly-refresh',
					'visibility-highlighting',
					'social-network-broadcasting'
				]
			],
			[
				'offer' => [
					'slug' => 'activite-secondaire',
					'type' => 'pack-secondary-activity'
				],
				'offer_options'=> [
					'description',
					'1-rubrique',
					'1-logo',
					'10-photo',
					'localisation',
					'site-internet-rs',
					'description-produits-services',
					'horaires-ouverture',
					'contact-button'
				]
			],
			[
				'offer' => [
					'slug' => 'annuaire-produits-et-services',
					'type' => 'pack-activity'
				],
				'offer_options'=> [
					'description',
					'1-rubrique',
					'1-logo',
					'10-photo',
					'localisation',
					'site-internet-rs',
					'description-produits-services',
					'horaires-ouverture',
					'contact-button'
				]
			],
		];

		foreach($data as $value) {
			$offer = Offer::findBySlug($value['offer']['slug']);

			foreach($value['offer_options'] as $offerOption) {
				$option = Option::where('code', $offerOption)
					->where('type', $value['offer']['type'])
					->first();

				$offer->options()->attach($option->id);
			}
		}
	}
}
