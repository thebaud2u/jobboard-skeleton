<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationPortee extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_portee',
		'id_membre',
		'espece',
		'id_race',
		'nom_race',
		'id_mere',
		'id_pere',
		'de_race',
		'numero_portee',
		'date_naissance',
		'date_disponibilite',
		'nb_males',
		'nb_femelles',
		'date_enregistrement',
		'date_modification',
		'diffusion',
		'etat'
	];
}
