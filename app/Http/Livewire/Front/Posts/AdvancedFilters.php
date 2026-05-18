<?php

namespace App\Http\Livewire\Front\Posts;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Enums\AnimalSexes;
use App\Enums\ProtrusionTypes;

use App\Models\{PostType, Species};

class AdvancedFilters extends Component
{
	public PostType $postType;
	public Species $species;

	public $filters;
	public $responsive = false;

	// Filters fields
	public $animalSexes;
	public $litterTypes;
	public $protrusionTypes;

	#[On('post-type-selected-in-filters')]
	public function setPostType($postType)
	{
		if($postType) {
			$this->postType = PostType::findBySlug($postType, 'en');

			if($this->postType) {
				$this->filters['post_type'] = $postType;

				if($this->postType->getTranslation('slug', 'en') != 'stud') {
					$this->animalSexes = AnimalSexes::asHumanArray();
					$this->litterTypes = PostType::where('slug->en', 'litter')
						->orWhere('slug->en', 'litter-yet-to-come')
						->get();
				}
				elseif($this->postType->getTranslation('slug', 'en') == 'stud') $this->protrusionTypes = ProtrusionTypes::asHumanArray();
			}
		}

		$this->search();
	}

	public function search()
	{
		switch ($this->filters['pure_breed']) {
			case 'true':
				$this->filters['pure_breed'] = true;
				break;
			case 'false':
				$this->filters['pure_breed'] = false;
				break;
			case 'indif':
				$this->filters['pure_breed'] = null;
				break;
			
			default:
				$this->filters['pure_breed'] = null;
				break;
		}

		$this->dispatch('posts-advanced-filters', filters: $this->filters);
	}

	public function resetForm()
	{
		$this->filters['litter_type'] = [];
		$this->filters['max_price'] = null;
		$this->filters['min_price'] = null;
		$this->filters['pure_breed'] = null;
		$this->filters['quotation'] = null;
		$this->filters['sex'] = [];
		$this->filters['protrusion_type'] = [];
		$this->filters['order_by'] = 'revelancy';

		$this->dispatch('form-reset');
		$this->search();
	}

	public function mount()
	{
		$this->filters['litter_type'] = [];
		$this->filters['max_price'] = null;
		$this->filters['min_price'] = null;
		$this->filters['post_type'] = $this->postType->getTranslation('slug', 'en');
		$this->filters['pure_breed'] = null;
		$this->filters['quotation'] = null;
		$this->filters['sex'] = [];
		$this->filters['protrusion_type'] = [];
		$this->filters['order_by'] = 'revelancy';

		if($this->postType->getTranslation('slug', 'en') != 'stud') {
			$this->animalSexes = AnimalSexes::asHumanArray();
			$this->litterTypes = PostType::where('slug->en', 'litter')
				->orWhere('slug->en', 'litter-yet-to-come')
				->get();
		}
		elseif($this->postType->getTranslation('slug', 'en') == 'stud') $this->protrusionTypes = ProtrusionTypes::asHumanArray();

		if(session()->has('filters')) {
			$filters = session()->get('filters');

			if(!empty($filters['max_price'])) $this->filters['max_price'] = $filters['max_price'];
			if(!empty($filters['min_price'])) $this->filters['min_price'] = $filters['min_price'];
			if(!empty($filters['litter_type'])) $this->filters['litter_type'] = $filters['litter_type'];
			if(!empty($filters['pure_breed'])) $this->filters['pure_breed'] = $filters['pure_breed'];
			if(!empty($filters['quotation'])) $this->filters['quotation'] = $filters['quotation'];
			if(!empty($filters['sex'])) $this->filters['sex'] = $filters['sex'];
			if(!empty($filters['protrusion_type'])) $this->filters['protrusion_type'] = $filters['protrusion_type'];
		}
	}

	public function render()
	{
		return view('livewire.front.posts.advanced-filters');
	}
}
