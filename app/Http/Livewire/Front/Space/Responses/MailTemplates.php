<?php

namespace App\Http\Livewire\Front\Space\Responses;

use Livewire\Component;
use Livewire\Attributes\On;

use Illuminate\Support\Facades\Auth;

use App\Models\{Animal, MailQueue, Post, Response, Species};

class MailTemplates extends Component
{
	public Response $response;
	public Species $species;

	public $mode = 'auto-modal';
	public $title = 'Pickup confirmation';
	public $model;
	public $mailTemplates;
	public $templatesSelected = [];
	public $frequencyChoice = '12-months';

	protected function rules()
	{
		return [
			'templatesSelected' => []
		];
	}

	public function setSelectedTemplate()
	{
		$rules = [
			'templatesSelected' => ['required']
		];

		$messages = [
			'templatesSelected.required' => __('You must select at least one message')
		];

		$this->validate($rules, $messages);

		$actualTemplates = $this->response->mailQueues
			->pluck('identifier')
			->toArray();

		foreach($this->templatesSelected as $template) {
			if(!empty($actualTemplates)) {
				if(in_array($template, $actualTemplates)) continue;
			}

			$newMailQueue = new MailQueue;
			$newMailQueue->user_id = Auth::guard('web')->user()->id;
			$newMailQueue->response_id = $this->response->id;
			$newMailQueue->identifier = $this->mailTemplates[$template]['identifier'];
			$newMailQueue->frequency = $this->mailTemplates[$template]['frequency'] == 'chosen-by-user' ? $this->frequencyChoice : $this->mailTemplates[$template]['frequency'];
			$newMailQueue->save();
		}

		$this->dispatch('templates-set');
	}

