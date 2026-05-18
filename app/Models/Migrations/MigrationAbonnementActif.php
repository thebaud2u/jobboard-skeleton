<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAbonnementActif extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_membre',
		'login',
		'email',
		'formule_abonnement',
		'formule_abonnement_libelle',
		'formule_abonnement_expiration',
		'option_encadrement',
		'option_sms',
		'nombre_annonce',
		'nombre_annonce_encadree',
		'date_fin',
	];
}
