<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

use App\Enums\ContactTypes;

use App\Notifications\SendContact;

class Contact extends Model
{
	use Notifiable;

	protected $fillable = [
		'object',
		'firstname',
		'lastname',
		'phone',
		'email',
		'message',
		'file',
		'created_at',
		'updated_at'
	];

	/**
	 * The attributes that should be cast.
	 *
	 * @var array<string, string>
	 */
	protected $casts = [
		'created_at' => 'datetime',
		'updated_at' => 'datetime'
	];

	// Functions
	public static function boot()
	{
		parent::boot();
		static::created(function($model) {
			if($model->type == ContactTypes::Contact) $model->notify(new SendContact($model));
		});
	}
}
