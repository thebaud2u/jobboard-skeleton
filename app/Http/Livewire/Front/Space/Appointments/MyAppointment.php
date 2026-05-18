<?php

namespace App\Http\Livewire\Front\Space\Appointments;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Enums\{AnimalStates, AppointmentTypes, PublicationStates, ResponseStates, ResponseTypes};
use App\Models\{Animal, Appointment, Company, Litter, Message, Post, Response, User};

class MyAppointment extends Component
{
	public Company $company;
	public Response $response;
	
	public $animal;
	public $appointment;
	public $fromUser;
	public $toUser;
	public $situation;
	public $time = 'coming';
	public $openModal = false;

	// Properties
	public $id;
	public $selectedSpecies;
	public $selectedElement;
	public $selectedApplicant;
	public $gender;
	public $firstname;
	public $lastname;
	public $email;
	public $date;
	public $startHour;
	public $appointmentType;
	public $message;
	public $animalAlreadyReserved = false;
	public $conflictAppointment = null;

	// Lists
	public $speciesList;
	public $animalsList;
	public $postsList;
	public $applicants;
	public $appointmentTypes;

	protected function rules() {
		return [
			'selectedSpecies' => [],
			'selectedElement' => [],
			'selectedApplicant' => [],
			'gender' => [],
			'firstname' => [],
			'lastname' => [],
			'email' => [],
			'date' => [],
			'startHour' => [],
			'appointmentType' => [],
			'message' => [],
		];
	}

	#[On('time-selected')]
	public function timeSelected($time)
	{
		$this->time = $time;
	}

	#[On('show')]
	public function show($id)
	{
		if($id) {
			$appointmentExists = Appointment::where('id', $id)
				->where(function($where) {
					$where->whereHas('from', function($whereHas) {
						$whereHas->where('id', Auth::guard('web')->user()->id);
					})
					->orWhereHas('to', function($whereHas) {
						$whereHas->where('id', Auth::guard('web')->user()->id);
					});
				})
				->first();

			if($appointmentExists) {
				$this->appointment = $appointmentExists;
				$this->initProperties();
			}
		}
	}

	#[On('no-appointment-to-show')]
	public function noAppointmentToShow()
	{
		$this->appointment = new Appointment;
	}

	public function speciesSelected()
	{
		if($this->selectedSpecies) {
			$this->animalsList = Animal::whereHas('species', function($whereHas) {
					$whereHas->where('slug->en', $this->selectedSpecies);
				})
				->where(function($where) {
					$where->whereHas('lastLife', function($whereHas) {
						$whereHas->whereIn('state', [AnimalStates::Available, AnimalStates::Reserved]);
					});
				})
				->where(function($where) {
					$where->whereHas('litters', function($whereHas) {
						$whereHas->whereHas('post', function($whereHasPosts) {
							$whereHasPosts->whereHas('lastPublication', function($whereHas) {
								$whereHas->whereIn('state', [
									PublicationStates::Published,
									PublicationStates::PublishedUpdatedWaitingModeration,
									PublicationStates::PublishedUpgradedWaitingModeration
								]);
							})
							->whereHas('user', function($whereHasUser) {
								$whereHasUser->where('id', Auth::guard('web')->user()->id);
							});
						});
					});
				})
				->get();

			$this->postsList = Post::whereHas('type', function($whereHas) {
					$whereHas->whereNotIn('slug->en', ['stud']);
				})
				->whereHas('lastPublication', function($whereHas) {
					$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHasMorph('model', [Litter::class, Animal::class], function($whereHasMorph) {
					$whereHasMorph->whereHas('species', function($whereHas) {
						$whereHas->where('slug->en', $this->selectedSpecies);
					});
				})
				->whereHas('user', function($whereHasUser) {
					$whereHasUser->where('id', Auth::guard('web')->user()->id);
				})
				->get();
		}
	}

	public function elementSelected()
	{
		if($this->selectedElement) {
			$this->selectedApplicant = null;

			$this->animal = Animal::findBySlug($this->selectedElement);
			$post = Post::findBySlug($this->selectedElement);

			if($this->animal) $key = $this->animal->id;
			elseif($post) {
				$key = $post->id;
				
				if($post->model instanceof Animal) $this->animal = $post->model;
			}

			if($key) {
				$this->applicants = Auth::guard('web')->user()
					->applicants()
					->where('state', ResponseStates::Received)
					->whereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph) use($key) {
						$whereHasMorph->where('id', $key);
					})
					->get();

				if($this->applicants->isNotEmpty()) {
					if($this->animal) {
						if($this->animal->lastLife->state == AnimalStates::Reserved) $this->selectedApplicant = $this->animal->lastLife->model->slug;
						else $this->selectedApplicant = $this->applicants->first()->from->slug;
					}
					else $this->selectedApplicant = $this->applicants->first()->from->slug;

					$this->checkApplicant();
				}
			}
		}
	}

