<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Enums\{PublicationStates};

use App\Models\{Company, MailLog, Offer, Post, ProfessionnalActivity, Subscription};

class CheckPublicationCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'check:publication';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check companies, posts & professionnal activities publication date validity, send emails when expiring soon';

	public function companies()
	{
		$companiesExpiringInAMonth = Company::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->whereHas('subscription', function($whereHasSubscription) {
					$whereHasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->where('free', false);
					});
				})
				->whereDate('end_date', Carbon::now()->addMonth());
			})
			->get();

		if($companiesExpiringInAMonth->isNotEmpty()) {
			foreach($companiesExpiringInAMonth as $company) {
				$newMailLog = new MailLog;
				$newMailLog->user_id = $company->user->id;
				$newMailLog->type = 'company-expires-in-a-month';
				$newMailLog->model()->associate($company);
				$newMailLog->save();
			}
		}

		$companiesExpiringInThreeDays = Company::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->whereHas('subscription', function($whereHasSubscription) {
					$whereHasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->where('free', false);
					});
				})
				->whereDate('end_date', Carbon::now()->addDays(3));
			})
			->get();

		if($companiesExpiringInThreeDays->isNotEmpty()) {
			foreach($companiesExpiringInThreeDays as $company) {
				if($company->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $company->user->id;
					$newMailLog->type = 'company-expires-in-three-days';
					$newMailLog->model()->associate($company);
					$newMailLog->save();
				}
			}
		}

		Log::info('companiesExpiringInThreeDays is done ' . Carbon::now());

		$companyExpiringTomorrow = Company::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->whereHas('subscription', function($whereHasSubscription) {
					$whereHasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->where('free', false);
					});
				})
				->whereDate('end_date', Carbon::now()->addDay());
			})
			->get();

		if($companyExpiringTomorrow->isNotEmpty()) {
			foreach($companyExpiringTomorrow as $company) {
				if($company->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $company->user->id;
					$newMailLog->type = 'company-expires-tomorrow';
					$newMailLog->model()->associate($company);
					$newMailLog->save();
				}
			}
		}

		Log::info('companyExpiringTomorrow is done ' . Carbon::now());

		$companiesWithoutStandardOfferExpiring = Company::whereHas('lastPublication', function($whereHasLastPublication) {
				$whereHasLastPublication->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->whereHas('subscription', function($whereHasSubscription) {
					$whereHasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->where('free', false);
					});
				})
				->whereDate('end_date', Carbon::now());
			})
			->get();

		if($companiesWithoutStandardOfferExpiring->isNotEmpty()) {
			$offer = Offer::findBySlug('page-elevage-standard');

			foreach($companiesWithoutStandardOfferExpiring as $company) {
				if($company->user) {
					if($company->user->hasCreditAvailable($offer->slug)) {
						$subscription = $company->user->subscriptions()
							->whereHas('offer', function($whereHas) use($offer) {
								$whereHas->where('slug', $offer->slug);
							})
							->first();
					}
					else {
						$newSubscription = new Subscription;
						$newSubscription->user_id = $company->user->id;
						$newSubscription->offer_id = $offer->id;
						$newSubscription->quantity = 1;
						$newSubscription->remaining_quantity = 1;
						$newSubscription->end_date = Carbon::now()->addYear();
						$newSubscription->from = 'EOL';
						$newSubscription->synchronized_with_stripe = false;
						$newSubscription->save();

						$subscription = $newSubscription;
					}

					$company->publications()->create([
						'user_id' => $company->user->id,
						'subscription_id' => $subscription->id,
						'state' => PublicationStates::Published
					]);
				}
				else $company->delete();
			}
		}

		Log::info('companiesWithoutStandardOfferExpiring is done ' . Carbon::now());
	}

	public function posts()
	{
		$postsExpiringInThreeDays = Post::whereDate('archived_at', Carbon::now()->addDays(3))
			->whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		if($postsExpiringInThreeDays->isNotEmpty()) {
			foreach($postsExpiringInThreeDays as $post) {
				if($post->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $post->user->id;
					$newMailLog->type = 'post-expires-in-three-days';
					$newMailLog->model()->associate($post);
					$newMailLog->save();
				}
			}
		}

		Log::info('postsExpiringInThreeDays is done ' . Carbon::now());

		$postsExpiringTomorrow = Post::whereDate('archived_at', Carbon::now()->addDay())
			->whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		if($postsExpiringTomorrow->isNotEmpty()) {
			foreach($postsExpiringTomorrow as $post) {
				if($post->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $post->user->id;
					$newMailLog->type = 'post-expires-tomorrow';
					$newMailLog->model()->associate($post);
					$newMailLog->save();
				}
			}
		}

		Log::info('postsExpiringTomorrow is done ' . Carbon::now());

		$posts = Post::whereDate('archived_at', '<', Carbon::now())
			->whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		if($posts->isNotEmpty()) {
			foreach($posts as $post) {
				$lastPublication = $post->lastPublication;

				$post->publications()->create([
					'user_id' => $post->user_id,
					'subscription_id' => $lastPublication->subscription->id,
					'state' => PublicationStates::Archived,
					'end_date' => Carbon::today()
				]);
			}
		}

		Log::info('posts is done ' . Carbon::now());
	}

	public function professionnalActivities()
	{
		$professionnalActivitiesExpiringInThreeDays = ProfessionnalActivity::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->where('end_date', Carbon::now()->addDays(3));
			})
			->get();

		if($professionnalActivitiesExpiringInThreeDays->isNotEmpty()) {
			foreach($professionnalActivitiesExpiringInThreeDays as $professionnalActivity) {
				if($professionnalActivity->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $professionnalActivity->user->id;
					$newMailLog->type = 'professionnal-activity-expires-in-three-days';
					$newMailLog->model()->associate($professionnalActivity);
					$newMailLog->save();
				}
			}
		}

		Log::info('professionnalActivitiesExpiringInThreeDays is done ' . Carbon::now());

		$professionnalActivitiesExpiringTomorrow = ProfessionnalActivity::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->where('end_date', Carbon::now()->addDay());
			})
			->get();

		if($professionnalActivitiesExpiringTomorrow->isNotEmpty()) {
			foreach($professionnalActivitiesExpiringTomorrow as $professionnalActivity) {
				if($professionnalActivity->user) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $professionnalActivity->user->id;
					$newMailLog->type = 'professionnal-activity-expires-tomorrow';
					$newMailLog->model()->associate($professionnalActivity);
					$newMailLog->save();
				}
			}
		}

		Log::info('professionnalActivitiesExpiringTomorrow is done ' . Carbon::now());

		$professionnalActivities = ProfessionnalActivity::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				])
				->where('end_date', '<', Carbon::now());
			})
			->get();

		if($professionnalActivities->isNotEmpty()) {
			foreach($professionnalActivities as $professionnalActivity) {
				$lastPublication = $professionnalActivity->lastPublication;

				$professionnalActivity->publications()->create([
					'user_id' => $professionnalActivity->user_id,
					'subscription_id' => $lastPublication->subscription->id,
					'state' => PublicationStates::Archived,
					'end_date' => Carbon::today()
				]);
			}
		}

		Log::info('professionnalActivities is done ' . Carbon::now());
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('check:publication Starts at ' . Carbon::now());

		$this->companies();
		$this->posts();
		$this->professionnalActivities();

		Log::info('check:publication Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
