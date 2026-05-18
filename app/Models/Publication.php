<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

use App\Enums\{AlertTypes, ResponseStates, PublicationStates};

use App\Notifications\{CompanyYouFollowHasANewPost, NewPostMatchsYourAlert};

class Publication extends Model
{
	protected $fillable = [
		'user_id',
		'subscription_id',
		'state',
		'end_date',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'state' => PublicationStates::class,
		'end_date' => 'date',
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	public static function boot()
	{
		parent::boot();
		static::created(function($publication) {
			if($publication->model instanceof Post) {
				// Passage en non-disponible des demandes de l'annonce à la dépublication, disponible à la republication (si des demandes existent)
				if($publication->state == PublicationStates::Published || $publication->state == PublicationStates::Archived) {
					if($publication->state == PublicationStates::Published) $responseState = ResponseStates::Received;
					elseif($publication->state == PublicationStates::Archived) $responseState = ResponseStates::Unavailable;

					$postResponses = $publication->model->responses;

					if($postResponses->isNotEmpty()) {
						foreach($postResponses as $response) {
							$response->state = $responseState;
							$response->saveQuietly();
						}
					}

					if($publication->model->type->getTranslation('slug', 'en') == 'litter') {
						if($publication->state == PublicationStates::Published) {
							$availableAnimals = $publication->model->model->getAvailableChildren();

							if($availableAnimals->isNotEmpty()) {
								foreach($availableAnimals as $animal) {
									$availableAnimalResponses = $animal->responses;

									if($availableAnimalResponses->isNotEmpty()) {
										foreach($availableAnimalResponses as $response) {
											$response->state = $responseState;
											$response->saveQuietly();
										}
									}
								}
							}
						}
						elseif($publication->state == PublicationStates::Archived) {
							$animals = $publication->model->model->animals;

							if($animals->isNotEmpty()) {
								foreach($animals as $animal) {
									$animalResponses = $animal->responses;

									if($animalResponses->isNotEmpty()) {
										foreach($animalResponses as $response) {
											$response->state = $responseState;
											$response->saveQuietly();
										}
									}
								}
							}
						}
					}
				}

				if($publication->state == PublicationStates::Published && $publication->model->countPublishedTimes() <= 1) {
					// Envoi d'email de nouvelle annonce aux followers d'un entreprise
					$followers = $publication->model->user->company->favoriters()
						->whereHas('alerts', function($whereHas) use($publication) {
							$whereHas->where('type', AlertTypes::Company)
								->whereHas('company', function($whereHasCompany) use($publication) {
									$whereHasCompany->where('slug', $publication->model->user->company->slug);
								});
						})
						->get();

					if($followers->isNotEmpty()) {
						foreach($followers as $follower) {
							$follower->notify(new CompanyYouFollowHasANewPost($publication->model));
						}
					}

					// Envoi d'email de nouvelle annonce aux users dont l'alerte correspond à l'annonce
					$post = $publication->model;

					if(($post->type->getTranslation('slug', 'en') == 'litter' && $post->model->availableChildrenExists()) || $post->type->getTranslation('slug', 'en') != 'litter') {
						$alertsMatching = Alert::where('type', AlertTypes::Post)
							->where('values->species', $post->model->species->getTranslation('slug', 'en'));

						if($post->type->getTranslation('slug', 'en') == 'litter' || $post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							$breeds = $post->model->breeds()->pluck('slug')->all();

							$alertsMatching = $alertsMatching->where('values->post_type', 'litter')
								->where(function($whereBreed) use($breeds) {
									foreach($breeds as $breed) {
										$whereBreed->orWhereJsonContains('values->breed', $breed);
									}
								});

							if($post->type->getTranslation('slug', 'en') == 'litter') {
								$maxPrice = $post->model->getHighestPrice();
								$minPrice = $post->model->getLowestPrice();

								if($minPrice || $maxPrice) {
									$childrenPrices = $post->model->getAvailableChildrenPrices();

									if(!empty($childrenPrices)) {
										$alertsMatching = $alertsMatching->where(function($where) use($childrenPrices) {
											foreach($childrenPrices as $childPrice) {
												$where->orWhere(function($childWhere) use($childPrice) {
													$childWhere->where(function($minWhere) use($childPrice) {
														$minWhere->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.min_price")) AS UNSIGNED) <= ?', [$childPrice])
															->orWhereNull('values->min_price');
													})
													->where(function($maxWhere) use($childPrice) {
														$maxWhere->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.max_price")) AS UNSIGNED) >= ?', [$childPrice])
															->orWhereNull('values->max_price');
													});
												});
											}
										});
									}
								}

								if($post->model->hasPureBreedChildren()) {
									$alertsMatching = $alertsMatching->where(function($where) {
										$where->where('values->pure_breed', 'yes')
											->orWhere('values->pure_breed', 'both');
									});
								}
								else {
									$alertsMatching = $alertsMatching->where(function($where) {
										$where->where('values->pure_breed', 'no')
											->orWhere('values->pure_breed', 'both');
									});
								}

								$alertsMatching = $alertsMatching->where(function($where) use($post) {
									if($post->model->availableFemaleChildrenExists()) $where->orWhereIn('values->sex', ['female', 'both']);
									if($post->model->availableMaleChildrenExists()) $where->orWhereIn('values->sex', ['male', 'both']);
								});
							}
						}
						else {
							$alertsMatching = $alertsMatching->where('values->post_type', $post->type->getTranslation('slug', 'en'))
								->where('values->breed', $post->model->breed->slug)
								->where(function($where) use($post) {
									$where->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.max_price")) AS UNSIGNED) >= ?', $post->values->get('price'))
										->orWhereNull('values->max_price');
								})
								->where(function($where) use($post) {
									$where->whereRaw('CAST(JSON_UNQUOTE(JSON_EXTRACT(`values`, "$.min_price")) AS UNSIGNED) <= ?', $post->values->get('price'))
										->orWhereNull('values->min_price');
								});

							if($post->model->values->get('pure_breed') === true) {
								$alertsMatching = $alertsMatching->where(function($where) {
									$where->where('values->pure_breed', 'yes')
										->orWhere('values->pure_breed', 'both');
								});
							}
							else {
								$alertsMatching = $alertsMatching->where(function($where) {
									$where->where('values->pure_breed', 'no')
										->orWhere('values->pure_breed', 'both');
								});
							}
						}

						$alertsMatching = $alertsMatching->where(function($whereLocation) use($post) {
							$postAddress = $post->user->company->address;
							if($postAddress->city) {
								$whereLocation->orWhere(function($orWhere) use($postAddress) {
									$orWhere->whereRaw('JSON_EXTRACT(`values`, "$.distance") > 0')
										->whereNotNull('values->city_id')
										->whereRaw(
											'
											ST_Distance_Sphere(
												point(
													(SELECT gps_lng FROM cities WHERE id = JSON_UNQUOTE(JSON_EXTRACT(alerts.values, "$.city_id"))),
													(SELECT gps_lat FROM cities WHERE id = JSON_UNQUOTE(JSON_EXTRACT(alerts.values, "$.city_id")))
												),
												point(?, ?)
											) <= JSON_UNQUOTE(JSON_EXTRACT(alerts.values, "$.distance")) * 1000
											',
											[$postAddress->city->gps_lng, $postAddress->city->gps_lat]
										);
								});
							}

							$whereLocation->orWhere(function($orWhere) use($postAddress) {
								$orWhere->where(function($where) {
										$where->whereNull('values->distance')
											->orWhereRaw('JSON_EXTRACT(`values`, "$.distance") = 0');
									})
									->where(function($where) use($postAddress) {
										$where->where('values->country_id', $postAddress->country->id)
											->orWhereNull('values->country_id');
									})
									->when($postAddress->region, function($when) use($postAddress) {
										$when->where(function($where) use($postAddress) {
											$where->where('values->region_id', $postAddress->region->id)
												->orWhereNull('values->region_id');
										});
									})
									->when($postAddress->department, function($when) use($postAddress) {
										$when->where(function($where) use($postAddress) {
											$where->where('values->department_id', $postAddress->department->id)
												->orWhereNull('values->department_id');
										});
									})
									->when($postAddress->city, function($when) use($postAddress) {
										$when->where(function($where) use($postAddress) {
											$where->where('values->city_id', $postAddress->city->id)
												->orWhereJsonContains('values->cities', $postAddress->city->id)
												->orWhereNull('values->city_id');
										});
									});
								});
							})
							->where('enabled', true)
							->get();

						if($alertsMatching->isNotEmpty()) {
							foreach($alertsMatching as $alert) {
								$alert->user->notify(new NewPostMatchsYourAlert($post, $alert));
							}
						}
					}
				}
			}
		});
	}

	// Relations
	public function model(): MorphTo
	{
		return $this->morphTo();
	}

	public function subscription(): BelongsTo
	{
		return $this->belongsTo(Subscription::class)->withTrashed();
	}

	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}

	// Functions
	public function isArchived(): bool
	{
		return $this->state === PublicationStates::Archived;
	}

	public function isDeleted(): bool
	{
		return $this->state === PublicationStates::Deleted;
	}

	public function isDraft(): bool
	{
		return $this->state === PublicationStates::Draft;
	}

	public function isDraftWaitingModerationForPublication(): bool
	{
		return $this->state === PublicationStates::DraftWaitingModerationForPublication;
	}

	public function isPublished(): bool
	{
		return $this->state === PublicationStates::Published;
	}

	public function isPublishedUpdatedWaitingModeration(): bool
	{
		return $this->state === PublicationStates::PublishedUpdatedWaitingModeration;
	}

	public function isPublishedUpgradedWaitingModeration(): bool
	{
		return $this->state === PublicationStates::PublishedUpgradedWaitingModeration;
	}

	public function isWaitingToBePublished(): bool
	{
		return ($this->isDraftWaitingModerationForPublication() || $this->isPublishedUpdatedWaitingModeration() || $this->isPublishedUpgradedWaitingModeration()) ? true : false;
	}
}
