<?php

namespace App\Services;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\HttpClient\Exception\ClientException;

class BrevoService
{
	protected $client;
	protected $apiKey;

	public function __construct()
	{
		$this->client = HttpClient::create();
		$this->apiKey = config('services.brevo.key');
	}

	public function sendTransactionalEmail(string $to, array $details, array $tags = [], array $attachment = []): array
	{
		if(isset($details['template'])) $template = $details['template'];
		else $template = 41;

		try {
			$payload = [
				'to' => [['email' => $to]],
				'sender' => ['email' => config('mail.from.address'), 'name' => config('mail.from.name')],
				'templateId' => $template,
				'params' => [
					'body' => $details['body'],
					'subject' => $details['subject'],
					// Ajoutez d'autres paramètres dynamiques si nécessaire
				],
			];

			// Ajouter les tags au payload si non vide
			if (!empty($tags)) {
				$payload['tags'] = $tags;
			}

			if (!empty($attachment)) {
				$att = [
					'content' => base64_encode($attachment['content']), // Encode UNE SEULE FOIS ici
					'name'    => $attachment['name'] ?? 'invitation.ics',
					'type'    => $attachment['type'] ?? 'text/calendar'
				];

				$payload['attachment'] = [$att];
			}

			$response = $this->client->request('POST', 'https://api.brevo.com/v3/smtp/email', [
				'headers' => [
					'api-key' => $this->apiKey,
					'Content-Type' => 'application/json',
				],
				'json' => $payload,
			]);

			return [
				'success' => true,
				'message' => 'Email envoyé avec succès',
				'response' => $response->getContent(),
			];
		} catch (ClientException $e) {
			return [
				'success' => false,
				'message' => 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage(),
				'response' => $e->getResponse()->getContent(false),
			];
		}
	}

	/**
	 * Ajoute un contact à une liste Brevo.
	 *
	 * @param string $email L'adresse email du contact
	 * @param array $listIds Les IDs des listes auxquelles ajouter le contact
	 * @param array $attributes Attributs supplémentaires du contact (ex. : NOM, PRENOM)
	 * @return array Résultat de l'opération
	 */
	public function addContactToList(string $email, array $listIds, array $attributes = []): array
	{
		try {
			$response = $this->client->request('POST', 'https://api.brevo.com/v3/contacts', [
				'headers' => [
					'api-key' => $this->apiKey,
					'Content-Type' => 'application/json',
				],
				'json' => [
					'email' => $email,
					'listIds' => $listIds, // ID de la liste master = 9, ID de la liste prospect = 30
					'attributes' => $attributes,
					'updateEnabled' => true, // Met à jour le contact s'il existe déjà
				],
			]);

			return [
				'success' => true,
				'message' => 'Contact ajouté à la liste avec succès',
				'response' => $response->getContent(),
			];
		} catch (ClientException $e) {
			return [
				'success' => false,
				'message' => 'Erreur lors de l\'ajout du contact : ' . $e->getMessage(),
				'response' => $e->getResponse()->getContent(false),
			];
		}
	}

	/**
	 * Ajoute un contact à une liste Brevo.
	 *
	 * @param string $email L'adresse email du contact
	 * @param array $listIds Les IDs des listes auxquelles ajouter le contact
	 * @param array $attributes Attributs supplémentaires du contact (ex. : NOM, PRENOM)
	 * @return array Résultat de l'opération
	 */
	public function unsubscribeContactOptin(string $email, array $attributes = []): array
	{
		try {
			$response = $this->client->request('POST', 'https://api.brevo.com/v3/contacts', [
				'headers' => [
					'api-key' => $this->apiKey,
					'Content-Type' => 'application/json',
				],
				'json' => [
					'email' => $email,
					'attributes' => $attributes,
					'updateEnabled' => true, // Met à jour le contact s'il existe déjà
				],
			]);

			return [
				'success' => true,
				'message' => 'Contact ajouté à la liste avec succès',
				'response' => $response->getContent(),
			];
		} catch (ClientException $e) {
			return [
				'success' => false,
				'message' => 'Erreur lors de l\'ajout du contact : ' . $e->getMessage(),
				'response' => $e->getResponse()->getContent(false),
			];
		}
	}

	/**
	 * Vérifie que l'email et l'ID Brevo correspondent au même contact.
	 *
	 * @param string $email Email du contact
	 * @param int $brevoContactId ID Brevo du contact
	 * @return void
	 * @throws Exception Si l'email et l'ID ne correspondent pas ou si le contact n'existe pas
	 */
	public function verifyContactIdentity($email, $brevoContactId)
	{
		try {
			$endpoint = 'https://api.brevo.com/v3/contacts/' . urlencode($email) . '?identifierType=email_id';
			$response = $this->client->request('GET', $endpoint, [
				'headers' => [
					'api-key' => $this->apiKey,
					'Content-Type' => 'application/json',
				]
			]);
			$data = json_decode($response->getContent(), true);

			if (!isset($data['id']) || $data['id'] != $brevoContactId) {
				throw new \Exception('L\'email et l\'ID Brevo ne correspondent pas au même contact.');
			}
			else return true;
		} catch (\Exception $e) {
			throw new \Exception('Erreur lors de la vérification de l\'identité du contact : ' . $e->getMessage());
		}
	}
}
