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

use App\Models\{Animal, Company, Country, Message, Post, Response, Role, Species, TempApplication, User};

use App\Services\BrevoService;
use App\Services\FigoService;

class ApplicationModals extends Component
{
	public Animal $animal;
	public Company $company;
	public Post $post;
	public Response $response;
	public Species $species;
	public TempApplication $contactTempApplication;
	public TempApplication $callTempApplication;
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
	public $speciesText;
	public $url;
	public $phoneNumber;
	public $breed = null;

	// Properties
	public $message;
	public $phone;
	public $contactEmail;
	public $contactPassword;
	public $contactGender;
	public $contactFirstname;
	public $contactLastname;
	public $contactPasswordConfirmation;
	public $contactCountry;
	public $contactCgu;
	public $contactOptinNewsletter = false;
	public $contactOptinReceiveInfo = false;
	public $contactOptinReceiveDeals = false;
	public $contactOptinFigo = false;

	public $callEmail;
	public $callPassword;
	public $callGender;
	public $callFirstname;
	public $callLastname;
	public $callPasswordConfirmation;
	public $callCountry;
	public $callCgu;
	public $callOptinNewsletter = false;
	public $callOptinReceiveInfo = false;
	public $callOptinReceiveDeals = false;
	public $callOptinFigo = false;

	public $alreadySent = false;

	protected function rules()
	{
		return [
			'message' => [],
			'phone' => [],
			'contactEmail' => [],
			'contactPassword' => [],
			'contactGender' => [],
			'contactFirstname' => [],
			'contactLastname' => [],
			'contactPasswordConfirmation' => [],
			'contactCountry' => [],
			'contactCgu' => [],
			'contactOptinNewsletter' => [],
			'contactOptinReceiveInfo' => [],
			'contactOptinReceiveDeals' => [],
			'contactOptinFigo' => [],
			'callEmail' => [],
			'callPassword' => [],
			'callGender' => [],
			'callFirstname' => [],
			'callLastname' => [],
			'callPasswordConfirmation' => [],
			'callCountry' => [],
			'callCgu' => [],
			'callOptinNewsletter' => [],
			'callOptinReceiveInfo' => [],
			'callOptinReceiveDeals' => [],
			'callOptinFigo' => [],
		];
	}

	#[On('openCall')]
	public function openCall()
	{
		if($this->user->exists) {
			$this->stepCall = 5;
			$this->sendPhoneNumberMessage();
		}
	}

	#[On('figo-done')]
	public function getGiftLater()
	{
		$this->dispatch('figo-close');
		$this->stepContact = 6;
	}

	public function submitAPIData(FigoService $figoService)
	{
		if(!$this->alreadySent) {
			$this->alreadySent = true;
			if($this->user->phone) $figoService->createFunnelSession($this->user, 'eol-application-modal', true);
		}
	}

	public function sendPhoneNumberMessage()
	{
		$eol = User::findBySlug('eleveurs-online');
		$messageAlreadyExists = false;

		$responseEOL = $this->user->applicants()->whereHas('from', function($whereHas) use($eol) {
				$whereHas->where('slug', $eol->slug);
			})
			->first();

		if(!$responseEOL) {
			$responseEOL = new Response;
			$responseEOL->from()->associate($eol);
			$responseEOL->to()->associate($this->user);
			$responseEOL->type = ResponseTypes::EleveursOnline;
			$responseEOL->state = ResponseStates::Closed;
			$responseEOL->save();
		}
		else {
			$messageAlreadyExists = Message::where('user_id', $eol->id)
				->whereHas('company', function($whereHas) {
					$whereHas->where('slug', $this->company->slug);
				})
				->where('thread_id', $responseEOL->thread->id)
				->exists();
		}

		if(!$messageAlreadyExists) {
			$newMessage = new Message;
			$newMessage->thread_id = $responseEOL->thread->id;
			$newMessage->user_id = $responseEOL->from->id;
			$newMessage->body = 'Bonjour '.$responseEOL->to->firstname.',<br/><br/>

				Vous avez demandé à obtenir le numéro de téléphone de l’éleveur '.$this->company->user->name.' et le voici : <br/>
				👉 '.$this->phoneNumber.'<br/><br/>

				💬 Petit conseil : vous pouvez aussi lui poser vos questions via la messagerie interne.<br/>
				Cela lui permet de garder une trace de votre demande et de vous répondre plus facilement.<br/><br/>

				Nous vous souhaitons une belle prise de contact et, on l’espère, une magnifique rencontre à venir !<br/><br/>

				<b>L’équipe Éleveurs Online 🐶🐱</b>';
			$newMessage->automated = true;
			$newMessage->company_id = $this->company->id;
			$newMessage->save();
		}
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
				'callEmail' => ['required', 'string', 'lowercase', 'email']
			];

