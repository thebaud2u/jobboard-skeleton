<?php

namespace App\Http\Livewire\Front\Space\Animals;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Species;

class Filters extends Component
{
	public $species;
	public $filters;

	public function search()
	{
		$this->dispatch('animals-filters', $this->filters);
	}

	public function mount()
	{
		$this->filters['species'] = null;
		$this->filters['type'] = 'company';
		$this->filters['orderBy'] = 'alphabetical';

		$this->species = Species::all();
	}

	public function render()
	{
		return view('livewire.front.space.animals.filters');
	}
}
