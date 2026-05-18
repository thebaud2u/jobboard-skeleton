<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model
{
	public $timestamps = false;

	protected $fillable = [
		'street',
		'additional_1',
		'additional_2',
		'custom_postcode',
		'custom_province',
		'custom_city',
		'country_id',
		'region_id',
		'department_id',
		'city_id',
		'gps_lat',
		'gps_lng',
		'for_moderation',
		'collection'
	];

	// Relations
	public function city(): BelongsTo
	{
		return $this->belongsTo(City::class);
	}

	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class);
	}

	public function department(): BelongsTo
	{
		return $this->belongsTo(Department::class);
	}	

	public function model(): MorphTo
	{
		return $this->morphTo();
	}

	public function region(): BelongsTo
	{
		return $this->belongsTo(Region::class);
	}
}
