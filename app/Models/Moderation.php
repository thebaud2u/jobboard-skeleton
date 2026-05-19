<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Enums\ModerationStates;

use App\Support\{ModerationCompanyDenyReasons, ModerationPostDenyReasons, ModerationCommentDenyReasons};

class Moderation extends Model
{
	protected $fillable = [
		'admin_id',
		'state',
		'reason',
		'description',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'state' => ModerationStates::class,
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	public static function boot()
	{
		parent::boot();
		static::created(function($model) {
			$canSendEmail = false;

			if($model->state == ModerationStates::Validated && ($model->model instanceof Company || $model->model instanceof Post) && $model->model->lastPublication->isPublished()) {
				$canSendEmail = true;
			}

			if($model->model instanceof Company) {
				if($model->state == ModerationStates::Denied) $model->model->user->sendAutomaticEmail('company-denied', $model->model->id);
				elseif($model->state == ModerationStates::Validated && $canSendEmail) $model->model->user->sendAutomaticEmail('company-validated', $model->model->id);
			}
			elseif($model->model instanceof Post) {
				if($model->state == ModerationStates::Denied) $model->model->user->sendAutomaticEmail('post-denied', $model->model->id);
				elseif($model->state == ModerationStates::Validated && $canSendEmail) $model->model->user->sendAutomaticEmail('post-validated', $model->model->id);
			}
		});
	}

	// Relations
	public function admin(): BelongsTo
	{
		return $this->belongsTo(Admin::class);
	}

	public function model(): MorphTo
	{
		return $this->morphTo()->withoutTrashed();
	}

	// Functions
	public function isDenied(): bool
	{
		return $this->state === ModerationStates::Denied;
	}

	public function isValidated(): bool
	{
		return $this->state === ModerationStates::Validated;
	}

	public function isWaiting(): bool
	{
		return $this->state === ModerationStates::Waiting;
	}

	public function getReasonTitle(): string
	{
		if($this->model instanceof Company) $reasonTitle = ModerationCompanyDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof Comment) $reasonTitle = ModerationCommentDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof Post) $reasonTitle = ModerationPostDenyReasons::HISTORY[$this->reason]['Title'];

		return __($reasonTitle);
	}
}
