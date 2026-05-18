<?php

namespace App\Http\Livewire\Front\Space\Profile;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

use App\Services\BrevoService;
use App\Services\FigoService;

class PendingUser extends Component
{
	public User $user;

	public $pending = false;
	public $optinNewsletter = 1;
	public $optinReceiveInfo = 1;
	public $optinReceiveDeals = 1;
	public $optinFigo = 1;

	protected $brevoService;

	protected function rules()
	{
		return [
			'pending' => [],
			'optinNewsletter' => [],
			'optinReceiveInfo' => [],
			'optinReceiveDeals' => [],
			'optinFigo' => [],
		];
	}

	public function pendingDone()
	{
		$rules = [
			'pending' => ['accepted']
		];

		$messages = [
			'pending.accepted' => __('You must accept the general terms of use of Eleveurs-Online')
		];

		$this->validate($rules, $messages);

		$suffix = 'ADOPTANT';
		$attributes = [];

		$this->brevoService = new BrevoService;

		if($this->optinNewsletter == 'yes') $attributes['OPTIN_NL_'.$suffix] = 1;
		else $attributes['OPTIN_NL_'.$suffix] = 0;

		if($this->optinReceiveInfo == 'yes') $attributes['OPTIN_MARKETING_'.$suffix] = 1;
		else $attributes['OPTIN_MARKETING_'.$suffix] = 0;

		if($this->optinReceiveDeals == 'yes') $attributes['OPTIN_PARTENAIRE_'.$suffix] = 1;
		else $attributes['OPTIN_PARTENAIRE_'.$suffix] = 0;

		$result = $this->brevoService->addContactToList(
			$this->user->email,
			[9],
			$attributes
		);

		if($this->optinFigo) {
			$figoService = app(FigoService::class);
			$figoService->createFunnelSession($this->user, 'eol-pending-modal');
		}

		$this->user->updateValue('optins', [
			'optin_newsletter' => $this->optinNewsletter,
			'optin_receive_info' => $this->optinReceiveInfo,
			'optin_receive_deals' => $this->optinReceiveDeals,
			'optin_figo' => $this->optinFigo,
		]);

		$this->user->pending = false;
		$this->user->save();

		$this->dispatch('pending-done');
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();
		$this->optinNewsletter = data_get($this->user->values, 'optins.optin_newsletter');
		$this->optinReceiveInfo = data_get($this->user->values, 'optins.optin_receive_info');
		$this->optinReceiveDeals = data_get($this->user->values, 'optins.optin_receive_deals');
		$this->optinFigo = data_get($this->user->values, 'optins.optin_figo');
	}

	public function render()
	{
		return view('livewire.front.space.profile.pending-user');
	}
}
