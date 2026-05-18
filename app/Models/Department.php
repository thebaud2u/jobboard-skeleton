<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
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
		'region_code'
	];

	public function region(): BelongsTo
	{
		return $this->belongsTo(Region::class, 'region_code', 'code');
	}

	public function cities(): HasMany
	{
		return $this->hasMany(City::class, 'department_code', 'code');
	}
}
