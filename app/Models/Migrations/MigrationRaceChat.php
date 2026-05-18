<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationRaceChat extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'race',
		'nouvel_id',
		'ancien_id',
		'autre_noms',
		'code',
		'chapo_introduction',
		'aspect_general',
		'caracteristiques',
		'entretien',
		'sante',
		'id_photos',
		'poil',
		'taille',
		'besoin_activite',
		'besoin_attention',
		'besoin_toilettage',
		'rarete_race',
		'besoin_independance',
		'hypoallergenique',
		'id_standard',
		'titre_standard'
	];
}