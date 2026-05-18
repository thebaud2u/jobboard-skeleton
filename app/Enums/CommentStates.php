<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum CommentStates:string {
	use AsHumanLabels;

	case Deleted = 'deleted';
	case Denied = 'denied';
	case Published = 'published';
	case WaitingModeration = 'waiting-moderation';

	public function inHuman(): string{
		return match($this) {
			self::Deleted => 'Deleted',
			self::Denied => 'Denied',
			self::Published => 'Published',
			self::WaitingModeration => 'Waiting moderation'
		};
	}
}