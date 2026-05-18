<?php

namespace App\Http\Livewire\Front\Space\ProfessionnalActivities;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Enums\PublicationStates;

use App\Models\Offer;
use App\Models\ProfessionnalActivity;

class MyProfessionnalActivities extends Component
{
	use WithPagination;

	// Search filters
	public $state = [];

	#[On('professionnal-activities-search-slot')]
	public function search(array $filters)
	{
		$this->state = $filters['state'];
	}

	public function mount()
	{

	}

	public function render()
	{
		$professionnalActivities = ProfessionnalActivity::when($this->state, function($when) {
				$when->whereHas('lastPublication', function($whereHas) {
					$whereHas->where('state', $this->state);
				});
			})
			->whereHas('user', function($whereHas) {
				$whereHas->where('id', Auth::guard('web')->user()->id);
			})
			->distinct()
			->latest('created_at')
			->paginate(30);

		return view('livewire.front.space.professionnal-activities.my-professionnal-activities', compact('professionnalActivities'));
	}
}
