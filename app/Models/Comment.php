<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Auth;

use App\Enums\{ModerationStates, CommentStates};

use App\Notifications\{CommentCreated, CommentReply};

use App\Traits\ModerationTools;

class Comment extends Model
{
	use ModerationTools, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'source',
		'destination',
		'content',
		'state',
		'created_at',
		'updated_at',
		'deleted_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'state' => CommentStates::class,
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime'
	];

	public static function boot()
	{
		parent::boot();
		static::created(function($model) {
			if(!$model->awaitingModeration()) {
				if($model->target instanceof Company) $model->target->user->notify(new CommentCreated($model));
				elseif($model->target instanceof Breed) {
					if(Auth::guard('web')->user()->hasRole('applicant')) {
						$model->target->companies->each(function($company) use($model) {
							$company->user->notify(new CommentCreated($model));
						});
					}
				}
				elseif($model->target instanceof Comment) {
					$originalTarget = $model->target->getRootComment();

					if(Auth::guard('web')->user()->hasRole(['breeder', 'individual_breeder', 'professionnal_breeder']) && $originalTarget->target instanceof Breed) $originalTarget->source->notify(new CommentReply($model, $originalTarget->target, Auth::guard('web')->user()));
				}
			}
		});
	}

	// Relations
	public function likes(): HasMany
	{
		return $this->hasMany(CommentLike::class);
	}

	public function source(): MorphTo
	{
		return $this->morphTo();
	}

	public function target(): MorphTo
	{
		return $this->morphTo();
	}

	public function commentsReceived(): MorphMany
	{
		return $this->morphMany(Comment::class, 'target');
	}

	// Functions
	public function isDeleted(): bool
	{
		return $this->state === CommentStates::Deleted;
	}

	public function isDenied(): bool
	{
		return $this->state === CommentStates::Denied;
	}

	public function isPublished(): bool
	{
		return $this->state === CommentStates::Published;
	}

	public function isWaitingModeration(): bool
	{
		return $this->state === CommentStates::WaitingModeration;
	}

	public function getRootComment()
	{
		if($this->target instanceof self) {
			return $this->target->root;
		}

		return $this;
	}

	public function getCommentsReceivedPublished()
	{
		return $this->commentsReceived()->where('state', CommentStates::Published);
	}
}
