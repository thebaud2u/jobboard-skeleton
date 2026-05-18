<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use Illuminate\Notifications\Notifiable;

use App\Notifications\MailLogCreated;

class MailLog extends Model
{
	use Notifiable;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'type',
		'reminder_number',
		'user_id',
	];

	public static function boot()
	{
		parent::boot();
		static::created(function($model) {
			$model->notify(new MailLogCreated($model));
		});
	}

	// Relations
	public function model(): MorphTo
	{
		return $this->morphTo();
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function post(): BelongsTo
	{
		return $this->belongsTo(Post::class);
	}
}
