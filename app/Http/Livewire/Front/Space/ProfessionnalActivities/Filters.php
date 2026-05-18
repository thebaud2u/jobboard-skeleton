<?php

namespace App\Http\Livewire\Front\Space\ProfessionnalActivities;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Models\ProfessionnalActivity;

class Filters extends Component
{
	// Search filters
	public $state = [];

	public function search()
	{
		$this->dispatch('professionnal-activities-search-slot', [
			'state' => $this->state
		]);
	}

	public function resetForm()
	{
		$this->state = array();

		$this->search();
	}

	public function render()
	{
		$professionnalActivitiesArray = array();

		$professionnalActivities = ProfessionnalActivity::whereHas('user', function($whereHas) {
				$whereHas->where('id', Auth::guard('web')->user()->id);
			})
			->get();

		if($professionnalActivities->isNotEmpty()) {
			foreach($professionnalActivities as $professionnalActivity) {
				$professionnalActivitiesArray[] = $professionnalActivity->id;
			}
		}

		$filterStates = ProfessionnalActivity::whereIn('id', $professionnalActivitiesArray)
			->whereHas('lastPublication')
			->with('lastPublication') // Charge la relation
			->get()
			->pluck('lastPublication.state') // Récupère la propriété 'state'
			->unique()
			->values();

		return view('livewire.front.space.professionnal-activities.filters', [
			'filterStates' => $filterStates
		]);
	}
}
