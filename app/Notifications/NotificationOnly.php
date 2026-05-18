<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

use App\Models\{Animal, Post, User};

class NotificationOnly extends Notification
{
	use Queueable;

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public User $user, public string $type, public $model)
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
			'database'
		];
	}

	public function toDatabase($notifiable)
	{
		if($this->type == 'adoption-congratulation') {
			if($this->model->model instanceof Animal) $animal = $this->model->model;
			elseif($this->model->model instanceof Post) $animal = $this->model->model->model;

			$array = [
				'response_id' => $this->model->id,
				'body' => 'Félicitations pour l\'adoption de '.$animal->name.' - '.$animal->breed->name.' - '.__($animal->values->get('sex')),
				'url' => route('space.responses.my-messages', ['response' => $this->model->id])
			];
		}

		return $array;
	}
}
