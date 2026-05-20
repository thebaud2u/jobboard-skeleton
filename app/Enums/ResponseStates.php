<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ResponseStates:string {
	use AsHumanLabels;

	case Accepted = 'accepted';
	case Denied = 'denied';
	case Received = 'received';
	case Unavailable = 'unavailable';

	public function inHuman(): string{
		return match($this) {
			self::Accepted => 'Accepted',
			self::Denied => 'Denied',
			self::Received => 'Received',
			self::Unavailable => 'Unavailable'
		};
	}
}
