<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationClubRaceRace extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_club',
		'nom_club',
		'espece',
		'id_race',
		'libelle_race'
	];
}
