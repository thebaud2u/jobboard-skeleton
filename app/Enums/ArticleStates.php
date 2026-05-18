<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum ArticleStates:string {
	use AsHumanLabels;

	case Archived = 'archived';
	case Deleted = 'deleted';
	case Draft = 'draft';
	case Published = 'published';
	case Unpublished = 'unpublished';
	case WaitingPublication = 'waiting-publication';

	public function inHuman(): string{
		return match($this) {
			self::Archived => 'Archived',
			self::Deleted => 'Deleted',
			self::Draft => 'Draft',
			self::Published => 'Published',
			self::Unpublished => 'Unpublished',
			self::WaitingPublication => 'Waiting publication'
		};
	}
}