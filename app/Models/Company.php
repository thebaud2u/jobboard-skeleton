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

use App\Enums\{Affixes, AnimalSexes, AnimalStates, PublicationStates, CommentStates};

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

	public function activeBreeders(): HasMany
	{
		return $this->hasMany(Animal::class, 'company_id')->where('values->breeder_status', 'active');
	}

	public function animals(): HasMany
	{
		return $this->hasMany(Animal::class, 'company_id');
	}

	public function breeds(): BelongsToMany
	{
		return $this->belongsToMany(Breed::class);
	}

	public function breeders(): HasMany
	{
		return $this->hasMany(Animal::class, 'company_id')->whereIn('values->breeder_status', ['active', 'inactive']);
	}

	public function life(): MorphMany
	{
		return $this->morphMany(AnimalLife::class, 'model');
	}

	public function litters(): HasMany
	{
		return $this->hasMany(Litter::class);
	}

	public function littersAvailable(): HasMany
	{
		return $this->hasMany(Litter::class)
			->whereHas('post.lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
			});
	}

	public function littersWithAvailableAnimals(): HasMany
	{
		return $this->hasMany(Litter::class)
			->whereHas('post.lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
			})
			->whereHas('animals.lastLife', function($whereHas) {
				$whereHas->where('state', AnimalStates::Available);
			});
	}

	public function mediable(): HasMany
	{
		return $this->hasMany(Mediable::class);
	}

	public function responses(): MorphMany
	{
		return $this->morphMany(Response::class, 'model');
	}

	public function species(): BelongsToMany
	{
		return $this->belongsToMany(Species::class);
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

	public function getSpeciesBreeds(string $slug): Collection
	{
		return $this->breeds()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->get();
	}

	public function getCatBreeds(): Collection
	{
		return $this->breeds()->whereHas('species', function($whereHas) {
				$whereHas->where('slug->en', 'cat');
			})
			->get();
	}

	public function getDogBreeds(): Collection
	{
		return $this->breeds()->whereHas('species', function($whereHas) {
				$whereHas->where('slug->en', 'dog');
			})
			->get();
	}

	public function hasSpeciesPureBreed(string $slug): bool
	{
		$pureBreed = $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->pure_breed', true)
			->count();

		return $pureBreed > 0 ? true: false;
	}

	public function breedsBreed(string $slug): bool
	{
		$breedsBreed = $this->breeds()
			->where('slug', $slug)
			->count();

		return $breedsBreed > 0 ? true: false;
	}

	public function hasDisplayBreeders(): bool
	{
		$displayBreeders = $this->getDisplayBreeders()
			->count();

		return $displayBreeders > 0 ? true: false;
	}

	public function getDisplayBreeders(): Collection
	{
		return $this->breeders()
			->where('values->display', true)
			->where('values->breeder_status', 'active')
			->get();
	}

	// Retrieves all species of display breeders of the current company
	public function getSpeciesOfDisplayBreeders(): Collection
	{
		$speciesIdOfBreeders = $this->breeders()
			->where('values->display', true)
			->where('values->breeder_status', 'active')
			->select('species_id')
			->distinct()
			->pluck('species_id');

		return Species::whereIn('id', $speciesIdOfBreeders)
			->orderBy('name', 'DESC')
			->get();
	}

	// Retrieves all breeds from the species of the display breeders of the current company
	public function getBreedsOfDisplayBreedersSpecies(Species $species): Collection
	{
		$breedsIdOfBreeders = $this->breeders()
			->where('values->display', true)
			->where('values->breeder_status', 'active')
			->whereHas('species', function($whereHas) use($species) {
				$whereHas->where('slug->en', $species->getTranslation('slug', 'en'));
			})
			->select('breed_id')
			->distinct()
			->pluck('breed_id');

		return Breed::whereIn('id', $breedsIdOfBreeders)
			->orderBy('name', 'ASC')
			->get();
	}

	public function getDisplayBreedersOfBreed(Breed $breed): Collection
	{
		return $this->breeders()
			->whereHas('breed', function($whereHas) use($breed) {
				$whereHas->where('slug', $breed->slug);
			})
			->where('values->display', true)
			->where('values->breeder_status', 'active')
			->orderBy('name')
			->get();
	}

	public function getFemaleBreeders(): Collection
	{
		return $this->breeders()->where('values->sex', AnimalSexes::Female->value)
			->where('values->breeder_status', 'active')
			->get();
	}

	public function getPureBreedFemaleBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->sex', AnimalSexes::Female->value)
			->where('values->breeder_status', 'active')
			->where('values->pure_breed', true)
			->get();
	}

	public function getFemaleBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->sex', AnimalSexes::Female->value)
			->where('values->breeder_status', 'active')
			->get();
	}

	public function getMaleBreeders(): Collection
	{
		return $this->breeders()->where('values->sex', AnimalSexes::Male->value)
			->where('values->breeder_status', 'active')
			->get();
	}

	public function getMaleBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->sex', AnimalSexes::Male->value)
			->where('values->breeder_status', 'active')
			->get();
	}

	public function getMaleBreedersOfBreeds(array $breeds): Collection
	{
		return $this->breeders()->whereHas('breed', function($whereHas) use($breeds) {
				$whereHas->whereIn('slug', $breeds);
			})
			->where('values->sex', AnimalSexes::Male->value)
			->where('values->breeder_status', 'active')
			->get();
	}

	public function getCompanyPureBreedBreedsOfSpecies(string $slug): Collection
	{
		return $this->breeds()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->whereHas('breedStandard')
			->get();
	}

	public function getBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->get();
	}

	public function getInativeBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->breeder_status', 'inactive')
			->get();
	}

	public function getActiveBreedersOfSpecies(string $slug): Collection
	{
		return $this->breeders()->whereHas('species', function($whereHas) use($slug) {
				$whereHas->where('slug->en', $slug);
			})
			->where('values->breeder_status', 'active')
			->get();
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

	public function constructBreedsFromModeration(): Collection
	{
		return Breed::whereIn('slug', data_get($this->values, 'for_moderation.breeds'))
			->get();
	}

	public function hasAvailableAnimals(): bool
	{
		return $this->litters()
			->whereHas('animals.lastLife', function($whereHas) {
				$whereHas->where('state', AnimalStates::Available);
			})
			->exists();
	}

	public function hasPureBreedBreeders(): bool
	{
		return $this->breeders()->where('values->pure_breed', true)
			->exists();
	}

	public function getTypeOfPureBreedBreeders(): array
	{
		$pureBreedTypes = array('LOF' => false, 'LOOF' => false);
		$pureBreedBreeders = $this->breeders()->where('values->pure_breed', true)
			->get();

		foreach($pureBreedBreeders as $pureBreedBreeder) {
			if($pureBreedBreeder->species->getTranslation('slug', 'en') == 'cat') $pureBreedTypes['LOOF'] = true;
			elseif($pureBreedBreeder->species->getTranslation('slug', 'en') == 'dog') $pureBreedTypes['LOF'] = true;
		}

		return $pureBreedTypes;
	}

	public function countLittersWithAvailableAnimalsOfSpecies($speciesSlug): int
	{
		return $this->littersWithAvailableAnimals()->whereHas('species', function($whereHas) use($speciesSlug) {
				$whereHas->where('slug', $speciesSlug);
			})
			->count();
	}

	public function getRetiredBreederPosts()
	{
		return $this->user->posts()
			->whereHas('type', function($whereHasType) {
				$whereHasType->where('slug->en', 'retired-breeder');
			})
			->whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();
	}

	public function getStudPosts()
	{
		return $this->user->posts()
			->whereHas('type', function($whereHasType) {
				$whereHasType->where('slug->en', 'stud');
			})
			->whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();
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
