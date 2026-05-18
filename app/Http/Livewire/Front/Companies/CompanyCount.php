<?php

namespace App\Http\Livewire\Front\Companies;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\{Breed, Species};

class CompanyCount extends Component
{
	public $companyCount;
	public Breed $breed;
	public Species $species;

	#[On('set-company-count')]
	public function setCompanyCount($companyCount)
	{
		$this->companyCount = $companyCount;
	}

	public function mount()
	{
		if($this->breed->exists && $this->breed->species->getTranslation('slug', 'en') != $this->species->getTranslation('slug', 'en')) {
			$this->breed = new Breed;
		}
	}

	public function render()
	{
		return view('livewire.front.companies.company-count');
	}
}
