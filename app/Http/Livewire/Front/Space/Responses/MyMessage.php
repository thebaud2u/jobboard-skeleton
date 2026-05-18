<?php

namespace App\Http\Livewire\Front\Space\Responses;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Enums\{AnimalStates, PublicationStates, ResponseStates, ResponseTypes};

use App\Models\{Animal, Appointment, Company, Message, Post, ProfessionnalActivity, Response, User};

class MyMessage extends Component
{
	use WithFileUploads;

	// Entities
	public Animal $animal;
	public Response $response;
	public $appointment;
	public $model;

	// Collections
	public $messages;

	// Properties
	public $applications = false;
	public $applicants = false;
	public $fromUser;
	public $toUser;
	public $photoLeft;
	public $photoRight;
	public $name;
	public $type;
	public $goToRoute;
	public $situation;
	public $appointmentPassed = true;
	public $showAutomaticMessageTemplatesModal = false;
	public $showCommentModal = false;
	public $templatesSelected = [];
	public $lastLife = null;

	// Inputs
	public $newMessage;
	public $file;

	protected function rules()
	{
		return [
			'newMessage' => [],
			'file' => []
		];
	}

	#[On('clear')]
	public function clear()
	{
		$this->response = new Response;
	}

	#[On('last-step-modal')]
	public function lastStepModal()
	{
		if($this->situation == 'answerer') $this->showAutomaticMessageTemplatesModal = true;
		elseif($this->situation == 'asking') $this->showCommentModal = true;
	}

	#[On('show')]
	public function show($id)
	{
		if($id) {
			if(!$this->response->exists || $this->response->id != $id) {
				$response = Response::find($id);

				if($response) $this->response = $response;
			}

			$this->initProperties();
			$this->refreshConversation();
		}
	}

	public function initConfirmation()
	{
		if(!$this->response->values->has('part_confirmation')) {
			$values = $this->response->values;
			$values->put('part_confirmation', collect(['asking' => false, 'answerer' => false]));
			$this->response->values = $values;
			$this->response->saveQuietly();
		}
	}

	public function archiveConversation()
	{
		$partArchive = collect($this->response->values->get('archive'));

		if($this->situation == 'asking') $partArchive->put('asking', true);
		elseif($this->situation == 'answerer') $partArchive->put('answerer', true);

		$this->response->updateValue('archive', $partArchive);
		$this->response->saveQuietly();

		$this->dispatch('conversation-archived');
		$this->dispatch('refresh-list');
	}

	public function archivePost()
	{
		if($this->type == 'animal') {
			// Si la portée auquel appartient l'animal ne contient plus d'animaux disponible à l'adoption, on désactive l'annonce.
			if(!$this->model->getPostFromLitter()->model->hasAvailableChildren()) {
				$post = $this->response->model->getPostFromLitter();
				$post->archived_at = Carbon::now();
				$post->save();

				$lastPublication = $post->lastPublication;
				$post->publications()->create([
					'user_id' => $post->user->id,
					'subscription_id' => $lastPublication->subscription->id,
					'state' => PublicationStates::Archived,
					'end_date' => $lastPublication->subscription->end_date
				]);
			}
		}
		elseif($this->type == 'post') {
			$post = $this->response->model;
			$post->archived_at = Carbon::now();
			$post->save();

			$lastPublication = $post->lastPublication;
			$post->publications()->create([
				'user_id' => $post->user->id,
				'subscription_id' => $lastPublication->subscription->id,
				'state' => PublicationStates::Archived,
				'end_date' => $lastPublication->subscription->end_date
			]);
		}
	}

	public function cancelAppointment()
	{
		$appointment = $this->response
			->appointments()
			->latest()
			->first();

		if($appointment) $appointment->delete();

		// Permet de faire remonter la conversation
		$this->response->touchQuietly();
		$this->initProperties();
		$this->dispatch('refresh-list', response: $this->response->id);
	}

