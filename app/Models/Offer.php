<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Offer extends Model
{
	use HasSlug;

	protected $fillable = [
		'product_id',
		'name',
		'slug',
		'type',
		'description',
		'prices',
		'permission_id',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'prices' => AsCollection::class,
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
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
			->saveSlugsTo('slug')
			->generateSlugsFrom('name');
	}

	// Relations
	public function options(): BelongsToMany
	{
		return $this->belongsToMany(Option::class);
	}

	// Functions
	public function hasOption(string $code): bool
	{
		return $this->options()->where('code', $code)->first() ? true : false;
	}

	public function getMaxPhoto(): Int
	{
		$option = $this->options()->where('code', 'like', '%photo%')->first();

		return (int) explode('-', $option->code)[0];
	}

	public function getMaxBreed(): Int|String
	{
		$option = $this->options()->where('code', 'like', '%breed%')->first();

		$value = explode('-', $option->code)[0];

		return $value === 'unlimited' ? 'unlimited' : (int) $value;
	}

	public function getPrices(): array|null
	{
		if($this->prices) return $this->prices->toArray();
		else return null;
	}
}
