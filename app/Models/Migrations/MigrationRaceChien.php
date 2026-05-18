<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationRaceChien extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'nouvel_id',
		'nom',
		'id_ancienne_liste',
		'utilisation_questionnaire',
		'espece',
		'nom_commun',
		'numero_groupe',
		'top_races',
		'libele_groupe',
		'chapo_introduction',
		'aspect_general',
		'caracteristiques',
		'entretien',
		'sante',
		'id_photos',
		'poil',
		'taille',
		'protecteur',
		'sportif',
		'affectueux',
		'assistance',
		'besoin_education',
		'besoin_attention',
		'besoin_toilettage',
		'rarete_race',
		'chien_chasse',
		'hypoallergenique',
		'voyage_avion',
		'deuxieme_categorie',
		'brachicephale',
		'prix_moyen_etalon',
		'prix_moyen_chiot_LOF',
		'prix_moyen_retraite',
		'id_standard',
		'titre_standard',
	];
}
