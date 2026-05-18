<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnnuaireEducateurHoraire extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_membre',
		'id_jour',
		'horaire_matin_1',
		'horaire_matin_2',
		'horaire_apres_midi_1',
		'horaire_apres_midi_2',
		'type_rendez_vous'
	];
}
