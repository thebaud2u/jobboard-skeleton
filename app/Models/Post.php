<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

use Overtrue\LaravelFavorite\Traits\Favoriteable;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Enums\ProtrusionTypes;

use App\Traits\{HasValuesCollection, ModerationTools, PublicationTools, SubscriptionTools};

class Post extends Model implements Viewable, HasMedia
{
	use Favoriteable, HasSlug, HasValuesCollection, InteractsWithMedia, InteractsWithViews, ModerationTools, PublicationTools, SoftDeletes, SubscriptionTools;

	protected $fillable = [
		'user_id',
		'post_type_id',
		'name',
		'slug',
		'values',
		'published_at',
		'archived_at',
		'refreshed_at',
		'created_at',
		'updated_at',
		'deleted_at'
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
			'published_at' => 'datetime',
			'archived_at' => 'datetime',
			'refreshed_at' => 'datetime',
			'created_at' => 'datetime',
			'updated_at' => 'datetime',
			'deleted_at' => 'datetime'
		];
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
			->generateSlugsFrom('name')
			->saveSlugsTo('slug');
	}

	public function registerMediaCollections(): void
	{
		$this->addMediaCollection('photos');
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('photos')
			->width(1280)
			->height(1280);
	}

	// Relations
	public function appointments(): MorphMany
	{
		return $this->morphMany(MailLog::class, 'model');
	}

	public function mediable(): HasMany
	{
		return $this->hasMany(Mediable::class);
	}

	public function model(): MorphTo
	{
		return $this->morphTo()->withTrashed();
	}

	public function responses(): MorphMany
	{
		return $this->morphMany(Response::class, 'model');
	}

	public function type(): BelongsTo
	{
		return $this->belongsTo(PostType::class, 'post_type_id', 'id');
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	// Functions
	public function offer(): Offer
	{
		return $this->lastPublication->subscription->offer;
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

	public function getProtrusionTypesInHuman(): string
	{
		$sentence = '';

		if($this->values->has('protrusion_types')) {
			foreach($this->values->get('protrusion_types') as $index => $protrusionType) {
				$sentence .= __(ProtrusionTypes::class::from($protrusionType)->inHuman());

				if($index+1 < count($this->values->get('protrusion_types'))) $sentence .= ', ';
			}
		}

		return $sentence;
	}
}
