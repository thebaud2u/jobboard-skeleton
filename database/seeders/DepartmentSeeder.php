<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
	public function run(): void
	{
		LazyCollection::make(function() {
			$handle = fopen("database/seeders/csv/departments.csv", 'r');

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
					'region_code' => $row[1],
					'code' => $row[2],
					'name' => $row[3],
					'slug' => Str::of($row[3])->slug('-'),
				];
			})->toArray();

			DB::table('departments')->insert($records);
		});
	}
}