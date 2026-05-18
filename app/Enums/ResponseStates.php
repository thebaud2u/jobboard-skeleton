<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ResponseStates:string {
	use AsHumanLabels;

	case Closed = 'closed'; // to keep, Figo & EOL chat
	case Received = 'received'; // to keep
	case Unavailable = 'unavailable'; // to keep

	public function inHuman(): string{
		return match($this) {
			self::Closed => 'Closed',
			self::Received => 'Ongoing',
			self::Unavailable => 'Unavailable'
		};
	}
}
