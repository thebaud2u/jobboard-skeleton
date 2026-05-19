<?php

namespace App\Http\Livewire\Front;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Auth\Events\Registered;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Enums\{ResponseStates, ResponseTypes, ContactTypes};

use App\Models\{Company, Contact, Country, Message, Post, Response, Role, User};

use App\Services\BrevoService;

class ApplicationModals extends Component
{
	public Company $company;
	public Contact $contact;
	public Post $post;
	public Response $response;
	public Species $species;
	public User $user;

	public $element;
	public $hasApplyied = false;
	public $showModal = true;
	public $stepContact = 1;
	public $stepCall = 1;
	public $hasJustVerifiedEmailForContact = false;
	public $loginReloadForContact = false;
	public $hasJustVerifiedEmailForCall = false;
	public $loginReloadForCall = false;
	public $url;
	public $phoneNumber;

	// Properties
	public $message;
	public $phone;
	public $email;
	public $password;

	public $alreadySent = false;

	protected function rules()
	{
		return [
			'message' => [],
			'phone' => [],
			'email' => [],
			'password' => []
		];
	}

	#[On('openCall')]
	public function openCall()
	{
		if($this->user->exists) $this->stepCall = 5;
	}

	public function continueToForm()
	{
		$rules = [
			'phone' => ['required', 'phone:BE,FR']
		];

		$messages = [
			'phone.required' => __(':element is mandatory', ['element' => __('Your phone number')]),
			'phone.phone' => __('Your phone number format is invalid'),
		];

		$this->validate($rules, $messages);

		$this->user->phone = $this->phone;
		$this->user->save();

		return redirect()->route('space.responses.create', ['element' => $this->element->slug]);
	}

