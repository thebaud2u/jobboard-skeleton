<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\BrevoService;

use App\Models\User;

class NewsletterController extends Controller
{
	protected $brevoService;

	public function __construct(BrevoService $brevoService)
	{
		$this->brevoService = $brevoService;
	}

	public function index()
	{
		return view('front.newsletter');
	}

	public function subscribe(Request $request)
	{
		$validated = $request->validate([
			'email' => 'required|email',
			'optins' => 'nullable|array',
			'optins.*' => 'string|in:OPTIN_NL_ADOPTANT,OPTIN_MARKETING_ADOPTANT,OPTIN_PARTENAIRE_ADOPTANT,OPTIN_NL_ELEVEUR,OPTIN_MARKETING_ELEVEUR,OPTIN_PARTENAIRE_ELEVEUR,OPTIN_NL_PROFESSIONNEL,OPTIN_MARKETING_PROFESSIONNEL,OPTIN_PARTENAIRE_PROFESSIONNEL,OPTIN_MARKETING_PROSPECT,OPTIN_PARTENAIRE_PROSPECT'
		]);

		try {
			$attributes = [];

			// Déterminer les listes en fonction des opt-ins
			$listId = [];
			$optins = $validated['optins'] ?? [];
			foreach ($optins as $optin) {
				$attributes[$optin] = 1;
				// Ajouter l'ID de la liste en fonction de l'opt-in
				if (in_array($optin, ['OPTIN_MARKETING_PROSPECT', 'OPTIN_PARTENAIRE_PROSPECT'])) {
					if (!in_array(30, $listId)) {
						$listId[] = 30; // Liste prospects
					}
				}
				// elseif (isset($request->isProspect) && $request->isProspect == "true") $listId[] = 30;
				else {
					if (!in_array(9, $listId)) {
						$listId[] = 9; // Liste master
					}
				}
			}

			// Si aucune liste n'est sélectionnée, utiliser la liste master par défaut
			if (empty($listId)) {
				$listId = [9];
			}

			// Ajouter le contact à la liste Brevo
			$result = $this->brevoService->addContactToList(
				$validated['email'],
				$listId,
				$attributes
			);

			// Préparer le message de retour
			$apiMessage = isset($result['id']) ? __('Contact ajouté avec l\'ID : :id', ['id' => $result['id']]) : __('Contact ajouté ou mis à jour avec succès.');

			// Setup userType pour tracking
			$userType = 'non_identifie';

			foreach ($request->all() as $key => $value) {
				if($key == 'optins') {
					foreach ($value as $k => $v) {
						if (str_contains($v, 'ADOPTANT')) {
							$userType = 'adoptant';
							break;
						}
						if (str_contains($v, 'ELEVEUR')) {
							$userType = 'eleveur';
							break;
						}
						if (str_contains($v, 'PROFESSIONNEL')) {
							$userType = 'pro';
							break;
						}
					}
				}
			}
			
			return redirect()->to($request->input('redirect_to', url()->previous()))
				->with('success', __('Vous êtes inscrits.') . ' ' . $apiMessage)
				->with('gtm', [
					'event'     => 'generate_lead',
					'user_type' => $userType
				]);

		} catch (Exception $e) {
			return redirect()->to($request->input('redirect_to', url()->previous()))
				->with('error', __('Une erreur est survenue lors de l\'inscription : :message', ['message' => $e->getMessage()]));
		}
	}

	public function unsubscribe(Request $request) {
		if($this->brevoService->verifyContactIdentity($request->userEmail, $request->idBrevo)) {
			return view('front.unsubscribe', ['optin' => $request->optin, 'email' => $request->userEmail]);
		}
	}

	public function formUnsubscribe(Request $request) {
		$validated = $request->validate([
			'email' => 'required|email',
			'optin' => 'required|string|in:OPTIN_NL_ADOPTANT,OPTIN_MARKETING_ADOPTANT,OPTIN_PARTENAIRE_ADOPTANT,OPTIN_NL_ELEVEUR,OPTIN_MARKETING_ELEVEUR,OPTIN_PARTENAIRE_ELEVEUR,OPTIN_NL_PROFESSIONNEL,OPTIN_MARKETING_PROFESSIONNEL,OPTIN_PARTENAIRE_PROFESSIONNEL,OPTIN_MARKETING_PROSPECT,OPTIN_PARTENAIRE_PROSPECT'
		]);

		// Modifie l'optin du contact
		$result = $this->brevoService->unsubscribeContactOptin(
			$validated['email'],
			[$validated['optin'] => 2]
		);

		$user = User::where('email', $request->email)
			->first();

		if($user) {
			$optins = $user->values->get('optins');

			if($request->optin == 'OPTIN_NL_ADOPTANT' || $request->optin == 'OPTIN_NL_ELEVEUR' || $request->optin == 'OPTIN_NL_PROFESSIONNEL') $optins['option_newsletter'] = 2;
			elseif($request->optin == 'OPTIN_MARKETING_ADOPTANT' || $request->optin == 'OPTIN_MARKETING_ELEVEUR' || $request->optin == 'OPTIN_MARKETING_PROFESSIONNEL') $optins['option_receive_info'] = 2;
			elseif($request->optin == 'OPTIN_PARTENAIRE_ADOPTANT' || $request->optin == 'OPTIN_PARTENAIRE_ELEVEUR' || $request->optin == 'OPTIN_PARTENAIRE_PROFESSIONNEL') $optins['optin_receive_deals'] = 2;

			$user->updateValue('optins', $optins);
			$user->save();
		}

		return redirect()->route('home')->with('success', __('Vous êtes bien désinscrits.'));
	}
}
