<?php

namespace App\Http\Livewire\Front\Space\Responses;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Enums\ResponseTypes;

use App\Models\{Animal, Breed, Media, Mediable, Message, Post, Response, TempApplication, User};

use App\Services\FigoService;

class Form extends Component
{
	use WithFileUploads;

	public Animal $animal;
	public Breed $breed;
	public Post $post;
	public Response $response;
	public User $user;

	public $active = 1;
	public $totalSteps = 2;
	public $type;
	public $element;
	public $subComponentKey = 0;

	// Adopters
	public $placeConfiguration;
	public $householdComposition = [];
	public $homeAnimals = [];
	public $animalExperience;
	public $timeDedication;
	public $applicationSent = false;
	public $responseRoute;
	public $goToRoute;
	public $buttonText;

	// Breeders
	public $responseValues;
	public $pureBreedFemale = false;
	public $mediableClassPhoto;
	public $mediableIdPhoto;
	public $quotation = 3;
	public $pedigreeFile;
	public $date;
	public $message;
	public $alreadySent = false;

	protected function rules()
	{
		return [
			'message' => [],
			'placeConfiguration' => [],
			'householdComposition' => [],
			'homeAnimals' => [],
			'animalExperience' => [],
			'timeDedication' => [],
			'pureBreedFemale' => [],
			'quotation' => [],
			'pedigreeFile' => [],
			'date' => [],
			'message' => []
		];
	}

	public function removePedigree(): void
	{
		$this->pedigreeFile = null;
	}

	public function homeAnimalsSelected()
	{
		if(!empty($this->homeAnimals)) {
			if(end($this->homeAnimals) === 'none') $this->homeAnimals = ['none'];

			elseif(in_array('none', $this->homeAnimals)) {
				$this->homeAnimals = array_diff($this->homeAnimals, ['none']);
				$this->homeAnimals = array_values($this->homeAnimals);
			}
		}
		else $this->homeAnimals = ['none'];
	}

	public function goto($index)
	{
		$this->active = $index;
	}

	public function previous()
	{
		$this->active--;
	}

