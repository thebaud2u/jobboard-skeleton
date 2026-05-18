<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationStandardRace extends Model
{
	protected $table = 'migration_standards_race';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'identifiant',
		'titre',
		'especes',
		'id_races',
		'races',
		'numeros_standards_races',
		'illustration',
		'copyright_photo',
		'header',
		'contenu',
		'date_creation',
		'date_modification',
		'publication'
	];
}
