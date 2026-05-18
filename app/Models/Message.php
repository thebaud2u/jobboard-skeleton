<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\Message as ModelsMessage;

use App\Notifications\MessageSent;

class Message extends ModelsMessage
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'thread_id',
		'user_id',
		'body',
		'file',
		'is_read',
		'automated',
		'values',
		'company_id',
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'is_read' => 'boolean',
		'automated' => 'boolean',
		'values' => AsCollection::class,
	];

	// Tools
	public static function boot()
	{
		parent::boot();
		static::created(function($message) {
			if(Auth::guard('web')->check()) {
				$response = Response::where('thread_id', $message->thread_id)
					->first();

				// Permet de faire remonter la conversation
				if($response) $response->touchQuietly();

				$recipient = $message->participants->where('user_id', '!=', Auth::guard('web')->user()->id)
					->first();

				if($recipient) {
					$user = User::find($recipient->user_id);

					if($user && ($user->slug != 'assur-opoil' && $user->slug != 'eleveurs-online') && $response) {
						$user->notify(new MessageSent($response, $message, Auth::guard('web')->user()));
					}
				}
			}
		});
	}

	// Relations
	public function company(): BelongsTo
	{
		return $this->belongsTo(Company::class);
	}

	// Functions
	public function markAsRead(): void
	{
		$this->update(['is_read' => true]);
	}
}
