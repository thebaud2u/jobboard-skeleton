<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class City extends Model
{
	public $timestamps = false;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'department_code',
		'name',
		'slug',
		'zip_code',
		'gps_lat',
		'gps_lng'
	];

	public function department(): BelongsTo
	{
		return $this->belongsTo(Department::class, 'department_code', 'code');
	}

	public function region(): HasOneThrough
	{
		return $this->hasOneThrough(Region::class, Department::class, 'code', 'code', 'department_code', 'region_code');
	}
}
