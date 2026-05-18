<?php

namespace App\Models\Migrations;

use Illuminate\Database\Eloquent\Model;

class UrlMatch extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'old_id',
		'old_slug',
		'type',
		'new_id',
		'new_slug',
	];
}
