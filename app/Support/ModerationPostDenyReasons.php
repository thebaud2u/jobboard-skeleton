<?php

namespace App\Support;

class ModerationPostDenyReasons
{
	public const REASONS = [
		'missing-parents' => [
			'Title' => 'Missing parents',
			'Description' => "Hello, so that your post can be published, we thank you for indicating a Father and a Mother within your reach. Best regards, L'Equipe Eleveurs Online."
		],
		'identification-number-incorrect' => [
			'Title' => 'Identification number is incorrect',
			'Description' => "Hello, the ID number entered does not match your pet. Please check and correct your entry. Best regards, L'Equipe Eleveurs Online."
		],
		'identification-number-not-provided' => [
			'Title' => 'Identification number not provided',
			'Description' => "Hello, we thank you for indicating your animal’s identification number to allow its validation. Best regards, L'Equipe Eleveurs Online."
		],
		'profil-incomplete' => [
			'Title' => 'Profil incomplete',
			'Description' => "Hello, please complete your profile so that we can validate your post. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other',
			'Description' => ""
		],
	];

	public const HISTORY = [
		'litter-number-not-recognized' => [
			'Title' => 'Litter number not recognized',
			'Description' => ""
		],
		'litter-number-doesnt-match' => [
			'Title' => 'Litter number does not match',
			'Description' => ""
		],
		'not-LOF' => [
			'Title' => 'Not LOF',
			'Description' => ""
		],
		'individual-more-than-one-post' => [
			'Title' => 'Individual : more than a post broadcasted over the year',
			'Description' => ""
		],
		'deletion-last-notification' => [
			'Title' => 'Last notification before account deletion',
			'Description' => ""
		],
		'switched' => [
			'Title' => 'Professionnal post switched to individual',
			'Description' => ""
		],
		'missing-parents' => [
			'Title' => 'Missing parents',
			'Description' => "Hello, so that your post can be published, we thank you for indicating a Father and a Mother within your reach. Best regards, L'Equipe Eleveurs Online."
		],
		'identification-number-incorrect' => [
			'Title' => 'Identification number is incorrect',
			'Description' => "Hello, the ID number entered does not match your pet. Please check and correct your entry. Best regards, L'Equipe Eleveurs Online."
		],
		'identification-number-not-provided' => [
			'Title' => 'Identification number not provided',
			'Description' => "Hello, we thank you for indicating your animal’s identification number to allow its validation. Best regards, L'Equipe Eleveurs Online."
		],
		'profil-incomplete' => [
			'Title' => 'Profil incomplete',
			'Description' => "Hello, please complete your profile so that we can validate your post. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other',
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
