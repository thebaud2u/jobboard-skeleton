<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\MailQueueStates;

class MailQueue extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'response_id',
		'identifier',
		'frequency',
		'state',
		'last_sent',
		'created_at',
		'updated_at'
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'state' => MailQueueStates::class,
			'last_sent' => 'date',
			'created_at' => 'datetime',
			'updated_at' => 'datetime'
		];
	}

	// Relations
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function response(): BelongsTo
	{
		return $this->belongsTo(Response::class);
	}
}
