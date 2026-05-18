<?php

namespace App\Http\Livewire\Front\Space\Profile;

use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Enums\PublicationStates;

use App\Models\{Address, Country, User};

class CompleteMyProfile extends Component
{
	use WithFileUploads;

	public User $user;
	public Address $address;

	public $active = 1;
	public $totalSteps;
	public $userState = 'create';
	public $userHasBeenValidated = false;
	public $changesHasBeenMade = false;

	public $interestedIn;

	// Adopters
	public $placeConfiguration;
	public $homeAnimals = [];
	public $animalExperience;
	public $householdComposition = [];
	public $adoptionProject;
	public $timeDedication;

	// Breeders
	public $role;

	// Professionnal breeders
	public $siret;
	public $companyName;
	public $sirenDocument;

	// For Professionnal breeders & Individual breeders
	public $addressArray;
	public $city;
	public $identityCard;
	public $homeDocument;
	public $acacedCertificates = ['dogs' => null, 'cats' => null];
	public $endDatesAcaced = ['dogs' => null, 'cats' => null];
	public $dogsAgreement = false;
	public $catsAgreement = false;

	// For Adopters & Breeders (pro & ind)
	public $phone;

	protected function rules()
	{
		return [
			'placeConfiguration' => [],
			'homeAnimals' => [],
			'animalExperience' => [],
			'householdComposition' => [],
			'adoptionProject' => [],
			'phone' => [],
			'role' => [],
			'siret' => [],
			'companyName' => [],
			'addressArray.street' => [],
			'addressArray.city_id' => [],
			'identityCard' => [],
			'sirenDocument' => [],
			'acacedCertificates' => [],
			'endDatesAcaced' => [],
			'dogsAgreement' => [],
			'catsAgreement' => []
		];
	}

	#[On('address-selected')]
	public function addressSelected($address)
	{
		$this->addressArray = $address;
	}

	public function setAddress()
	{
		if($this->user->address()->count() > 0) {
			if($this->user->address->country->id != $this->addressArray['country_id']) {
				$this->user->address->delete();

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

				$this->user->address()->create($this->addressArray);
			}
			else $this->user->address->update($this->addressArray);
		}
		else $this->user->address()->create($this->addressArray);

		$this->address = $this->user->address()->first();
	}

	public function homeAnimalsSelected()
	{
		if(!empty($this->homeAnimals)) {
			if(end($this->homeAnimals) === 'none') {
				$this->homeAnimals = ['none'];
			}

			elseif(in_array('none', $this->homeAnimals)) {
				$this->homeAnimals = array_diff($this->homeAnimals, ['none']);
				$this->homeAnimals = array_values($this->homeAnimals);
			}
		} else {
			$this->homeAnimals = ['none'];
		}
	}

	public function goto($index)
	{
		$this->active = $index;
	}

	public function previous()
	{
		$this->active--;
	}

	public function removeIdentityCardFile(): void
	{
		$this->identityCard = null;
	}

	public function removeHomeDocumentFile(): void
	{
		$this->homeDocument = null;
	}

	public function removeSirenFile(): void
	{
		$this->sirenDocument = null;
	}

	public function removeAcacedFile(string $key): void
	{
		$this->acacedCertificates[$key] = null;
	}

