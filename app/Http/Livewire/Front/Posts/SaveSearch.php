<?php

namespace App\Http\Livewire\Front\Posts;

use Livewire\Component;
use Livewire\Attributes\On;

class SaveSearch extends Component
{
	public $button = true;
	public $banner = false;
	public $filters;

	#[On('send-filters-to-save-search')]
	public function receiveFilters($filters)
	{
		$this->filters['species'] = $filters['species'];
		$this->filters['breed'] = $filters['breed'];
		$this->filters['post_type'] = $filters['post_type'];
		$this->filters['country_id'] = $filters['country_id'];
		$this->filters['region_id'] = $filters['region_id'];
		$this->filters['department_id'] = $filters['department_id'];
		$this->filters['city_id'] = $filters['city_id'];
		$this->filters['cities'] = $filters['cities'];
		$this->filters['distance'] = $filters['distance'];
		$this->filters['max_price'] = $filters['max_price'];
		$this->filters['min_price'] = $filters['min_price'];
		$this->filters['pure_breed'] = $filters['pure_breed'];
		$this->filters['sex'] = $filters['sex'];

		session()->put('save-search-with-filters', $this->filters);

		return redirect()->route('space.alerts.my-alerts');
	}

	public function saveSearch()
	{
		$this->dispatch('get-posts-filters', filters: $this->filters);
	}

	public function mount()
	{
		$this->filters['species'] = null;
		$this->filters['breed'] = null;
		$this->filters['post_type'] = null;
		$this->filters['country_id'] = null;
		$this->filters['region_id'] = null;
		$this->filters['department_id'] = null;
		$this->filters['city_id'] = null;
		$this->filters['cities'] = null;
		$this->filters['distance'] = null;
		$this->filters['max_price'] = null;
		$this->filters['min_price'] = null;
		$this->filters['pure_breed'] = null;
		$this->filters['sex'] = [];
	}

	public function render()
	{
		return view('livewire.front.posts.save-search');
	}
}
