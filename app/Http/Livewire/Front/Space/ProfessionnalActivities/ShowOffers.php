<?php

namespace App\Http\Livewire\Front\Space\ProfessionnalActivities;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\{Offer, ProfessionnalActivity, User};

class ShowOffers extends Component
{
	// Entities
	public Offer $offer;
	public ProfessionnalActivity $professionnalActivity;
	public User $user;

	// Properties
	public $offers;
	public $professionnalActivityState = 'create';

	public function submitForm($id)
	{
		$offer = Offer::find($id);

		if($offer) return redirect()->route('space.professionnal-activities.create', ['offer' => $offer->slug]);
		else session()->flash('error', __('The given offer doesn\'t exist'));
	}

	public function mount()
	{
		if($this->professionnalActivity->exists) {
			if($this->professionnalActivityState == 'create') $this->professionnalActivityState = 'extend';

			$this->currentOffer = $this->professionnalActivity->offer();

			$this->offers = Offer::where('type', 'post')
				->where('slug', $this->currentOffer->slug)
				->get();
		}
		else {
			$this->professionnalActivity = new ProfessionnalActivity;
			$this->professionnalActivityState = 'create';
			$this->currentOffer = null;

			if(Auth::guard('web')->user()->hasRole('professionnal')) $this->offers = Offer::findBySlug('annuaire-produits-et-services');
			elseif(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) $this->offers = Offer::findBySlug('activite-secondaire');
		}
	}

	public function render()
	{
		return view('livewire.front.space.professionnal-activities.show-offers');
	}
}
