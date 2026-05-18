<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Enums\ModerationStates;

use App\Support\{ModerationAnimalDenyReasons, ModerationCompanyDenyReasons, ModerationPostDenyReasons, ModerationProfessionnalActivityDenyReasons, ModerationCommentDenyReasons, ModerationUserDenyReasons};

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
			
			if($model->state == ModerationStates::Validated && ($model->model instanceof Company || $model->model instanceof Post || $model->model instanceof ProfessionnalActivity) && $model->model->lastPublication->isPublished()) {
				$canSendEmail = true;
			}

			if($model->model instanceof Animal) {
				if($model->state == ModerationStates::Denied) $model->model->company->user->sendAutomaticEmail('animal-denied', $model->model->id);
			}
			elseif($model->model instanceof Company) {
				if($model->state == ModerationStates::Denied) $model->model->user->sendAutomaticEmail('company-denied', $model->model->id);
				elseif($model->state == ModerationStates::Validated && $canSendEmail) $model->model->user->sendAutomaticEmail('company-validated', $model->model->id);
			}
			elseif($model->model instanceof Post) {
				if($model->state == ModerationStates::Denied) $model->model->user->sendAutomaticEmail('post-denied', $model->model->id);
				elseif($model->state == ModerationStates::Validated && $canSendEmail) $model->model->user->sendAutomaticEmail('post-validated', $model->model->id);
			}
			elseif($model->model instanceof ProfessionnalActivity) {
				if($model->state == ModerationStates::Denied) $model->model->user->sendAutomaticEmail('professionnal-activity-denied', $model->model->id);
				elseif($model->state == ModerationStates::Validated && $canSendEmail) $model->model->user->sendAutomaticEmail('professionnal-activity-validated', $model->model->id);
			}
			elseif($model->model instanceof User) {
				if($model->state == ModerationStates::Denied) {
					if($model->model->hasRole(['professionnal_breeder', 'individual_breeder'])) $model->model->sendAutomaticEmail('breeder-account-denied');
					elseif($model->model->hasRole('professionnal')) $model->model->sendAutomaticEmail('professionnal-account-denied');
				}
				elseif($model->state == ModerationStates::Validated) {
					if($model->model->hasRole(['professionnal_breeder', 'individual_breeder'])) $model->model->sendAutomaticEmail('breeder-account-validated');
					elseif($model->model->hasRole('professionnal')) $model->model->sendAutomaticEmail('professionnal-account-validated');
				}
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
		elseif($this->model instanceof Animal) $reasonTitle = ModerationAnimalDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof ProfessionnalActivity) $reasonTitle = ModerationProfessionnalActivityDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof Comment) $reasonTitle = ModerationCommentDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof Post) $reasonTitle = ModerationPostDenyReasons::HISTORY[$this->reason]['Title'];
		elseif($this->model instanceof User) $reasonTitle = ModerationUserDenyReasons::HISTORY[$this->reason]['Title'];

		return __($reasonTitle);
	}
}
