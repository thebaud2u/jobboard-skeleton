<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Region extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'code',
		'name',
		'slug',
		'country_code'
	];

	public function departments(): HasMany
	{
		return $this->hasMany(Department::class, 'region_code', 'code');
	}

	public function cities(): HasManyThrough
	{
		return $this->hasManyThrough(City::class, Department::class, 'region_code', 'department_code', 'code', 'code');
	}

	public function country(): BelongsTo
	{
		return $this->belongsTo(Country::class, 'country_code', 'code');
	}
}
