<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Models\{Breed, Comment, User};

class CommentReply extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Comment $comment, public Breed $breed, public User $sender)
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
			'subject' => '💬 Un éleveur a répondu à votre question sur la race '.$this->breed->name,
			'body' => '<p>Bonjour '.$notifiable->firstname.',</p><br/>

				<p>Vous aviez posté un commentaire sur la fiche de la race '.$this->breed->name.' sur Eleveurs Online.</p>
				<p><b>Un éleveur vient de vous répondre !</b></p><br/>

				<p>👉 Cliquez ici pour lire sa réponse :</p>
				<p><a href="'.route('breed-search.'.$this->breed->species->name.'-breeds.show', ['breed' => $this->breed->slug]).'">Voir la réponse</a></p><br/>

				<p>N’hésitez pas à poursuivre la conversation ou à explorer les annonces des éleveurs de cette race si vous souhaitez aller plus loin dans votre projet d’adoption.</p><br/>

				<p>Merci pour votre confiance,</p>
				<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>',
			'tags' => ['Question_race', 'adoptant']
		];
	}

	public function toDatabase($notifiable)
	{
		return [
			'comment_id' => $this->comment->id,
			'body' => $this->sender->name.' a répondu à votre commentaire ou question sur la race '.$this->breed->name,
			'url' => route('breed-search.'.$this->breed->species->name.'-breeds.show', ['breed' => $this->breed->slug]),
		];
	}
}
