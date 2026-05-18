<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

class CustomResetPassword extends Notification implements ShouldQueue
{
	use Queueable;

	protected $token;

	public function __construct($token)
	{
		$this->token = $token;
	}

	public function via($notifiable)
	{
		return BrevoChannel::class;
	}

	public function toBrevoChannel($notifiable)
	{
		$url = url(route('password.reset', [
			'token' => $this->token,
			'email' => $notifiable->getEmailForPasswordReset(),
		], false));

		$body = '<p>Bonjour '.$notifiable->firstname.',</p>
			<p>Merci de vous être inscrit(e) sur '.env('APP_NAME').' !</p><br/>

			<p>Vous avez demander à changer votre mot de passe de compte Eleveurs-Online.</p><br/>

			<p><a href="'.$url.'">👉 C\'est par ici : Réitinialiser mon mot de passe.</a></p><br/>

			<p>Ce lien est valable pendant 48 heures.</p><br/>

			<p>Si vous n’êtes pas à l’origine de cette demande, veuillez ignorer ce message et votre mot de passe ne sera pas modifié.</p><br/>

			<p>À très bientôt sur Eleveurs Online !</p><br/>
			<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';

		return [
			'recipient' => $notifiable->getEmailForPasswordReset(),
			'subject' => 'Demande de réinitialisation de mot de passe de votre compte Eleveurs Online 🐾',
			'body' => $body,
			'tags' => ['Mot-de-passe']
		];
	}
}
