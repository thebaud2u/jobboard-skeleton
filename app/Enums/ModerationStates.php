<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ModerationStates:string {
	use AsHumanLabels;

	case Denied = 'denied';
	case Validated = 'validated';
	case Waiting = 'waiting';

	public function inHuman(): string{
		return match($this) {
			self::Denied => 'Denied',
			self::Validated => 'Validated',
			self::Waiting => 'Waiting'
		};
	}
}