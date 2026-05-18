<?php

namespace App\Http\Livewire\Front\Companies;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Enums\PostTypesAvailable;

use App\Models\{Breed, PostType};

class AdvancedFilters extends Component
{
	public Breed $breed;

	public $filters;
	public $responsive = false;

	// Filters fields
	public $postsTypesAvailable;

	#[On('breed-selected-in-filters')]
	public function setBreed($breed)
	{
		if($breed) {
			$this->breed = Breed::findBySlug($breed);
			$this->filters['company_breed'] = $breed;
			$this->search();
		}
	}

	public function search()
	{
		$this->dispatch('companies-advanced-filters', filters: $this->filters);
	}

	public function resetForm()
	{
		$this->filters['company_post_type_available'] = [];
		$this->filters['company_order_by'] = 'revelancy';

		$this->dispatch('form-reset');
		$this->search();
	}

	public function mount()
	{
		$this->filters['company_post_type_available'] = [];
		$this->filters['company_breed'] = $this->breed->slug;
		$this->filters['company_order_by'] = 'revelancy';

		$this->postsTypesAvailable = PostTypesAvailable::asHumanArray();
	}

	public function render()
	{
		return view('livewire.front.companies.advanced-filters');
	}
}
