<?php

namespace App\Http\Livewire\Front\Space\ProfessionnalActivities;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

use App\Enums\PublicationStates;

use App\Models\{Address, City, Country, Department, Region};
use App\Models\{Activity, ActivityCategory, ActivitySolution, Media, Mediable, Offer, ProfessionnalActivity, Species, Subscription, User};

class Form extends Component
{
	use WithFileUploads;

	public Address $addressCompany;
	public Address $addressActivity;
	public Mediable $mediable;
	public Offer $offer;
	public ProfessionnalActivity $professionnalActivity;
	public Subscription $subscription;
	public User $user;

	public $active = 1;
	public $totalSteps = 4;
	public $professionnalActivityState = 'create';
	public $professionnalActivityHasBeenValidated = false;
	public $changeHasBeenMade = false;
	public $lastPublication;
	public $hasSolutionDetailsInstead = false;

	// Lists
	public $speciesList;
	public $activityCategoriesList;
	public $activitySolutionsList;
	public $activitySolutionCollection;

	// Properties
	public $mediableClassLogo;
	public $mediableIdLogo;
	public $collectionLogo;
	public $mediableClassPhotos;
	public $mediableIdPhotos;
	public $collectionPhotos;
	public $photoCount = 0;
	public $mediasLeft = 0;
	public $subComponentKey = 0;

	public $siret;
	public $companyName;
	public $addressArray;
	public $phone;
	public $checkedSpecies = [];
	public $selectedActivity;
	public $checkedActivitySolutions = [];
	public $checkedActivitySolutionDetails = [];
	public $name;
	public $website;
	public $instagram;
	public $facebook;
	public $description;
	public $appointmentOptions = [];
	public $radiusValue;
	public $schedule = [];
	public $creditAvailable = 0;

	protected function rules()
	{
		return [
			'phone' => [],
			'siret' => [],
			'companyName' => [],
			'addressArray.street' => [],
			'addressArray.city_id' => [],
			'sirenDocument' => [],
			'checkedSpecies' => [],
			'selectedActivity' => [],
			'checkedActivitySolutions' => [],
			'checkedActivitySolutionDetails' => [],
			'name' => [],
			'website' => [],
			'instagram' => [],
			'facebook' => [],
			'description' => [],
			'appointmentOptions' => [],
			'radiusValue' => []
		];
	}

	#[On('address-selected')]
	public function addressSelected($address)
	{
		$this->addressArray = $address;
	}

	#[On('media-added')]
	public function mediaAdded()
	{
		$this->refreshLastPublication();

		if($this->professionnalActivityState == 'update' && $this->lastPublication->isPublished()) {
			if(!$this->professionnalActivity->awaitingModeration()) {
				$endDate = null;

				if(!$this->offer->free) $endDate = $this->lastPublication->end_date;

				$this->professionnalActivity->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::PublishedUpdatedWaitingModeration,
					'end_date' => $endDate
				]);

				$this->professionnalActivity->markForModeration();
			}