	#[On('figo-done')]
	public function getGiftLater()
	{
		if($this->type == 'animal') {
			$this->goToRoute = route('post-search.'.$this->animal->species->getTranslation('slug', 'en').'-posts-with-breed', ['postType' => $this->post->type->slug, 'breed' => $this->post->model->breed->slug]);
			$this->buttonText = __('Find other :element', ['element' => $this->animal->species->getTranslation('slug', 'en') == 'dog' ? __('puppies') : __('kitties')]);
		}
		elseif($this->type == 'post') {
			$this->goToRoute = route('post-search.'.$this->post->model->species->getTranslation('slug', 'en').'-posts-with-breed', ['postType' => $this->post->type->slug, 'breed' => $this->post->model->breed->slug]);

			if($this->post->type->getTranslation('slug', 'en') == 'litter' || $this->post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $this->buttonText = __('Find other :element', ['element' => $this->post->model->species->getTranslation('slug', 'en') == 'dog' ? __('puppies') : __('kitties')]);
			elseif($this->post->type->getTranslation('slug', 'en') == 'retired-breeder') $this->buttonText = __('Find other :element', ['element' => __('adults')]);
			elseif($this->post->type->getTranslation('slug', 'en') == 'stud') $this->buttonText = __('Find other :element', ['element' => __('studs')]);
		}

		$this->dispatch('figo-close');
		$this->active++;
	}

	public function submitAPIData(FigoService $figoService)
	{
		if(!$this->alreadySent) {
			$this->alreadySent = true;
			if($this->user->phone) $figoService->createFunnelSession($this->user, 'eol-application-modal', true);
		}
	}

	public function submitForm()
	{
		if(!$this->user->hasApplied($this->element)) {
			if($this->post->type->getTranslation('slug', 'en') == 'stud') {
				if($this->active == 1) {
					if($this->user->hasRole('individual_breeder')) {
						$rules = [
							'pureBreedFemale' => ['accepted']
						];

						$messages = [
							'pureBreedFemale.accepted' => __('Your female must be :lof', ['lof' => $this->post->model->species->getTranslation('slug', 'en') == 'dog' ? 'LOF' : 'LOOF'])
						];

						$validate = $this->validate($rules, $messages);
					}
				}
				elseif($this->active == 2) {
					$rules = [
						'message' => ['required']
					];

					$messages = [
						'message.required' => __(':element is mandatory', ['element' => __('The message')])
					];

					$validate = $this->validate($rules, $messages);

					$values = new Collection();

					$this->response = new Response;
					$this->response->model()->associate($this->element);
					$this->response->from()->associate($this->user);
					$this->response->to()->associate($this->post->model->company->user);

					if($this->pedigreeFile) {
						$pedigreeFilePath = $this->pedigreeFile->store('animalsDocuments', 'private');
						$values->put('pedigree', $pedigreeFilePath);
					}

					if($this->date) $values->put('date', $this->date);

					$values->put('message', $this->message)
						->put('pure_breed', $this->pureBreedFemale)
						->put('quotation', $this->quotation)
						->put('archive', collect(['asking' => false, 'answerer' => false]));;

					$this->response->values = $values;
					$this->response->type = ResponseTypes::Application;
					$this->response->save();

					$mediablePhotos = Auth::guard('web')->user()->mediable->find($this->mediableIdPhoto);
					$mediaPhotos = $mediablePhotos->media;
					if($mediaPhotos->isNotEmpty()) {
						foreach($mediaPhotos as $mediaPhoto) {
							$this->response->addMedia($mediaPhoto->getPath())
								->usingName($mediaPhoto->name)
								->usingFileName($mediaPhoto->file_name)
								->toMediaCollection('photos'.$this->response->id);

							$mediaPhoto->delete();
						}

						$mediablePhotos->delete();
					}

					$this->responseRoute = route('space.responses.my-messages', ['response' => $this->response->id]);
				}
			}
			else {
				if($this->active == 1) {
					$this->user->updateValue('place_configuration', $this->placeConfiguration);
					$this->user->updateValue('household_composition', $this->householdComposition);
					$this->user->updateValue('home_animals', $this->homeAnimals);
					$this->user->save();
				}
				elseif($this->active == 2) {
					$this->user->updateValue('animal_experience', $this->animalExperience);
					$this->user->save();

					$values = new Collection();

					$tempApplication = TempApplication::where('email', $this->user->email)
						->where('element', $this->element->slug)
						->latest()
						->first();

					if($tempApplication) {
						$values->put('message', $tempApplication->message);
						$tempApplication->delete();
					}

					$this->response = new Response;
					$this->response->model()->associate($this->element);
					$this->response->from()->associate($this->user);
					$this->response->to()->associate($this->post->model->company->user);

					if($this->placeConfiguration) $values->put('place_configuration', $this->placeConfiguration);
					if($this->householdComposition) $values->put('household_composition', $this->householdComposition);
					if($this->homeAnimals) $values->put('home_animals', $this->homeAnimals);
					if($this->animalExperience) $values->put('animal_experience', $this->animalExperience);
					if($this->timeDedication) $values->put('time_dedication', $this->timeDedication);
					if($this->timeDedication) $values->put('time_dedication', $this->timeDedication);

					$values->put('archive', collect(['asking' => false, 'answerer' => false]))
						->put('part_confirmation', collect(['asking' => false, 'answerer' => false]));

					$this->response->values = $values;
					$this->response->type = ResponseTypes::Application;
					$this->response->save();

					$this->responseRoute = route('space.responses.my-messages', ['response' => $this->response->id]);
				}
			}
		}

		if($this->active < $this->totalSteps) $this->active++;
		else {
			if($this->post->type->getTranslation('slug', 'en') != 'stud') $this->dispatch('figo-show');
			else $this->getGiftLater();
		}
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();

		if($this->type == 'animal') {
			$this->animal = $this->element;
			$this->post = $this->animal->post ? $this->animal->post : $this->animal->getPostFromLitter();
			$this->breed = $this->animal->breed;
		}
		elseif($this->type == 'post') {
			$this->post = $this->element;

			if($this->post->type->getTranslation('slug', 'en') == 'retired-breeder') $this->animal = $this->post->model;
			elseif($this->post->type->getTranslation('slug', 'en') == 'stud') $this->animal = $this->post->model;
			elseif($this->post->type->getTranslation('slug', 'en') == 'litter' || $this->post->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
				$this->animal = new Animal;
				$this->breed = $this->post->model->breed;
			}

			if($this->animal->id) $this->breed = $this->animal->breed;
		}

		if($this->post->type->getTranslation('slug', 'en') == 'stud') {
			$this->mediableClassPhoto = Mediable::class;
			$responseMediaPhoto =  Mediable::firstOrCreate([
				'user_id' => $this->user->id,
				'type' => 'response-female-photo'
			]);
			$this->mediableIdPhoto = $responseMediaPhoto->id;
		}
		else {
			$this->placeConfiguration = $this->user->values->get('place_configuration');
			$this->homeAnimals = $this->user->values->get('home_animals');
			$this->animalExperience = $this->user->values->get('animal_experience');
			$this->householdComposition = $this->user->values->get('household_composition');

			if(!$this->user->values->has('time_dedication')) {
				$values = $this->user->values;
				$values->put('time_dedication', null);
				$this->user->values = $values;
				$this->user->save();
			}
			
			$this->timeDedication = $this->user->values->get('time_dedication');
		}
	}

	public function render()
	{
		$this->subComponentKey++;

		return view('livewire.front.space.responses.form');
	}
}
