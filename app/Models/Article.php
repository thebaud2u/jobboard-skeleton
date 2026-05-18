<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Enums\ArticleStates;

use App\Support\StopWords;

use App\Traits\HasValuesCollection;

class Article extends Model implements HasMedia, Viewable
{
	use HasSlug, HasValuesCollection, InteractsWithMedia, InteractsWithViews, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'admin_id',
		'author_id',
		'title',
		'slug',
		'values',
		'header',
		'body',
		'start_publication_date',
		'end_publication_date',
		'in_selection',
		'last_update_date',
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
		'state' => ArticleStates::class,
		'values' => AsCollection::class,
		'start_publication_date' => 'datetime',
		'end_publication_date' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
		'last_update_date' => 'datetime',
		'deleted_at' => 'datetime'
	];

	// Tools
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
				$afterReplace = preg_replace($pattern, '-', $this->title);

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
		$this->addMediaCollection('photo')->singleFile();
		$this->addMediaCollection('article_images');
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('photo')
			->width(1280)
			->height(1280);
	}

	// Relations
	public function admin(): BelongsTo
	{
		return $this->belongsTo(Admin::class);
	}

	public function author(): BelongsTo
	{
		return $this->belongsTo(ArticleAuthor::class, 'article_author_id');
	}

	public function breeds(): BelongsToMany
	{
		return $this->BelongsToMany(Breed::class);
	}

	public function department(): MorphOne
	{
		return $this->morphOne(Address::class, 'model');
	}

	public function departments(): MorphMany
	{
		return $this->MorphMany(Address::class, 'model');
	}

	public function sections(): BelongsToMany
	{
		return $this->belongsToMany(ArticleSection::class)->withPivot('is_main');
	}

	public function species(): BelongsToMany
	{
		return $this->belongsToMany(Species::class);
	}

	public function tags(): BelongsToMany
	{
		return $this->belongsToMany(ArticleTag::class);
	}

	public function targets(): BelongsToMany
	{
		return $this->belongsToMany(ArticleTarget::class);
	}

	/**
     * Le swyp article liés à l'article
     */
    public function swypArticles(): HasMany
    {
        return $this->hasMany(SwypArticle::class, 'article_id');
    }


	// Functions
	public function mainSection(): ArticleSection
	{
		return $this->sections()
			->wherePivot('is_main', true)
			->first();
	}

	public function secondarySections(): Collection
	{
		return $this->sections()
			->wherePivot('is_main', false)
			->get();
	}
	
	/**
	 * Reset main and secondary sections
	 *
	 * @param int $mainSectionId
	 * @param array $secondarySectionIds
	 */
	public function setSections(int $mainSectionId, array $secondarySectionIds = []): void
	{
		$oldMain = $this->sections()->wherePivot('is_main', true)->pluck('article_section_id');
		if($oldMain->isNotEmpty()) $this->sections()->detach($oldMain);

		$this->sections()->attach($mainSectionId, ['is_main' => true]);

		if(!empty($secondarySectionIds)) {
			$data = collect($secondarySectionIds)
				->mapWithKeys(fn($id) => [$id => ['is_main' => false]])
				->toArray();

			$this->sections()->syncWithoutDetaching($data);
		}
	}
}
