<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use App\Enums\ResponseStates;

use App\Notifications\{ResponseCreated, ResponseUpdated};

use App\Traits\{DisplayAddress, HasValuesCollection, ModerationTools, SubscriptionTools};

class Response extends Model implements HasMedia
{
	use HasValuesCollection, InteractsWithMedia, SoftDeletes;

	protected $fillable = [
		'thread_id',
		'from_user_id',
		'to_user_id',
		'state',
		'values',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'values' => AsCollection::class,
			'state' => ResponseStates::class
		];
	}

	public static function boot()
	{
		parent::boot();
		static::created(function($response) {
			$thread = Thread::create([
				'subject' => $response->model->name
			]);

			$response->thread_id = $thread->id;
			$response->saveQuietly();

			Participant::create([
				'thread_id' => $thread->id,
				'user_id' => $response->from->id,
				'last_read' => new Carbon()
			]);

			Participant::create([
				'thread_id' => $thread->id,
				'user_id' => $response->to->id,
				'last_read' => new Carbon()
			]);

			if($response->values->has('message')) {
				$newMessage = new Message;
				$newMessage->thread_id = $response->thread->id;
				$newMessage->user_id = $response->from->id;
				$newMessage->body = $response->values->get('message');
				$newMessage->saveQuietly();
			}

			$response->to->notify(new ResponseCreated($response, Auth::guard('web')->user()));
		});

		static::updated(function($response) {
			if($response->state == ResponseStates::Received) {
				$user = null;

				if(Auth::guard('web')->user()->id == $response->from_user_id) $user = $response->to;
				elseif(Auth::guard('web')->user()->id == $response->to_user_id) $user = $response->from;

				if($user) $user->notify(new ResponseUpdated($response, Auth::guard('web')->user()));
			}
		});
	}

	// Tools
	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('photos')->singleFile();
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('photos')
			->width(360)
			->height(360);
	}

	// Relations
	public function appointments(): HasMany
	{
		return $this->hasMany(Appointment::class);
	}

	public function from(): BelongsTo
	{
		return $this->belongsTo(User::class, 'from_user_id')->withTrashed();
	}

	public function model(): MorphTo
	{
		return $this->morphTo()->withTrashed();
	}

	public function mailQueues(): HasMany
	{
		return $this->hasMany(MailQueue::class);
	}

	public function thread(): BelongsTo
	{
		return $this->belongsTo(Thread::class)->withTrashed();
	}

	public function to(): BelongsTo
	{
		return $this->belongsTo(User::class, 'to_user_id')->withTrashed();
	}

	// Functions
	public function getMessages()
	{
		return $this->thread->messages;
	}

	public function getLatestMessage()
	{
		return $this->thread->getLatestMessageAttribute();
	}

	public function isClosed(): bool
	{
		return $this->state === ResponseStates::Closed;
	}

	public function isReceived(): bool
	{
		return $this->state === ResponseStates::Received;
	}

	public function isUnavailable(): bool
	{
		return $this->state === ResponseStates::Unavailable;
	}

	public function hasDataToShow(string $type, string $body): bool
	{
		if($type == 'animal' || ($type == 'post' && $this->model->type->getTranslation('slug', 'en') != 'stud')) {
			return ($this->from->phone || (
					$this->values && 
					$this->values->isNotEmpty() && (
						$this->values->has('animal_experience') ||
						$this->values->has('home_animals') ||
						$this->values->has('place_configuration') ||
						$this->values->has('time_dedication') ||
						$this->values->has('household_composition') ||
						$this->values->has('gender_preference') ||
						$this->values->has('interest_in_other_animal') ||
						($this->values->has('message') && $body != $this->values->get('message')))
				));
		}
		else {
			return (
				$this->values && 
				$this->values->isNotEmpty() && (
					$this->values->has('pure_breed') ||
					$this->values->has('quotation') ||
					$this->values->has('pedigree') ||
					$this->values->has('date') ||
					($this->values->has('message') && $body != $this->values->get('message')))
			) ||
			!is_null($this->getFirstMedia('photos'.$this->id));
		}
	}

	public function newReservationMessage()
	{
		$newMessage = new Message;
		$newMessage->thread_id = $this->thread->id;
		$newMessage->user_id = $this->from->id;
		$newMessage->body = '<div class="flex flex-col gap-y-2">
			<span class="font-bold">
				'.__('Congratulations for your reservation !').'
			</span>

			<span>
				'.__('Your new companion is waiting for you... What if you were already thinking about his health ?').'
			</span>

			<span>
				'.__('Assur O\'Poil, the health insurance recommended by Éleveurs Online, accompanies you from the start with advice, tips and exclusive offers.').'
			</span>

			<form id="figo" action="'.route('api-assuropoil').'" method="POST" class="my-4" target="_blank">
				'.csrf_field().'

				<input type="hidden" name="user_id" value="'.$this->to->id.'" />
				<input type="hidden" name="from" value="eol-conversation-message" />

				<button type="submit" class="inline-flex items-center px-5 py-3 whitespace-nowrap gap-x-2 font-bold bg-white hover:bg-breeder-deepblue border border-breeder-deepblue hover:border-breeder-deepblue rounded-full text-sm text-breeder-deepblue hover:text-white focus:outline-none focus:ring-0 transition ease-in-out duration-150  w-full justify-center">
					'.__('I want to protect my pet').'
				</button>
			</form>
		</div>';
		$newMessage->save();
	}
}