	public function submitForm()
	{
		if($this->user->hasRole('adopter')) {
			if($this->active == 1) {
				$this->user->updateValue('place_configuration', $this->placeConfiguration);
				$this->user->updateValue('household_composition', $this->householdComposition);
				$this->user->updateValue('home_animals', $this->homeAnimals);
				$this->user->updateValue('interested_in', $this->interestedIn);
				$this->user->save();
			}
			elseif($this->active == 2) {
				$this->user->updateValue('adoption_project', $this->adoptionProject);
				$this->user->updateValue('animal_experience', $this->animalExperience);
				$this->user->updateValue('time_dedication', $this->timeDedication);
				$this->user->save();
			}
			elseif($this->active == 3) {
				$rules = [
					'phone' => ['nullable', 'phone:BE,FR']
				];

				$messages = [
					'phone.phone' => __('Your phone number format is invalid')
				];

				$this->validate($rules, $messages);

				$this->user->phone = $this->phone;
				$this->user->save();

				$this->setAddress();
			}
		}
		elseif($this->user->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder'])) {
			if($this->user->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder']) && $this->active == 1) {
				$rules = [
					'role' => ['required'],
					'interestedIn' => ['required'],
				];

				$messages = [
					'role.required' => __('You must select your situation'),
					'interestedIn.required' => __('You must select your situation'),
				];

				$this->validate($rules, $messages);

				if($this->userState == 'create') {
					$this->user->updateValue('interested_in', $this->interestedIn);
					$this->user->syncRoles($this->role);
				}
				elseif($this->userState == 'update') {
					if($this->user->values->get('interested_in') != $this->interestedIn) {
						$this->changesHasBeenMade = true;

						$this->user->updateValue('interested_in', $this->interestedIn);
						$this->user->updateValue('acaced_certificates', [
							'cats' => null,
							'dogs' => null
						]);
						$this->user->updateValue('end_dates_acaced', [
							'cats' => null,
							'dogs' => null
						]);
						$this->user->updateValue('agreement_EOL', [
							'cats' => false,
							'dogs' => false
						]);

						$this->user->markForModeration();

						if($company = $this->user->company) {
							if($company->isPublished()) {
								$company->publications()->create([
									'user_id' => $this->user->id,
									'subscription_id' => $company->lastPublication->subscription->id,
									'state' => PublicationStates::PublishedUpdatedWaitingModeration,
									'end_date' => $company->lastPublication->end_date
								]);
							}

							$company->breeds()->detach();
						}
					}
				}

				$this->user->save();
			}
			elseif(($this->user->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->active == 2)) {
				$rules = [
					'phone' => ['required', 'phone:BE,FR'],
					'addressArray.street' => ['required'],
					'addressArray.custom_city' => ['required_without:addressArray.city_id'],
					'addressArray.city_id' => ['required_without:addressArray.custom_city']
				];

				$messages = [
					'phone.required' => __(':element is mandatory', ['element' => __('Your phone number')]),
					'phone.phone' => __('Your phone number format is invalid'),
					'addressArray.street.required' => __(':element is mandatory', ['element' => __('Your street')]),
					'addressArray.custom_city.required_without' => __(':element is mandatory', ['element' => __('Your city')]),
					'addressArray.city_id.required_without' => __(':element is mandatory', ['element' => __('Your city')])
				];

				// Address validation sharing errors with livewire child componant Address
				if((is_null($this->addressArray['street']) || empty($this->addressArray['street'])) || (is_null($this->addressArray['custom_city']) && is_null($this->addressArray['city_id']))) $this->dispatch('address-validation-error');

				if($this->user->hasRole(['professionnal_breeder'])) {
					if($this->addressArray['country_id'] == '19') $rules['siret'] = ['required'];
					else {
						$rules['siret'] = ['required', 'numeric', 'min_digits:14', 'max_digits:14'];
						$messages['siret.min_digits'] = __('Your :element must be :x digits minimum', ['element' => __('Siret'), 'x' => 14]);
						$messages['siret.max_digits'] = __('Your :element must be :x digits maximum', ['element' => __('Siret'), 'x' => 14]);
					}

					$rules['companyName'] = ['required', 'string', 'min:2', 'max:255'];

					$messages['siret.required'] = __(':element is mandatory', ['element' => __('Your Siret number')]);
					$messages['companyName.required'] = __(':element is mandatory', ['element' => __('Your company name')]);
					$messages['companyName.min'] = __('Your :element must be :x characters minimum', ['element' => __('Your company name'), 'x' => 2]);
					$messages['companyName.max'] = __('Your :element must be :x characters maximum', ['element' => __('Your company name'), 'x' => 255]);
				}

				$this->validate($rules, $messages);

				if($this->user->hasRole(['professionnal_breeder'])) {
					if($this->userState == 'create') {
						$this->user->updateValue('siret', $this->siret);
						$this->user->updateValue('company_name', $this->companyName);
					}
					elseif($this->userState == 'update') {
						if($this->user->values->get('siret') != $this->siret || $this->user->values->get('company_name') != $this->companyName) {
							$forModeration = $this->user->values->get('for_moderation', []);

							if($this->user->values->get('siret') != $this->siret) $forModeration['siret'] = $this->siret;
							if($this->user->values->get('company_name') != $this->companyName) $forModeration['company_name'] = $this->companyName;

							$this->user->updateValue('for_moderation', $forModeration);
							$this->user->markForModeration();
						}
					}
				}

				$this->user->phone = $this->phone;
				$this->user->save();

				$this->setAddress();
			}
			elseif(($this->user->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->active == 3)) {
				$needValidation = false;

				if(($this->userHasBeenValidated && !is_null($this->identityCard)) || (!$this->userHasBeenValidated && is_null($this->user->values->get('identity_card')))) {
					$needValidation = true;

					$rules['identityCard'] = ['required', 'file', 'mimes:pdf,jpg,png', 'max:12288'];

					$messages['identityCard.required'] = __(':element is mandatory', ['element' => __('Your identity card')]);
					$messages['identityCard.file'] =  __(':element is expected', ['element' => __('A file')]);
					$messages['identityCard.mimes'] = __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']);
					$messages['identityCard.max'] = __(':size maximum', ['size' => '12mo']);
				}

				if(($this->userHasBeenValidated && !is_null($this->homeDocument)) || (!$this->userHasBeenValidated && is_null($this->user->values->get('home_document')))) {
					$needValidation = true;

					$rules['homeDocument'] = ['required', 'file', 'mimes:pdf,jpg,png', 'max:12288'];

					$messages['homeDocument.required'] = __(':element is mandatory', ['element' => __('Your home document')]);
					$messages['homeDocument.file'] =  __(':element is expected', ['element' => __('A file')]);
					$messages['homeDocument.mimes'] = __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']);
					$messages['homeDocument.max'] = __(':size maximum', ['size' => '12mo']);
				}

				if($this->user->hasRole(['professionnal_breeder'])) {
					if(($this->userHasBeenValidated && !is_null($this->sirenDocument)) || (!$this->userHasBeenValidated && is_null($this->user->values->get('siren_document')))) {
						$needValidation = true;

						$rules['sirenDocument'] = ['required', 'file', 'mimes:pdf,jpg,png', 'max:12288'];

						$messages['sirenDocument.required'] = __(':element is mandatory', ['element' => __('Your Siren document')]);
						$messages['sirenDocument.file'] =  __(':element is expected', ['element' => __('A file')]);
						$messages['sirenDocument.mimes'] = __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']);
						$messages['sirenDocument.max'] = __(':size maximum', ['size' => '12mo']);
					}

					if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'dogs') {
						if(
							($this->userHasBeenValidated && !is_null($this->acacedCertificates['dogs'])) ||
							($this->user->awaitingModeration() && !is_null($this->user->values->get('acaced_certificates')) && data_get($this->user->values, 'acaced_certificates.dogs')) ||
							!$this->userHasBeenValidated)
						{
							$needValidation = true;

							$rules['acacedCertificates.dogs'] = ['required', 'file', 'mimes:pdf,jpg,png', 'max:12288'];

							$messages['acacedCertificates.dogs.required'] = __(':element is mandatory', ['element' => __('Your dog training certificate')]);
							$messages['acacedCertificates.dogs.file'] =  __(':element is expected', ['element' => __('A file')]);
							$messages['acacedCertificates.dogs.mimes'] = __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']);
							$messages['acacedCertificates.dogs.max'] = __(':size maximum', ['size' => '12mo']);
						}

						if(
							($this->userHasBeenValidated && !is_null($this->endDatesAcaced['dogs'])) ||
							($this->user->awaitingModeration() && data_get($this->user->values, 'end_dates_acaced.dogs')) ||
							(!$this->userHasBeenValidated && data_get($this->user->values, 'end_dates_acaced.dogs'))
						) {
							$needValidation = true;

							$rules['endDatesAcaced.dogs'] = ['required', 'date'];

							$messages['endDatesAcaced.dogs.required'] = __(':element is mandatory', ['element' => __('Your dog training certificate end date')]);
							$messages['endDatesAcaced.dogs.date'] = __(':element is expected', ['element' => __('A date (dd/mm/yyyy)')]);
						}
					}

					if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'cats') {
						if(
							($this->userHasBeenValidated && !is_null($this->acacedCertificates['cats'])) ||
							($this->user->awaitingModeration() && !is_null($this->user->values->get('acaced_certificates')) && data_get($this->user->values, 'acaced_certificates.cats')) ||
							!$this->userHasBeenValidated)
						{
							$needValidation = true;

							$rules['acacedCertificates.cats'] = ['required', 'file', 'mimes:pdf,jpg,png', 'max:12288'];

							$messages['acacedCertificates.cats.required'] = __(':element is mandatory', ['element' => __('Your cat training certificate')]);
							$messages['acacedCertificates.cats.file'] =  __(':element is expected', ['element' => __('A file')]);
							$messages['acacedCertificates.cats.mimes'] = __(':element of the following format is expected : :format', ['element' => __('A file'), 'format' => 'pdf, jpg, png']);
							$messages['acacedCertificates.cats.max'] = __(':size maximum', ['size' => '12mo']);
						}

						if(
							($this->userHasBeenValidated && !is_null($this->endDatesAcaced['cats'])) ||
							($this->user->awaitingModeration() && data_get($this->user->values, 'end_dates_acaced.cats')) ||
							(!$this->userHasBeenValidated && data_get($this->user->values, 'end_dates_acaced.cats'))
						) {
							$needValidation = true;

							$rules['endDatesAcaced.cats'] = ['required', 'date'];

							$messages['endDatesAcaced.cats.required'] = __(':element is mandatory', ['element' => __('Your cat acaced certificate end date')]);
							$messages['endDatesAcaced.cats.date'] = __(':element is expected', ['element' => __('A date (dd/mm/yyyy)')]);
						}
					}
				}

				if($needValidation) {
					$this->validate($rules, $messages);

					$this->user->markForModeration();

					if(($this->userHasBeenValidated && !is_null($this->identityCard)) || !$this->userHasBeenValidated) {
						$identityCardPath = $this->identityCard->store('breedersDocuments', 'private');
						$this->user->updateValue('identity_card', $identityCardPath);
					}

					if(($this->userHasBeenValidated && !is_null($this->homeDocument)) || !$this->userHasBeenValidated) {
						$homeDocumentPath = $this->homeDocument->store('breedersDocuments', 'private');
						$this->user->updateValue('home_document', $homeDocumentPath);
					}

					if($this->user->hasRole(['professionnal_breeder'])) {
						if(($this->userHasBeenValidated && !is_null($this->sirenDocument)) || !$this->userHasBeenValidated) {
							$sirenDocumentPath = $this->sirenDocument->store('breedersDocuments', 'private');
							$this->user->updateValue('siren_document', $sirenDocumentPath);
						}

						if($this->user->hasRole('professionnal_breeder')) {
							if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'dogs') {
								if(
									($this->userHasBeenValidated && !is_null($this->acacedCertificates['dogs'])) ||
									($this->user->awaitingModeration() && !is_null($this->user->values->get('acaced_certificates')) && data_get($this->user->values, 'acaced_certificates.dogs')) ||
									!$this->userHasBeenValidated)
								{
									$acacedCertificatesPath = $this->acacedCertificates['dogs']->store('breedersDocuments', 'private');
									$this->user->updateValue('acaced_certificates.dogs', $acacedCertificatesPath);
									$this->user->updateValue('end_dates_acaced.dogs', $this->endDatesAcaced['dogs']);
								}
							}

							if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'cats') {
								if(
									($this->userHasBeenValidated && !is_null($this->acacedCertificates['cats'])) ||
									($this->user->awaitingModeration() && !is_null($this->user->values->get('acaced_certificates')) && data_get($this->user->values, 'acaced_certificates.cats')) ||
									!$this->userHasBeenValidated)
								{
									$acacedCertificatesPath = $this->acacedCertificates['cats']->store('breedersDocuments', 'private');
									$this->user->updateValue('acaced_certificates.cats', $acacedCertificatesPath);
									$this->user->updateValue('end_dates_acaced.cats', $this->endDatesAcaced['cats']);
								}
							}
						}
					}
				}
			}
			elseif($this->user->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->active == 4) {
				if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'dogs') {
					$rules['dogsAgreement'] = ['accepted'];

					$messages['dogsAgreement.accepted'] = __(':element is mandatory', ['element' => __('Your signature on the dog agreement')]);
				}

				if($this->user->values->get('interested_in') == 'both' || $this->user->values->get('interested_in') == 'cats') {
					$rules['catsAgreement'] = ['accepted'];

					$messages['catsAgreement.accepted'] = __(':element is mandatory', ['element' => __('Your signature on the cat agreement')]);
				}

				$this->validate($rules, $messages);

				$this->user->updateValue('agreement_EOL', ['dogs' => $this->dogsAgreement, 'cats' => $this->catsAgreement]);
			}
		}

		$this->user->save();

		if($this->active < $this->totalSteps) $this->active++;
		else {
			if($this->userState == 'create') session()->flash('profile_completed');
			elseif($this->userState == 'update' && $this->changesHasBeenMade) {
				session()->flash('profile_completed');
				session()->flash('company_breeds_must_be_set_again');
			}

			return redirect()->route('space.profile.dashboard');
		}
	}

	public function mount($setActiveStep = null)
	{
		$this->user = Auth::guard('web')->user();
		$this->userHasBeenValidated = $this->user->hasBeenValidated();

		if($this->user->profileCompletionPercentage() < 100 && !$this->userHasBeenValidated) $this->userState = 'create';
		else $this->userState = 'update';

		if($this->user->address) $this->address = $this->user->address()->first();
		else $this->address = new Address;

		if($this->user->hasRole(['breeder', 'professionnal_breeder', 'individual_breeder'])) {
			$this->interestedIn = $this->user->values->get('interested_in');
			$this->totalSteps = 4;

			if($this->user->hasRole('professionnal_breeder')) {
				$this->role = 'professionnal_breeder';
				$this->siret = $this->user->values->get('siret');
				$this->companyName = $this->user->values->get('company_name');
				$this->endDatesAcaced = $this->user->values->get('end_dates_acaced');
				$this->dogsAgreement = data_get($this->user->values, 'agreement_EOL.dogs');
				$this->catsAgreement = data_get($this->user->values, 'agreement_EOL.cats');
			}
			elseif($this->user->hasRole('individual_breeder')) $this->role = 'individual_breeder';
		}
		elseif($this->user->hasRole('adopter')) {
			$this->totalSteps = 3;

			$this->placeConfiguration = $this->user->values->get('place_configuration');
			$this->homeAnimals = $this->user->values->get('home_animals');
			$this->animalExperience = $this->user->values->get('animal_experience');
			$this->householdComposition = $this->user->values->get('household_composition');
			$this->adoptionProject = $this->user->values->get('adoption_project');

			if(!$this->user->values->has('time_dedication')) {
				$values = $this->user->values;
				$values->put('time_dedication', null);
				$this->user->values = $values;
				$this->user->save();
			}

			$this->timeDedication = $this->user->values->get('time_dedication');
		}

		$this->interestedIn = $this->user->values->get('interested_in');
		$this->phone = $this->user->phone;

		if(!is_null($setActiveStep)) $this->active = $setActiveStep;
		elseif($this->user->hasRole(['professionnal_breeder', 'individual_breeder'])) {
			if(!$this->interestedIn) $this->active = 1;
			else $this->active = 2;
		}
	}

	public function render()
	{
		return view('livewire.front.space.profile.complete-my-profile');
	}
}
