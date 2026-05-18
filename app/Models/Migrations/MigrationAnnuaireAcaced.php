<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnnuaireAcaced extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_acaced',
		'identifiant',
		'nom',
		'adresse',
		'code_postal',
		'ville',
		'email',
		'telephone',
		'site',
		'habilitation_debut',
		'habilitation_fin',
		'chiens',
		'chats',
		'etat'
	];
}
