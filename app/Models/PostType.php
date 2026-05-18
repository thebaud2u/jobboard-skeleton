<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\Translatable\HasTranslations;

class PostType extends Model
{
	use HasTranslations;

	public $timestamps = false;
	public $translatable = ['slug'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'name',
		'slug'
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts(): array
	{
		return [
			'slug' => AsCollection::class
		];
	}

	// Tools
	public function getRouteKey()
	{
		return $this->getTranslation('slug', app()->getLocale());
	}

	public function generateTranslatedSlugs()
	{
		foreach(['en', 'fr'] as $locale) {
			$name = $this->getTranslation('name', $locale);
			$this->setTranslation('slug', $locale, Str::slug($name));
		}
	}

	public static function findBySlug(string $slug, ?string $locale = null): ?self
	{
		$locale = $locale ?? app()->getLocale();

		return self::where("slug->{$locale}", $slug)->first();
	}

	// Relations
	public function posts(): BelongsToMany
	{
		return $this->belongsToMany(Post::class);
	}

	public function searches(): HasMany
	{
		return $this->hasMany(Search::class);
	}
}
