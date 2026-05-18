<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;

use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Support\StopWords;

use App\Traits\HasValuesCollection;

class ArticleAuthor extends Model implements HasMedia, Viewable
{
	use HasSlug, HasValuesCollection, InteractsWithMedia, InteractsWithViews, SoftDeletes;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'firstname',
		'lastname',
		'name',
		'slug',
		'values',
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
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
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
		$this->addMediaCollection('photo')->singleFile();
	}

	public function registerMediaConversions(Media $media = null): void
	{
		$this->addMediaConversion('optimized')
			->performOnCollections('photo')
			->width(1280)
			->height(1280);
	}

	// Relations
	public function articles(): HasMany
	{
		return $this->hasMany(Article::class);
	}
}
