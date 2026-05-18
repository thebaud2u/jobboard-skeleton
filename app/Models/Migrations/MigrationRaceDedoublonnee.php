<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationRaceDedoublonnee extends Model
{
	protected $table = 'migration_races_dedoublonnees';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'race_id',
		'race_doublon',
		'race',
		'famille',
		'race_slugifiee',
		'url',
		'isRaceParente'
	];
}
