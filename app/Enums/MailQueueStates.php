<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum MailQueueStates:string {
	use AsHumanLabels;

	case Active = 'active';
	case Done = 'done';

	public function inHuman(): string{
		return match($this) {
			self::Active => 'Active',
			self::Done => 'Done'
		};
	}
}
