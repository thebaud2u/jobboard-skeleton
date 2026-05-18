<?php

namespace App\Http\Livewire\Front\Space\Profile;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\User;

class InterestedIn extends Component
{
	public User $user;

	public $interestedIn = null;

	protected function rules()
	{
		return [
			'interestedIn' => []
		];
	}

	public function saveInterest()
	{
		$rules = [
			'interestedIn' => 'required'
		];

		$messages = [
			'interestedIn.required' => __('You must select your interest')
		];

		$this->validate($rules, $messages);

		$this->user->updateValue('interested_in', $this->interestedIn);
		$this->user->save();
	}

	public function later()
	{
		if(!is_null($this->interestedIn)) $this->saveInterest();
		
		$this->dispatch('interest-saved');
	}

	public function completeProfile()
	{
		if($this->user->hasRole(['adopter', 'breeder', 'professionnal_breeder', 'individual_breeder'])) {
			$this->saveInterest();

			return redirect()->route('space.profile.complete-my-profile');
		}
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();
	}

	public function render()
	{
		return view('livewire.front.space.profile.interested-in');
	}
}
