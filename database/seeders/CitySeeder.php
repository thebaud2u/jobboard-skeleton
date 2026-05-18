<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class CitySeeder extends Seeder
{
	public function run(): void
	{
		DB::statement('ALTER TABLE `cities` ADD FULLTEXT INDEX cities_fulltext_index (zip_code, name)');

		LazyCollection::make(function() {
			$handle = fopen("database/seeders/csv/cities.csv", 'r');

			while (($line = fgetcsv($handle, 4096)) !== false) {
			$dataString = implode(",", $line);
			$row = explode(',', $dataString);
			yield $row;
			}

			fclose($handle);
		})
		->skip(1)
		->chunk(1000)
		->each(function (LazyCollection $chunk) {
			$records = $chunk->map(function ($row) {
				return [
					'id' => $row[0],
					'department_code' => $row[1],
					'insee_code' => $row[2],
					'zip_code' => $row[3],
					'name' => $row[4],
					'slug' => Str::of($row[4])->slug('-'),
					'gps_lat' => $row[6],
					'gps_lng' => $row[7],
				];
			})->toArray();

			DB::table('cities')->insert($records);
		});
	}
}