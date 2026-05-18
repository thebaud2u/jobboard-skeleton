<?php

namespace App\Support;

class ModerationCompanyDenyReasons
{
	public const REASONS = [
		'companies-animal-information-incorrect' => [
			'Title' => 'Some of your animals informations are incorrect',
			'Description' => "Hello, we thank you for indicating your animal’s identification number to allow its validation. Best regards, L'Equipe Eleveurs Online."
		],
		'incomplete-profil' => [
			'Title' => 'Profil incomplete',
			'Description' => "Hello, please complete your profile so that we can validate your company. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other reason',
			'Description' => ""
		],
	];

	public const HISTORY = [
		'medecines-promotion' => [
			'Title' => 'Prohibition of medicines promotion',
			'Description' => ""
		],
		'abusive-content' => [
			'Title' => 'Abusive content',
			'Description' => ""
		],
		'companies-animal-information-incorrect' => [
			'Title' => 'Some of your animals informations are incorrect',
			'Description' => "Hello, we thank you for indicating your animal’s identification number to allow its validation. Best regards, L'Equipe Eleveurs Online."
		],
		'incomplete-profil' => [
			'Title' => 'Profil incomplete',
			'Description' => "Hello, please complete your profile so that we can validate your company. Best regards, L'Equipe Eleveurs Online."
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
