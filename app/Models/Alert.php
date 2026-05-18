<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Enums\{AlertTypes, AnimalStates, PublicationStates};

class Alert extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array<int, string>
	 */
	protected $fillable = [
		'user_id',
		'company_id',
		'type',
		'name',
		'values',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'type' => AlertTypes::class,
		'values' => AsCollection::class,
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Relations
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	public function company(): BelongsTo
	{
		return $this->belongsTo(Company::class);
	}

	// Functions
	public function countPosts(): int
	{
		if($this->type == AlertTypes::Post) {
			// Defining cities in the distance circle
			$cityIdsInRadius = null;
			if($this->values->get('distance') > 0) {
				$cityId = $this->values->get('cities')[0] ?? $this->values->get('city_id') ?? null;

				if($cityId) {
					$city = City::find($cityId);

					if($city) {
						$cityIdsInRadius = City::select('id')
							->whereRaw(
								'ST_Distance_Sphere(point(gps_lng, gps_lat), point(?, ?)) <= ?',
								[$city->gps_lng, $city->gps_lat, $this->values->get('distance') * 1000]
							)->pluck('id')->toArray();
					}
				}
			}

			$addressFilter = function($filter) use($cityIdsInRadius) {
				if(!empty($this->values->get('country_id')) && $this->values->get('distance') == 0) $filter->where('country_id', $this->values->get('country_id'));
				if(!empty($this->values->get('region_id')) && $this->values->get('distance') == 0) $filter->where('region_id', $this->values->get('region_id'));
				if(!empty($this->values->get('department_id')) && $this->values->get('distance') == 0) $filter->where('department_id', $this->values->get('department_id'));
				if(!empty($cityIdsInRadius)) $filter->whereIn('city_id', $cityIdsInRadius);
				elseif(!empty($this->values->get('cities')) && $this->values->get('distance') == 0) $filter->whereIn('city_id', $this->values->get('cities'));
				elseif(!empty($this->values->get('city_id')) && $this->values->get('distance') == 0) $filter->where('city_id', $this->values->get('city_id'));
			};

			$animals = Animal::whereHas('company', function($whereHas) {
					$whereHas->whereHas('user');
				})
				->whereHas('species', function($whereHas) {
					$whereHas->where('slug->en', $this->values->get('species'));
				})
				->where(function($where) {
					$where->whereHas('lastLife', function($whereHas) {
						$whereHas->whereIn('state', [AnimalStates::Available, AnimalStates::Reserved]);
					})
					->orDoesntHave('lastLife');
				})
				->when($this->values->get('breed'), function($when) {
					$when->whereHas('breed', function($whereHas) {
						$whereHas->where('slug', $this->values->get('breed'));
					});
				})
				->when($this->values->get('max_price'), function($when) {
					$when->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.price")) AS UNSIGNED) <= ?', [$this->values->get('max_price')]);
				})
				->when($this->values->get('min_price'), function($when) {
					$when->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.price")) AS UNSIGNED) >= ?', [$this->values->get('min_price')]);
				})
				->when($this->values->get('pure_breed'), function($when) {
					if($this->values->get('pure_breed') == 'yes') $when->where('values->pure_breed', true);
					elseif($this->values->get('pure_breed') == 'no') $when->where('values->pure_breed', false);
				})
				->when($this->values->get('sex'), function($when) {
					if($this->values->get('sex') != 'both') $when->where('values->sex', $this->values->get('sex'));
				})
				->whereHas('litters', function($whereHas) {
					$whereHas->whereHas('post', function($whereHasPosts) {
						$whereHasPosts->whereHas('type', function($whereHasType) {
							$whereHasType->where('slug->en', 'litter');
						})
						->whereHas('lastPublication', function($whereHas) {
							$whereHas->whereIn('state', [
								PublicationStates::Published,
								PublicationStates::PublishedUpdatedWaitingModeration,
								PublicationStates::PublishedUpgradedWaitingModeration
							]);
						});
					});
				})
				->whereHas('company.address', $addressFilter)
				->count();

			$posts = Post::whereHas('user')
				->when($this->values->get('post_type'), function($when) {
					if($this->values->get('post_type') == 'litter') {
						$when->whereHas('type', function($whereHas) {
							$whereHas->where('slug->en', 'litter-yet-to-come');
						});
					}
					else {
						$when->whereHas('type', function($whereHas) {
							$whereHas->where('slug->en', $this->values->get('post_type'));
						});
					}
				}, function($default) {
					$default->whereHas('type', function($whereHas) {
						$whereHas->whereNot('slug->en', 'litter');
					});
				})
				->whereHas('lastPublication', function($whereHas) {
					$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->when($this->values->get('max_price'), function($when) {
					$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) <= ?", [$this->values->get('max_price')]);
				})
				->when($this->values->get('min_price'), function($when) {
					$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) >= ?", [$this->values->get('min_price')]);
				})
				->whereHasMorph('model', [Animal::class, Litter::class], function($whereHasMorph, $class) use($addressFilter) {
					if($class === Animal::class) {
						$whereHasMorph->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', $this->values->get('species'));
						})
						->where(function($where) {
							$where->whereHas('lastLife', function($whereHas) {
								$whereHas->whereIn('state', [AnimalStates::Available, AnimalStates::Reserved]);
							})
							->orDoesntHave('lastLife');
						})
						->when($this->values->get('breed'), function($when) {
							$when->whereHas('breed', function($whereHas) {
								$whereHas->where('slug', $this->values->get('breed'));
							});
						})
						->when($this->values->get('max_price'), function($when) {
							$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) <= ?", [$this->values->get('max_price')]);
						})
						->when($this->values->get('min_price'), function($when) {
							$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) >= ?", [$this->values->get('min_price')]);
						})
						->when($this->values->get('pure_breed'), function($when) {
							if($this->values->get('pure_breed') == 'yes') $when->where('values->pure_breed', true);
							elseif($this->values->get('pure_breed') == 'no') $when->where('values->pure_breed', false);
						})
						->when($this->values->get('sex'), function($when) {
							if($this->values->get('sex') != 'both') $when->where('values->sex', $this->values->get('sex'));
						})
						->whereHas('company.address', $addressFilter);
					}
					elseif($class === Litter::class) {
						$whereHasMorph->when($this->values->get('pure_breed'), function($when) {
							$when->whereHas('mother', function($whereHas) {
								if($this->values->get('pure_breed') == 'yes') $whereHas->where('values->pure_breed', true);
								elseif($this->values->get('pure_breed') == 'no') $whereHas->where('values->pure_breed', false);
							});
						})
						->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', $this->values->get('species'));
						})
						->when($this->values->get('breed'), function($when) {
							$when->whereHas('breeds', function($whereHas) {
								$whereHas->where('slug', $this->values->get('breed'));
							});
						})
						->where(function($where) {
							$where->whereHas('animals', function($whereHasAnimals) {
								$whereHasAnimals->where(function($where) {
									$where->whereHas('lastLife', function($whereHas) {
										$whereHas->whereIn('state', [AnimalStates::Available, AnimalStates::Reserved]);
									})
									->orDoesntHave('lastLife');
								})
								->when($this->values->get('max_price'), function($when) {
									$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) <= ?", [$this->values->get('max_price')]);
								})
								->when($this->values->get('min_price'), function($when) {
									$when->whereRaw("CAST(JSON_UNQUOTE(JSON_EXTRACT(`posts`.`values`, '$.price')) AS UNSIGNED) >= ?", [$this->values->get('min_price')]);
								})
								->when($this->values->get('pure_breed'), function($when) {
									if($this->values->get('pure_breed') == 'yes') $when->where('values->pure_breed', true);
									elseif($this->values->get('pure_breed') == 'no') $when->where('values->pure_breed', false);
								})
								->when($this->values->get('sex'), function($when) {
									if($this->values->get('sex') != 'both') $when->where('values->sex', $this->values->get('sex'));
								});
							})
							->orDoesntHave('animals');
						})
						->whereHas('company.address', $addressFilter);
					}
				})
				->count();

			$total = $animals + $posts;
		}
		elseif($this->type == AlertTypes::Company) {
			$postsStats = $this->company->user->getPostStats();
			$total = $postsStats['activePosts'];
		}

		return $total;
	}

	public function buildLocalisation(): string|null
	{
		if($this->type == AlertTypes::Post) {
			if($this->values->get('country_id') || $this->values->get('region_id') || $this->values->get('department_id') ||
				$this->values->get('city_id') || $this->values->get('cities') || $this->values->get('distance')) {
				if($this->values->get('cities')) {
					$cities = City::whereIn('id', $this->values->get('cities'))
						->get();

					$localisation = $cities[0]->name.' ('.__('all city').')';
				}
				elseif($this->values->get('city_id')) {
					$city = City::find($this->values->get('city_id'));

					$localisation = $city->name.' ('.$city->zip_code.')';
				}
				elseif($this->values->get('department_id')) {
					$department = Department::find($this->values->get('department_id'));

					$localisation = $department->name;
				}
				elseif($this->values->get('region_id')) {
					$region = Region::find($this->values->get('region_id'));

					$localisation = $region->name;
				}
				elseif($this->values->get('country_id')) {
					$country = Country::find($this->values->get('country_id'));

					$localisation = $country->name;
				}
			}
			else $localisation = null;
		}
		elseif($this->type == AlertTypes::Company) $localisation = $this->company->displayPartOfAddress('department+zipcode+city');

		return $localisation;
	}
}
