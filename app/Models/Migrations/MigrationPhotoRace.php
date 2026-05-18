<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationPhotoRace extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'is_denomination_secondaire',
		'id_race',
		'race',
		'famille',
		'url',
		'photo1000',
		'photo660'
	];
}
