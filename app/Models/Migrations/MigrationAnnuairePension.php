<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnnuairePension extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_pension',
		'id_membre',
		'civilite',
		'nom',
		'prenom',
		'email',
		'password',
		'raison_sociale',
		'siret',
		'adresse_1',
		'adresse_2',
		'code_postal',
		'ville',
		'pays',
		'telephone',
		'photo',
		'texte_presentation',
		'url',
		'facebook',
		'twitter',
		'instagram',
		'chiens',
		'chats',
		'type_de_box',
		'si_interieur_chauffage',
		'promenade',
		'toilettage',
		'date_inscription',
		'date_derniere_connexion',
		'date_fin_abonnement',
		'etat'
	];
}
