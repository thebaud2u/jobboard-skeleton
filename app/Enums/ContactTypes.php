<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ContactTypes: string {
	use AsHumanLabels;

	case Application = 'application';
	case Contact = 'contact';
	case Call = 'call';

	public function inHuman(): string{
		return match($this) {
			self::Application => 'Application',
			self::Contact => 'Contact',
			self::Call => 'Call'
		};
	}
}
