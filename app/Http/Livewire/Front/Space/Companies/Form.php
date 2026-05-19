<?php

namespace App\Http\Livewire\Front\Space\Companies;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

use App\Enums\{Affixes, PublicationStates};

use App\Models\{Address, City, Country, Department, Region};
use App\Models\{Breed, Company, Media, Mediable, Offer, Species, Subscription, User};

use App\Services\EmbedService;
use App\Rules\MediaUrl;

class Form extends Component
{
	use WithFileUploads;

	protected $embedService;

	// Entities
	public Address $address;
	public Company $company;
	public Mediable $mediable;
	public Offer $offer;
	public Subscription $subscription;
	public User $user;

	// Properties
	public $name;
	public $affix = 'suffix';
	public $affixName;
	public $breeds = [];
	public $description;
	public $addressArray;
	public $videos = [];
	public $catFacebook;
	public $catInstagram;
	public $dogFacebook;
	public $dogInstagram;
	public $numberActiveFemaleCatBreeder = null;
	public $numberActiveFemaleDogBreeder = null;
	public $website;

	// Misc
	public $lastPublication;
	public $companyState = 'create';
	public $active = 1;
	public $totalSteps = 3;
	public $maxBreeds;
	public $breedCount = 0;
	public $subComponentKey = 0;
	public $changeHasBeenMade = false;
	public $mediableClassLogo;
	public $mediableIdLogo;
	public $collectionLogo;
	public $mediableClassPhotos;
	public $mediableIdPhotos;
	public $collectionPhotos;
	public $photoCount = 0;
	public $mediasLeft = 0;

	// User Values
	public $userInterestedIn;

	protected function rules()
	{
		return [
			'name' => [],
			'affixName' => [],
			'breeds' => [],
			'numberActiveFemaleCatBreeder' => [],
			'numberActiveFemaleDogBreeder' => [],
			'addressArray' => [],
			'description' => [],
			'videos' => [],
			'facebook' => [],
			'instagram' => [],
			'website' => []
		];
	}

	#[On('address-selected')]
	public function addressSelected($address)
	{
		$this->addressArray = $address;
	}

	#[On('breed-selected')]
	public function breedSelected($breedSlug)
	{
		if($this->maxBreeds == 'unlimited' || count($this->breeds) < $this->maxBreeds) {
			$breed = Breed::findBySlug($breedSlug);

			if($breed && !in_array($breed->slug, $this->breeds)) $this->breeds[$breed->slug] = $breed->name;
		}
		else session()->flash('error', __('You\'ve reached the maximum breeds your offer allows you'));
	}

	#[On('new-breeder-associated')]
	public function newBreederAssociated($animalSlug)
	{
		$this->subComponentKey++;
	}

	#[On('media-added')]
	public function mediaAdded()
	{
		$this->refreshLastPublication();

		if($this->companyState == 'update' && $this->lastPublication->isPublished()) {
			if(!$this->company->awaitingModeration()) {
				$endDate = null;

				if(!$this->offer->free) $endDate = $this->lastPublication->end_date;

				$this->company->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::PublishedUpdatedWaitingModeration,
					'end_date' => $endDate
				]);

				$this->company->markForModeration();
			}

