<?php

namespace App\Enums;

use App\Traits\AsHumanLabels;

enum PublicationStates:string {
	use AsHumanLabels;

	case Archived = 'archived';
	case Deleted = 'deleted';
	case Draft = 'draft';
	case DraftWaitingModerationForPublication = 'draft-waiting-moderation-for-publication';
	case Published = 'published';
	case PublishedUpdatedWaitingModeration = 'published-updated-waiting-moderation';
	case PublishedUpgradedWaitingModeration = 'published-upgraded-waiting-moderation';

	public function inHuman(): string{
		return match($this) {
			self::Archived => 'Archived',
			self::Deleted => 'Deleted',
			self::Draft => 'Draft',
			self::DraftWaitingModerationForPublication => 'Draft waiting moderation for publication',
			self::Published => 'Published',
			self::PublishedUpdatedWaitingModeration => 'Published, updated and waiting moderation',
			self::PublishedUpgradedWaitingModeration => 'Published, upgraded and waiting moderation',
		};
	}
}