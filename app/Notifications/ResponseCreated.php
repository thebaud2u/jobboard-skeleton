<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Models\{Animal, Company, Post, ProfessionnalActivity, Response, User};

class ResponseCreated extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Response $response, public User $sender)
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
		return [
			'recipient' => $notifiable->email,
			'subject' => '📝 Nouvelle demande reçue sur l’une de vos annonces',
			'body' => '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Vous avez reçu une <b>réponse à votre annonce</b> sur Eleveurs Online.</p><br/>

				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Consulter la réponse</a></p><br/>

				<p>Prenez le temps d’examiner la demande et d’échanger via la messagerie intégrée.</p><br/>

				<p>Une réponse rapide renforce votre visibilité auprès de la communauté.</p><br/>

				<p>À bientôt sur Eleveurs Online,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>',
			'tags' => ['Nouvelle_candidature', 'Eleveurs']
		];
	}

	public function toDatabase($notifiable)
	{
		if($this->response->model instanceof Animal) $text = $this->response->model->name;
		elseif($this->response->model instanceof Post) {
			if($this->response->model->type->getTranslation('slug', 'en') == 'litter' || $this->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				if($this->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$this->response->model->model->breed->name;
				elseif($this->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$this->response->model->model->breed->name.' à venir';
			}
			else $text = $this->response->model->model->name;
		}
		elseif($this->response->model instanceof Company || $this->response->model instanceof ProfessionnalActivity) {
			$text = $this->response->model->name;
		}

		return [
			'response_id' => $this->response->id,
			'body' => $this->sender->name.' vous a envoyé une demande pour '.$text,
			'url' => route('space.responses.my-messages', ['response' => $this->response->id]),
		];
	}
}