	public function markAsReserved()
	{
		$this->initConfirmation();

		$values = $this->response->values;
		$values->put('part_confirmation', collect(['asking' => false, 'answerer' => false]));
		$this->response->values = $values;
		$this->response->saveQuietly();

		$this->response->from->life()->create([
			'animal_id' => $this->animal->id,
			'state' => AnimalStates::Reserved
		]);

		$values = new Collection();
		$values->put('answerer', __('You have <strong>reserved</strong> :animal for :adopter the :date at :hour', [
			'animal' => $this->animal->name,
			'adopter' => $this->response->from->name,
			'date' => Carbon::now()->translatedFormat('l d F'),
			'hour' => Carbon::now()->format('H:i')
		]))
		->put('asking', __(':company has <strong>reserved</strong> you :animal the :date at :hour', [
			'company' => $this->response->to->company->name,
			'animal' => $this->animal->name,
			'date' => Carbon::now()->translatedFormat('l d F'),
			'hour' => Carbon::now()->format('H:i')
		]));

		Message::createQuietly([
			'thread_id' => $this->response->thread->id,
			'user_id' => Auth::guard('web')->user()->id,
			'body' => 'reservation-created',
			'automated' => true,
			'values' => $values,
			'is_read' => false
		]);

		$figo = User::findBySlug('assur-opoil');

		$responseFigo = $this->response->from->applicants()->whereHas('from', function($whereHas) use($figo) {
				$whereHas->where('slug', $figo->slug);
			})
			->exists();

		if(!$responseFigo) {
			$responseFigo = new Response;
			$responseFigo->from()->associate($figo);
			$responseFigo->to()->associate($this->response->from);
			$responseFigo->type = ResponseTypes::Figo;
			$responseFigo->state = ResponseStates::Closed;
			$responseFigo->save();
		}
		else {
			$responseFigo = $this->response->from->applicants()->whereHas('from', function($whereHas) use($figo) {
					$whereHas->where('slug', $figo->slug);
				})
				->first();

			$responseFigo->newReservationMessage();
		}

		// Permet de faire remonter la conversation
		$this->response->touchQuietly();
		$this->initProperties();
		$this->dispatch('refresh-list', response: $this->response->id);
	}

	public function cancelReservation()
	{
		$reservation = $this->response->from->life()
			->whereHas('animal', function($whereHas) {
				$whereHas->where('id', $this->animal->id);
			})
			->where('state', AnimalStates::Reserved)
			->first();

		if($reservation) {
			$reservation->delete();

			$values = new Collection();
			$values->put('answerer', __('You have <strong>canceled the reservation</strong> of :animal for :adopter the :date at :hour', [
				'animal' => $reservation->animal->name,
				'adopter' => $this->response->from->name,
				'date' => Carbon::now()->translatedFormat('l d F'),
				'hour' => Carbon::now()->format('H:i')
			]))
			->put('asking', __(':company has <strong>canceled the reservation</strong> of :animal the :date at :hour', [
				'company' => $this->response->to->company->name,
				'animal' => $reservation->animal->name,
				'date' => Carbon::now()->translatedFormat('l d F'),
				'hour' => Carbon::now()->format('H:i')
			]));

			Message::createQuietly([
				'thread_id' => $this->response->thread->id,
				'user_id' => Auth::guard('web')->user()->id,
				'body' => 'reservation-canceled',
				'automated' => true,
				'values' => $values,
				'is_read' => false
			]);
		}

		// Permet de faire remonter la conversation
		$this->response->touchQuietly();
		$this->initProperties();
		$this->dispatch('refresh-list', response: $this->response->id);
	}

	public function confirmPickup()
	{
		$this->initConfirmation();

		$partConfirmation = collect($this->response->values->get('part_confirmation'));

		if($this->situation == 'asking') {
			$partConfirmation->put('asking', true);
			Auth::guard('web')->user()->sendAutomaticEmail('animal-adopted-for-known-user', $this->response->id);
		}
		elseif($this->situation == 'answerer') {
			$partConfirmation->put('answerer', true);
			Auth::guard('web')->user()->sendNotificationOnly('adoption-congratulation', $this->response->id);
		}

		$this->response->updateValue('part_confirmation', $partConfirmation);
		$this->response->saveQuietly();

		if($partConfirmation->get('answerer') == true) {
			if($this->type == 'animal' || ($this->type == 'post' && $this->model->type->getTranslation('slug', 'en') == 'retired-breeder')) {
				$this->response->from->life()->create([
					'animal_id' => $this->animal->id,
					'state' => AnimalStates::Adopted
				]);

				$this->animal->user_id = $this->response->from->id;
				$this->animal->save();

				$this->archivePost();
			}
		}

		$this->dispatch('pickup-validated');
		$this->dispatch('refresh-list', lastStepCallback: true, response: $this->response->id);
	}

