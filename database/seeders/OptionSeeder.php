<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Option;

class OptionSeeder extends Seeder
{
	public function run(): void
	{
		$data = [
			[
				'name' => 'Credits validity : 1 year',
				'code' => 'credit-validity',
				'type' => 'post'
			],
			[
				'name' => 'Diffusion time : 3 months',
				'code' => 'diffusion-time',
				'type' => 'post'
			],
			[
				'name' => 'Monthly posts refresh',
				'code' => 'monthly-refresh',
				'type' => 'post'
			],
			[
				'name' => 'Weekly posts refresh',
				'code' => 'weekly-refresh',
				'type' => 'post'
			],
			[
				'name' => 'Link to your company page',
				'code' => 'company-page-link',
				'type' => 'post'
			],
			[
				'name' => '1 photo per animal',
				'code' => '1-photo',
				'type' => 'post'
			],
			[
				'name' => '3 photos per animal',
				'code' => '3-photo',
				'type' => 'post'
			],
			[
				'name' => '5 photo per animal',
				'code' => '5-photo',
				'type' => 'post'
			],
			[
				'name' => 'Framed posts',
				'code' => 'visibility-framed',
				'type' => 'post'
			],
			[
				'name' => 'Highlighting + framed posts',
				'code' => 'visibility-highlighting',
				'type' => 'post'
			],
			[
				'name' => 'Social network broadcasting',
				'code' => 'social-network-broadcasting',
				'type' => 'post'
			],
			[
				'name' => 'Description',
				'code' => 'description',
				'type' => 'company'
			],
			[
				'name' => 'Localisation',
				'code' => 'localisation',
				'type' => 'company'
			],
			[
				'name' => '1 breed',
				'code' => '1-breed',
				'type' => 'company'
			],
			[
				'name' => '3 breeds',
				'code' => '3-breed',
				'type' => 'company'
			],
			[
				'name' => 'Unlimited breeds',
				'code' => 'unlimited-breed',
				'type' => 'company'
			],
			[
				'name' => 'Contact button',
				'code' => 'contact-button',
				'type' => 'company'
			],
			[
				'name' => 'Displays your breeders on your company page',
				'code' => 'display-breeders',
				'type' => 'company'
			],
			[
				'name' => 'Display your posts on your company page',
				'code' => 'display-posts',
				'type' => 'company'
			],
			[
				'name' => 'Weekly refresh of your company',
				'code' => 'weekly-refresh',
				'type' => 'company'
			],
			[
				'name' => '1 photo',
				'code' => '1-photo',
				'type' => 'company'
			],
			[
				'name' => '10 photos',
				'code' => '10-photo',
				'type' => 'company'
			],
			[
				'name' => '15 photos',
				'code' => '15-photo',
				'type' => 'company'
			],
			[
				'name' => 'Refresh of your posts',
				'code' => 'posts-refresh',
				'type' => 'company'
			],
			[
				'name' => '4 videos',
				'code' => '4-video',
				'type' => 'company'
			],
			[
				'name' => '1 logo',
				'code' => '1-logo',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => '10 photo',
				'code' => '10-photo',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => '1 rubrique',
				'code' => '1-rubrique',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Site Internet + RS',
				'code' => 'site-internet-rs',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Description produits ou services',
				'code' => 'description-produits-services',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Horaires d\'ouverture',
				'code' => 'horaires-ouverture',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Description',
				'code' => 'description',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Localisation',
				'code' => 'localisation',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => 'Contact button',
				'code' => 'contact-button',
				'type' => 'pack-secondary-activity'
			],
			[
				'name' => '1 logo',
				'code' => '1-logo',
				'type' => 'pack-activity'
			],
			[
				'name' => '1 rubrique',
				'code' => '1-rubrique',
				'type' => 'pack-activity'
			],
			[
				'name' => '10 photo',
				'code' => '10-photo',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Site Internet + RS',
				'code' => 'site-internet-rs',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Description produits ou services',
				'code' => 'description-produits-services',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Horaires d\'ouverture',
				'code' => 'horaires-ouverture',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Description',
				'code' => 'description',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Localisation',
				'code' => 'localisation',
				'type' => 'pack-activity'
			],
			[
				'name' => 'Contact button',
				'code' => 'contact-button',
				'type' => 'pack-activity'
			],
		];

		foreach($data as $option) {
			$newOption = new Option;
			$newOption->name = $option['name'];
			$newOption->code = $option['code'];
			$newOption->type = $option['type'];
			$newOption->save();
		}
	}
}
