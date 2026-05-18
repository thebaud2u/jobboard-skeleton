<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\{Offer, Subscription};

class CheckPermissionsCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'check:permissions';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check inactive subscriptions';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('check:permissions Starts at ' . Carbon::now());

		Subscription::where('end_date', '<', Carbon::now())
			->whereHas('offer', function($whereHas) {
				$whereHas->where('free', 0);
			})
			->delete();

		Log::info('check:permissions Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
