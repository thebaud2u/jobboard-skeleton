<?php

namespace App\Http\Livewire\Front\Space\Responses;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Enums\{ResponseStates, ResponseTypes};

use App\Models\{Company, ProfessionnalActivity, Response, Post};

class Filters extends Component
{
	public $type;
	public $filters;

	public $types = [];

	public function search()
	{
		$this->dispatch('filters', $this->filters);
	}

	public function mount()
	{
		$this->filters['type'] = null;
		$this->filters['not-read-only'] = false;

		$postResponsesApplicant = Auth::guard('web')->user()->applicants()
			->where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('values->archive->answerer', false)
						->where('type', ResponseTypes::Application);
				})
				->orWhere('type', '<>', ResponseTypes::Application);
			})
			->get();

		$postResponsesApplications = Auth::guard('web')->user()->applications()
			->where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('values->archive->asking', false)
						->where('type', ResponseTypes::Application);
				})
				->orWhere('type', '<>', ResponseTypes::Application);
			})
			->get();

		$hasPostResponses = $postResponsesApplicant->merge($postResponsesApplications);

		if($hasPostResponses->isNotEmpty()) $this->types[] = ['value' => 'posts', 'label' => __('Posts messages')];

		$companyResponsesApplicant = Auth::guard('web')->user()->applicants()
			->whereHasMorph('model', [Company::class])
			->where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('values->archive->answerer', false)
						->where('type', ResponseTypes::Application);
				})
				->orWhere('type', '<>', ResponseTypes::Application);
			})
			->get();

		$companyResponsesApplications = Auth::guard('web')->user()->applications()
			->whereHasMorph('model', [Company::class])
			->where(function($where) {
				$where->where(function($subWhere) {
					$subWhere->where('values->archive->asking', false)
						->where('type', ResponseTypes::Application);
				})
				->orWhere('type', '<>', ResponseTypes::Application);
			})
			->get();

		$hasCompanyResponses = $companyResponsesApplicant->merge($companyResponsesApplications);

		if($hasCompanyResponses->isNotEmpty()) $this->types[] = ['value' => 'company', 'label' => __('Company messages')];

		$applicantsArchived = Auth::guard('web')->user()
			->applicants()
			->where('values->archive->answerer', true)
			->get();

		$applicationsArchived = Auth::guard('web')->user()
			->applications()
			->where('values->archive->asking', true)
			->get();

		$hasArchivedResponses = $applicantsArchived->merge($applicationsArchived);

		if($hasArchivedResponses->isNotEmpty()) $this->types[] = ['value' => 'archived', 'label' => __('Archived messages')];

		$this->dispatch('reponses-show-ready');
	}

	public function render()
	{
		return view('livewire.front.space.responses.filters');
	}
}
