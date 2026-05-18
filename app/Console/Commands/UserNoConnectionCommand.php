<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\{MailLog, User};

class UserNoConnectionCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:no_connection';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send emails to know if they are still looking for a pet';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('user:no_connection Starts at ' . Carbon::now());

		$users = User::whereHas('roles', function($whereHas) {
				$whereHas->where('name', 'adopter');
			})
			->whereDoesntHave('mailLogs', function($whereDoesntHave) {
				$whereDoesntHave->where('type', 'user-no-connection');
			})
			->where('last_logon', '<=', Carbon::now()->subMonths(6))
			->get();

		if($users->isNotEmpty()) {
			foreach($users as $user) {
				$newMailLog = new MailLog;
				$newMailLog->user_id = $user->id;
				$newMailLog->type = 'user-no-connection';
				$newMailLog->save();
			}
		}
		Log::info('users is done ' . Carbon::now());
		Log::info('user:no_connection Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
