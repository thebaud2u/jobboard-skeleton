<?php

namespace App\Http\Livewire\Front\Space\Animals;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Enums\{AnimalStates, ResponseStates, ResponseTypes};
use App\Models\{Animal, Company, Litter, User};

class Animals extends Component
{
	public Animal $animal;
	public Company $company;
	public Litter $litter;
	public User $user;

	public $source;
	public $animals;
	public $type;
	public $hasDisplayBreedersOption;
	public $subComponentKey = 0;
	public $filters;

	#[On('animals-filters')]
	public function search(array $filters)
	{
		$this->filters['species'] = $filters['species'];
		$this->filters['type'] = $filters['type'];
		$this->filters['orderBy'] = $filters['orderBy'];

		$this->initAnimals();
	}

	#[On('templates-set')]
	public function templatesSet()
	{
		$this->subComponentKey++;
	}

	#[On('animal-deleted')]
	public function refresh()
	{
		if($this->source == 'company') $this->animals = $this->company->animals;
		elseif($this->source == 'user') $this->animals = $this->user->animals;

		$this->fresh();
	}

	public function getAnimal($id)
	{
		if($id) {
			$animal = Animal::find($id);

			if($animal) {
				$this->animal = $animal;

				if($this->animal->values->has('breeder_status')) {
					$this->type = 'breeder';
				}
				else {
					$this->type = 'litter-animal';
					$this->litter = $this->animal->litters->first();
				}
			}
		}
	}

	public function fresh()
	{
		$this->animal = new Animal;
		$this->type = null;
	}

	public function initAnimals()
	{
		if($this->source == 'company') {
			$this->animals = $this->company->animals()->when($this->filters['species'], function($when) {
					$when->whereHas('species', function($whereHas) {
						$whereHas->where('slug->en', $this->filters['species']);
					});
				})
				->when($this->filters['type'], function($when) {
					if($this->filters['type'] == 'company') {
						$when->where(function($where) {
							$where->whereHas('lastLife', function($whereHas) {
								$whereHas->whereHasMorph('model', Company::class)
									->whereNotIn('state', [AnimalStates::Adopted, AnimalStates::Reserved]);
							})
							->orWhere(function($where) {
								$where->doesntHave('lastLife')
									->whereHas('company', function($whereHas) {
										$whereHas->where('slug', $this->company->slug);
									});
							});
						});
					}
					else {
						$when->whereHas('lastLife', function($whereHas) {
							if($this->filters['type'] == 'adopted') $whereHas->where('state', AnimalStates::Adopted);
							elseif($this->filters['type'] == 'reserved') $whereHas->where('state', AnimalStates::Reserved);
						});
					}
				})
				->when($this->filters['orderBy'], function($when) {
					if($this->filters['orderBy'] == 'alphabetical') $when->orderBy('name', 'ASC');
					else $when->orderBy('created_at', 'DESC');
				})
				->get();
		}
		elseif($this->source == 'user') $this->animals = $this->user->animals;
	}

	public function mount()
	{
		$this->filters['species'] = null;
		$this->filters['type'] = 'company';
		$this->filters['orderBy'] = 'alphabetical';
		
		$this->fresh();
		$this->initAnimals();
	}

	public function render()
	{
		return view('livewire.front.space.animals.my-animals');
	}
}
