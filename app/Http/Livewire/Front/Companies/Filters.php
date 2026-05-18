<?php

namespace App\Http\Livewire\Front\Companies;

use Livewire\Component;
use Livewire\Attributes\On;

use App\Models\Breed;
use App\Models\Species;

class Filters extends Component
{
	public Breed $breed;
	public Species $species;

	public $withRedirect = false;
	public $responsive = false;
	public $savedSearch = null;
	public $filters;
	public $cities;
	public $displayCompany = 'w-full lg:mx-auto';

	public $autocomplete = false;

	// Lists
	public $breedsList;
	public $mhList;

	#[On('location-selected')]
	public function locationSelected($filters)
	{
		$this->filters['company_country_id'] = $filters['country_id'];
		$this->filters['company_region_id'] = $filters['region_id'];
		$this->filters['company_department_id'] = $filters['department_id'];
		$this->filters['company_city_id'] = $filters['city_id'];
		$this->filters['company_cities'] = $filters['cities'];
		$this->filters['company_distance'] = $filters['distance'];

		session()->put('filters', $this->filters);
		//if(!$this->withRedirect) $this->search();
	}

	#[On('autocompleted')]
	public function breedSelected($slug)
	{
		if($slug) {
			$breed = Breed::findBySlug($slug);

			if($breed) {
				$this->filters['company_breed'] = $breed->slug;
				session()->put('filters', $this->filters);
				$this->breed = $breed;

				$this->autocomplete = false;

				/*$this->dispatch('breed-selected-in-filters', breed: $this->filters['breed']);

				if(!$this->withRedirect) $this->search();
				else {
					session()->put('filters', $this->filters);
					$this->dispatch('posts-filters', $this->filters);
				}*/
			}
		}
	}

	#[On('autocomplete-reset')]
	public function breedEmptied()
	{
		$this->filters['company_breed'] = null;
		session()->put('filters', $this->filters);
		$this->breed = new Breed;

		/*$this->dispatch('breed-selected-in-filters', breed: $this->filters['breed']);

		if(!$this->withRedirect) $this->search();*/
	}

	public function removeLocalisation()
	{
		$this->filters['company_country_id'] = null;
		$this->filters['company_region_id'] = null;
		$this->filters['company_department_id'] = null;
		$this->filters['company_city_id'] = null;
		$this->filters['company_cities'] = null;
		$this->filters['company_distance'] = 0;

		$this->dispatch('location-reset');
	}

	public function search()
	{
		if($this->withRedirect) {
			session()->put('filters', $this->filters);

			if($this->filters['company_breed']) {
				$breed = Breed::findBySlug($this->filters['company_breed']);

				if($breed) return redirect()->route('company-search.'.$this->species->getTranslation('slug', 'en').'-companies-with-breed', ['breed' => $breed->slug]);
			}

			return redirect()->route('company-search.'.$this->species->getTranslation('slug', 'en').'-companies');
		}
		else $this->dispatch('filters', $this->filters);
	}

	public function mount()
	{
		$this->filters['company_keyword'] = null;
		$this->filters['company_breed'] = null;

		$this->filters['company_country_id'] = null;
		$this->filters['company_region_id'] = null;
		$this->filters['company_department_id'] = null;
		$this->filters['company_city_id'] = null;
		$this->filters['company_cities'] = null;
		$this->filters['company_distance'] = 0;

		if(session()->has('filters')) {
			$filters = session()->get('filters');

			if(!empty($filters['company_keyword'])) $this->filters['company_keyword'] = $filters['company_keyword'];
			if(!empty($filters['company_breed'])) $this->filters['company_breed'] = $filters['company_breed'];
			if(!empty($filters['company_post_type_available'])) $this->filters['company_post_type_available'] = $filters['company_post_type_available'];
			if(!empty($filters['company_country_id'])) $this->filters['company_country_id'] = $filters['company_country_id'];
			if(!empty($filters['company_region_id'])) $this->filters['company_region_id'] = $filters['company_region_id'];
			if(!empty($filters['company_department_id'])) $this->filters['company_department_id'] = $filters['company_department_id'];
			if(!empty($filters['company_city_id'])) $this->filters['company_city_id'] = $filters['company_city_id'];
			if(!empty($filters['company_cities'])) $this->filters['company_cities'] = $filters['company_cities'];
			if(!empty($filters['company_distance'])) $this->filters['company_distance'] = $filters['company_distance'];
		}

		$this->breedsList = $this->species->breeds;

		if($this->breed->exists && $this->breed->species->getTranslation('slug', 'en') == $this->species->getTranslation('slug', 'en')) {
			$this->filters['company_breed'] = $this->breed->slug;
		}
		else {
			$this->filters['company_breed'] = null;
			$this->breed = new Breed;
		}
	}

	public function render()
	{
		return view('livewire.front.companies.filters');
	}
}
