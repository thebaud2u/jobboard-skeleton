<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationChiotChaton extends Model
{
	protected $table = 'migration_chiots_chatons';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_animal',
		'id_membre',
		'id_pere',
		'id_mere',
		'id_portee',
		'famille',
		'race',
		'sexe',
		'nom',
		'statut',
		'robe',
		'identification',
		'animal_sterilise',
		'numero_livre_origine',
		'liste_vaccin',
		'description',
		'tarif',
		'photos',
		'date_ajout_bdd',
		'id_annonce'
	];
}
