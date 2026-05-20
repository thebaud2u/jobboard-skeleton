<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Laravel\Sanctum\HasApiTokens;

use Cmgmyr\Messenger\Traits\Messagable;

use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\PermissionRegistrar;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use Overtrue\LaravelFavorite\Traits\Favoriter;

use App\Enums\{PublicationStates, ResponseStates};

use App\Notifications\CustomResetPassword;
use App\Notifications\CustomVerifyEmail;

use App\Traits\{AutomaticEmails, DisplayAddress, HasValuesCollection, ModerationTools, SubscriptionTools};

class User extends Authenticatable implements HasMedia, MustVerifyEmail
{
	use AutomaticEmails, DisplayAddress, Favoriter, HasRoles, HasSlug, HasValuesCollection, InteractsWithMedia, Messagable, ModerationTools, Notifiable, SoftDeletes, SubscriptionTools;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'gender',
		'name',
		'slug',
		'firstname',
		'lastname',
		'email',
		'code',
		'other',
		'phone',
		'values',
		'birth_date',
		'pending'
	];

	protected $hidden = [
		'password',
		'remember_token'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'values' => AsCollection::class,
		'birth_date' => 'date',
		'email_verified_at' => 'datetime',
		'last_logon' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime'
	];

	/**
	 * The events that wil be automatically logged
	 *
	 * @var array<int, string>
	 */
	protected static $recordEvents = ['created', 'updated', 'deleted', 'restored'];

	public static function boot()
	{
		parent::boot();
		static::deleted(function($user) {
			if($user->applicants->isNotEmpty()) {
				foreach($user->applicants as $response) {
					$response->state = ResponseStates::Closed;
					$response->saveQuietly();
				}
			}

			if($user->applications->isNotEmpty()) {
				foreach($user->applications as $response) {
					$response->state = ResponseStates::Closed;
					$response->saveQuietly();
				}
			}
		});
	}

	// Tools
	public function getRouteKey()
	{
		return 'slug';
	}

	/**
	 * Get the options for generating the slug.
	 *
	 * @return SlugOptions
	 */
	public function getSlugOptions(): SlugOptions
	{
		return SlugOptions::create()
			->saveSlugsTo('slug')
			->generateSlugsFrom('name');
	}

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('avatar')->singleFile();
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('avatar')
			->width(360)
			->height(360);
	}

	// Overrides default mail sender for the password reset process
	public function sendPasswordResetNotification($token)
	{
		$this->notify(new CustomResetPassword($token));
	}

	// Overrides default mail sender for the mail verification process
	public function sendEmailVerificationNotification()
	{
		$this->notify(new CustomVerifyEmail());
	}

	// Relations
	public function address(): MorphOne
	{
		return $this->morphOne(Address::class, 'model');
	}

	public function alerts(): HasMany
	{
		return $this->hasMany(Alert::class);
	}

	// All responses where the current user is the recipient
	public function applicants(): HasMany
	{
		return $this->hasMany(Response::class, 'to_user_id');
	}

	public function applications(): HasMany
	{
		return $this->hasMany(Response::class, 'from_user_id');
	}

	public function company(): HasOne
	{
		return $this->hasOne(Company::class);
	}

	public function latestSubscription(): HasOne
	{
		return $this->hasOne(Subscription::class)
			->latestOfMany()
			->withTrashed();
	}

	public function mailLogs(): HasMany
	{
		return $this->hasMany(MailLog::class);
	}

	public function mediable(): HasMany
	{
		return $this->hasMany(Mediable::class);
	}

	public function messages(): HasMany
	{
		return $this->hasMany(Message::class);
	}

	public function posts(): HasMany
	{
		return $this->hasMany(Post::class);
	}

	public function readNotifications(): HasMany
	{
		return $this->hasMany(ReadNotification::class);
	}

	public function subscriptions(): HasMany
	{
		return $this->hasMany(Subscription::class);
	}

	public function commentsGiven(): MorphMany
	{
		return $this->morphMany(Comment::class, 'source');
	}

	// Functions
	public function initValues(): void
	{
		$values = new Collection();
		$values->put('optins', [
			'optin_newsletter' => 0,
			'optin_receive_info' => 0,
			'optin_receive_deals' => 0
		]);

		$this->values = $values;
		$this->save();
	}

	public function profileCompletionPercentage(): float
	{
		if(is_null($this->values)) $this->initValues();

		$count = 0;
		$total = 2;

		if(!is_null($this->phone)) $count++;
		if($this->address()->count() > 0) $count++;

		return number_format($count*100/$total, 2);
	}

	public function hasApplied($element): bool
	{
		return $element->responses()->whereHas('from', function($whereHas) {
				$whereHas->where('id', '=', $this->id);
			})
			->exists();
	}

	/**
	 * HasViewed or not a given element
	 *
	 * @param class User or class Post
	 * @param int id
	 * @return int
	 */
	public function hasViewed($elementType, $elementId): int
	{
		return UsersViews::whereHas('user', function($whereHas) {
				$whereHas->where('id', '=', $this->id);
			})
			->where('element_type', '=', $elementType)
			->where('element_id', '=', $elementId)
			->count();
	}

	/**
	 * HasViewed or not a given element
	 *
	 * @param class User or class Post
	 * @param int id
	 * @return int
	 */
	public function recentlyViewedPosts(): Collection
	{
		$viewedPosts = UsersViews::whereHas('user', function($whereHas) {
				$whereHas->where('id', '=', $this->id);
			})
			->where('element_type', '=', Post::class)
			->select('element_id')
			->limit(9)
			->get()
			->toArray();

		return Post::whereIn('id', $viewedPosts)
			->get();
	}

	public function getPostStats(): array
	{
		$activePosts = $this->posts()->whereHas('lastPublication', function($whereHas) {
				$whereHas->where('state', PublicationStates::Published)
					->orWhere('state', PublicationStates::PublishedUpdatedWaitingModeration)
					->orWhere('state', PublicationStates::PublishedUpgradedWaitingModeration);
			})
			->count();

		$draftPosts = $this->posts()->whereHas('lastPublication', function($whereHas) {
				$whereHas->where('state', PublicationStates::Draft)
					->orWhere('state', PublicationStates::DraftWaitingModerationForPublication);
			})
			->count();

		$inactivePosts = $this->posts()->whereHas('lastPublication', function($whereHas) {
				$whereHas->where('state', PublicationStates::Archived)
					->orWhere('state', PublicationStates::Deleted);
			})
			->count();

		return $stats = [
			'activePosts' => $activePosts,
			'draftPosts' => $draftPosts,
			'inactivePosts' => $inactivePosts
		];
	}

	public function getResponseStats(): array
	{
		$applicants = $this->applicants()
			->where('state', ResponseStates::Received)
			->count();

		$applications = $this->applications()
			->where('state', ResponseStates::Received)
			->count();

		$receivedResponses = $applications + $applicants;

		$appointments = $this->appointments()->whereDate('date', '>=', Carbon::now())
			->get()
			->filter(function($appointment) {
				$start = Carbon::parse($appointment->date)
					->setTimeFromTimeString($appointment->values->get('start_hour'));

				return $start >= Carbon::now();
			});

		$appointeds = $this->appointed()->whereDate('date', '>=', Carbon::now())
			->get()
			->filter(function($appointment) {
				$start = Carbon::parse($appointment->date)
					->setTimeFromTimeString($appointment->values->get('start_hour'));

				return $start >= Carbon::now();
			});

		$appointmentsToCome = $appointments->count() + $appointeds->count();

		return $stats = [
			'receivedResponses' => $receivedResponses,
			'appointmentsToCome' => $appointmentsToCome
		];
	}

	public function countUnreadMessages()
	{
		$count = 0;

		$applications = $this->applications()
			->whereHas('thread')
			->get();

		$applicants = $this->applicants()
			->whereHas('thread')
			->get();

		$responses = $applications->merge($applicants);

		if($responses->isNotEmpty()) {
			foreach($responses as $response) {
				$count += $response->thread->messages()
					->whereNot('user_id', $this->id)
					->where('is_read', 0)
					->count();
			}
		}

		return $count;
	}

	public function countResponseUnreadMessages(Response $response): int
	{
		return $response->thread->messages()
			->whereNot('user_id', $this->id)
			->where('is_read', 0)
			->count();
	}

	public function hasCommentWaitingModeration($target): bool
	{
		$hasComment = $this->commentsGiven()->whereHasMorph('target', get_class($target), function($whereHas) use($target) {
				$whereHas->where('id', $target->id);
			})
			->latest()
			->first();

		if($hasComment) return $hasComment->isWaitingModeration();
		else return false;
	}

	public function countPostsWaitingPublicationWithGivenOffer($slug): int
	{
		return $this->posts()->whereHas('lastPublication', function($whereHas) use($slug) {
				$whereHas->where('state', PublicationStates::DraftWaitingModerationForPublication)
					->whereHas('subscription', function($whereHasSubscription) use($slug) {
						$whereHasSubscription->whereHas('offer', function($whereHasOffer) use($slug) {
							$whereHasOffer->where('slug', $slug);
					});
				});
			})
			->count();
	}

	public function getAllNotifications($limit = false)
	{
		return DatabaseNotification::where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('notifiable_type', User::class)
						->where('notifiable_id', $this->id);
				})
				->orWhere(function($orWhere) {
					$orWhere->where('notifiable_type', MailLog::class)
						->whereIn('notifiable_id', $this->mailLogs()->pluck('id'));
				});
			})
			->whereRaw('JSON_LENGTH(data) > 0')
			->orderBy('created_at', 'DESC')
			->when($limit, function($when) {
				$when->limit(5);
			})
			->get();
	}

	public function getNotReadNotifications($limit = false)
	{
		return DatabaseNotification::where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('notifiable_type', User::class)
						->where('notifiable_id', $this->id);
				})
				->orWhere(function($orWhere) {
					$orWhere->where('notifiable_type', MailLog::class)
						->whereIn('notifiable_id', $this->mailLogs()->pluck('id'));
				});
			})
			->whereRaw('JSON_LENGTH(data) > 0')
			->whereNotIn('id', $this->readNotifications()->pluck('notification_id')->toArray())
			->orderBy('created_at', 'DESC')
			->when($limit, function($when) {
				$when->limit(5);
			})
			->get();
	}

	public function getReadNotifications($limit = false)
	{
		return DatabaseNotification::where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('notifiable_type', User::class)
						->where('notifiable_id', $this->id);
				})
				->orWhere(function($orWhere) {
					$orWhere->where('notifiable_type', MailLog::class)
						->whereIn('notifiable_id', $this->mailLogs()->pluck('id'));
				});
			})
			->whereRaw('JSON_LENGTH(data) > 0')
			->whereIn('id', $this->readNotifications()->pluck('notification_id')->toArray())
			->orderBy('created_at', 'DESC')
			->when($limit, function($when) {
				$when->limit(5);
			})
			->get();
	}
}
