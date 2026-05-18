<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ResponseTypes:string {
	use AsHumanLabels;

	case Application = 'application';
	case Messaging = 'messaging';
	case Self = 'eleveurs-online';

	public function inHuman(): string{
		return match($this) {
			self::Application => 'Application',
			self::Messaging => 'Messaging',
			self::Self => 'Self',
		};
	}
}
