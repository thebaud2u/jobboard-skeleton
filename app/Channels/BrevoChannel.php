<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

use App\Services\BrevoService;

class BrevoChannel
{
	public function send($notifiable, Notification $notification)
	{
		$details = $notification->toBrevoChannel($notifiable);

		$brevoService = new BrevoService();
		$result = $brevoService->sendTransactionalEmail($details['recipient'], $details, $details['tags'] ?? [], $details['attachment'] ?? []);
	}
}
