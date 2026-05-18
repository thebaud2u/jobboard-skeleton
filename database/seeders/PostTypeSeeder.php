<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\PostType;

class PostTypeSeeder extends Seeder
{
	public function run(): void
	{
		$postType = new PostType([
			'name' => 'litter',
			'slug' => ['en' => 'litter', 'fr' => 'portee']
		]);
		$postType->save();

		$postType = new PostType([
			'name' => 'litter yet to come',
			'slug' => ['en' => 'litter-yet-to-come', 'fr' => 'portee-a-venir']
		]);
		$postType->save();

		$postType = new PostType([
			'name' => 'retired breeder',
			'slug' => ['en' => 'retired-breeder', 'fr' => 'adulte-retraite']
		]);
		$postType->save();

		$postType = new PostType([
			'name' => 'stud',
			'slug' => ['en' => 'stud', 'fr' => 'etalon']
		]);
		$postType->save();
	}
}