	public function refreshConversation()
	{
		$this->messages = $this->response->getMessages();

		foreach($this->messages as $message) {
			if($message->user?->id != Auth::guard('web')->user()->id) $message->markAsRead();
		}
	}

	public function initProperties()
	{
		$this->response->refresh();
		$this->animal = new Animal;
		$this->lastLife = null;
		$this->goToRoute = null;

		if(Auth::guard('web')->user()->id == $this->response->from->id) {
			$this->situation = 'asking';
			$this->fromUser = $this->response->from;
			$this->toUser = $this->response->to;
		}
		else {
			$this->situation = 'answerer';
			$this->fromUser = $this->response->to;
			$this->toUser = $this->response->from;
		}

		$this->model = $this->response->model;
		$this->messages = $this->response->getMessages();

		if($this->model instanceof Animal) {
			$this->type = 'animal';
			$this->animal = $this->model;

			if(!$this->model->trashed() && !$this->model->getPostFromLitter()->trashed()) $this->goToRoute = route('animal-search.animal.show', ['company' => $this->model->company->slug, 'post' => $this->model->getPostFromLitter()->slug, 'breed' => $this->model->breed->slug, 'animal' => $this->model->id, 'type' => ($this->model->species->getTranslation('slug', 'en') == 'cat' ? __('kitten') : __('puppy')), 'sex' => Str::slugify(__($this->model->getSex()))]);

			$this->photoRight = $this->model->getFirstMedia('photos'.$this->model->id);

			if($this->situation == 'asking') {
				$this->photoLeft = $this->toUser->getFirstMedia('avatar');
				$this->name = $this->model->company->name;
			}
			elseif($this->situation == 'answerer') {
				if($this->toUser->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->toUser->company) {
					$this->photoLeft = $this->toUser->company->getFirstMedia('logo');
					$this->name = $this->toUser->company->name;
				}
				else {
					$this->name = $this->toUser->name;
					$this->photoLeft = $this->toUser->getFirstMedia('avatar');
				}
			}
		}
		elseif($this->model instanceof Company) {
			$this->type = 'company';

			if($this->model->isPublished())	$this->goToRoute = route('company-search.company.show', ['company' => $this->model->slug]);

			if($this->situation == 'asking') {
				$this->photoLeft = $this->toUser->getFirstMedia('avatar');
				$this->photoRight = $this->model->getFirstMedia('logo');
				if(!$this->photoRight) $this->photoRight = $this->model->getFirstMedia('photos');

				$this->name = $this->model->name;
			}
			elseif($this->situation == 'answerer') {
				if($this->toUser->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->toUser->company) {
					$this->photoLeft = $this->toUser->getFirstMedia('avatar');
					$this->photoRight = $this->model->getFirstMedia('logo');
					if(!$this->photoRight) $this->photoRight = $this->model->getFirstMedia('photos');

					$this->name = $this->toUser->company->name;
				}
				else {
					$this->photoLeft = $this->toUser->getFirstMedia('avatar');
					$this->photoRight = $this->model->getFirstMedia('logo');
					if(!$this->photoRight) $this->photoRight = $this->model->getFirstMedia('photos');
					$this->name = $this->toUser->name;
				}
			}
		}
		elseif($this->model instanceof Post) {
			$this->type = 'post';

			if($this->model->isPublished())	$this->goToRoute = route('post-search.post.show', ['company' => $this->model->model->company->slug, 'post' => $this->model->slug, 'breed' => $this->model->model->breed->slug]);

			if($this->model->type->getTranslation('slug', 'en') == 'litter' || $this->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $this->photoRight = $this->model->getFirstMedia('photos'.$this->model->id);
			else {
				$this->photoRight = $this->model->getFirstMedia('photos'.$this->model->id);
				$this->animal = $this->model->model;
			}

			if($this->situation == 'asking') {
				$this->photoLeft = $this->toUser->getFirstMedia('avatar');
				$this->name = $this->model->model->company->name;
			}
			elseif($this->situation == 'answerer') {
				$this->photoLeft = $this->toUser->getFirstMedia('avatar');

				if($this->toUser->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->toUser->company) $this->name = $this->toUser->company->name;
				else $this->name = $this->toUser->name;
			}
		}
		elseif($this->model instanceof ProfessionnalActivity) {
			$this->type = 'professionnal-activity';

			if($this->model->isPublished())	$this->goToRoute = route('professionnal-activity-search.professionnal-activity.show', ['activityCategory' => $this->model->category->slug, 'activity' => $this->model->activity->slug, 'professionnalActivity' => $this->model->slug]);

			if($this->situation == 'asking') {
				$this->photoLeft = $this->toUser->getFirstMedia('avatar');
				$this->photoRight = $this->model->getFirstMedia('logo');
				if(!$this->photoRight) $this->photoRight = $this->model->getFirstMedia('photos');

				$this->name = $this->model->name;
			}
			elseif($this->situation == 'answerer') {
				if($this->toUser->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->toUser->company) {
					$this->photoLeft = $this->toUser->company->getFirstMedia('logo');
					$this->photoRight = $this->toUser->company->getFirstMedia('logo');
					$this->name = $this->toUser->company->name;
				}
				else {
					$this->photoLeft = $this->toUser->getFirstMedia('avatar');
					$this->photoRight = $this->model->getFirstMedia('logo');
					if(!$this->photoRight) $this->photoRight = $this->model->getFirstMedia('photos');

					$this->name = $this->toUser->name;
				}
			}
		}
		else $this->name = $this->toUser->name;

		if($this->model instanceof Animal || $this->model instanceof Post) {
			$this->appointment = $this->response->appointments()
				->latest()
				->first();

			if($this->appointment) {
				$appointmentDate = Carbon::parse($this->appointment->date);
				$appointmentDate->setTimeFromTimeString($this->appointment->values->get('start_hour'));
				$this->appointmentPassed = $appointmentDate <= Carbon::now();
			}
		}

		if($this->animal->exists) $this->lastLife = $this->animal->lastLife;
	}

	public function send()
	{
		$rules = [
			'newMessage' => ['required_without_all:file', 'nullable', 'string'],
			'file' => ['required_without_all:newMessage', 'nullable', 'file', 'mimes:pdf,jpg,png', 'max:12288'],
		];

		$messages = [
			'newMessage.required_without_all' => __(':element is mandatory', ['element' => __('Your message')]),
			'file.required_without_all' => __(':element is mandatory', ['element' => __('A file')]),
			'file.file' => __(':element is expected', ['element' => __('A file')]),
			'file.mimes' => __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']),
			'file.max' => __(':size maximum', ['size' => '12mo'])
		];

		$this->validate($rules, $messages);

		$path = null;
		if($this->file) $path = $this->file->store('messages', 'private');

		$message = Message::create([
			'thread_id' => $this->response->thread->id,
			'user_id' => Auth::guard('web')->user()->id,
			'body' => $this->newMessage,
			'file' => $path,
			'is_read' => false
		]);

		$this->response->load('thread');
		$partArchive = collect($this->response->values->get('archive'));

		$partArchive->put('asking', false);
		$partArchive->put('answerer', false);

		$this->response->updateValue('archive', $partArchive);
		$this->response->saveQuietly();

		$this->refreshConversation();

		$this->newMessage = '';
		$this->file = '';
	}

	public function mount()
	{
		if($this->response->id) $this->initProperties();
		else $this->response = new Response;

		$this->applications = Auth::guard('web')->user()->applications()->exists();
		$this->applicants = Auth::guard('web')->user()->applicants()->exists();
	}

	public function render()
	{
		return view('livewire.front.space.responses.my-message');
	}
}
