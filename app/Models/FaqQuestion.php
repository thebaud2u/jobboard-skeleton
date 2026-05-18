<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

use App\Enums\FaqStates;

use App\Support\StopWords;

class FaqQuestion extends Model
{
	use HasSlug;

	protected $fillable = [
		'question',
		'answer',
		'slug',
		'state',
		'order',
		'faq_rubrique_id',
		'user_id'
	];

	protected $casts = [
		'state' => FaqStates::class
	];

	/**
	 * The attributes that should be mutated to dates
	 *
	 * @var array
	 */
	protected $dates = [
		'created_at',
		'updated_at'
	];

	protected static function boot()
	{
		parent::boot();
		self::saving(function(Model $model) {
			if(!$model->user_id) $model->user_id = Auth::guard('admin')->user()->id;
		});
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

	public function scopePublished($query)
	{
		$query->where('state', FaqStates::Published);
	}

	public function rubrique()
	{
		return $this->belongsTo(FaqRubrique::class, 'faq_rubrique_id', 'id');
	}

	public function faq()
	{
		return $this->rubrique->faq();
	}

	public function author()
	{
		return $this->belongsTo(Admin::class, 'user_id', 'id');
	}
}
