<?php

namespace App\Http\Livewire\Front\Space\Profile;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Services\BreederGPTService;

class BreederGpt extends Component
{
	public User $user;

	public $message = '';
	public $conversations = [];
	public $conversationId = null;
	public $conversationSelected = false;
	public $messages = null;
	public $autoMessages = [];
	public $showLoader = false;
	public $hasAccess = false;
	public array $responses = [];

	public function selectConversation($conversation)
	{
		$breederGPT = app(BreederGPTService::class);

		$this->conversationId = $conversation;

		$this->messages = [];

		$response = $breederGPT->getHistory($this->user->id, $this->conversationId);

		if($response && !empty($response['data'])) {
			foreach($response['data'] as $history) {
				$this->messages[$history['id']] = [
					'query' => $history['query'],
					'answer' => $history['answer'] ?? '',
				];
			}
		}

		$this->dispatch('conversation-loaded');
	}

	public function hideModels()
	{
		if(is_null($this->messages)) $this->messages = [];
	}

	public function newChat()
	{
		$this->message = '';
		$this->conversationId = '';
		$this->conversationSelected = false;
		$this->messages = null;
	}

	public function autoMessage($index)
	{
		$this->message = $this->autoMessages[$index];
		$this->messages = [];
	}

	public function refreshConversations()
	{
		$breederGPT = app(BreederGPTService::class);

		/*$this->conversations = $breederGPT->getConversations($this->user->id);

		if($this->conversations['data']) {
			foreach($this->conversations['data'] as $conversation) {
				$breederGPT->deleteConversation($conversation['id'], $this->user->id);
			}
		}*/

		$this->conversations = $breederGPT->getConversations($this->user->id);

		if($this->conversations && $this->conversations['data']) {
			$this->selectConversation($this->conversations['data'][0]['id']);
			$this->conversationSelected = true;
		}
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();

		if($this->user->company?->offer()?->slug == 'page-elevage-master') {
			$this->hasAccess = true;

			$this->autoMessages = [
				"Quelles sont mes obligations légales pour déclarer mon activité d'entreprise ?",
				"Comment évaluer la vitalité des chiots nouveau-nés ?",
				"Quelle est la réglementation sur l'identification des animaux ?",
				"Quels sont les tests de dépistage génétique recommandés pour ma race et comment les interpréter ?",
				"Quel protocole de vaccination dois-je appliquer pour mes chiots/chatons et comment gérer le 'trou immunitaire' ?",
				"Comment gérer le sevrage alimentaire et prévenir les troubles digestifs chez les chiots/chatons ?",
				"Comment optimiser la gestion de la reproduction et réduire la mortalité néonatale dans mon entreprise ?"
			];

			$this->refreshConversations();
		}
	}

	public function render()
	{
		if(!$this->conversationSelected && $this->conversationId) $this->refreshConversations();

		return view('livewire.front.space.profile.breeder-gpt');
	}
}
