<?php

namespace App\Support;

class ModerationUserDenyReasons
{
	public const REASONS = [
		'siret-unvalid-for-professionnal-activity' => [
			'Title' => 'SIRET not compliant with a professional company activity',
			'Description' => "Hello, to practice as a professional breeder on our site, it is necessary that your SIRET number corresponds to a company activity, i.e. the code APE 01.49Z – Company of other animals. Thus, this code certifies that you are indeed declared to the Chamber of Agriculture as a breeder of dogs and/or cats, in accordance with articles L214-6 and following of the Rural Code. Since your current SIRET corresponds to another activity, you can, if you wish, create a secondary activity dedicated to dog company in order to be listed on the site as a professional breeder. We remain at your disposal if you need help or clarification regarding this process. Best regards, L'Equipe Eleveurs Online."
		],
		'missing-document' => [
			'Title' => 'Missing document',
			'Description' => "Hello, we need a voting proof of residence to validate your account. Sincerely, L'Equipe Eleveurs Online."
		],
		'non-concordant-document' => [
			'Title' => 'Non-concordant document',
			'Description' => "Hello, the account name does not match the name indicated on the ID, we thank you for sending us a matching ID or modifying your account. Best regards, L'Equipe Eleveurs Online."
		],
		'other' => [
			'Title' => 'Other',
			'Description' => ""
		],
	];

	public const HISTORY = [
		'insee-opposition' => [
			'Title' => 'Insee opposition',
			'Description' => ""
		],
		'siret-unvalid' => [
			'Title' => 'Siret unvalid',
			'Description' => ""
		],
		'siret-hidden' => [
			'Title' => 'SIRET number hidden Insee',
			'Description' => ""
		],
		'siret-unvalid-for-professionnal-activity' => [
			'Title' => 'SIRET not compliant with a professional company activity',
			'Description' => "Hello, to practice as a professional breeder on our site, it is necessary that your SIRET number corresponds to a company activity, i.e. the code APE 01.49Z – Company of other animals. Thus, this code certifies that you are indeed declared to the Chamber of Agriculture as a breeder of dogs and/or cats, in accordance with articles L214-6 and following of the Rural Code. Since your current SIRET corresponds to another activity, you can, if you wish, create a secondary activity dedicated to dog company in order to be listed on the site as a professional breeder. We remain at your disposal if you need help or clarification regarding this process. Best regards, L'Equipe Eleveurs Online."
		],
		'ID-checking' => [
			'Title' => 'ID checking',
			'Description' => ""
		],
		'cessation-siret' => [
			'Title' => 'Cessation of activity Siret',
			'Description' => ""
		],
		'asking-home-document' => [
			'Title' => 'Need of home document',
			'Description' => ""
		],
		'missing-document' => [
			'Title' => 'Missing document',
			'Description' => "Hello, we need a voting proof of residence to validate your account. Sincerely, L'Equipe Eleveurs Online."
		],
		'non-concordant-document' => [
			'Title' => 'Non-concordant document',
			'Description' => "Hello, the account name does not match the name indicated on the ID, we thank you for sending us a matching ID or modifying your account. Best regards, L'Equipe Eleveurs Online."
		],
		'update-accaced-document' => [
			'Title' => 'Update your ACACED certificat',
			'Description' => "Please, update your acaced certificate. Best regards, L'Equipe Eleveurs Online."
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
