<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Log;

use App\Enums\PublicationStates;

use App\Models\{Company, Litter, Post};

class RefreshAllCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'refresh:all';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Refresh posts (and it\'s animals) and companies';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('refresh:all Starts at ' . Carbon::now());

		// Posts
		// Weekly refresh
		$postsWeeklyRefresh = Post::whereHas('lastPublication', function($whereHasLastPublication) {
				$whereHasLastPublication->whereHas('subscription', function($wherehasSubscription) {
					$wherehasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->whereHas('options', function($whereHasOption) {
							$whereHasOption->where('code', 'weekly-refresh');
						});
					})
					->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				});
			})
			->where(function($where) {
				$where->where('refreshed_at', '<=', Carbon::now()->subWeek()->format('Y-m-d'))
					->orWhereNull('refreshed_at');
			})
			->select('id')
			->get();

		if($postsWeeklyRefresh->isNotEmpty()) {
			foreach($postsWeeklyRefresh as $postWeeklyRefresh) {
				$post = Post::find($postWeeklyRefresh->id);
				$post->refreshed_at = Carbon::now();
				$post->save();

				if($post->model instanceof Litter) {
					$animals = $post->model->getAvailableChildren();

					if($animals->isNotEmpty()) {
						foreach($animals as $animal) {
							$animal->refreshed_at = $post->refreshed_at;
							$animal->save();
						}
					}
				}
				else {
					$post->model->refreshed_at = $post->refreshed_at;
					$post->model->save();
				}
			}
		}

		Log::info('postsWeeklyRefresh is done ' . Carbon::now());

		// Monthly refresh
		$postsMonthlyRefresh = Post::whereHas('lastPublication', function($whereHasLastPublication) {
				$whereHasLastPublication->whereHas('subscription', function($wherehasSubscription) {
					$wherehasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->whereHas('options', function($whereHasOption) {
							$whereHasOption->where('code', 'monthly-refresh');
						});
					})
					->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				});
			})
			->where(function($where) {
				$where->where('refreshed_at', '<=', Carbon::now()->subMonth()->format('Y-m-d'))
					->orWhereNull('refreshed_at');
			})
			->select('id')
			->get();

		if($postsMonthlyRefresh->isNotEmpty()) {
			foreach($postsMonthlyRefresh as $postMonthlyRefresh) {
				$post = Post::find($postMonthlyRefresh->id);
				$post->refreshed_at = Carbon::now();
				$post->save();

				if($post->model instanceof Litter) {
					$animals = $post->model->getAvailableChildren();

					if($animals->isNotEmpty()) {
						foreach($animals as $animal) {
							$animal->refreshed_at = $post->refreshed_at;
							$animal->save();
						}
					}
				}
				else {
					$post->model->refreshed_at = $post->refreshed_at;
					$post->model->save();
				}
			}
		}

		Log::info('postsMonthlyRefresh is done ' . Carbon::now());

		// Companies
		$companiesMonthlyRefresh = Company::whereHas('lastPublication', function($whereHasLastPublication) {
				$whereHasLastPublication->whereHas('subscription', function($wherehasSubscription) {
					$wherehasSubscription->whereHas('offer', function($whereHasOffer) {
						$whereHasOffer->whereHas('options', function($whereHasOption) {
							$whereHasOption->where('code', 'weekly-refresh');
						});
					})
					->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				});
			})
			->where(function($where) {
				$where->where('refreshed_at', '<=', Carbon::now()->subWeek()->format('Y-m-d'))
					->orWhereNull('refreshed_at');
			})
			->select('id')
			->get();

		if($companiesMonthlyRefresh->isNotEmpty()) {
			foreach($companiesMonthlyRefresh as $companyMonthlyRefresh) {
				$company = Company::find($companyMonthlyRefresh->id);
				$company->refreshed_at = Carbon::now();
				$company->save();
			}
		}

		Log::info('companiesMonthlyRefresh is done ' . Carbon::now());
		Log::info('refresh:all Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
