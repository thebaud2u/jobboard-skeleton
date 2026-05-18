<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


use App\Enums\{ModerationStates, PublicationStates};

use App\Models\{Admin, Company, Moderation, Post, Offer, Subscription, User};
use App\Models\Migrations\{MigrationAbonnementActif};

class SubscriptionSeeder extends Seeder
{
	public $admin;
	public $userSubscription;
	public $postOffers;
	public $companyMasterOffer;
	public $companyPremiumOffer;
	public $companyStandardOffer;
	public $postMasterOffer;
	public $postPremiumOffer;
	public $postStandardOffer;

	function detectCode($listArticles) {
		$articles = explode(',', $listArticles);

		$has50 = false;
		$has5xxx = false;

		foreach ($articles as $article) {
			$article = trim($article);

			if ($article == '50') {
				$has50 = true;
			} elseif (preg_match('/^5\d{2,}$/', $article)) {
				$has5xxx = true;
			}
		}

		if ($has50 && !$has5xxx) {
			return 1;
		} elseif (!$has50 && $has5xxx) {
			return 2;
		} elseif ($has50 && $has5xxx) {
			return 3;
		} else {
			return 0; // Cas non prévu
		}
	}

	public function subscriptions(): void
	{
		Log::info('Début des subscriptions');
		DB::beginTransaction();

		try {
			$migrationAbonnementActif = MigrationAbonnementActif::all();

			if($migrationAbonnementActif->isNotEmpty()) {
				$admin = Admin::first();
				$start = microtime(true);

				foreach($migrationAbonnementActif as $index => $abonnement) {
					if($abonnement->date_fin) {
						$user = User::where('email', $abonnement->email)
							->first();

						if($user) {
							if($abonnement->formule_abonnement == 16 || $abonnement->formule_abonnement == 17 || $abonnement->formule_abonnement == 1600 || $abonnement->formule_abonnement == 1700) {
								$dateFinAbonnement = Carbon::createFromFormat('Y-m-d', $abonnement->date_fin);

								if($dateFinAbonnement->format('Y-m-d') < '2025-09-22') $endDate = null;
								elseif($dateFinAbonnement->format('Y-m-d') > '2025-09-22' && $dateFinAbonnement->format('Y-m-d') < '2025-12-31') $endDate = '2025-12-31';
								elseif($dateFinAbonnement->format('Y-m-d') > '2025-12-31') $endDate = $dateFinAbonnement->format('Y-m-d');

								$company = $user->company;

								if($abonnement->formule_abonnement == 16) {
									// Premium
									$companyOffer = $this->companyPremiumOffer->id;
									$postOffer = $this->postPremiumOffer->id;

									if($company) {
										if($company->breeds->count() > 3) {
											// Master
											$companyOffer = $this->companyMasterOffer->id;
										}
									}
								}
								elseif($abonnement->formule_abonnement == 17) {
									$companyOffer = $this->companyMasterOffer->id;
									$postOffer = $this->postPremiumOffer->id;
								}
								elseif($abonnement->formule_abonnement == 1600 || $abonnement->formule_abonnement == 1700) {
									$companyOffer = $this->companyMasterOffer->id;
									$postOffer = $this->postMasterOffer->id;
								}

								if(is_null($endDate)) {
									$newSubscription = new Subscription;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $companyOffer;
									$newSubscription->quantity = 1;
									$newSubscription->remaining_quantity = 0;
									$newSubscription->end_date = $abonnement->date_fin;
									$newSubscription->from = 'EOL';
									$newSubscription->synchronized_with_stripe = false;
									$newSubscription->save();

									if($company) {
										$company->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::Draft
										]);
									}

									$newSubscription = new Subscription;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $postOffer;
									$newSubscription->quantity = $abonnement->nombre_annonce;
									$newSubscription->remaining_quantity = 0;
									$newSubscription->end_date = $abonnement->date_fin;
									$newSubscription->from = 'EOL';
									$newSubscription->synchronized_with_stripe = false;
									$newSubscription->save();
								}
								else {
									$newSubscription = new Subscription;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $companyOffer;
									$newSubscription->quantity = 1;
									$newSubscription->remaining_quantity = 0;
									$newSubscription->end_date = $endDate;
									$newSubscription->from = 'EOL';
									$newSubscription->synchronized_with_stripe = false;
									$newSubscription->save();

									if($company) {
										$company->markForModeration();

										$newModeration = new Moderation;
										$newModeration->model()->associate($company);
										$newModeration->state = ModerationStates::Validated;
										$newModeration->admin_id = $admin->id;
										$newModeration->save();

										$company->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::Draft
										]);

										$company->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::DraftWaitingModerationForPublication
										]);

										$company->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'end_date' => $endDate,
											'state' => PublicationStates::Published
										]);
									}

