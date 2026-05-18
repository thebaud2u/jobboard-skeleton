<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Models\{Breed, Company, Comment};

class CommentCreated extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Comment $comment)
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
		if($this->comment->target instanceof Company) {
			$subject = '⭐ Un adoptant a laissé un avis dans votre livre d\'or — souhaitez-vous le publier ?';
			$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Un adoptant a récemment déposé un <b>avis dans le livre d’or</b> de votre entreprise sur Eleveurs Online 🐾</p><br/>

				<p><a href="'.route('space.companies.my-company').'">👉 Lire l’avis et choisir s’il doit être publié (onglet "Témoignages")</a></p><br/>

				<p>Les témoignages d’adoptants renforcent la confiance des futurs visiteurs. Vous pouvez décider de le rendre visible sur votre page entreprise en un clic.</p><br/>

				<p>Merci pour votre professionnalisme,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
			$tags = ['Nouvel_avis', 'Eleveurs'];
		}
		elseif($this->comment->target instanceof Breed) {
			$subject = '💬 Un message a été posté sur la page de votre race — votre réponse compte !';
			$body = '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Un adoptant a laissé <b>un message sur la page de la race '.$this->comment->target->name.'</b> sur Eleveurs Online.<br/>

				<p><a href="'.route('breed-search.'.$this->comment->target->species->name.'-breeds.show', ['breed' => $this->comment->target->slug]).'">👉 Voir le message et y répondre</a></p><br/>

				<p>💡 En répondant, vous contribuez à améliorer votre visibilité auprès des futurs adoptants intéressés par cette race. Votre expertise est précieuse pour la communauté !</p><br/>

				<p>Merci pour votre engagement,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';
			$tags = ['Fiche_race', 'Eleveurs'];
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
		if($this->comment->target instanceof Company) {
			$body = 'Un adoptant a laissé un avis dans votre livre d\'or : publiez-le !';
			$url = route('space.companies.my-company');
		}
		elseif($this->comment->target instanceof Breed) {
			$body = 'Un message a été posté sur la page de votre race — votre réponse compte !';
			$url = route('breed-search.'.$this->comment->target->species->name.'-breeds.show', ['breed' => $this->comment->target->slug]);
		}

		return [
			'comment_id' => $this->comment->id,
			'body' => $body,
			'url' => $url,
		];
	}
}