	public function checkApplicant()
	{
		$this->animalAlreadyReserved = false;

		if($this->selectedElement && $this->selectedApplicant && $this->appointmentType == AppointmentTypes::Pickup->value) {
			$this->conflictAppointment = null;

			$this->animal = Animal::findBySlug($this->selectedElement);
			$post = Post::findBySlug($this->selectedElement);

			if($this->animal) $key = $this->animal->id;
			elseif($post) $key = $post->id;

			if($this->animal) {
				if($this->animal->lastLife->state == AnimalStates::Reserved && $this->animal->lastLife->model->slug != $this->selectedApplicant) {
					$this->animalAlreadyReserved = true;
					$this->conflictAppointment = Appointment::whereHas('to', function($whereHas) {
							$whereHas->where('slug', $this->animal->lastLife->model->slug);
						})
						->whereHas('from', function($whereHas) {
							$whereHas->where('slug', Auth::guard('web')->user()->slug);
						})
						->where(function($where) use($key, $post) {
							$where->when($this->animal, function($when) use($key) {
								$when->whereHasMorph('model', [Animal::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							})
							->when($post, function($when) use($key) {
								$when->whereHasMorph('model', [Post::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							})
							->orWhereHas('response', function($orWhereHas) use($key) {
								$orWhereHas->whereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							});
						})
						->first();
				}
				else {
					$this->animalAlreadyReserved = false;
					$this->conflictAppointment = null;
				}
			}
		}
	}

	public function cancelAppointment()
	{
		$this->appointment->delete();
		$this->appointment = new Appointment;

		$this->dispatch('refresh-appointments');
	}

	public function fresh()
	{
		$this->id = null;
		$this->selectedSpecies = null;
		$this->selectedElement = null;
		$this->selectedApplicant = null;
		$this->gender = null;
		$this->firstname = null;
		$this->lastname = null;
		$this->email = null;
		$this->date = null;
		$this->startHour = null;
		$this->appointmentType = null;
		$this->message = null;
		$this->animal = null;
		$this->animalAlreadyReserved = false;
		$this->conflictAppointment = null;

		$this->dispatch('appointment-reset');
	}

	public function getAppointment($id, $modal)
	{
		$this->fresh();
		$this->id = $id;

		$appointment = Appointment::find($this->id);

		if($appointment) {
			$this->date = $appointment->date->format('Y-m-d');
			$this->startHour = $appointment->values->get('start_hour');
			$this->appointmentType = $appointment->type;
			$this->message = $appointment->values->get('message');

			$this->dispatch('appointment-loaded');
			$this->dispatch('open-modal', $modal);
		}
	}

	public function setAppointement()
	{
		if($this->id) {
			$rules = [
				'date' => ['required'],
				'startHour' => ['required', 'date_format:H:i'],
				'appointmentType' => ['required'],
				'message' => ['nullable']
			];

			$messages = [
				'date.required' => __(':element is mandatory', ['element' => __('The date')]),
				'startHour.required' => __(':element is mandatory', ['element' => __('The starting hour')]),
				'startHour.date_format' => __('hh:mm format is required'),
				'appointmentType.required' => __(':element is mandatory', ['element' => __('The type of appointment')])
			];
		}
		else {
			$rules = [
				'selectedSpecies' => ['required'],
				'selectedElement' => ['required'],
				'date' => ['required'],
				'startHour' => ['required', 'date_format:H:i'],
				'appointmentType' => ['required'],
				'message' => ['nullable'],
				'selectedApplicant' => ['required_without:gender,firstname,lastname,email'],
				'gender' => ['required_without:selectedApplicant'],
				'firstname' => ['required_without:selectedApplicant'],
				'lastname' => ['required_without:selectedApplicant'],
				'email' => ['required_without:selectedApplicant', 'nullable', 'email'],
			];

			$messages = [
				'selectedSpecies.required' => __('In order to create an appointment, you must choose an animal. Select a species in order to select an animal.'),
				'selectedElement.required' => __('You must select an animal'),
				'date.required' => __(':element is mandatory', ['element' => __('The date')]),
				'startHour.required' => __(':element is mandatory', ['element' => __('The starting hour')]),
				'startHour.date_format' => __('hh:mm format is required'),
				'appointmentType.required' => __(':element is mandatory', ['element' => __('The type of appointment')]),
				'selectedApplicant.required_without' => __(':element is mandatory if no new user is entered', ['element' => __('The applicant')]),
				'gender.required_without' => __(':element is mandatory', ['element' => __('The gender')]),
				'firstname.required_without' => __(':element is mandatory if no applicant is selected', ['element' => __('The firstname')]),
				'lastname.required_without' => __(':element is mandatory if no applicant is selected', ['element' => __('The lastname')]),
				'email.required_without' => __(':element is mandatory if no applicant is selected', ['element' => __('The email')]),
			];
		}

		$this->validate($rules, $messages);

		if($this->id) {
			$appointment = Appointment::find($this->id);
			$appointment->updateValue('start_hour', $this->startHour);
			$appointment->updateValue('message', $this->message);
			$appointment->save();
		}
		else {
			if(!$this->selectedApplicant) {
				$userExist = User::where('email', $this->email)
					->first();

				if(!$userExist) {
					$newUser = new User;
					$newUser->gender = $this->gender;
					$newUser->firstname = $this->firstname;
					$newUser->lastname = $this->lastname;
					$newUser->name = $this->firstname.' '.$this->lastname;
					$newUser->password = bcrypt(Str::random(12));
					$newUser->email = $this->email;
					$newUser->pending = true;
					$newUser->save();

					$newUser->assignRole('adopter');

					$newUser->initValues();

					$adopter = $newUser->slug;
				}
				else $adopter = $userExist->slug;
			}
			else $adopter = $this->selectedApplicant;

			$user = User::findBySlug($adopter);

			if(!$this->selectedApplicant) {
				if($this->appointmentType == AppointmentTypes::Visit->value) $user->sendAutomaticEmail('visit-appointment-created-for-unknown-user');
				elseif($this->appointmentType == AppointmentTypes::Pickup->value) $user->sendAutomaticEmail('pickup-appointment-created-for-unknown-user');
			}

			$this->animal = Animal::findBySlug($this->selectedElement);
			$post = Post::findBySlug($this->selectedElement);

			if($this->animal) $key = $this->animal->id;
			elseif($post) $key = $post->id;

			if($key) {
				$response = Response::whereHas('from', function($whereHas) use($user) {
						$whereHas->where('id', $user->id);
					})
					->whereHas('to', function($whereHas) {
						$whereHas->where('id', Auth::guard('web')->user()->id);
					})
					->when($this->animal, function($when) use($key) {
						$when->whereHasMorph('model', [Animal::class], function($whereHasMorph) use($key) {
							$whereHasMorph->where('id', $key);
						});
					})
					->when($post, function($when) use($key) {
						$when->whereHasMorph('model', [Post::class], function($whereHasMorph) use($key) {
							$whereHasMorph->where('id', $key);
						});
					})
					->first();

				$values = new Collection();
				$values->put('start_hour', $this->startHour)
					->put('message', $this->message);

				$appointment = new Appointment;

				if($response) $appointment->response_id = $response->id;
				else {
					if($this->animal) $appointment->model()->associate($this->animal);
					elseif($post) $appointment->model()->associate($post);
				}

				$appointment->from_user_id = Auth::guard('web')->user()->id;
				$appointment->to_user_id = $user->id;
				$appointment->values = $values;
			}
		}

		$appointment->type = $this->appointmentType;
		$appointment->date = $this->date;
		$appointment->save();

		if($appointment->type == AppointmentTypes::Pickup) {
			if($appointment->response) {
				$response = $appointment->response;
				$values = $response->values;
				$values->put('part_confirmation', collect(['asking' => false, 'answerer' => false]));
				$response->values = $values;
				$response->saveQuietly();

				if($response->model instanceof Animal) $this->animal = $response->model;
				elseif($response->model instanceof Post && $response->model->type->getTranslation('slug', 'en') == 'retired-breeder') $this->animal = $response->model->model;
			}
			else {
				if($appointment->model instanceof Animal) $this->animal = $appointment->model;
				elseif($appointment->model instanceof Post && $appointment->model->type->getTranslation('slug', 'en') == 'retired-breeder') $this->animal = $appointment->model->model;
			}

			if($this->animal) {
				// Si l'animal est déjà réservé mais que l'adoptant est différent de celui auquel on fix le rdv, on retire la réservation du précédent adoptant
				if($this->animal->lastLife->state == AnimalStates::Reserved && $this->animal->lastLife->model->slug != $appointment->to->slug) {
					$conflictAppointment = Appointment::whereHas('to', function($whereHas) {
							$whereHas->where('slug', $this->animal->lastLife->model->slug);
						})
						->whereHas('from', function($whereHas) {
							$whereHas->where('slug', Auth::guard('web')->user()->slug);
						})
						->where(function($where) use($key, $post) {
							$where->when($this->animal, function($when) use($key) {
								$when->whereHasMorph('model', [Animal::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							})
							->when($post, function($when) use($key) {
								$when->whereHasMorph('model', [Post::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							})
							->orWhereHas('response', function($orWhereHas) use($key) {
								$orWhereHas->whereHasMorph('model', [Animal::class, Post::class], function($whereHasMorph) use($key) {
									$whereHasMorph->where('id', $key);
								});
							});
						})
						->first();
					
					if($conflictAppointment) $conflictAppointment->delete();

					$this->animal->lastLife->delete();

					$this->animal->refresh();
				}

				if($this->animal->lastLife->state != AnimalStates::Reserved) {
					$appointment->to->life()->create([
						'animal_id' => $this->animal->id,
						'state' => AnimalStates::Reserved
					]);
				}
			}

			$figo = User::findBySlug('assur-opoil');

			$responseFigo = $appointment->to->applicants()->whereHas('from', function($whereHas) use($figo) {
					$whereHas->where('slug', $figo->slug);
				})
				->exists();

			if(!$responseFigo) {
				$responseFigo = new Response;
				$responseFigo->from()->associate($figo);
				$responseFigo->to()->associate($appointment->to);
				$responseFigo->type = ResponseTypes::Figo;
				$responseFigo->state = ResponseStates::Closed;
				$responseFigo->save();
			}
			else {
				$responseFigo = $appointment->to->applicants()->whereHas('from', function($whereHas) use($figo) {
						$whereHas->where('slug', $figo->slug);
					})
					->first();

				$responseFigo->newReservationMessage();
			}
		}

		$this->dispatch('appointment-validated');
		$this->dispatch('refresh-appointments');

		$this->fresh();
	}

	public function initProperties()
	{
		if(Auth::guard('web')->user()->id == $this->appointment->from->id) {
			$this->situation = 'asking';
			$this->fromUser = $this->appointment->from;
			$this->toUser = $this->appointment->to;
		}
		else {
			$this->situation = 'answerer';
			$this->fromUser = $this->appointment->to;
			$this->toUser = $this->appointment->from;
		}
	}

	public function mount()
	{
		if($this->appointment->id) $this->initProperties();

		$this->dispatch('appointment-show-ready');

		if(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			if(Auth::guard('web')->user()->company) {
				$this->company = Auth::guard('web')->user()->company;

				if($this->company) $this->speciesList = $this->company->species;
			}
			else $this->speciesList = new Collection();
		}

		$this->appointmentTypes = AppointmentTypes::asHumanArray();

		if($this->response->exists) {
			$this->fresh();

			if($this->response->model instanceof Post) $this->selectedSpecies = $this->response->model->model->species->getTranslation('slug', 'en');
			elseif($this->response->model instanceof Animal) $this->selectedSpecies = $this->response->model->species->getTranslation('slug', 'en');

			$this->speciesSelected();

			$this->selectedElement = $this->response->model->slug;
			$this->elementSelected();

			$this->selectedApplicant = $this->response->from->slug;
			$this->checkApplicant();

			$this->openModal = true;
		}
	}

	public function render()
	{
		return view('livewire.front.space.appointments.my-appointment');
	}
}
