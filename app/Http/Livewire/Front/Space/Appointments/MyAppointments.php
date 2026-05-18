<?php

namespace App\Http\Livewire\Front\Space\Appointments;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Models\{Animal, Appointment, Post, Response};

class MyAppointments extends Component
{
	public $activeAppointment = 0;
	public $appointments;
	public $time = 'coming';

	public $filters;

	#[On('filters')]
	public function filters(array $filters)
	{
		$this->filters['species'] = $filters['species'];
		$this->filters['type'] = $filters['type'];
		$this->filters['response'] = $filters['response'];

		$this->refreshAppointments();
	}

	#[On('time-selected')]
	public function timeSelected($time)
	{
		$this->time = $time;

		$this->initAppointments();
		$this->sendFirstAppointment();
	}

	#[On('refresh-appointments')]
	public function refreshAppointments()
	{
		$this->activeAppointment = new Appointment;
		$this->initAppointments();
		$this->sendFirstAppointment();
	}

	#[On('appointment-show-ready')]
	public function sendFirstAppointment()
	{
		if($this->appointments->isNotEmpty()) {
			if($this->activeAppointment->id) $this->show($this->activeAppointment->id);
			else $this->show($this->appointments->first()->id);
		}
		else $this->dispatch('no-appointment-to-show');
	}

	public function show($id)
	{
		$this->activeAppointment = Appointment::find($id);
		$this->dispatch('show', $id);
	}

	public function initAppointments()
	{
		$appointments = Auth::guard('web')->user()
			->appointments()
			->where(function($where) {
				$where->whereHas('response', function($whereHas) {
					$whereHas->when($this->filters['species'], function($when) {
						$when->whereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph, $class) {
							if($class === Animal::class) {
								$whereHasMorph->whereHas('species', function($whereHas) {
									$whereHas->where('slug->en', $this->filters['species']);
								});
							}
							elseif($class === Post::class) {
								$whereHasMorph->whereHas('model', function($whereHasModel) {
									$whereHasModel->whereHas('species', function($whereHas) {
										$whereHas->where('slug->en', $this->filters['species']);
									});
								});
							}
						});
					})
					->when($this->filters['response'], function($when) {
						$when->where('id', $this->filters['response']);
					});
				})
				->orWhereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph, $class) {
					$whereHasMorph->when($this->filters['species'], function($when) use($class) {
						if($class === Animal::class) {
							$when->whereHas('species', function($whereHas) {
								$whereHas->where('slug->en', $this->filters['species']);
							});
						}
						elseif($class === Post::class) {
							$when->whereHas('model', function($whereHasModel) {
								$whereHasModel->whereHas('species', function($whereHas) {
									$whereHas->where('slug->en', $this->filters['species']);
								});
							});
						}
					});
				});
			})
			->when($this->filters['type'], function($when) {
				$when->where('type', $this->filters['type']);
			})
			->orderBy('date', 'DESC')
			->get()
			->filter(function($appointment) {
				$start = Carbon::parse($appointment->date)
					->setTimeFromTimeString($appointment->values->get('start_hour'));

				if($this->time == 'coming') return $start >= Carbon::now();
				elseif($this->time == 'passed') return $start < Carbon::now();
			});

		$appointed = Auth::guard('web')->user()
			->appointed()
			->where(function($where) {
				$where->whereHas('response', function($whereHas) {
					$whereHas->when($this->filters['species'], function($when) {
						$when->whereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph, $class) {
							if($class === Animal::class) {
								$whereHasMorph->whereHas('species', function($whereHas) {
									$whereHas->where('slug->en', $this->filters['species']);
								});
							}
							elseif($class === Post::class) {
								$whereHasMorph->whereHas('model', function($whereHasModel) {
									$whereHasModel->whereHas('species', function($whereHas) {
										$whereHas->where('slug->en', $this->filters['species']);
									});
								});
							}
						});
					})
					->when($this->filters['response'], function($when) {
						$when->where('id', $this->filters['response']);
					});
				})
				->orWhereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph, $class) {
					$whereHasMorph->when($this->filters['species'], function($when) use($class) {
						if($class === Animal::class) {
							$when->whereHas('species', function($whereHas) {
								$whereHas->where('slug->en', $this->filters['species']);
							});
						}
						elseif($class === Post::class) {
							$when->whereHas('model', function($whereHasModel) {
								$whereHasModel->whereHas('species', function($whereHas) {
									$whereHas->where('slug->en', $this->filters['species']);
								});
							});
						}
					});
				});
			})
			->when($this->filters['type'], function($when) {
				$when->where('type', $this->filters['type']);
			})
			->orderBy('date', 'DESC')
			->get()
			->filter(function($appointment) {
				$start = Carbon::parse($appointment->date)
					->setTimeFromTimeString($appointment->values->get('start_hour'));

				if($this->time == 'coming') return $start >= Carbon::now();
				elseif($this->time == 'passed') return $start < Carbon::now();
			});

		$this->appointments = $appointments->merge($appointed);
	}

	public function mount()
	{
		$this->filters['species'] = null;
		$this->filters['type'] = null;
		$this->filters['response'] = null;

		$this->initAppointments();
	}

	public function render()
	{
		return view('livewire.front.space.appointments.my-appointments');
	}
}
