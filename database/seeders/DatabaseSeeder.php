<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
		$this->call([
			CountrySeeder::class,
			RegionSeeder::class,
			DepartmentSeeder::class,
			CitySeeder::class,
			OfferSeeder::class,
			OptionSeeder::class,
			OfferOptionSeeder::class,
			RoleSeeder::class,
			AdminSeeder::class,
			PostTypeSeeder::class,
			SubscriptionSeeder::class,
		]);
	}
}
