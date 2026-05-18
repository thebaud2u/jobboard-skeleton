<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnimal extends Model
{
	protected $table = 'migration_animaux';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_animal',
		'id_membre',
		'identifiant_elevage',
		'espece',
		'sexe',
		'race',
		'de_race',
		'nom',
		'photo',
		'date_naissance',
		'statut',
		'disponibilite',
		'robe',
		'identification',
		'liste_examen',
		'liste_vaccin',
		'mere',
		'pere',
		'description',
		'publication',
		'date_ajout_bdd'
	];
}
