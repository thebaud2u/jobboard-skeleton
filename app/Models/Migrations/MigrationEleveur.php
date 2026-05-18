<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationEleveur extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_eleveur',
		'identifiant',
		'civilite_libelle',
		'nom',
		'prenom',
		'login',
		'email',
		'password',
		'date_creation_compte',
		'telephone',
		'option_sms',
		'telephone_sms',
		'sms_telephone_etat',
		'sms_heure_debut',
		'sms_heure_fin',
		'nr_date_naissance',
		'date_verification_email',
		'date_derniere_connexion',
		'optin_newsletter',
		'nr_optin_editeurs',
		'nr_optin_partenaires',
		'role_utilisateur',
		'nr_interesse_par',
		'nr_mon_habitation',
		'nr_les_animaux_dans_mon_foyer',
		'nr_mon_experience_avec_les_animaux',
		'nr_la_composition_de_mon_menage',
		'nr_mon_projet_adoption',
		'siret',
		'etat_validation_siret',
		'date_validation_siret',
		'raison_sociale',
		'adresse_1',
		'adresse_2',
		'code_postal',
		'ville',
		'pays',
		'nr_charte_EOL_chiens',
		'nr_charte_EOL_chats',
		'race_elevee',
		'etat',
		'is_acaced_chat',
		'is_acaced_chien',
		'is_verified',
		'is_verified_print'
	];
}