	public function formContact()
	{
		// message + email step, checking if email is associated to an existing user
		// if it is, he's pushed to step 2
		// if not, he's pushed to step 3
		if($this->stepContact == 1) {
			$rules = [
				'message' => ['required'],
				'contactEmail' => ['required', 'string', 'lowercase', 'email']
			];

			$messages = [
				'message.required' => __(':element is mandatory', ['element' => __('The message')]),
				'contactEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'contactEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'contactEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')])
			];

			$this->validate($rules, $messages);

			$tempApplicationExists = TempApplication::where('email', $this->contactEmail)
				->where('element', $this->element->slug)
				->where('type', ContactTypes::Contact)
				->latest()
				->first();

			if($tempApplicationExists) $this->contactTempApplication = $tempApplicationExists;
			else {
				$newTempApplication = new TempApplication;
				$newTempApplication->email = $this->contactEmail;
				$newTempApplication->message = $this->message;
				$newTempApplication->url = $this->url;
				$newTempApplication->element = $this->element->slug;
				$newTempApplication->save();

				$this->contactTempApplication = $newTempApplication;
			}

			if($this->user->exists) $this->stepContact = 5;
			else {
				$userFound = User::where('email', $this->contactEmail)
					->first();

				if($userFound) $this->stepContact = 2;
				else $this->stepContact = 3;
			}
		}
		// Step to login the user from the given email address
		// In order to properly log the user in, we must refresh the page so we put the auto opening of the modal in session and we refresh if the user has validated his account
		// if the user account is not yet verified, we show step 4
		elseif($this->stepContact == 2) {
			$rules = [
				'message' => ['required'],
				'contactEmail' => ['required', 'string', 'lowercase', 'email'],
				'contactPassword' => ['required']
			];

			$messages = [
				'message.required' => __(':element is mandatory', ['element' => __('The message')]),
				'contactEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'contactEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'contactEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')]),
				'contactPassword.required' => __(':element is mandatory', ['element' => __('The password')])
			];

			$this->validate($rules, $messages);

			$email = strtolower($this->contactEmail);
			$user = User::where('email', $email)
				->orWhere('code', $this->contactEmail)
				->first();

			if(!$user || ($user->code !== $this->contactEmail && $user->email !== $email) || ! Hash::check($this->contactPassword, $user->password)) {
				throw ValidationException::withMessages([
					'contactEmail' => trans('auth.failed'),
				]);
			}
			else {
				$this->user = $user;
				Auth::guard('web')->login($this->user);
				$this->user->last_logon = Carbon::now();
				$this->user->save();
			}

			if($this->user->hasVerifiedEmail()) {
				session()->put('application-modals.login-reload-for-contact', true);
				$this->redirect($this->url);
			}
			else $this->stepContact = 4;
		}
		// Account creation step
		elseif($this->stepContact == 3) {
			$rules = [
				'contactGender' => ['required'],
				'contactFirstname' => ['required', 'string', 'min:2', 'max:125'],
				'contactLastname' => ['required', 'string', 'min:2', 'max:125'],
				'contactEmail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email'],
				'contactPassword' => ['required', 'same:contactPasswordConfirmation', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
				'contactCountry' => ['required'],
				'contactCgu' => ['required']
			];

			$messages = [
				'contactGender.required' => __(':element is mandatory', ['element' => __('The gender')]),
				'contactFirstname.required' => __(':element is mandatory', ['element' => __('The firstname')]),
				'contactFirstname.string' => __('There can\'t be any numerals in your :element', ['element' => __('firstname')]),
				'contactFirstname.min' => __('Your :element must be :x caracters minimum', ['element' => __('firstname'), 'x' => 2]),
				'contactFirstname.max' => __('Your :element must be :x caracters maximum', ['element' => __('firstname'), 'x' => 125]),
				'contactLastname.required' => __(':element is mandatory', ['element' => __('The lastname')]),
				'contactLastname.string' => __('There can\'t be any numerals in your :element', ['element' => __('lastname')]),
				'contactLastname.min' => __('Your :element must be :x caracters minimum', ['element' => __('lastname'), 'x' => 2]),
				'contactLastname.max' => __('Your :element must be :x caracters maximum', ['element' => __('lastname'), 'x' => 125]),
				'contactEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'contactEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'contactEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')]),
				'contactEmail.max' => __('Your :element must be :x caracters maximum', ['element' => __('email'), 'x' => 255]),
				'contactEmail.unique' => __('An account already exists with this email'),
				'contactPassword.required' => __(':element is mandatory', ['element' => __('The password')]),
				'contactPassword.same' => __('Both password don\'t match'),
				'contactPassword.min' => __('The password must contain at least :min characters', ['min' => 8]),
				'contactCountry.required' => __(':element is mandatory', ['element' => __('The country')]),
				'contactCgu.required' => __('You must accept the terms of use')
			];

			$this->validate($rules, $messages);

			$this->user = new User;
			$this->user->gender = $this->contactGender;
			$this->user->name = $this->contactFirstname.' '.$this->contactLastname;
			$this->user->firstname = $this->contactFirstname;
			$this->user->lastname = $this->contactLastname;
			$this->user->email = $this->contactEmail;
			$this->user->password = Hash::make($this->contactPassword);
			$this->user->save();

			$this->user->assignRole('adopter');

			$this->user->initValues();

			$optinValues = $this->user->values->get('optins');
			$optinsValues['optin_newsletter'] = $this->contactOptinNewsletter ? 1 : 0;
			$optinsValues['optin_receive_info'] = $this->contactOptinReceiveInfo ? 1 : 0;
			$optinsValues['optin_receive_deals'] = $this->contactOptinReceiveDeals ? 1 : 0;
			$optinsValues['optin_figo'] = $this->contactOptinFigo ? 1 : 0;

			$this->user->updateValue('optins', $optinValues);
			$this->user->save();

			$country = Country::where('iso_code', $this->contactCountry)
				->first();

			if($country) {
				$this->user->address()->create([
					'country_id' => $country->id
				]);
			}

			try {
				$brevoService = new BrevoService;
				$attributes= [];

				if($this->contactOptinNewsletter) $attributes['OPTIN_NL_ADOPTANT'] = 1;
				if($this->contactOptinReceiveInfo) $attributes['OPTIN_MARKETING_ADOPTANT'] = 1;
				if($this->contactOptinReceiveDeals) $attributes['OPTIN_PARTENAIRE_ADOPTANT'] = 1;

				$result = $brevoService->addContactToList(
					$this->user->email,
					[9],
					$attributes
				);
			} catch (Exception $e) {
				Log::error('erreur création optin');
			}

			if($this->user->values->get('optins.optin_figo') === 1) {
				$figoService = new FigoService;
				$figoService->createFunnelSession($this->user, 'eol-register-from-contact-modal-form');
			}

			event(new Registered($this->user));

			$this->stepContact = 4;
		}
		elseif($this->stepContact == 4) {
			// the account is verified, the user is pushed to step 5
			if($this->user->exists && $this->user->hasVerifiedEmail()) $this->stepContact = 5;
		}
		// the user has the choice between creating the response without answering further questions, if it's the case, we create the response here.
		// if not, the user is redirected via the button to the response form.
		elseif($this->stepContact == 5) {
			$rules = [
				'phone' => ['required', 'phone:BE,FR']
			];

			$messages = [
				'phone.required' => __(':element is mandatory', ['element' => __('Your phone number')]),
				'phone.phone' => __('Your phone number format is invalid'),
			];

			$this->validate($rules, $messages);

			$this->user->phone = $this->phone;
			$this->user->save();

			$values = new Collection();
			$values->put('message', $this->contactTempApplication->message)
				->put('archive', collect(['asking' => false, 'answerer' => false]))
				->put('part_confirmation', collect(['asking' => false, 'answerer' => false]));

			$this->response = new Response;
			$this->response->model()->associate($this->element);
			$this->response->from()->associate($this->user);
			$this->response->to()->associate($this->post->model->company->user);
			$this->response->values = $values;
			$this->response->type = ResponseTypes::Application;
			$this->response->save();

			$this->contactTempApplication->delete();
			$this->contactTempApplication = new TempApplication;

			if($this->post->type->getTranslation('slug', 'en') == 'retired-breeder' || $this->post->type->getTranslation('slug', 'en') == 'stud') $this->speciesText = $this->species->name;
			else {
				if($this->species->getTranslation('slug', 'en') == 'dog') $this->speciesText = 'puppy';
				elseif($this->species->getTranslation('slug', 'en') == 'cat') $this->speciesText = 'kitty';
			}

			$this->dispatch('figo-show');
		}
	}

	public function formCall()
	{
		if($this->stepCall == 1) {
			$rules = [
				'email' => ['required', 'string', 'lowercase', 'email']
			];

			$messages = [
				'email.required' => __(':element is mandatory', ['element' => __('The email')]),
				'email.email' => __(':element is expected', ['element' => __('An email')]),
				'email.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')])
			];

			$this->validate($rules, $messages);

			if($this->user->exists) $this->stepCall = 5;
			else {
				$email = strtolower($this->email);
				$userFound = User::where('email', $email)
					->first();

				if($userFound) $this->stepCall = 2;
				else $this->stepCall = 3;
			}
		}
		elseif($this->stepCall == 2) {
			$rules = [
				'email' => ['required', 'string', 'lowercase', 'email'],
				'password' => ['required']
			];

			$messages = [
				'email.required' => __(':element is mandatory', ['element' => __('The email')]),
				'email.email' => __(':element is expected', ['element' => __('An email')]),
				'email.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')]),
				'password.required' => __(':element is mandatory', ['element' => __('The password')]),
			];

			$this->validate($rules, $messages);

			$email = strtolower($this->email);
			$userFound = User::where('email', $email)
				->first();

			if(!$userFound || !Hash::check($this->password, $user->password)) {
				throw ValidationException::withMessages([
					'email' => trans('auth.failed'),
				]);
			}
			else {
				$this->user = $user;
				Auth::guard('web')->login($this->user);
				$this->user->last_logon = Carbon::now();
				$this->user->save();
			}

			if($this->user->hasVerifiedEmail()) {
				session()->put('application-modals.login-reload-for-call', true);
				$this->redirect($this->url);
			}
			else $this->stepCall = 4;
		}
		elseif($this->stepCall == 3) {
			$callTempApplicationExists = TempApplication::where('email', $this->callEmail)
				->where('element', $this->element->slug)
				->where('type', ContactTypes::Call)
				->latest()
				->first();

			if($callTempApplicationExists) $this->callTempApplication = $callTempApplicationExists;
			else {
				$newTempApplication = new TempApplication;
				$newTempApplication->email = strtolower($this->email);
				$newTempApplication->url = $this->url;
				$newTempApplication->element = $this->element->slug;
				$newTempApplication->type = ContactTypes::Call->value;
				$newTempApplication->save();

				$this->contactTempApplication = $newTempApplication;
			}

			$this->stepCall = 4;
		}
		elseif($this->stepCall == 4) {
			if($this->user->exists && $this->user->hasVerifiedEmail()) {

				$email = strtolower($this->email);
				$callTempApplicationExists = TempApplication::where('email', $email)
					->where('element', $this->element->slug)
					->where('type', ContactTypes::Call)
					->latest()
					->first();

				if($callTempApplicationExists) $this->callTempApplication = $callTempApplicationExists;
				else {
					$newTempApplication = new TempApplication;
					$newTempApplication->email = strtolower($this->email);
					$newTempApplication->url = $this->url;
					$newTempApplication->element = $this->element->slug;
					$newTempApplication->type = ContactTypes::Call->value;
					$newTempApplication->save();

					$this->contactTempApplication = $newTempApplication;
				}

				$this->stepCall = 5;
			}
		}
	}

	public function mount()
	{
		if($this->element instanceof Post) {
			$this->post = $this->element;
			$this->company = $this->post->model->company;
			$this->url = route('post-search.post.show', ['company' => $this->company->slug, 'post' => $this->post->slug]);
		}

		$this->phoneNumber = $this->post->user->phone;

		if(Auth::guard('web')->check()) {
			$this->user = Auth::guard('web')->user();
			$this->email = $this->user->email;
			$this->phone = $this->user->phone;

			if((
				(Auth::guard('web')->user()->hasRole('adopter') && ($this->post->type->getTranslation('slug', 'en') == 'litter' || $this->post->type->getTranslation('slug', 'en') == 'litter-yet-to-come' || $this->post->type->getTranslation('slug', 'en') == 'retired-breeder')) ||
				(Auth::guard('web')->user()->hasRole(['professionnal_breeder', 'individual_breeder']) && $this->post->type->getTranslation('slug', 'en') == 'stud')
			) && Auth::guard('web')->user()->id != $this->post->user->id && !$this->hasApplyied) $this->showModal = true;
			else $this->showModal = false;
		}
		else $this->user = new User;

		if($this->user->exists) {
			$tempApplicationContactExists = TempApplication::where('email', $this->user->email)
				->where('element', $this->element->slug)
				->where('type', ContactTypes::Contact)
				->latest()
				->first();

			if($tempApplicationContactExists && $this->user->hasVerifiedEmail()) {
				$this->contactTempApplication = $tempApplicationContactExists;
				$this->stepContact = 5;
			}

			$this->stepCall = 5;

			if(
				(session()->has('application-modals.email-verified-just-now-for-contact') && session()->get('application-modals.email-verified-just-now-for-contact') === true) ||
				(session()->has('application-modals.login-reload-for-contact') && session()->get('application-modals.login-reload-for-contact') === true) ||
				(session()->has('application-modals.email-verified-just-now-for-call') && session()->get('application-modals.email-verified-just-now-for-call') === true) ||
				(session()->has('application-modals.login-reload-for-call') && session()->get('application-modals.login-reload-for-call') === true)
			) {
				if(session()->get('application-modals.email-verified-just-now-for-contact') === true) $this->hasJustVerifiedEmailForContact = true;
				elseif(session()->get('application-modals.login-reload-for-contact') === true) $this->loginReloadForContact = true;
				elseif(session()->get('application-modals.email-verified-just-now-for-call') === true) {
					$this->hasJustVerifiedEmailForCall = true;
					$this->sendPhoneNumberMessage();
				}
				elseif(session()->get('application-modals.login-reload-for-call') === true) {
					$this->loginReloadForCall = true;
					$this->sendPhoneNumberMessage();
				}
			}

			if(session()->has('application-modals.email-verified-just-now-for-contact')) session()->forget('application-modals.email-verified-just-now-for-contact');
			if(session()->has('application-modals.login-reload-for-contact')) session()->forget('application-modals.login-reload-for-contact');
			if(session()->has('application-modals.email-verified-just-now-for-call')) session()->forget('application-modals.email-verified-just-now-for-call');
			if(session()->has('application-modals.login-reload-for-call')) session()->forget('application-modals.login-reload-for-call');
		}
	}

	public function render()
	{
		return view('livewire.front.application-modals');
	}
}
