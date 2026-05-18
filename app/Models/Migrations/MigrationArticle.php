<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationArticle extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'identifiant',
		'titre',
		'rubrique',
		'sous_rubrique',
		'especes',
		'races',
		'publi_redactionnel',
		'illustration',
		'copyright_photo',
		'header',
		'contenu',
		'date_publication',
		'date_fin_publication',
		'auteur',
		'publication'
	];
}
