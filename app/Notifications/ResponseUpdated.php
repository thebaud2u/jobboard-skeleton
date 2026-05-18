<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Enums\ResponseStates;

use App\Models\{Animal, Response, Post, User};

class ResponseUpdated extends Notification
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
		if($this->response->model instanceof Animal || ($this->response->model instanceof Post && $this->response->model->type->getTranslation('slug', 'en') != 'stud')) {
			if($this->response->model instanceof Animal) $text = 'pour l’adoption de '.$this->response->model->name;
			elseif($this->response->model instanceof Post) {
				if($this->response->model->type->getTranslation('slug', 'en') == 'litter' || $this->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
					if($this->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'pour la portée '.$this->response->model->model->breed->name;
					elseif($this->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'pour la portée à venir '.$this->response->model->model->breed->name;
				}
				else $text = 'pour l’adoption de '.$this->response->model->model->name;
			}

			$subject = '🔄 Mise à jour du statut de votre demande sur Eleveurs Online';
			$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Nous vous informons que le <b>statut de votre demande</b> '.$text.' a été mis à jour par l’éleveur sur <b>Eleveurs Online 🐾</b></p><br/>

				<p>➡️ Nouveau statut : '.__($this->response->state->inHuman()).'</p><br/>

				<p>Pour consulter le détail de votre demande et échanger avec l’éleveur si besoin, rendez-vous ici :</p>
				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Accéder à ma demande</a></p><br/>

				<p>Merci pour votre confiance et votre engagement envers une adoption responsable 💙</p><br/>

				<p>À très bientôt,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
			$tags = ['Statut_candidature', 'Adoptant'];
		}
		elseif($this->response->model instanceof Post && $this->response->model->type->getTranslation('slug', 'en') == 'stud') {
			$subject = '🔄 Mise à jour du statut de votre demande pour un étalon sur Eleveurs Online';
			$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Nous vous informons que le <b>statut de votre demande</b> pour un étalon de l\'entreprise '.$this->sender->company->name.' a été mis à jour par l’éleveur sur <b>Eleveurs Online</b> 🐾</p><br/>

				<p>➡️ Nouveau statut : '.__($this->response->state->inHuman()).'</p><br/>

				<p>Pour consulter le détail de votre demande et échanger avec l’éleveur si besoin, rendez-vous ici :</p>
				<p><a href="'.route('space.responses.my-messages', ['response' => $this->response->id]).'">👉 Accéder à ma demande</a></p><br/>

				<p>À très bientôt,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
			$tags = ['Statut_candidature', 'Eleveurs'];
		}

		return [
			'recipient' => $notifiable->email,
			'subject' => $subject,
			'body' => $body,
			'tags' => $tags
		];
	}

	public function toDatabase($notifiable)
	{
		$body = 'Le statut de votre demande a été modifié, votre demande est : '.__($this->response->state->inHuman());
		$url = route('space.responses.my-messages', ['response' => $this->response->id]);

		return [
			'response_id' => $this->response->id,
			'body' => $body,
			'url' => $url,
		];
	}
}
