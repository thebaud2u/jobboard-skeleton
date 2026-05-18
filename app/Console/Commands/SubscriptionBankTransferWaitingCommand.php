<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Models\{MailLog, Subscription};

class SubscriptionBankTransferWaitingCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'subscription:bank_transfer_waiting';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Send emails to remind user to pay the credit purchased via bank transfer in Stripe';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('subscription:bank_transfer_waiting Starts at ' . Carbon::now());

		$subscriptions = Subscription::where('values->payment_method', 'customer_balance')
			->where('values->payment_status', 'requires_action')
			->get();

		if($subscriptions->isNotEmpty()) {
			foreach($subscriptions as $subscription) {
				$sendMail = false;
				$reminder = 1;

				$previousReminder = MailLog::whereHas('user', function($whereHas) use($subscription) {
						$whereHas->where('id', $subscription->user->id);
					})
					->whereHasMorph('model', [Subscription::class], function($whereHasMorph) use($subscription) {
						$whereHasMorph->where('id', $subscription->id);
					})
					->where('type', 'reminder-bank-transfer-waiting')
					->latest()
					->first();

				$now = Carbon::now()->startOfDay();
				$daysSince = $now->diffInDays($subscription->created_at);

				// Définition des paliers de rappel
				$reminderDelays = [
					1 => 0,
					2 => 3,
					3 => 5,
					4 => 7,
				];

				if($previousReminder) {
					$nextReminder = $previousReminder->reminder_number + 1;

					if(isset($reminderDelays[$nextReminder]) && $daysSince === $reminderDelays[$nextReminder]) {
						$sendMail = true;
						$reminder = $nextReminder;
					}
				}
				else $sendMail = true;

				if($sendMail) {
					$newMailLog = new MailLog;
					$newMailLog->user_id = $subscription->user->id;
					$newMailLog->type = 'reminder-bank-transfer-waiting';
					$newMailLog->reminder_number = $reminder;
					$newMailLog->model()->associate($subscription);
					$newMailLog->save();
				}
			}
		}

		Log::info('subscriptions is done ' . Carbon::now());
		Log::info('subscription:bank_transfer_waiting Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
