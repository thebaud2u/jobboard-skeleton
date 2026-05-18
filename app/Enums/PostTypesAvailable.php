<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum PostTypesAvailable:string {
	use AsHumanLabels;

	case LittersAvailable = 'litters-available';
	case LittersSoonAvailable = 'litters-soon-available';
	case RetiredAdultsAvailable = 'retired-adults-available';
	case StudsAvailable = 'studs-available';

	public function inHuman(): string{
		return match($this) {
			self::LittersAvailable => 'Litters available',
			self::LittersSoonAvailable => 'Litters soon available',
			self::RetiredAdultsAvailable => 'Adults available',
			self::StudsAvailable => 'Studs available'
		};
	}
}