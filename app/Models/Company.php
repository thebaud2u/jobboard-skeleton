<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

use Overtrue\LaravelFavorite\Traits\Favoriteable;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Enums\{PublicationStates, CommentStates};

use App\Support\StopWords;

use App\Traits\{DisplayAddress, HasValuesCollection, ModerationTools, PublicationTools, SubscriptionTools};

class Company extends Model implements HasMedia, Viewable
{
	use DisplayAddress, Favoriteable, HasSlug, HasValuesCollection, InteractsWithMedia, InteractsWithViews, ModerationTools, PublicationTools, SoftDeletes, SubscriptionTools;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'name',
		'slug',
		'description',
		'values',
		'refreshed_at',
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
		'values' => AsCollection::class,
		'refreshed_at' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'deleted_at' => 'datetime'
	];

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
			->generateSlugsFrom(function() {
				$stopWords = StopWords::list();

				// Construire le pattern avec les délimiteurs de mots \b
				$pattern = '/\b(' . implode('|', array_map('preg_quote', $stopWords)) . ')\b/ui';

				// Remplace les stopwords par un tiret
				$afterReplace = preg_replace($pattern, '-', $this->name);

				// Fusionne les tirets et espaces multiples en un seul tiret
				$afterReplace = preg_replace('/[-\s]+/', '-', $afterReplace);

				// Supprime tirets en début et fin
				$afterReplace = trim($afterReplace, '-');

				return Str::slug($afterReplace);
			})
			->saveSlugsTo('slug');
	}

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('logo')->singleFile();
		$this->addMediaCollection('photos');
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('logo')
			->width(360)
			->height(360);

		$this->addMediaConversion('optimized')
			->performOnCollections('photos')
			->width(1280)
			->height(1280);
	}

	// Relations
	public function address(): MorphOne
	{
		return $this->morphOne(Address::class, 'model')->where('for_moderation', false);
	}

	public function addressForModeration(): MorphOne
	{
		return $this->morphOne(Address::class, 'model')->where('for_moderation', true);
	}

	public function mediable(): HasMany
	{
		return $this->hasMany(Mediable::class);
	}

	public function responses(): MorphMany
	{
		return $this->morphMany(Response::class, 'model');
	}

	public function commentsGiven(): MorphMany
	{
		return $this->morphMany(Comment::class, 'source');
	}

	public function commentsReceived(): MorphMany
	{
		return $this->morphMany(Comment::class, 'target');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	// Functions
	// Returns the current offer of the company, must return any offer from publications except upgrade offer
	public function offer(): Offer
	{
		return $this->publications()
			->whereNot('state', \App\Enums\PublicationStates::PublishedUpgradedWaitingModeration)
			->orderByDesc('id')
			->latest()
			->first()
			->subscription
			->offer;
	}

	/**
	 * HasViewed or not a given element
	 *
	 * @param class User or class Post
	 * @param int id
	 * @return int
	 */
	public function hasViewed(string $elementType, int $elementId): int
	{
		return UsersViews::whereHas('user', function($whereHas) {
				$whereHas->where('id', '=', $this->user->id);
			})
			->where('element_type', '=', $elementType)
			->where('element_id', '=', $elementId)
			->count();
	}

	public function isValidated(): bool
	{
		if($this->lastModeration) return $this->lastModeration->isValidated();
		else return false;
	}

	public function countCommentsReceivedPublished()
	{
		return $this->commentsReceived()->where('state', CommentStates::Published)
			->count();
	}

	public function getCommentsReceivedPublished()
	{
		return $this->commentsReceived()->where('state', CommentStates::Published)
			->get();
	}
}
