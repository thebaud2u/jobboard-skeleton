<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Models\{Alert, Post};

class NewPostMatchsYourAlert extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Post $post, public Alert $alert)
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
			'subject' => 'Une nouvelle annonce correspond à votre alerte',
			'body' => '<p>Bonjour '.$notifiable->firstname.',</p><br/>

			<p>Une nouvelle annonce correspond à l\'alerte « '.$this->alert->name.' » que vous avez créée sur Éleveur Online vient d’être publiée</p><br/>

			<p>👉 Pour voir les détails de l\'annonce :</p>
			<p><a href="'.route('post-search.post.show', ['company' => $this->post->user->company->slug, 'post' => $this->post->slug, 'breed' => $this->post->model->breed->slug]).'">ici</a></p><br/>

			<p>À très bientôt,</p>
			<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>',
			'tags' => ['reservation_animal', 'adoptant']
		];
	}

	public function toDatabase($notifiable)
	{
		return [
			'body' => 'Une nouvelle annonce correspond à l\'alerte « '.$this->alert->name.' » que vous avez créée sur Éleveur Online vient d’être publiée',
			'url' => route('post-search.post.show', ['company' => $this->post->user->company->slug, 'post' => $this->post->slug, 'breed' => $this->post->model->breed->slug])
		];
	}
}
