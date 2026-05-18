<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\URL;

use App\Channels\BrevoChannel;

class CustomVerifyEmail extends Notification implements ShouldQueue
{
	use Queueable;

	public function via($notifiable)
	{
		return BrevoChannel::class;
	}

	public function toBrevoChannel($notifiable)
	{
		$verificationUrl = $this->verificationUrl($notifiable);

		$body = '<p>Bonjour '.$notifiable->firstname.',</p>
			<p>Merci de vous être inscrit(e) sur '.env('APP_NAME').' !</p><br/>

			<p>Pour finaliser la création de votre compte et accéder à toutes nos fonctionnalités, il vous suffit de confirmer votre adresse e-mail en cliquant ci-dessous :</p><br/>

			<p><a href="'.$verificationUrl.'">👉 Confirmer mon compte</a></p><br/>

			<p>Ce lien est valable pendant 48 heures.</p><br/>

			<p>Si vous n’êtes pas à l’origine de cette inscription, veuillez ignorer ce message et votre adresse ne sera pas utilisée.</p><br/>

			<p>À très bientôt sur Eleveurs Online !</p><br/>
			<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';

		return [
			'recipient' => $notifiable->getEmailForVerification(),
			'subject' => 'Confirmez votre inscription à Eleveurs Online 🐾',
			'body' => $body,
			'tags' => ['Inscription']
		];
	}

	protected function verificationUrl($notifiable)
	{
		return URL::temporarySignedRoute(
			'verification.verify',
			Carbon::now()->addHours(48),
			[
				'id' => $notifiable->getKey(),
				'hash' => sha1($notifiable->getEmailForVerification()),
			]
		);
	}
}
