<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\{MailLog, User};

class UserProfileCompletionCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'user:profile_completion';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send emails to remind user to complete their profile';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('user:profile_completion Starts at ' . Carbon::now());

		$users = User::whereHas('roles', function($whereHas) {
				$whereHas->where('name', 'adopter');
			})
			->whereDoesntHave('mailLogs', function($whereDoesntHave) {
				$whereDoesntHave->where('type', 'reminder-adopter-profile-completion');
			})
			->where('last_logon', '<=', Carbon::now()->subWeek())
			->get();

		if($users->isNotEmpty()) {
			foreach($users as $user) {
				if($user->profileCompletionPercentage() < 100) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $user->id;
					$newMailLog->type = 'reminder-adopter-profile-completion';
					$newMailLog->save();
				}
			}
		}

		Log::info('users is done ' . Carbon::now());
		Log::info('user:profile_completion Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
