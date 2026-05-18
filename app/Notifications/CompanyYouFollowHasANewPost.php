<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Channels\BrevoChannel;

use App\Models\{Company, Post};

class CompanyYouFollowHasANewPost extends Notification
{
	use Queueable;

	public Company $company;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public Post $post)
	{
		$this->company = $post->user->company;
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
			'subject' => 'L\'entreprise que vous suivez vient de publier une annonce',
			'body' => '<p>Bonjour '.$notifiable->firstname.',</p><br/>

			<p>L\'entreprise '.$this->company->name.' que vous suivez vient de publier une nouvelle annonce !</p><br/>

			<p>👉 Pour voir les détails de l\'annonce :</p>
			<p><a href="'.route('post-search.post.show', ['company' => $this->company->slug, 'post' => $this->post->slug, 'breed' => $this->post->model->breed->slug]).'">ici</a></p><br/>

			<p>À très bientôt,</p>
			<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>',
			'tags' => ['reservation_animal', 'adoptant']
		];
	}

	public function toDatabase($notifiable)
	{
		return [
			'body' => 'L\'entreprise '.$this->company->name.' que vous suivez vient de publier une nouvelle annonce !',
			'url' => route('post-search.post.show', ['company' => $this->company->slug, 'post' => $this->post->slug, 'breed' => $this->post->model->breed->slug])
		];
	}
}
