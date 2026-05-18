<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnnuairePensionToilettage extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_membre',
		'prestation',
		'tg',
		'g',
		'm',
		'p',
		'c',
		'intitule'
	];
}
