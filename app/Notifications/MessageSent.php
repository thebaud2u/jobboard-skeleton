<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

use App\Channels\BrevoChannel;

use App\Models\{Message, Response, ProfessionnalActivity, User};

class MessageSent extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Response $response, public Message $message, public User $sender)
	{

	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param  mixed  $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return [
			BrevoChannel::class,
			'database'
		];
	}

	public function toBrevoChannel($notifiable)
	{
		if($notifiable->hasRole('adopter')) {
			$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Bonne nouvelle !</p>
				<p>Vous avez reçu un <b>nouveau message</b>.</p><br/>

				<p>Pour le consulter et répondre directement, cliquez ici :</p>
				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Lire le message</a></p><br/>

				<p>Ce message concerne probablement un animal que vous avez repéré récemment : ne laissez pas passer cette occasion d’échanger avec l’éleveur !</p><br/>

				<p>À bientôt sur Eleveurs Online,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
			$tags = ['Nouveau_message', 'Adopter'];
		}
		elseif($notifiable->hasRole(['breeder', 'individual_breeder', 'professionnal_breeder', 'professionnal'])) {
			if($this->response->model instanceof ProfessionnalActivity) {
				$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Bonne nouvelle !</p>
				<p>Vous avez reçu un <b>nouveau message</b>.</p><br/>

				<p></p>
				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Lire le message</a></p><br/>

				<p>📢 Répondre rapidement augmente vos chances de retenir l’attention du client et de démarrer une collaboration. Les utilisateurs privilégient les professionnels les plus réactifs.</p>
				<p>À vous de jouer !</p><br/>

				<p>À bientôt sur Eleveurs Online,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
				$tags = ['Nouveau_message', 'professionnels'];
			}
			else {
				$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Bonne nouvelle !</p>
				<p>Vous avez reçu un <b>nouveau message</b>.</p><br/>

				<p>Pour le consulter et répondre directement, cliquez ici :</p>
				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Lire le message</a></p><br/>

				<p>Répondre rapidement renforme la qualité de votre profil auprès de la communauté.</p><br/>

				<p>À bientôt sur Eleveurs Online,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
				$tags = ['Nouveau_message', 'Eleveurs'];
			}
		}

		return [
			'recipient' => $notifiable->email,
			'subject' => '📩 Vous avez reçu un nouveau message sur Eleveurs Online',
			'body' => $body,
			'tags' => $tags
		];
	}

	public function toDatabase($notifiable)
	{
		return [
			'message_id' => $this->message->id,
			'response_id' => $this->response->id,
			'body' => $this->sender->name.' vous a envoyé un message : '.Str::limit($this->message->body),
			'url' => route('space.responses.my-messages', ['response' => $this->response->id]),
		];
	}
}