	public function mount()
	{
		if($this->model instanceof Animal) $this->species = $this->model->species;
		elseif($this->model instanceof Post) $this->species = $this->model->model->species;

		$this->mailTemplates = [
			'check-up-and-questions' => [
				'identifier' => 'check-up-and-questions',
				'species' => 'both',
				'frequency_label' => '3 semaines après adoption',
				'frequency' => '3-weeks-after-adoption',
				'title' => 'Est-ce que tout se passe bien ? Avez-vous des questions ? ',
				'body' => 'Bonjour [Prénom],<br/><br/>

					Cela fait déjà trois semaines que [Nom de l\'animal] a rejoint votre foyer ❤️<br/>
					Comment ça se passe ? Avez-vous des questions, des doutes, ou besoin de conseils ?<br/>
					👉 Contactez-nous si besoin !<br/><br/>

					À très bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'reminder-first-vaccine' => [
				'identifier' => 'reminder-first-vaccine',
				'species' => 'both',
				'frequency_label' => 'Quand l\'animal a 12 semaines',
				'frequency' => 'animal-12-weeks-old',
				'title' => 'Rappel vaccin + 1er rdv véto',
				'body' => 'Bonjour [Prénom],<br/><br/>

					[Nom de l\'animal] a maintenant 12 semaines ! 🐾<br/>
					C’est le moment de prendre rendez-vous pour son rappel vaccinal, étape clé pour le protéger.<br/>
					Il faudra ensuite prévoir un rendez-vous pour le dernier rappel à 16 semaines.<br/>
					Si ce n’est pas déjà fait, contactez votre vétérinaire dès maintenant.<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <a href="'.route('article.index', ['arg1' => 'sante']).'">ici</a><br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'reminder-second-vaccine' => [
				'identifier' => 'reminder-second-vaccine',
				'species' => 'both',
				'frequency_label' => 'Quand l\'animal à 1 an',
				'frequency' => 'animal-one-year-old',
				'title' => 'Rappel vaccin',
				'body' => 'Bonjour [Prénom],<br/><br/>

					[Nom de l\'animal] aura prochainement 1 an ! 🐾<br/>
					C’est le moment de prendre rendez-vous pour son rappel vaccinal, étape clé pour le protéger.<br/>
					Si ce n’est pas déjà fait, contactez votre vétérinaire dès maintenant.<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <a href="'.route('article.index', ['arg1' => 'sante']).'">ici</a><br/><br/>

					À bientôt,<br/>
					L’équipe Eleveurs Online 🐶🐱'
			],
			'reminder-first-deworming' => [
				'identifier' => 'reminder-first-deworming',
				'species' => 'both',
				'frequency_label' => '1 fois par mois jusqu\'au 6 mois de l\'animal',
				'frequency' => 'once-per-month-until-animal-6-months-old',
				'title' => 'Rappel vermifuge 6 mois',
				'body' => 'Bonjour [Prénom],<br/><br/>

					Pour rester en pleine forme, [Nom de l\'animal] a besoin d’un vermifuge tous les mois jusqu’à ses 6 mois.<br/>
					Si vous avez un doute sur le produit ou la dose à utiliser, n’hésitez pas à demander conseil à votre vétérinaire.<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <a href="'.route('article.index', ['arg1' => 'sante']).'">ici</a><br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'reminder-second-deworming' => [
				'identifier' => 'reminder-second-deworming',
				'species' => 'both',
				'frequency_label' => 'jusqu\'au 3 ans de l\'animal puis 1 fois tous les 3 mois (4 fois par an)',
				'frequency' => 'once-per-month-until-6-months-then-once-very-three-months',
				'title' => 'Rappel verfimuge 6 mois > 3 ans',
				'body' => 'Bonjour [Prénom],<br/><br/>

					Petit rappel bien utile : [Nom de l\'animal] doit être vermifugé tous les 3 mois ou selon les recommandations de votre vétérinaire.<br/>
					Un geste simple pour sa santé, et pour la vôtre.<br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos santé et prévention <a href="'.route('article.index', ['arg1' => 'sante']).'">ici</a><br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'food-change-transition' => [
				'identifier' => 'food-change-transition',
				'species' => 'dog',
				'frequency_label' => '12 mois ou 15 mois',
				'frequency' => 'chosen-by-user',
				'title' => 'Changement alimentation 1ère transition',
				'body' => 'Bonjour [Prénom],<br/><br/>

					À cette période, [Nom de l\'animal] termine sa croissance. 🐾<br/>
					C’est le bon moment pour envisager une transition vers une alimentation adulte.<br/>
					Nous recommandons de commencer à partir de [12 ou 15 mois selon votre choix].<br/><br/>

					👉 Pour obtenir d\'autres conseils et en savoir plus, consultez la rubrique Eleveurs Online dédiée aux infos nutrition <a href="'.route('article.index', ['arg1' => 'nutrition']).'">ici</a><br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'castration-sterilization' => [
				'identifier' => 'castration-sterilization',
				'species' => 'both',
				'frequency_label' => 'Au 6 mois de l\'animal',
				'frequency' => 'until-animal-6-months-old',
				'title' => 'Castration / Stérilisation',
				'body' => 'Bonjour [Prénom],<br/><br/>

					[Nom de l\'animal] approche de ses 6 mois ! 🐾<br/>
					C’est généralement le moment de discuter de stérilisation/castration avec votre vétérinaire.<br/>
					Cette décision dépend de plusieurs facteurs : race, santé, comportement, mode de vie et peut nécessiter une adaptation alimentaire.<br/><br/>

					👉 Eleveurs Online vous explique tout <a href="'.route('article.index', ['arg1' => 'sante']).'">ici</a><br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'first-summer' => [
				'identifier' => 'first-summer',
				'species' => 'both',
				'frequency_label' => 'Premier été qui suit l\'adoption au 15/06',
				'frequency' => 'first-summer-after-adoption',
				'title' => 'Conseils sur les premières vacances',
				'body' => 'Bonjour [Prénom],<br/><br/>

					C’est bientôt l’été 🌞 et peut-être les premières vacances de [Nom de l\'animal] !<br/>
					Transport, hébergement, sécurité, baignade… vous vous demandez comment partir sereinement avec votre animal.<br/><br/>

					👉 Consultez la rubrique dédiée sur Eleveurs Online <a href="'.route('article.index', ['arg1' => 'conseils-entretien']).'">ici</a><br/><br/>

					À bientôt,<br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			],
			'first-birthday' => [
				'identifier' => 'first-birthday',
				'species' => 'both',
				'frequency_label' => 'Aux 1 an de l\'animal',
				'frequency' => 'animal-birthday',
				'title' => 'Premier anniversaire',
				'body' => 'Bonjour [Prénom],<br/><br/>

					[Nom de l\'animal] fête déjà sa première bougie ! 🐾<br/>
					Merci de lui avoir offert un foyer aimant.<br/>
					Et si vous nous partagiez une photo souvenir ? 📸 N\'hésitez pas à la diffuser sur les réseaux et à tagguer également <a href="https://www.instagram.com/eleveurs_online">@Eleveurs_Online</a> !<br/><br/>

					Encore joyeux anniversaire à votre compagnon !<br/><br/>

					À bientôt,<br/><br/>

					Elevage (Nom de l\'entreprise ou affixe/suffixe)'
			]
		];

		if($this->mode == 'grid' || $this->mode == 'only-modal') {
			$this->templatesSelected = $this->response->mailQueues
				->pluck('identifier')
				->toArray();

			$mailQueues = $this->response->mailQueues
				->where('identifier', 'food-change-transition')
				->first();

			if($mailQueues) $this->frequencyChoice = $mailQueues->frequency;
		}
	}

	public function render()
	{
		return view('livewire.front.space.responses.mail-templates');
	}
}
