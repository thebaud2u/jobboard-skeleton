<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Option extends Model
{
	protected $fillable = [
		'name',
		'code',
		'type',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relations
	public function offers(): BelongsToMany
	{
		return $this->belongsToMany(Offer::class, 'offers_options', 'option_id', 'offer_id');
	}
}
