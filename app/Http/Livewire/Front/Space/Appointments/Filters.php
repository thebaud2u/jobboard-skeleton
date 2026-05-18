<?php

namespace App\Http\Livewire\Front\Space\Appointments;

use Livewire\Component;

use Illuminate\Support\Facades\Auth;

use App\Enums\{AppointmentTypes, ResponseTypes};
use App\Models\{Animal, Response, Species};

class Filters extends Component
{
	public $time = 'coming';
	public $species;
	public $types;
	public $responses;
	public $filters;

	public function timeSelected($time)
	{
		$this->dispatch('time-selected', time: $time);
	}

	public function search()
	{
		$this->dispatch('filters', $this->filters);
	}

	public function mount()
	{
		$this->filters['species'] = null;
		$this->filters['type'] = null;
		$this->filters['response'] = null;

		$this->species = Species::all();
		$this->types = AppointmentTypes::asHumanArray();

		$applications = Auth::guard('web')->user()
			->applications()
			->where('type', '=', ResponseTypes::Application)
			->orderByDesc('updated_at')
			->get();

		$applicants = Auth::guard('web')->user()
			->applicants()
			->where('type', '=', ResponseTypes::Application)
			->orderByDesc('updated_at')
			->get();

		$this->responses = $applications->merge($applicants);
	}

	public function render()
	{
		return view('livewire.front.space.appointments.filters');
	}
}
