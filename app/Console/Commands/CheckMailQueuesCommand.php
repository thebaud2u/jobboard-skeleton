<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Enums\{AnimalStates, MailQueueStates};

use App\Models\{Animal, Litter, MailQueue, Message, Post, Response};

class CheckMailQueuesCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'check:mail_queues';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check for active mailQueues to send automated message in response thread';

	public $mailQueue = null;

	public function markMailQueueAsDone()
	{
		$this->mailQueue->state = MailQueueStates::Done;
		$this->mailQueue->save();
	}

	public function addMessage(string $body) {
		$newMessage = new Message;
		$newMessage->thread_id = $this->mailQueue->response->thread->id;
		$newMessage->user_id = $this->mailQueue->user->id;
		$newMessage->body = $body;
		$newMessage->automated = true;
		$newMessage->save();

		$partArchive = collect($this->mailQueue->response->values->get('archive'));
		$partArchive->put('asking', true);
		$this->mailQueue->response->updateValue('archive', $partArchive);
		$this->mailQueue->response->saveQuietly();
	}

	public function checkUpAndQuestions(): void
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$lastLife = $animal->lastLife;

			if($lastLife && $lastLife->state == AnimalStates::Adopted) {
				$now = Carbon::now()->startOfDay();
				$weeksSince = $lastLife->created_at->diffInWeeks($now);

				if($weeksSince == 3) {
					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

					Cela fait déjà trois semaines que '.$animal->name.' a rejoint votre foyer ❤️<br/>
					Comment ça se passe ? Avez-vous des questions, des doutes, ou besoin de conseils ?<br/>
					👉 Contactez-nous si besoin !<br/><br/>

					À très bientôt,<br/><br/>

					Elevage '.$this->mailQueue->user->company->name;

					$this->addMessage($body);

					$this->markMailQueueAsDone();
				}
			}
		}
	}

	public function reminderVaccine(string $number)
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$now = Carbon::now()->startOfDay();
			$birthDate = Carbon::parse($animal->values->get('birth_date'));

			if($number == 'first') {
				$weeksSince = $birthDate->diffInWeeks($now);
				$condition = $weeksSince == 12;
			}
			elseif($number == 'second') {
				$yearSince = $birthDate->diffInYears($now);
				$condition = $yearSince == 1;
			}

			if($condition) {
				if($number == 'first') {
					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

						'.$animal->name.' a maintenant 12 semaines ! 🐾<br/>
						C’est le moment de prendre rendez-vous pour son rappel vaccinal, étape clé pour le protéger.<br/>
						Il faudra ensuite prévoir un rendez-vous pour le dernier rappel à 16 semaines.<br/>
						Si ce n’est pas déjà fait, contactez votre vétérinaire dès maintenant.<br/><br/>

						👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <b><a href="'.route('article.show', ['article' => 'rendez-veterinaire-adoption-indispensable']).'">ici</a></b><br/><br/>

						À bientôt,<br/><br/>

						Elevage '.$this->mailQueue->user->company->name;
				}
				elseif($number == 'second') {
					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

						'.$animal->name.' aura prochainement 1 an ! 🐾<br/>
						C’est le moment de prendre rendez-vous pour son rappel vaccinal, étape clé pour le protéger.<br/>
						Si ce n’est pas déjà fait, contactez votre vétérinaire dès maintenant.<br/><br/>

						👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <b><a href="'.route('article.show', ['article' => 'rendez-veterinaire-adoption-indispensable']).'">ici</a></b><br/><br/>

						À bientôt,<br/><br/>

						Elevage '.$this->mailQueue->user->company->name;
				}

				$this->addMessage($body);

				$this->markMailQueueAsDone();
			}
		}
	}

	public function reminderDeworming(string $number)
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$now = Carbon::now()->startOfDay();
			$birthDate = Carbon::parse($animal->values->get('birth_date'));
			$lastSent = $this->mailQueue->last_sent;
			$condition = false;


			if($number == 'first') {
				$limit = $birthDate->diffInMonths($now);

				if(is_null($lastSent)) $condition = true;
				else {
					$monthSinceLastSent = $now->diffInMonths($lastSent);
					$condition = $monthSinceLastSent == 1;
				}
			}
			elseif($number == 'second') {
				$limit = $birthDate->diffInYears($now);

				if(is_null($lastSent)) $condition = $birthDate->diffInMonths($now) == 6;
				else {
					$monthSinceLastSent = $now->diffInMonths($lastSent);
					$condition = $monthSinceLastSent == 3;
				}
			}

			if($condition) {
				if($number == 'first') {
					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

					Pour rester en pleine forme, '.$animal->name.' a besoin d’un vermifuge tous les mois jusqu’à ses 6 mois.<br/>
					Si vous avez un doute sur le produit ou la dose à utiliser, n’hésitez pas à demander conseil à votre vétérinaire.<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <b><a href="'.route('article.show', ['article' => 'vermifuges-chiots-chatons-proteger-animal-famille-parasites']).'">ici</a></b><br/><br/>

					À bientôt,<br/><br/>

					Elevage '.$this->mailQueue->user->company->name;
				}
				elseif($number == 'second') {
					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

					Petit rappel bien utile : '.$animal->name.' doit être vermifugé tous les 3 mois ou selon les recommandations de votre vétérinaire.<br/>
					Un geste simple pour sa santé, et pour la vôtre.<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <b><a href="'.route('article.show', ['article' => 'vermifuges-chiots-chatons-proteger-animal-famille-parasites']).'">ici</a></b><br/><br/>

					À bientôt,<br/><br/>

					Elevage '.$this->mailQueue->user->company->name;
				}

				$this->addMessage($body);

				if(($number == 'first' && $limit == 6) || ($number == 'second' && $limit == 3)) $this->markMailQueueAsDone();

				$this->mailQueue->last_sent = Carbon::now();
				$this->mailQueue->save();
			}
		}
	}

	public function foodChangeTransition()
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$now = Carbon::now()->startOfDay();
			$birthDate = Carbon::parse($animal->values->get('birth_date'));

			if($this->mailQueue->frequency == '12-months') {
				$monthsSince = $birthDate->diffInMonths($now);
				$condition = $monthsSince == 12;
				$frequency = '12 mois';
			}
			elseif($this->mailQueue->frequency == '15-months') {
				$monthsSince = $birthDate->diffInMonths($now);
				$condition = $monthsSince == 15;
				$frequency = '15 mois';
			}

			if($condition) {
				$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

				À cette période, '.$animal->name.' termine sa croissance. 🐾<br/>
				C’est le bon moment pour envisager une transition vers une alimentation adulte.<br/>
				Nous recommandons de commencer à partir de '.$frequency.'.<br/><br/>

				👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos nutrition <b><a href="'.route('article.show', ['article' => 'reussir-transition-alimentaire-chiot-chaton']).'">ici</a></b><br/><br/>

				À bientôt,<br/><br/>

				Elevage '.$this->mailQueue->user->company->name;
			
				$this->addMessage($body);

				$this->markMailQueueAsDone();
			}
		}
	}

	public function castrationSterilization()
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$now = Carbon::now()->startOfDay();
			$birthDate = Carbon::parse($animal->values->get('birth_date'));
			$monthsSince = $birthDate->diffInMonths($now);

			if($monthsSince == 6) {
				$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

				'.$animal->name.' approche de ses 6 mois ! 🐾<br/>
				C’est généralement le moment de discuter de stérilisation/castration avec votre vétérinaire.<br/>
				Cette décision dépend de plusieurs facteurs : race, santé, comportement, mode de vie et peut nécessiter une adaptation alimentaire.<br/><br/>

				👉 Eleveurs Online vous explique tout <b><a href="'.route('article.show', ['article' => 'castration-sterilisation-chien-chat-faut-savoir-decider']).'">ici</a></b><br/><br/>

				À bientôt,<br/><br/>

				Elevage '.$this->mailQueue->user->company->name;

				$this->addMessage($body);

				$this->markMailQueueAsDone();
			}
		}
	}

	public function firstSummer()
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$lastLife = $animal->lastLife;

			if($lastLife && $lastLife->state == AnimalStates::Adopted) {
				$summerFollowingAdoption = $lastLife->created_at->copy()->setMonth(6)->setDay(15)->addYear();

				if(Carbon::now()->isSameDay($summerFollowingAdoption)) {
					if($animal->species->getTranslation('slug', 'en') == 'cat') $link = route('article.show', ['article' => 'partir-vacances-chat-cles-sejour-reussi']);
					elseif($animal->species->getTranslation('slug', 'en') == 'dog') $link = route('article.show', ['article' => 'premieres-vacances-chien-preparer-voyager-esprit-tranquille']);

					$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

					C’est bientôt l’été 🌞 et peut-être les premières vacances de '.$animal->name.' !<br/>
					Transport, hébergement, sécurité, baignade… vous vous demandez comment partir sereinement avec votre animal.<br/><br/>

					👉 Consultez la rubrique dédiée sur Eleveurs Online <b><a href="'.$link.'">ici</a></b><br/><br/>

					À bientôt,<br/><br/>

					Elevage '.$this->mailQueue->user->company->name;

					$this->addMessage($body);

					$this->markMailQueueAsDone();
				}
			}
		}
	}

	public function firstBirthday()
	{
		$responseModel = $this->mailQueue->response->model;
		$response = $this->mailQueue->response;

		if($responseModel instanceof Post) {
			if($responseModel->model instanceof Litter) $this->markMailQueueAsDone();
			elseif($responseModel->model instanceof Animal) $animal = $responseModel->model;
		}
		elseif($responseModel instanceof Animal) $animal = $responseModel;

		if($animal) {
			$now = Carbon::now()->startOfDay();
			$birthDate = Carbon::parse($animal->values->get('birth_date'));
			$yearSince = $birthDate->diffInYears($now);

			if($yearSince == 1) {
				$body = 'Bonjour '.$response->from->firstname.',<br/><br/>

				'.$animal->name.' fête déjà sa première bougie ! 🐾<br/>
				Merci de lui avoir offert un foyer aimant.<br/>
				Et si vous nous partagiez une photo souvenir ? 📸 N\'hésitez pas à la diffuser sur les réseaux et à tagguer également <a href="https://www.instagram.com/eleveurs_online">@Eleveurs_Online</a><br/><br/>

				Encore joyeux anniversaire à votre compagnon !<br/><br/>

				À bientôt,<br/><br/>

				Elevage '.$this->mailQueue->user->company->name;

				$this->addMessage($body);

				$this->markMailQueueAsDone();
			}
		}
	}

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('check:mail_queues Starts at ' . Carbon::now());

		$mailQueues = MailQueue::where('state', MailQueueStates::Active)
			->get();

		if($mailQueues->isNotEmpty()) {
			foreach($mailQueues as $mailQueue) {
				$this->mailQueue = $mailQueue;

				switch($mailQueue->identifier) {
					case 'check-up-and-questions':
						$this->checkUpAndQuestions();
						break;
					case 'reminder-first-vaccine':
						$this->reminderVaccine('first');
						break;
					case 'reminder-second-vaccine':
						$this->reminderVaccine('second');
						break;
					case 'reminder-first-deworming':
						$this->reminderDeworming('first');
						break;
					case 'reminder-second-deworming':
						$this->reminderDeworming('second');
						break;
					case 'food-change-transition':
						$this->foodChangeTransition();
						break;
					case 'castration-sterilization':
						$this->castrationSterilization();
						break;
					case 'first-summer':
						$this->firstSummer();
						break;
					case 'first-birthday':
						$this->firstBirthday();
						break;
				}

				$this->mailQueue = null;
			}
		}

		Log::info('check:mail_queues Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