			session()->flash('company_published_modified');
		}

		$this->countCompanyPhotos();
	}

	#[On('media-deleted')]
	public function mediaDeleted()
	{
		$this->countCompanyPhotos();
	}

	public function countCompanyPhotos()
	{
		if($this->companyState == 'create') $model = Auth::guard('web')->user()->mediable->find($this->mediableIdPhotos);
		elseif($this->companyState == 'update') $model = $this->company;

		$this->photoCount = $model->getMedia('photos')->count();
		$this->mediasLeft = $this->offer->getMaxPhoto() - $this->photoCount;
	}

	public function removeBreed($breedSlug)
	{
		unset($this->breeds[$breedSlug]);
	}

	public function previous()
	{
		if($this->active == 3) {
			if($this->offer->hasOption('display-breeders')) $this->active--;
			else $this->active = $this->active - 2;
		}
		else $this->active--;
	}

	public function goto($index)
	{
		$this->active = $index;
	}

	public function setAddress()
	{
		if($this->companyState == 'create') {
			if($this->company->address()->count() > 0) $this->company->address->delete();

			$country = Country::find($this->addressArray['country_id']);

			if($country) {
				if($country->code == 'FRA') {
					$this->addressArray['custom_postcode'] = null;
					$this->addressArray['custom_province'] = null;
					$this->addressArray['custom_city'] = null;
				}
				elseif($country->code == 'BEL') {
					$this->addressArray['region_id'] = null;
					$this->addressArray['department_id'] = null;
					$this->addressArray['city_id'] = null;
				}
			}

			$this->company->address()->create($this->addressArray);
		}
		elseif($this->companyState == 'update') {
			$current = $this->address->only([
				'country_id',
				'city_id',
				'custom_city',
				'street',
				'department_id',
				'region_id',
				'custom_postcode',
				'custom_province',
			]);

			$new = collect($this->addressArray)->only(array_keys($current))->toArray();

			if(array_diff_assoc($new, $current) || array_diff_assoc($current, $new)) {
				if($address = $this->company->addressForModeration) $address->delete();

				$this->addressArray['for_moderation'] = true;
				$this->company->address()->create($this->addressArray);
			}
		}
	}

	public function refreshLastPublication()
	{
		$this->company->load('lastPublication');

		$this->lastPublication = $this->company->lastPublication;

		if($this->lastPublication) {
			$this->subscription = $this->lastPublication->subscription;
			$this->offer = $this->subscription->offer;
		}
		else $this->subscription = $this->user->hasOfferSubscription($this->offer->slug);
	}

	public function setPublication($status)
	{
		$this->refreshLastPublication();

		if($this->companyState == 'create') {
			if($status == 'publish') {
				if($this->active < $this->totalSteps) {
					if($this->company->publications()->count() == 0) {
						$this->company->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::Draft
						]);
					}
				}
				elseif($this->active == $this->totalSteps) {
					$this->company->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::DraftWaitingModerationForPublication
					]);

					$this->company->markForModeration();
					$message = __(':element has been created successfully', ['element' => __('Your company page')]);
					session()->flash('company_published');
				}
			}
			elseif($status == 'draft') {
				if($this->company->publications()->count() == 0) {
					$this->company->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::Draft
					]);
				}

				$message = __(':element has been saved as draft successfully', ['element' => __('Your company page')]);
			}
		}
		elseif($this->companyState == 'update') {
			if($this->lastPublication->isDraft()) {
				if($status == 'publish') {
					if($this->active == $this->totalSteps) {
						$this->company->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::DraftWaitingModerationForPublication
						]);

						$this->company->markForModeration();
						session()->flash('company_published');
					}
				}
			}
			elseif($this->lastPublication->isPublished() && $this->changeHasBeenMade) {
				$endDate = null;

				if(!$this->offer->free) $endDate = $this->lastPublication->end_date;

				$this->company->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::PublishedUpdatedWaitingModeration,
					'end_date' => $endDate
				]);

				$this->company->markForModeration();
				session()->flash('company_published_modified');
			}
			elseif($this->lastPublication->isWaitingToBePublished() && $this->company->lastModeration->isDenied()) {
				$this->company->markForModeration();
				session()->flash('company_published_modified');
			}

			$message = __(':element has been updated successfully', ['element' => __('Your company page')]);
		}

		if($status == 'draft' || ($status == 'publish' && $this->active == $this->totalSteps)) return redirect(route('space.companies.my-company'))->with('success', $message);
	}

	public function syncPivots()
	{
		// Association of the breeds to the company
		if($this->companyState == 'create') {
			// Association of the species to the company
			if($this->userInterestedIn == 'both' || $this->userInterestedIn == 'cats') {
				$catSpecies = Species::findBySlug('cat', 'en');

				if($catSpecies) $this->company->species()->syncWithoutDetaching($catSpecies->id);
			}

			if($this->userInterestedIn == 'both' || $this->userInterestedIn == 'dogs') {
				$dogSpecies = Species::findBySlug('dog', 'en');

				if($dogSpecies) $this->company->species()->syncWithoutDetaching($dogSpecies->id);
			}

			if($this->breeds) {
				foreach($this->breeds as $slug => $name) {
					$breed = Breed::findBySlug($slug);

					if($breed) $this->company->breeds()->syncWithoutDetaching($breed->id);
				}
			}
		}
		elseif($this->companyState == 'update') {
			$fromModeration = false;

			if(data_get($this->company->values, 'for_moderation.breeds')) {
				$source = $this->company->constructBreedsFromModeration();
				$fromModeration = true;
			}
			else $source = $this->company->breeds;

			$currentBreeds = $source->pluck('slug');

			if($this->breeds) {
				$formBreeds = collect();

				foreach($this->breeds as $slug => $name) {
					$breed = Breed::findBySlug($slug);

					if($breed) $formBreeds->push($breed->slug);
				}

				// Breeds added
				$addedBreeds = $formBreeds->diff($currentBreeds);
				if($addedBreeds->isNotEmpty()) {
					$values = $this->company->values;
					$forModeration = $values->get('for_moderation', []);
					$forModeration['breeds'] = $formBreeds;
					$values->put('for_moderation', $forModeration);

					$this->company->values = $values;
					$this->company->save();
					$this->company->markForModeration();
					$this->changeHasBeenMade = true;
				}

				// Suppression
				$deletedBreeds = $currentBreeds->diff($formBreeds);
				if($deletedBreeds->isNotEmpty()) {
					foreach($deletedBreeds as $index => $slug) {
						$breed = Breed::findBySlug($slug);

						if($breed) {
							if($fromModeration) {
								$breedsFromModeration = data_get($this->company->values, 'for_moderation.breeds');

								$key = array_search($breed->slug, $breedsFromModeration);

								if($key || $key === 0) unset($breedsFromModeration[$key]);
							}
							else $this->company->breeds()->detach($breed->id);
						}
					}

					if($fromModeration) {
						$this->company->updateValue('for_moderation.breeds', array_values($breedsFromModeration));
						$this->company->save();
					}
				}
			}
		}
	}

	public function submitCompanyForm($status)
	{
		$this->embedService = new EmbedService;

		if($this->active == 1) {
			$rules = [
				'name' => ['required', 'min:2', 'max:125'],
				'affixName' => ['required', 'min:2', 'max:100'],
				'breeds' => ['required'],
				'numberActiveFemaleCatBreeder' => ['nullable', 'required_if:userInterestedIn,both,cats', 'numeric'],
				'numberActiveFemaleDogBreeder' => ['nullable', 'required_if:userInterestedIn,both,dogs', 'numeric'],
				'description' => ['required', 'min:2'],
				'addressArray.street' => ['required'],
				'addressArray.custom_city' => ['required_without:addressArray.city_id'],
				'addressArray.city_id' => ['required_without:addressArray.custom_city'],
				'catFacebook' => ['nullable', 'url:http,https'],
				'catInstagram' => ['nullable', 'url:http,https'],
				'dogFacebook' => ['nullable', 'url:http,https'],
				'dogInstagram' => ['nullable', 'url:http,https'],
				'website' => ['nullable', 'url:http,https']
			];

			$messages = [
				'name.required' => __(':element is mandatory', ['element' => __('Your company\'s name')]),
				'name.min' => __('Your :element must be :x characters minimum', ['element' => __('company\'s name'), 'x' => 2]),
				'name.max' => __('Your :element must be :x characters maximum', ['element' => __('company\'s name'), 'x' => 125]),
				'affixName.required' => __(':element is mandatory', ['element' => __($this->affix == 'suffix' ? 'Suffix name' : 'Prefix name')]),
				'affixName.min' => __('Your :element must be :x characters minimum', ['element' => __($this->affix == 'suffix' ? 'Suffix name' : 'Prefix name'), 'x' => 2]),
				'affixName.max' => __('Your :element must be :x characters maximum', ['element' => __($this->affix == 'suffix' ? 'Suffix name' : 'Prefix name'), 'x' => 100]),
				'breeds.required' => __(':element is mandatory', ['element' => __('Your company\'s must have at least one breed')]),
				'numberActiveFemaleCatBreeder.required_if' => __(':element is mandatory', ['element' => __('The number of active female cat breeder')]),
				'numberActiveFemaleCatBreeder.numeric' => __('Only numerals'),
				'numberActiveFemaleDogBreeder.required_if' => __(':element is mandatory', ['element' => __('The number of active female dog breeder')]),
				'numberActiveFemaleDogBreeder.numeric' => __('Only numerals'),
				'description.required' => __(':element is mandatory', ['element' => __('Your company\'s description')]),
				'description.min' => __('Your :element must be :x characters minimum', ['element' => __('company\'s description'), 'x' => 2]),
				'addressArray.street.required' => __(':element is mandatory', ['element' => __('Your street')]),
				'addressArray.custom_city.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
				'addressArray.city_id.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
				'catFacebook.url' => __('An http or https url is needed'),
				'catInstagram.url' => __('An http or https url is needed'),
				'dogFacebook.url' => __('An http or https url is needed'),
				'dogInstagram.url' => __('An http or https url is needed'),
				'website.url' => __('An http or https url is needed'),
			];

			if($this->maxBreeds != 'unlimited') {
				$rules['breeds'][] = 'max:'.$this->maxBreeds;
				$messages['breeds.max'] = __('Your company\'s must have maximum :x :breed', ['x' => $this->maxBreeds, 'breed' => $this->maxBreeds > 1 ? __('breeds') : __('breed')]);
			}

			if($this->offer->hasOption('4-video')) {
				foreach($this->videos as $key => $video) {
					if($video) {
						$isEmbedUrl = $this->embedService->isEmbedUrl($video);

						if(!$isEmbedUrl) {
							$videoEmbed = $this->embedService->convertToEmbed($video);

							if(is_null($videoEmbed)) {
								$rules['videos.'.$key] = [new MediaUrl];
								$messages['videos.'.$key] = 'Le lien du média '.($key+1).' n\'est pas correct';
							}
						}
					}
				}
			}

			// Address validation sharing errors with livewire child componant Address
			if((is_null($this->addressArray['street']) || empty($this->addressArray['street'])) || (is_null($this->addressArray['custom_city']) && is_null($this->addressArray['city_id']))) $this->dispatch('address-validation-error');

			$this->validate($rules, $messages);

			if($this->companyState == 'create') {
				$values = new Collection();

				$values->put('affix', $this->affix)
					->put('affix_name', $this->affixName)
					->put('cat_facebook', $this->catFacebook)
					->put('cat_instagram', $this->catInstagram)
					->put('dog_facebook', $this->dogFacebook)
					->put('dog_instagram', $this->dogInstagram)
					->put('website', $this->website);

				if($this->offer->hasOption('4-video')) {
					$videos = [];

					foreach($this->videos as $video) {
						if($video) {
							$isEmbedUrl = $this->embedService->isEmbedUrl($video);

							if(!$isEmbedUrl) {
								$videoEmbed = $this->embedService->convertToEmbed($video);

								$videos[] = $videoEmbed;
							}
							else $videos[] = $video;
						}
					}

					$values->put('videos', $videos);
				}

				$this->company->user_id = $this->user->id;
				$this->company->name = $this->name;
				$this->company->description = $this->description;
				$this->company->values = $values;
				$this->company->save();

				$this->syncPivots();

				$this->company->values = $values;
				$this->company->save();

				// The Media associated with a Mediable is taken back and transferred to the newly created company
				$mediableLogo = $this->user->mediable->where('type', 'company-logo')->first();
				$mediaLogo = $mediableLogo->media->first();

				if($mediaLogo) {
					$this->company->addMedia($mediaLogo->getPath())
						->usingName($mediaLogo->name)
						->usingFileName($mediaLogo->file_name)
						->toMediaCollection('logo');

					$mediaLogo->delete();
					$mediableLogo->delete();
				}

				$mediablePhotos = $this->user->mediable->where('type', 'company-photos')->first();
				$mediaPhotos = $mediablePhotos->media;
				if($mediaPhotos->isNotEmpty()) {
					foreach($mediaPhotos as $mediaPhoto) {
						$this->company->addMedia($mediaPhoto->getPath())
							->usingName($mediaPhoto->name)
							->usingFileName($mediaPhoto->file_name)
							->toMediaCollection('photos');

						$mediaPhoto->delete();
					}

					$mediablePhotos->delete();
				}

				$this->setAddress();
			}
			elseif($this->companyState == 'update') {
				$this->company->description = $this->description;
				$values = $this->company->values;
				$values->put('cat_facebook', $this->catFacebook)
					->put('cat_instagram', $this->catInstagram)
					->put('dog_facebook', $this->dogFacebook)
					->put('dog_instagram', $this->dogInstagram)
					->put('website', $this->website);

				if($this->offer->hasOption('4-video')) {
					$videos = [];

					foreach($this->videos as $video) {
						if($video) {
							$isEmbedUrl = $this->embedService->isEmbedUrl($video);

							if(!$isEmbedUrl) {
								$videoEmbed = $this->embedService->convertToEmbed($video);

								$videos[] = $videoEmbed;
							}
							else $videos[] = $video;
						}
					}
				}

				if(
					($this->company->name != $this->name) ||
					($values->get('affix') != $this->affix) ||
					($values->get('affix_name') != $this->affixName) ||
					($this->offer->hasOption('4-video') && $values->get('videos') != $videos)
				) {
					$this->changeHasBeenMade = true;

					$forModeration = $values->get('for_moderation', []);

					if($this->company->name != $this->name) $forModeration['name'] = $this->name;
					if($values->get('affix') != $this->affix) $forModeration['affix'] = $this->affix;
					if($values->get('affix_name') != $this->affixName) $forModeration['affix_name'] = $this->affixName;
					if($this->offer->hasOption('4-video') && $values->get('videos') != $videos) $forModeration['videos'] = $videos;

					$values->put('for_moderation', $forModeration);
					

					session()->flash('warning', __('Your updates needs to be moderated to be displayed. The customer service will moderate your updates as soon as possible.'));
				}

				$this->company->values = $values;
				$this->company->save();

				$this->syncPivots();
				$this->setAddress();
			}

			$values = $this->company->values;

			if($this->userInterestedIn == 'both' || $this->userInterestedIn == 'cats') $values->put('active_female_cat_breeder', $this->numberActiveFemaleCatBreeder);
			if($this->userInterestedIn == 'both' || $this->userInterestedIn == 'dogs') $values->put('active_female_dog_breeder', $this->numberActiveFemaleDogBreeder);

			$this->company->values = $values;
			$this->company->save();
		}

		$this->setPublication($status);

		if($this->active < $this->totalSteps && $status == 'publish') {
			$this->active++;

			if(!$this->offer->hasOption('display-breeders')) $this->active++;
		}
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();
		$this->userInterestedIn = $this->user->values->get('interested_in');

		if($this->company->id) {
			$this->companyState = 'update';

			$this->refreshLastPublication();

			$this->mediableClassLogo = Company::class;
			$this->mediableIdLogo = $this->company->id;
			$this->collectionLogo = 'logo';

			$this->mediableClassPhotos = Company::class;
			$this->mediableIdPhotos = $this->company->id;
			$this->collectionPhotos = 'photos';

			$this->address = $this->company->addressForModeration ?? $this->company->address ?? new Address();

			if(data_get($this->company->values, 'for_moderation.breeds')) $source = $this->company->constructBreedsFromModeration();
			else $source = $this->company->breeds;

			foreach($source as $breed) {
				$this->breeds[$breed->slug] = $breed->name;
			}

			$this->numberActiveFemaleCatBreeder = $this->company->values->get('active_female_cat_breeder');
			$this->numberActiveFemaleDogBreeder = $this->company->values->get('active_female_dog_breeder');
			$this->catFacebook = $this->company->values->get('cat_facebook');
			$this->catInstagram = $this->company->values->get('cat_instagram');
			$this->dogFacebook = $this->company->values->get('dog_facebook');
			$this->dogInstagram = $this->company->values->get('dog_instagram');
			$this->website = $this->company->values->get('website');

			if(data_get($this->company->values, 'for_moderation.name')) $this->name = data_get($this->company->values, 'for_moderation.name');
			else $this->name = $this->company->name;

			if(data_get($this->company->values, 'for_moderation.description')) $this->description = data_get($this->company->values, 'for_moderation.description');
			else $this->description = $this->company->description;

			if(data_get($this->company->values, 'for_moderation.affix')) $this->affix = data_get($this->company->values, 'for_moderation.affix');
			else $this->affix = $this->company->values->get('affix');

			if(data_get($this->company->values, 'for_moderation.affix_name')) $this->affixName = data_get($this->company->values, 'for_moderation.affix_name');
			else $this->affixName = $this->company->values->get('affix_name');
			
			if($this->offer->hasOption('4-video')) {
				if(data_get($this->company->values, 'for_moderation.videos')) $this->videos = data_get($this->company->values, 'for_moderation.videos');
				else $this->videos = $this->company->values->get('videos') ?? [];
			}
		}
		else {
			$this->mediableClassLogo = Mediable::class;
			$companyMediableLogo =  Mediable::firstOrCreate([
				'user_id' => $this->user->id,
				'type' => 'company-logo'
			]);
			$this->mediableIdLogo = $companyMediableLogo->id;
			$this->collectionLogo = 'logo';

			$this->mediableClassPhotos = Mediable::class;
			$companyMediablePhotos = Mediable::firstOrCreate([
				'user_id' => $this->user->id,
				'type' => 'company-photos'
			]);
			$this->mediableIdPhotos = $companyMediablePhotos->id;
			$this->collectionPhotos = 'photos';

			if($this->user->address) $this->address = $this->user->address;
			else $this->address = new Address;

			$this->companyState = 'create';
		}

		$this->countCompanyPhotos();
		$this->maxBreeds = $this->offer->getMaxBreed();
	}

	public function render()
	{
		$affixes = Affixes::asHumanArray();

		if($this->maxBreeds != 'unlimited') $this->breedCount = $this->maxBreeds - count($this->breeds);

		$this->subComponentKey++;

		return view('livewire.front.space.companies.form', [
			'affixes' => $affixes,
		]);
	}
}