			session()->flash('professionnal_activity_modified');
		}

		$this->countProfessionnalActivityPhotos();
	}

	#[On('media-deleted')]
	public function mediaDeleted()
	{
		$this->countProfessionnalActivityPhotos();
	}

	public function countProfessionnalActivityPhotos()
	{
		if($this->professionnalActivityState == 'create') $model = Auth::guard('web')->user()->mediable->find($this->mediableIdPhotos);
		elseif($this->professionnalActivityState == 'update') $model = $this->professionnalActivity;

		$this->photoCount = $model->getMedia('photos')->count();
		$this->mediasLeft = $this->offer->getMaxPhoto() - $this->photoCount;
	}

	public function setAddress($collection)
	{
		$address = $this->professionnalActivity->address()->where('collection', $collection);
		$this->addressArray['collection'] = $collection;

		if($this->professionnalActivityState == 'create') {
			if($address->count() > 0) $address->first()->delete();

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

			$this->professionnalActivity->address()->create($this->addressArray);
		}
		elseif($this->professionnalActivityState == 'update') {
			$current = $this->professionnalActivity->address()->where('collection', $collection)->first();

			if($current) {
				$current = $current->only([
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
					if($address = $this->professionnalActivity->addressForModeration) $address->delete();

					$this->addressArray['for_moderation'] = true;
					$this->professionnalActivity->address()->create($this->addressArray);
				}
			}
			else {
				$this->addressArray['for_moderation'] = true;
				$this->professionnalActivity->address()->create($this->addressArray);
			}
		}

		if($collection == 'company') $this->addressCompany = $this->professionnalActivity->address()->where('collection', 'company')->first();
		elseif($collection == 'activity') $this->addressActivity = $this->professionnalActivity->address()->where('collection', 'activity')->first();
	}

	public function activityChecked()
	{
		if($this->selectedActivity) {
			$activity = Activity::findBySlug($this->selectedActivity, 'en');
			$this->activitySolutionsList = $activity->solutions;
			$this->checkedActivitySolutions = array();
			$this->checkedActivitySolutionDetails = null;
		}
	}

	public function activitySolutionsChecked()
	{
		if($this->checkedActivitySolutions) {
			$this->activitySolutionCollection = ActivitySolution::whereIn('slug', $this->checkedActivitySolutions)
				->get();

			if(!is_null($this->checkedActivitySolutionDetails)) {
				$slugsActuels = [];
	
				foreach ($this->activitySolutionCollection as $activitySolutionEntry) {
					foreach ($activitySolutionEntry->solutionDetails as $solutionDetail) {
						$slugsActuels[$solutionDetail->slug] = true;
					}
				}
	
				foreach ($this->checkedActivitySolutionDetails as $slug => $value) {
					if (!isset($slugsActuels[$slug])) {
						unset($this->checkedActivitySolutionDetails[$slug]);
					}
				}
	
				foreach ($slugsActuels as $slug => $_) {
					if (!isset($this->checkedActivitySolutionDetails[$slug])) {
						$this->checkedActivitySolutionDetails[$slug] = [];
					}
				}
			}
			else {
				foreach($this->activitySolutionCollection as $activitySolutionEntry) {
					foreach($activitySolutionEntry->solutionDetails as $solutionDetail) {
						$this->checkedActivitySolutionDetails[$solutionDetail->slug] = [];
					}
				}
			}
		}
	}

	public function setScheduleOrder()
	{
		$orderedDays = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

		foreach($orderedDays as $day) {
			$this->schedule[$day] = $this->professionnalActivity->values->get('schedule')[$day];
		}
	}

	public function updatedSchedule($value, $key)
	{
		if (Str::endsWith($key, '.closed') && $value) {
			$day = Str::before($key, '.closed');

			$this->schedule[$day]['parts'] = [
				'morning_start' => null,
				'morning_end' => null,
				'afternoon_start' => null,
				'afternoon_end' => null,
			];
		}
	}

	public function goto($index)
	{
		$this->active = $index;
	}

	public function previous()
	{
		if($this->professionnalActivityState == 'create' && $this->active == 2) return redirect()->route('space.professionnal-activities.update', ['professionnalActivity' => $this->professionnalActivity->slug]);

		$this->active--;
	}

	public function refreshLastPublication()
	{
		$this->professionnalActivity->load('lastPublication');

		$this->lastPublication = $this->professionnalActivity->lastPublication;

		if($this->lastPublication) {
			$this->subscription = $this->lastPublication->subscription;
			$this->offer = $this->subscription->offer;
		}
		else $this->subscription = $this->user->hasOfferSubscription($this->offer->slug);
	}

	public function setPublication($status)
	{
		$this->refreshLastPublication();

		if($this->professionnalActivityState == 'create') {
			if($status == 'publish') {
				if($this->active < $this->totalSteps) {
					if($this->professionnalActivity->publications()->count() == 0) {
						$this->professionnalActivity->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::Draft
						]);
					}
				}
				elseif($this->active == $this->totalSteps) {
					$this->professionnalActivity->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::DraftWaitingModerationForPublication
					]);

					$this->professionnalActivity->markForModeration();
					$message = __(':element has been created successfully', ['element' => __('Your activity')]);
					session()->flash('professionnal_activity_published');
				}
			}
			elseif($status == 'draft') {
				if($this->professionnalActivity->publications()->count() == 0) {
					$this->professionnalActivity->publications()->create([
						'user_id' => $this->user->id,
						'subscription_id' => $this->subscription->id,
						'state' => PublicationStates::Draft
					]);
				}

				$message = __(':element has been saved as draft successfully', ['element' => __('Your activity')]);
			}
		}
		elseif($this->professionnalActivityState == 'update') {
			if($this->lastPublication->isDraft()) {
				if($status == 'publish') {
					if($this->active == $this->totalSteps) {
						$this->professionnalActivity->publications()->create([
							'user_id' => $this->user->id,
							'subscription_id' => $this->subscription->id,
							'state' => PublicationStates::DraftWaitingModerationForPublication
						]);

						$this->professionnalActivity->markForModeration();
						session()->flash('professionnal_activity_published');
					}
				}
			}
			elseif($this->lastPublication->isPublished() && $this->changeHasBeenMade) {
				$endDate = null;

				if(!$this->offer->free) $endDate = $this->lastPublication->end_date;

				$this->professionnalActivity->publications()->create([
					'user_id' => $this->user->id,
					'subscription_id' => $this->subscription->id,
					'state' => PublicationStates::PublishedUpdatedWaitingModeration,
					'end_date' => $endDate
				]);

				$this->professionnalActivity->markForModeration();
				session()->flash('professionnal_activity_modified');
			}
			elseif($this->lastPublication->isWaitingToBePublished() && $this->professionnalActivity->lastModeration->isDenied()) {
				$this->professionnalActivity->markForModeration();
				session()->flash('professionnal_activity_modified');
			}

			$message = __(':element has been updated successfully', ['element' => __('Your activity')]);
		}

		if($status == 'draft' || ($status == 'publish' && $this->active == $this->totalSteps)) return redirect(route('space.professionnal-activities.my-professionnal-activities'))->with('success', $message);
	}

	public function syncPivots()
	{
		if($this->professionnalActivityState == 'create') {
			$speciesIds = Species::whereIn('slug->en', $this->checkedSpecies)->pluck('id')->toArray();
			$this->professionnalActivity->species()->syncWithoutDetaching($speciesIds);

			if(!$this->hasSolutionDetailsInstead) {
				$activitySolutionIds = ActivitySolution::whereIn('slug', $this->checkedActivitySolutions)->pluck('id')->toArray();
				$this->professionnalActivity->activitySolutions()->syncWithoutDetaching($activitySolutionIds);
			}
		}
		elseif($this->professionnalActivityState == 'update') {
			$currentSpeciesIds = $this->professionnalActivity->species()->pluck('species.id')->toArray();
			$currentActivitySolutionIds = $this->professionnalActivity->activitySolutions()->pluck('activity_solutions.id')->toArray();

			$newSpeciesIds = Species::whereIn('slug->en', $this->checkedSpecies)->pluck('id')->toArray();
			$newActivitySolutionIds = ActivitySolution::whereIn('slug', $this->checkedActivitySolutions)->pluck('id')->toArray();

			$speciesChanged = collect($currentSpeciesIds)->sort()->values()->toArray() !== collect($newSpeciesIds)->sort()->values()->toArray();
			$activitySolutionsChanged = collect($currentActivitySolutionIds)->sort()->values()->toArray() !== collect($newActivitySolutionIds)->sort()->values()->toArray();

			if($speciesChanged || $activitySolutionsChanged) {
				$this->changeHasBeenMade = true;
				$forModeration = $this->professionnalActivity->values->get('for_moderation', []);

				if($speciesChanged) $forModeration['species'] = $newSpeciesIds;
				if($activitySolutionsChanged) $forModeration['activity_solutions'] = $newActivitySolutionIds;

				$this->professionnalActivity->updateValue('for_moderation', $forModeration);
				$this->professionnalActivity->save();
				$this->professionnalActivity->markForModeration();
			}

			// Suppression
			$speciesToDetach = array_diff($currentSpeciesIds, $newSpeciesIds);
			if($speciesToDetach) $this->professionnalActivity->species()->detach($speciesToDetach);

			$activitySolutionsToDetach = array_diff($currentActivitySolutionIds, $newActivitySolutionIds);
			if($activitySolutionsToDetach) $this->professionnalActivity->activitySolutions()->detach($activitySolutionsToDetach);
		}
	}

	public function submitProfessionnalActivityForm($status)
	{
		if($this->active == 1) {
			$rules = [
				'siret' => ['required', 'numeric', 'min_digits:14', 'max_digits:14'],
				'companyName' => ['required', 'min:2', 'max:255'],
				'phone' => ['required'],
				'addressArray.street' => ['required'],
				'addressArray.custom_city' => ['required_without:addressArray.city_id'],
				'addressArray.city_id' => ['required_without:addressArray.custom_city']
			];

			$messages = [
				'siret.required' => __(':element is mandatory', ['element' => __('Your Siret number')]),
				'siret.min_digits' => __('Your :element must be :x digits minimum', ['element' => __('Siret'), 'x' => 14]),
				'siret.max_digits' => __('Your :element must be :x digits maximum', ['element' => __('Siret'), 'x' => 14]),
				'companyName.required' => __(':element is mandatory', ['element' => __('Your company name')]),
				'companyName.min' => __('Your :element must be :x characters minimum', ['element' => __('Your company name'), 'x' => 2]),
				'companyName.max' => __('Your :element must be :x characters maximum', ['element' => __('Your company name'), 'x' => 255]),
				'phone.required' => __(':element is mandatory', ['element' => __('Your phone number')]),
				'addressArray.street.required' => __(':element is mandatory', ['element' => __('Your street')]),
				'addressArray.custom_city.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
				'addressArray.city_id.required_without' => __(':element is mandatory', ['element' => __('Your city')])
			];

			// Address validation sharing errors with livewire child componant Address
			if((is_null($this->addressArray['street']) || empty($this->addressArray['street'])) || (is_null($this->addressArray['custom_city']) && is_null($this->addressArray['city_id']))) $this->dispatch('address-validation-error');

			$this->validate($rules, $messages);

			$this->professionnalActivity->user_id = $this->user->id;
			$this->professionnalActivity->name = $this->companyName;
			$this->professionnalActivity->initValues();
			$this->professionnalActivity->updateValue('siret', $this->siret);
			$this->professionnalActivity->updateValue('company_name', $this->companyName);
			$this->professionnalActivity->updateValue('phone', $this->phone);

			$this->setScheduleOrder();
			$this->setAddress('company');
		}
		elseif($this->active == 2) {
			$rules = [
				'selectedActivity' => ['required']
			];

			$messages = [
				'selectedActivity.required' => __(':element is mandatory', ['element' => __('An activity')])
			];

			$this->validate($rules, $messages);

			$activity = Activity::findBySlug($this->selectedActivity, 'en');

			$this->professionnalActivity->activity_category_id = $activity->category->id;
			$this->professionnalActivity->activity_id = $activity->id;
		}
		elseif($this->active == 3) {
			$rules = [
				'checkedSpecies' => ['required']
			];

			$messages = [
				'checkedSpecies.required' => __(':element is mandatory', ['element' => __('A species')])
			];

			if(!$this->hasSolutionDetailsInstead) {
				$rules['checkedActivitySolutions'] = ['required'];
				$messages['checkedActivitySolutions.required'] = __(':element is mandatory', ['element' => __('An activity service or product')]);
			}

			if(!empty($this->checkedActivitySolutionDetails)) {
				foreach($this->checkedActivitySolutionDetails as $slug => $value) {
					if($slug != 'heating' && $slug != 'training-options') {
						$rules["checkedActivitySolutionDetails.$slug"] = ['required'];
						$messages["checkedActivitySolutionDetails.$slug.required"] = __(':element is mandatory', ['element' => __('This field')]);
					}
				}

				if(isset($this->checkedActivitySolutionDetails['box-type'])) {
					if(in_array('interior', $this->checkedActivitySolutionDetails['box-type'])) {
						$rules['checkedActivitySolutionDetails.heating'] = ['required'];
						$messages['checkedActivitySolutionDetails.heating.required'] = __(':element is mandatory', ['element' => __('This field')]);
					}
				}
			}

			$this->validate($rules, $messages);

			if(!empty($this->checkedActivitySolutionDetails) || $this->hasSolutionDetailsInstead) {
				if($this->professionnalActivityState == 'create') {
					if($this->professionnalActivity->activitySolutions->isNotEmpty()) $this->professionnalActivity->activitySolutions()->detach();
					
					$this->professionnalActivity->updateValue('activity_solution_details', $this->checkedActivitySolutionDetails);
				}
				elseif($this->professionnalActivityState == 'update') {
					if($this->professionnalActivity->values->get('activity_solution_details') != $this->checkedActivitySolutionDetails) {
						$this->changeHasBeenMade = true;

						$values = $this->professionnalActivity->values;
						$forModeration = $values->get('for_moderation', []);
						$forModeration['activity_solution_details'] = $this->checkedActivitySolutionDetails;
						$this->professionnalActivity->updateValue('for_moderation', $forModeration);

						session()->flash('warning', __('Your updates needs to be moderated to be displayed. The customer service will moderate your updates as soon as possible.'));
					}
				}
			}

			$this->syncPivots();
		}
		elseif($this->active == 4) {
			$rules = [
				'name' => ['required', 'min:2', 'max:255'],
				'description' => ['required'],
				'addressArray.street' => ['required'],
				'addressArray.custom_city' => ['required_without:addressArray.city_id'],
				'addressArray.city_id' => ['required_without:addressArray.custom_city'],
				'website' => ['nullable', 'url:http,https']
			];

			$messages = [
				'name.required' => __(':element is mandatory', ['element' => __('Your activity name')]),
				'name.min' => __('Your :element must be :x characters minimum', ['element' => __('Your activity name'), 'x' => 2]),
				'name.max' => __('Your :element must be :x characters maximum', ['element' => __('Your activity name'), 'x' => 255]),
				'description.required' => __(':element is mandatory', ['element' => __('Your activity\'s description')]),
				'addressArray.street.required' => __(':element is mandatory', ['element' => __('Your street')]),
				'addressArray.custom_city.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
				'addressArray.city_id.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
				'website.url' => __('An http or https url is needed'),
			];

			// Address validation sharing errors with livewire child componant Address
			if((is_null($this->addressArray['street']) || empty($this->addressArray['street'])) || (is_null($this->addressArray['custom_city']) && is_null($this->addressArray['city_id']))) $this->dispatch('address-validation-error');

			$this->validate($rules, $messages);

			if($this->professionnalActivityState == 'create') {
				$this->professionnalActivity->name = $this->name;
				$this->professionnalActivity->description = $this->description;
				$this->professionnalActivity->updateValue('website', $this->website);
				$this->professionnalActivity->updateValue('instagram', $this->instagram);
				$this->professionnalActivity->updateValue('facebook', $this->facebook);

				// The Media associated with a Mediable is taken back and transferred to the newly created professionnalActivity
				$mediablePhotos = $this->user->mediable->where('type', 'professionnal-activity-photo')->first();
				$mediaPhotos = $mediablePhotos->media;
				if($mediaPhotos->isNotEmpty()) {
					foreach($mediaPhotos as $mediaPhoto) {
						$this->professionnalActivity->addMedia($mediaPhoto->getPath())
							->usingName($mediaPhoto->name)
							->usingFileName($mediaPhoto->file_name)
							->toMediaCollection('photos');

						$mediaPhoto->delete();
					}

					$mediablePhotos->delete();
				}

				$mediableLogo = $this->user->mediable->where('type', 'professionnal-activity-logo')->first();
				$mediaLogo = $mediableLogo->media;
				if($mediaLogo->isNotEmpty()) {
					foreach($mediaLogo as $mediaLogo) {
						$this->professionnalActivity->addMedia($mediaLogo->getPath())
							->usingName($mediaLogo->name)
							->usingFileName($mediaLogo->file_name)
							->toMediaCollection('logo');

						$mediaLogo->delete();
					}

					$mediableLogo->delete();
				}
			}
			elseif($this->professionnalActivityState == 'update') {
				if(
					$this->professionnalActivity->name != $this->name ||
					$this->professionnalActivity->description != $this->description ||
					$this->professionnalActivity->values->get('website') != $this->website ||
					$this->professionnalActivity->values->get('instagram') != $this->instagram ||
					$this->professionnalActivity->values->get('facebook') != $this->facebook
				) {
					$this->changeHasBeenMade = true;
					$forModeration = $this->professionnalActivity->values->get('for_moderation', []);

					if($this->professionnalActivity->name != $this->name) $forModeration['name'] = $this->name;
					if($this->professionnalActivity->description != $this->description) $forModeration['description'] = $this->description;
					if($this->professionnalActivity->values->get('website') != $this->website) $forModeration['website'] = $this->website;
					if($this->professionnalActivity->values->get('instagram') != $this->instagram) $forModeration['instagram'] = $this->instagram;
					if($this->professionnalActivity->values->get('facebook') != $this->facebook) $forModeration['facebook'] = $this->facebook;

					$this->professionnalActivity->updateValue('for_moderation', $forModeration);
					$this->professionnalActivity->markForModeration();
				}
			}

			$this->professionnalActivity->updateValue('appointment_options', $this->appointmentOptions);
			$this->professionnalActivity->updateValue('radius_value', $this->radiusValue);
			$this->professionnalActivity->updateValue('schedule', $this->schedule);

			$this->setAddress('professionnal_activity');
		}

		$this->professionnalActivity->save();
		$this->setPublication($status);

		if($this->active < $this->totalSteps && $status == 'publish') $this->active++;
		if($this->active == $this->totalSteps) {
			$this->creditAvailable = $this->user->countCreditAvailable($this->offer->slug);

			if($this->professionnalActivityState == 'update' && $this->lastPublication->isDraftWaitingModerationForPublication()) $this->creditAvailable++;
		}
	}

	public function mount()
	{
		$this->user = Auth::guard('web')->user();
		$this->speciesList = Species::all();
		$this->activityCategoriesList = ActivityCategory::all();

		if($this->professionnalActivity->id) {
			$this->professionnalActivityState = 'update';
			$this->active = 3;

			$this->refreshLastPublication();

			$this->selectedActivity = $this->professionnalActivity->activity?->getTranslation('slug', 'en');
			$this->activityChecked();

			if(data_get($this->professionnalActivity->values, 'for_moderation.species')) $this->checkedSpecies = Species::whereIn('id', data_get($this->professionnalActivity->values, 'for_moderation.species'))->get()->map(fn ($species) => $species->getTranslation('slug', 'en'))->toArray();
			else $this->checkedSpecies = $this->professionnalActivity->species->map(fn($species) => $species->getTranslation('slug', 'en'))->toArray();

			if(data_get($this->professionnalActivity->values, 'for_moderation.activity_solutions')) $this->checkedActivitySolutions = ActivitySolution::whereIn('id', data_get($this->professionnalActivity->values, 'for_moderation.activity_solutions'))->pluck('slug')->toArray();
			else $this->checkedActivitySolutions = $this->professionnalActivity->activitySolutions->map(fn($activitySolution) => $activitySolution->slug)->toArray();

			$this->activitySolutionsChecked();

			if(data_get($this->professionnalActivity->values, 'for_moderation.activity_solution_details')) $this->checkedActivitySolutionDetails = data_get($this->professionnalActivity->values, 'for_moderation.activity_solution_details');
			else if(!empty($this->professionnalActivity->values->get('activity_solution_details'))) $this->checkedActivitySolutionDetails = $this->professionnalActivity->values->get('activity_solution_details');

			if(data_get($this->professionnalActivity->values, 'for_moderation.name')) $this->name = data_get($this->professionnalActivity->values, 'for_moderation.name');
			else $this->name = $this->professionnalActivity->name;

			if(data_get($this->professionnalActivity->values, 'for_moderation.description')) $this->description = data_get($this->professionnalActivity->values, 'for_moderation.description');
			else $this->description = $this->professionnalActivity->description;

			if(data_get($this->professionnalActivity->values, 'for_moderation.website')) $this->website = data_get($this->professionnalActivity->values, 'for_moderation.website');
			else $this->website = $this->professionnalActivity->values->get('website');

			if(data_get($this->professionnalActivity->values, 'for_moderation.instagram')) $this->instagram = data_get($this->professionnalActivity->values, 'for_moderation.instagram');
			else $this->instagram = $this->professionnalActivity->values->get('instagram');

			if(data_get($this->professionnalActivity->values, 'for_moderation.facebook')) $this->facebook = data_get($this->professionnalActivity->values, 'for_moderation.facebook');
			else $this->facebook = $this->professionnalActivity->values->get('facebook');

			$this->mediableClassLogo = ProfessionnalActivity::class;
			$this->mediableIdLogo = $this->professionnalActivity->id;
			$this->collectionLogo = 'logo';

			$this->mediableClassPhotos = ProfessionnalActivity::class;
			$this->mediableIdPhotos = $this->professionnalActivity->id;
			$this->collectionPhotos = 'photos';

			$this->appointmentOptions = $this->professionnalActivity->values->get('appointment_options') ?? [];
			$this->radiusValue = $this->professionnalActivity->values->get('radius_value') ?? [];
			$this->setScheduleOrder();
		}
		else {
			$this->professionnalActivityState = 'create';
			$this->professionnalActivity = new ProfessionnalActivity;

			if($this->user->hasRole('professionnal_breeder')) {
				if($this->user->values->get('siret')) $this->siret = $this->user->values->get('siret');
				if($this->user->values->get('company_name')) $this->companyName = $this->user->values->get('company_name');
				if($this->user->phone) $this->phone = $this->user->phone;
			}

			$this->mediableClassLogo = Mediable::class;
			$professionnalActivityMediableLogo =  Mediable::firstOrCreate([
				'user_id' => $this->user->id,
				'type' => 'professionnal-activity-logo'
			]);
			$this->mediableIdLogo = $professionnalActivityMediableLogo->id;
			$this->collectionLogo = 'logo';

			$this->mediableClassPhotos = Mediable::class;
			$professionnalActivityMediablePhotos =  Mediable::firstOrCreate([
				'user_id' => $this->user->id,
				'type' => 'professionnal-activity-photo'
			]);
			$this->mediableIdPhotos = $professionnalActivityMediablePhotos->id;
			$this->collectionPhotos = 'photos';
		}

		$this->professionnalActivityHasBeenValidated = $this->professionnalActivity->hasBeenValidated();

		if($this->professionnalActivity->address) {
			$addressCompany = $this->professionnalActivity->address()->where('collection', 'company')->first();
			$this->addressCompany = $addressCompany ? $addressCompany : new Address;

			$addressActivity = $this->professionnalActivity->address()->where('collection', 'professionnal_activity')->first();
			$this->addressActivity = $addressActivity ? $addressActivity : new Address;
		}
		else {
			if($this->user->hasRole('professionnal_breeder') && $this->user->address) $this->addressCompany = $this->user->address()->first();
			else $this->addressCompany = new Address;

			$this->addressActivity = new Address;
		}

		$this->countProfessionnalActivityPhotos();
	}

	public function render()
	{
		$this->subComponentKey++;

		return view('livewire.front.space.professionnal-activities.form');
	}
}