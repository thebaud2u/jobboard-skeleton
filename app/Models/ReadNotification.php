<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReadNotification extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'notification_id',
		'user_id',
		'created_at',
		'updated_at',
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

	public function notification(): BelongsTo
	{
		return $this->belongsTo(Notification::class);
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
}
