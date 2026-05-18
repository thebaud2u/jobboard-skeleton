<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
	public function run(): void
	{
		LazyCollection::make(function() {
			$handle = fopen("database/seeders/csv/regions.csv", 'r');

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
					'code' => $row[1],
					'name' => $row[2],
					'slug' => Str::of($row[2])->slug('-'),
					'country_code' => 'FRA',
				];
			})->toArray();

			DB::table('regions')->insert($records);
		});
	}
}