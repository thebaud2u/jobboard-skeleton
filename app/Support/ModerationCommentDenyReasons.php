<?php

namespace App\Support;

class ModerationCommentDenyReasons
{
	public const REASONS = [
		'expand' => [
			'Title' => 'Please expand your presentation',
			'Description' => "Hello, we thank you for developing the presentation of your company: history, moments and/or key figures, anecdotes etc.. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other reason',
			'Description' => ""
		],
	];

	public const HISTORY = [
		'inapropriate' => [
			'Title' => 'Your comment is inapropriate',
			'Description' => ""
		],
		'expand' => [
			'Title' => 'Please expand your presentation',
			'Description' => "Hello, we thank you for developing the presentation of your company: history, moments and/or key figures, anecdotes etc.. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other reason',
			'Description' => ""
		],
	];

	public static function options(): array
	{
		$reasons =  self::REASONS;

		foreach ($reasons as $key => $item) {
			$reasons[$key]['Title'] = __($item['Title']);

			if(!empty($item['Description'])) $reasons[$key]['Description'] = __($item['Description']);
		}

		return $reasons;
	}
}