			$messages = [
				'callEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'callEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'callEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')])
			];

			$this->validate($rules, $messages);

			if($this->user->exists) $this->stepCall = 5;
			else {
				$userFound = User::where('email', $this->callEmail)
					->first();

				if($userFound) $this->stepCall = 2;
				else $this->stepCall = 3;
			}
		}
		elseif($this->stepCall == 2) {
			$rules = [
				'callEmail' => ['required', 'string', 'lowercase', 'email'],
				'callPassword' => ['required']
			];

			$messages = [
				'callEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'callEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'callEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')]),
				'callPassword.required' => __(':element is mandatory', ['element' => __('The password')]),
			];

			$this->validate($rules, $messages);

			$email = strtolower($this->callEmail);
			$user = User::where('email', $email)
				->orWhere('code', $this->callEmail)
				->first();

			if(!$user || ($user->code !== $this->callEmail && $user->email !== $email) || ! Hash::check($this->callPassword, $user->password)) {
				throw ValidationException::withMessages([
					'callEmail' => trans('auth.failed'),
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
			$rules = [
				'callGender' => ['required'],
				'callFirstname' => ['required', 'string', 'min:2', 'max:125'],
				'callLastname' => ['required', 'string', 'min:2', 'max:125'],
				'callEmail' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class.',email'],
				'callPassword' => ['required', 'same:callPasswordConfirmation', Password::min(8)->mixedCase()->letters()->numbers()->symbols()->uncompromised()],
				'callCountry' => ['required'],
				'callCgu' => ['required']
			];

			$messages = [
				'callGender.required' => __(':element is mandatory', ['element' => __('The gender')]),
				'callFirstname.required' => __(':element is mandatory', ['element' => __('The firstname')]),
				'callFirstname.string' => __('There can\'t be any numerals in your :element', ['element' => __('firstname')]),
				'callFirstname.min' => __('Your :element must be :x caracters minimum', ['element' => __('firstname'), 'x' => 2]),
				'callFirstname.max' => __('Your :element must be :x caracters maximum', ['element' => __('firstname'), 'x' => 125]),
				'callLastname.required' => __(':element is mandatory', ['element' => __('The lastname')]),
				'callLastname.string' => __('There can\'t be any numerals in your :element', ['element' => __('lastname')]),
				'callLastname.min' => __('Your :element must be :x caracters minimum', ['element' => __('lastname'), 'x' => 2]),
				'callLastname.max' => __('Your :element must be :x caracters maximum', ['element' => __('lastname'), 'x' => 125]),
				'callEmail.required' => __(':element is mandatory', ['element' => __('The email')]),
				'callEmail.email' => __(':element is expected', ['element' => __('An email')]),
				'callEmail.lowercase' => __('Your :element must be in lowercase', ['element' => __('email')]),
				'callEmail.max' => __('Your :element must be :x caracters maximum', ['element' => __('email'), 'x' => 255]),
				'callEmail.unique' => __('An account already exists with this email'),
				'callPassword.required' => __(':element is mandatory', ['element' => __('The password')]),
				'callPassword.same' => __('Both password don\'t match'),
				'callPassword.min' => __('The password must contain at least :min characters', ['min' => 8]),
				'callCountry.required' => __(':element is mandatory', ['element' => __('The country')]),
				'callCgu.required' => __('You must accept the terms of use')
			];

			$this->validate($rules, $messages);

			$this->user = new User;
			$this->user->gender = $this->callGender;
			$this->user->name = $this->callFirstname.' '.$this->callLastname;
			$this->user->firstname = $this->callFirstname;
			$this->user->lastname = $this->callLastname;
			$this->user->email = $this->callEmail;
			$this->user->password = Hash::make($this->callPassword);
			$this->user->save();

			$this->user->assignRole('adopter');

			$this->user->initValues();

			$optinValues = $this->user->values->get('optins');
			$optinsValues['optin_newsletter'] = $this->callOptinNewsletter ? 1 : 0;
			$optinsValues['optin_receive_info'] = $this->callOptinReceiveInfo ? 1 : 0;
			$optinsValues['optin_receive_deals'] = $this->callOptinReceiveDeals ? 1 : 0;
			$optinsValues['optin_figo'] = $this->callOptinFigo ? 1 : 0;

			$this->user->updateValue('optins', $optinValues);
			$this->user->save();

			$country = Country::where('iso_code', $this->callCountry)
				->first();

			if($country) {
				$this->user->address()->create([
					'country_id' => $country->id
				]);
			}

			try {
				$brevoService = new BrevoService;
				$attributes= [];

				if($this->callOptinNewsletter) $attributes['OPTIN_NL_ADOPTANT'] = 1;
				if($this->callOptinReceiveInfo) $attributes['OPTIN_MARKETING_ADOPTANT'] = 1;
				if($this->callOptinReceiveDeals) $attributes['OPTIN_PARTENAIRE_ADOPTANT'] = 1;

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
				$figoService->createFunnelSession($this->user, 'eol-register-from-call-modal-form');
			}

			event(new Registered($this->user));

			$callTempApplicationExists = TempApplication::where('email', $this->callEmail)
				->where('element', $this->element->slug)
				->where('type', ContactTypes::Call)
				->latest()
				->first();

			if($callTempApplicationExists) $this->callTempApplication = $callTempApplicationExists;
			else {
				$newTempApplication = new TempApplication;
				$newTempApplication->email = $this->callEmail;
				$newTempApplication->message = $this->message;
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

				$callTempApplicationExists = TempApplication::where('email', $this->callEmail)
					->where('element', $this->element->slug)
					->where('type', ContactTypes::Call)
					->latest()
					->first();

				if($callTempApplicationExists) $this->callTempApplication = $callTempApplicationExists;
				else {
					$newTempApplication = new TempApplication;
					$newTempApplication->email = $this->callEmail;
					$newTempApplication->message = $this->message;
					$newTempApplication->url = $this->url;
					$newTempApplication->element = $this->element->slug;
					$newTempApplication->type = ContactTypes::Call->value;
					$newTempApplication->save();

					$this->contactTempApplication = $newTempApplication;
				}

				$this->stepCall = 5;
				$this->sendPhoneNumberMessage();
			}
		}
	}

	public function sendNumberByEmail()
	{
		$brevoService = new BrevoService();
		$details['recipient'] = $this->callEmail;
		$details['subject'] = 'Le numéro de l’éleveur – et un petit conseil pour la suite 🐾';
		$details['body'] = 'Bonjour,<br/><br/>

			Vous avez demandé à obtenir le numéro de téléphone de l’éleveur '.$this->company->name.', et le voici :
			👉 '.$this->phoneNumber.'<br/><br/>

			C’est la personne qui pourra répondre à vos questions concernant votre projet d’adoption.<br/><br/>

			💡 Un petit plus pour vous aider dans votre démarche<br/><br/>

			Vous n’avez pas créé de compte sur Éleveurs Online, mais sachez qu’en le faisant :<br/><br/>
			- vous pourrez contacter les éleveurs directement via la messagerie interne,<br/>
			- recevoir des réponses plus facilement,<br/>
			- et profiter d’une expérience d’adoption plus simple et mieux organisée.<br/><br/>

			Créer un compte ne prend que quelques instants :<br/>
			👉 '.route('register').'<br/><br/>

			Nous vous souhaitons une belle prise de contact et, pourquoi pas, une magnifique rencontre à venir 🐶🐱<br/><br/>

		<b>L’équipe Éleveurs Online 🐶🐱</b>';

		$brevoService->sendTransactionalEmail($details['recipient'], $details, ['demande_tel_non_inscrit'], []);

		$this->stepCall = 6;
	}

	public function mount()
	{
		if($this->element instanceof Post) {
			$this->post = $this->element;
			$this->company = $this->post->model->company;
			$this->species = $this->post->model->species;
			$this->url = route('post-search.post.show', ['company' => $this->company->slug, 'post' => $this->post->slug, 'breed' => $this->post->model->breed->slug]);
			$this->breed = $this->post->model->breed;
		}
		elseif($this->element instanceof Animal) {
			$this->animal = $this->element;
			$this->company = $this->animal->company;
			$litters = $this->animal->litters;
			$this->species = $this->animal->species;
			$this->post = $litters->isNotEmpty() ? $this->animal->getPostFromLitter() : $this->animal->post;
			$this->url = route('animal-search.animal.show', ['company' => $this->company->slug, 'post' => $this->post->slug, 'breed' => $this->animal->breed->slug, 'animal' => $this->animal->id, 'type' => ($this->species->getTranslation('slug', 'en') == 'cat' ? __('kitten') : __('puppy')), 'sex' => Str::slugify(__($this->animal->getSex()))]);
			$this->breed = $this->animal->breed;
		}

		$this->phoneNumber = $this->post->user->phone;

		if(Auth::guard('web')->check()) {
			$this->user = Auth::guard('web')->user();
			$this->contactEmail = $this->user->email;
			$this->callEmail = $this->user->email;
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
