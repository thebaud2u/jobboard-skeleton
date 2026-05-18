<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationElevage extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_elevage',
		'identifiant',
		'nom_elevage',
		'raison_sociale',
		'affixe_canin',
		'affixe_felin',
		'adresse_1',
		'adresse_2',
		'code_postal',
		'ville',
		'pays',
		'espece',
		'id_race',
		'libelle_race',
		'presentation_elevage',
		'facebook',
		'instagram',
		'site',
		'photo_hd',
		'photo_bd',
		'photo_illustration_race',
		'old_slug',
		'nb_reproductrices'
	];
}