									$newSubscription = new Subscription;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $postOffer;
									$newSubscription->quantity = $abonnement->nombre_annonce;
									$newSubscription->remaining_quantity = $abonnement->nombre_annonce;
									$newSubscription->end_date = $endDate;
									$newSubscription->from = 'EOL';
									$newSubscription->synchronized_with_stripe = false;
									$newSubscription->save();

									foreach($user->posts as $post) {
										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::Draft
										]);

										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::DraftWaitingModerationForPublication
										]);

										$post->markForModeration();

										$newModeration = new Moderation;
										$newModeration->model()->associate($post);
										$newModeration->state = ModerationStates::Validated;
										$newModeration->admin_id = $this->admin->id;
										$newModeration->save();

										if($post->published_at) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $newSubscription->id,
												'end_date' => $post->archived_at ? $post->archived_at : $post->published_at->addMonths(4),
												'state' => PublicationStates::Published
											]);
										}

										if($post->archived_at && $post->archived_at <= Carbon::now()) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $newSubscription->id,
												'end_date' => $post->archived_at,
												'state' => PublicationStates::Archived
											]);
										}
									}
								}
							}
							elseif($abonnement->formule_abonnement == 50 || $abonnement->formule_abonnement == 5000 || $abonnement->formule_abonnement == 5002) {
								$newSubscription = new Subscription;
								$newSubscription->user_id = $user->id;
								$newSubscription->offer_id = $postOffer;
								$newSubscription->quantity = $abonnement->nombre_annonce;
								$newSubscription->remaining_quantity = $abonnement->nombre_annonce;
								$newSubscription->end_date = $abonnement->date_fin;
								$newSubscription->from = 'EOL';
								$newSubscription->synchronized_with_stripe = false;
								$newSubscription->save();

								foreach($user->posts as $post) {
										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::Draft
										]);

										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $newSubscription->id,
											'state' => PublicationStates::DraftWaitingModerationForPublication
										]);

										$post->markForModeration();

										$newModeration = new Moderation;
										$newModeration->model()->associate($post);
										$newModeration->state = ModerationStates::Validated;
										$newModeration->admin_id = $this->admin->id;
										$newModeration->save();

										if($post->published_at) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $newSubscription->id,
												'end_date' => $post->archived_at ? $post->archived_at : $post->published_at->addMonths(4),
												'state' => PublicationStates::Published
											]);
										}

										if($post->archived_at && $post->archived_at <= Carbon::now()) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $newSubscription->id,
												'end_date' => $post->archived_at,
												'state' => PublicationStates::Archived
											]);
										}
									}
							}
						}
						else Log::error('Utilisateur inexistant : ' . $abonnement->email);
					}

					if($index % 100 === 0) {
						gc_collect_cycles();
						Log::info("Traitement ligne $index en " . round(microtime(true) - $start, 2) . "s");
					}
				}
			}

			DB::commit();
			Log::info('Fin des subscriptions');
		}
		catch(\Throwable $e) {
			DB::rollBack();
			Log::error('Erreur dans subscriptions : ' . $e->getMessage());
			throw $e;
		}
	}

	public function posts(): void
	{
		Log::info('Début des posts');
		DB::beginTransaction();

		try {
			$posts = Post::all();

			if($posts->isNotEmpty()) {
				$admin = Admin::first();
				$start = microtime(true);

				foreach($posts as $index => $post) {
					$user = $post->user;
					$listArticles = $post->values->get('articles');

					if($listArticles == '') {
						$company = $user->company;

						if($company) {
							if(!$company->isPublished()) {
								$newSubscription = new Subscription;
								$newSubscription->user_id = $user->id;
								$newSubscription->offer_id = $this->companyStandardOffer->id;
								$newSubscription->quantity = 1;
								$newSubscription->remaining_quantity = 0;
								$newSubscription->from = 'EOL';
								$newSubscription->synchronized_with_stripe = false;
								$newSubscription->save();

								$company->markForModeration();

								$newModeration = new Moderation;
								$newModeration->model()->associate($company);
								$newModeration->state = ModerationStates::Validated;
								$newModeration->admin_id = $admin->id;
								$newModeration->save();

								$company->publications()->create([
									'user_id' => $user->id,
									'subscription_id' => $newSubscription->id,
									'state' => PublicationStates::Draft
								]);

								$company->publications()->create([
									'user_id' => $user->id,
									'subscription_id' => $newSubscription->id,
									'state' => PublicationStates::DraftWaitingModerationForPublication
								]);

								$company->publications()->create([
									'user_id' => $user->id,
									'subscription_id' => $newSubscription->id,
									'state' => PublicationStates::Published
								]);

								$newSubscription = new Subscription;
								$newSubscription->user_id = $user->id;
								$newSubscription->offer_id = $this->postPremiumOffer->id;
								$newSubscription->quantity = 1;
								$newSubscription->remaining_quantity = 0;
								$newSubscription->end_date = Carbon::now()->addYear();
								$newSubscription->from = 'EOL';
								$newSubscription->synchronized_with_stripe = false;
								$newSubscription->save();
							}

							$hasPostSubscription = $user->subscriptions()
								->whereHas('offer', function($whereHas) {
									$whereHas->whereIn('slug', $this->postOffers);
								})
								->first();

							if($hasPostSubscription) $userSubscription = $hasPostSubscription;
							else {
								$companyOffer = $company->offer();

								if($companyOffer->slug == 'page-elevage-master') $offerForPostPublication = $this->postMasterOffer;
								else $offerForPostPublication = $this->postPremiumOffer;

								$userSubscription = $user->subscriptions()
									->whereHas('offer', function($whereHas) use($offerForPostPublication) {
										$whereHas->where('slug', $offerForPostPublication->slug);
									})
									->first();
							}

							$postLastPublication = $post->lastPublication;

							if($userSubscription && !$postLastPublication) {
								$post->publications()->create([
									'user_id' => $user->id,
									'subscription_id' => $userSubscription->id,
									'state' => PublicationStates::Draft
								]);

								$post->publications()->create([
									'user_id' => $user->id,
									'subscription_id' => $userSubscription->id,
									'state' => PublicationStates::DraftWaitingModerationForPublication
								]);

								$post->markForModeration();

								$newModeration = new Moderation;
								$newModeration->model()->associate($post);
								$newModeration->state = ModerationStates::Validated;
								$newModeration->admin_id = $this->admin->id;
								$newModeration->save();

								if($post->published_at) {
									$post->publications()->create([
										'user_id' => $user->id,
										'subscription_id' => $userSubscription->id,
										'end_date' => $post->archived_at ? $post->archived_at : $post->published_at->addMonths(4),
										'state' => PublicationStates::Published
									]);
								}

								if($post->archived_at && $post->archived_at <= Carbon::now()) {
									$post->publications()->create([
										'user_id' => $user->id,
										'subscription_id' => $userSubscription->id,
										'end_date' => $post->archived_at,
										'state' => PublicationStates::Archived
									]);
								}
							}
						}
					}
					else {
						// Recherche de crédit d'annonces
						$userSubscription = $user->subscriptions()
							->whereHas('offer', function($whereHas) {
								$whereHas->whereIn('slug', $this->postOffers);
							})
							->first();

						if($userSubscription) {
							$code = $this->detectCode($listArticles);
							$offerForPostPublication = null;

							if($code == 1) $offerForPostPublication = $this->postPremiumOffer;
							elseif($code == 2 || $code == 3) $offerForPostPublication = $this->postMasterOffer;

							if($offerForPostPublication) {
								$userSubscription = $user->subscriptions()
									->whereHas('offer', function($whereHas) use($offerForPostPublication) {
										$whereHas->where('slug', $offerForPostPublication->slug);
									})
									->first();

								if(!$userSubscription) {
									$newSubscription = new Subscription;
									$newSubscription->user_id = $user->id;
									$newSubscription->offer_id = $offerForPostPublication->id;
									$newSubscription->quantity = 1;
									$newSubscription->remaining_quantity = 0;
									$newSubscription->end_date = Carbon::now()->addYear();
									$newSubscription->from = 'EOL';
									$newSubscription->synchronized_with_stripe = false;
									$newSubscription->save();

									$userSubscription = $newSubscription;
								}

								if($userSubscription) {
									$postLastPublication = $post->lastPublication;

									if(!$postLastPublication) {
										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $userSubscription->id,
											'state' => PublicationStates::Draft
										]);

										$post->publications()->create([
											'user_id' => $user->id,
											'subscription_id' => $userSubscription->id,
											'state' => PublicationStates::DraftWaitingModerationForPublication
										]);

										$post->markForModeration();

										$newModeration = new Moderation;
										$newModeration->model()->associate($post);
										$newModeration->state = ModerationStates::Validated;
										$newModeration->admin_id = $this->admin->id;
										$newModeration->save();

										if($post->published_at) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $userSubscription->id,
												'end_date' => $post->published_at->addMonths(4),
												'state' => PublicationStates::Published
											]);
										}

										if($post->archived_at && $post->archived_at <= Carbon::now()) {
											$post->publications()->create([
												'user_id' => $user->id,
												'subscription_id' => $userSubscription->id,
												'end_date' => $post->archived_at,
												'state' => PublicationStates::Archived
											]);
										}
									}
									else {
										foreach($post->publications as $publication) {
											$publication->subscription_id = $userSubscription->id;
											$publication->save();
										}
									}
								}
								else Log::info('Post subscription inexistante : user '.$user->email.' - offer '.$offerForPostPublication->slug);
							}
							else Log::info('code inconnu pour association d\'un crédit d\'annonce : '.$user->email);
						}
						else Log::info('Subscription inexistante : '.$user->email);
					}

					if($index % 100 === 0) {
						gc_collect_cycles();
						Log::info("Traitement ligne $index en " . round(microtime(true) - $start, 2) . "s");
					}
				}
			}

			DB::commit();
			Log::info('Fin des posts');
		}
		catch(\Throwable $e) {
			DB::rollBack();
			Log::error('Erreur dans posts : ' . $e->getMessage());
			throw $e;
		}
	}

	public function companies(): void
	{
		$companies = Company::whereDoesntHave('lastPublication')
			->get();

		if($companies->isNotEmpty()) {
			foreach($companies as $company) {
				if($company->user->hasCreditAvailable($this->companyStandardOffer->slug)) $newSubscription = $company->user->hasOfferSubscription($this->companyStandardOffer->slug);
				else {
					$newSubscription = new Subscription;
					$newSubscription->user_id = $company->user->id;
					$newSubscription->offer_id = $this->companyStandardOffer->id;
					$newSubscription->quantity = 1;
					$newSubscription->remaining_quantity = 0;
					$newSubscription->from = 'EOL';
					$newSubscription->synchronized_with_stripe = false;
					$newSubscription->save();
				}

				$company->publications()->create([
					'user_id' => $company->user->id,
					'subscription_id' => $newSubscription->id,
					'state' => PublicationStates::Draft
				]);
			}
		}
	}

	public function run(): void
	{
		$this->admin = Admin::first();
		$this->postOffers = Offer::where('type', 'post')
			->pluck('slug')
			->toArray();
		$this->companyMasterOffer = Offer::findBySlug('page-elevage-master');
		$this->companyPremiumOffer = Offer::findBySlug('page-elevage-premium');
		$this->companyStandardOffer = Offer::findBySlug('page-elevage-standard');
		$this->postMasterOffer = Offer::findBySlug('annonce-master');
		$this->postPremiumOffer = Offer::findBySlug('annonce-premium');
		$this->postStandardOffer = Offer::findBySlug('annonce-standard');

		$this->subscriptions();
		$this->posts();
		$this->companies();
	}
}
