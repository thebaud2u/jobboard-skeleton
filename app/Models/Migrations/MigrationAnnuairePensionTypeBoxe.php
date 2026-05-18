<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class MigrationAnnuairePensionTypeBoxe extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'id',
		'id_membre',
		'types_de_boxes'
	];
}
