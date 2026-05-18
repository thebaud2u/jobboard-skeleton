<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationClubRace extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id_club',
		'nom_club',
		'adresse_1',
		'adresse_2',
		'code_postal',
		'ville',
		'nom_n2',
		'FRA',
		'telephone_club',
		'portable_club',
		'fax_club',
		'email_club',
		'lien',
		'civilite_president',
		'nom_president',
		'prenom_president',
		'civilite_contact',
		'nom_contact',
		'prenom_contact',
		'email_contact',
		'telephone_contact',
		'date_inscription',
		'presentation',
		'nombre_adherents',
		'annee',
		'scc'
	];
}
