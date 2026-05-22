<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Carbon;

use Spatie\IcalendarGenerator\Components\Calendar;
use Spatie\IcalendarGenerator\Components\Event;
use Spatie\IcalendarGenerator\Properties\TextProperty;

use App\Channels\BrevoChannel;

use App\Models\{Animal, Appointment, MailLog, Post};

use App\Support\{ModerationAnimalDenyReasons, ModerationCompanyDenyReasons, ModerationPostDenyReasons, ModerationProfessionnalActivityDenyReasons, ModerationUserDenyReasons};

class MailLogCreated extends Notification
{
	use Queueable;

	private function generateIcal(Appointment $appointment)
	{
		$appointmentDate = $appointment->date
			->setTimeFromTimeString($appointment->values->get('start_hour'))
			->setTimezone('Europe/Paris');
		$startDate = $appointmentDate->copy()->setTimezone('UTC');
		$endDate = $appointmentDate->copy()->addHour()->setTimezone('UTC');

		$event = Event::create('RDV Eleveurs-Online')
			->startsAt($startDate)
			->endsAt($endDate)
			->description('Un rendez-vous est prévu via la plateforme Eleveurs-Online')
			->address('Sur place')
			->organizer('contact@eleveurs-online.com', 'Eleveurs-Online')
			->createdAt(Carbon::now('UTC'));

		$calendar = Calendar::create('Mon calendrier')
			->event($event)
			->appendProperty(TextProperty::create('METHOD', 'REQUEST'));

		return $calendar->get();
	}

	/**
	 * Create a new notification instance.
	 *
	 * @return void
	 */
	public function __construct(public MailLog $mailLog)
	{
		//
	}

	/**
	 * Get the notification's delivery channels.
	 *
	 * @param mixed $notifiable
	 * @return array
	 */
	public function via($notifiable)
	{
		return [
			BrevoChannel::class,
			'database'
		];
	}

	public function toBrevoChannel($notifiable)
	{
		$template = 41;
		$tags = [];
		$attachment = [];
		$footer = '<p>L’équipe <b>Eleveurs Online</b> 🐶🐱</p>';

		if($notifiable->type == 'visit-appointment-created-for-unknown-user' || $notifiable->type == 'pickup-appointment-created-for-unknown-user') {
			$tags = ['RDV_visite', 'visiteur'];
			$object = '📅 Un éleveur vous a proposé un rendez-vous';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Un éleveur sur <b>Eleveurs Online</b> vous a proposé un rendez-vous pour une visite d’un animal que vous avez repéré.</p><br/>

			<p>Pour consulter les détails du rendez-vous et échanger facilement avec l’éleveur, il vous suffit de créer un compte gratuitement sur notre plateforme.</p><br/>

			<p>👉 <a href="'.route('login').'">Validez mon compte et obtenir tous les détails du rendez-vous</a></p><br/>

			<p>Cela ne prend que quelques instants et cela vous permettra aussi de :<br/>
				<ul>
					<li>✔️ suivre vos échanges avec les éleveurs</li>
					<li>✔️ recevoir des alertes sur les animaux correspondant à vos critères</li>
					<li>✔️ finaliser sereinement votre démarche d’adoption</li>
				</ul>
			</p><br/>

			<p>Nous vous souhaitons une très belle rencontre,</p>';
		}
		elseif($notifiable->type == 'adoption-appointment-for-known-user-has-passed') {
			if($notifiable->model->response) {
				if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
				elseif($notifiable->model->response->model instanceof Post) {
					if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
						elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->response->model->model->name;
				}
			}
			else {
				if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
				elseif($notifiable->model->model instanceof Post) {
					if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
						elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->model->model->name;
				}
			}

			if($notifiable->user->id == $notifiable->model->from->id) $url = route('space.responses.my-messages', ['response' => $notifiable->model->response->id]);
			else $url = route('space.responses.my-messages', ['response' => $notifiable->model->response->id]);

			$tags = ['validation_adoption', 'adoptant'];
			$object = '✅ Votre adoption s’est bien déroulée ? Dites-nous tout !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous espérons que votre adoption avec '.$notifiable->model->from->company->name.' et '.$text.' s’est déroulée à merveille ! Il vous faut maintenant :</p><br/>

			<p><a href="'.$url.'">👉 Valider votre adoption dans votre espace</a></p>
			<p><a href="'.route('contact').'">Ou signaler un problème.</a></p><br/>

			<p>Vous pourrez également laisser un message dans le livre d\'or de l\'éleveur afin de l\'aider à améliorer son référencement sur la plateforme.</p>
			<p>La validation de l\'adoption vous permet d\'obtenir le passeport et le certificat iCad de votre animal. Elle vous permet aussi d\'accéder aux avantages exclusifs dont vous bénéficiez en tant que nouvel adoptant d\'Eleveurs-Online.</p><br/>

			<p><a href="'.route('login').'">👉 Me connecter</a></p><br/>

			<p>A bientôt,</p>';
		}
		elseif($notifiable->type == 'animal-adopted-for-known-user') {
			$tags = ['felicitations_adoption', 'adoptant'];
			$object = '🎉 Félicitations pour votre adoption !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Toute notre équipe vous adresse ses félicitations pour l’arrivée de votre animal.</p>
			<p>Nous vous souhaitons à tous les deux une belle et longue aventure ensemble, remplie de complicité, de jeux, et de bonheur partagé.</p><br/>

			<p>📘 Pour vous accompagner dans les premières semaines (et bien après), nous avons rassemblé des conseils pratiques, rédigés par des experts <a href="'.route('article.index', ['arg1' => 'proprietaires']).'">ici</a></p><br/>

			<p>🎁 <b>Et pour bien s’équiper dès le départ, vous avez débloqué votre pack d’avantages spécial "nouveau chiot / nouveau chaton" !</b></p>
			<p>Découvrez notre sélection de produits ser services utiles pour votre nouvel animal :</p>
			<p><a href="'.route('space.benefits.my-benefits').'">👉 Voir mes nouveaux avantages</a></p><br/>

			<p>Et n\'oubliez pas, le passeport avec toutes les informations importantes concernant votre animal sont disponibles dans votre espace rubrique <a href="'.route('space.animals.my-animals').'">Mes animaux"</a>.</p><br/>

			<p>Nous restons à vos côtés tout au long de cette belle aventure 💙</p>
			<p>N’hésitez pas à revenir sur Eleveurs Online pour des infos, des conseils, ou même… des compagnons de jeu plus tard 😉</p><br/>

			<p>Avec toute notre bienveillance,</p>';
		}
		elseif($notifiable->type == 'reminder-bank-transfer-waiting') {
			$tags = ['Relance_virement'];
			$object = '🔔 Rappel de votre paiement en attente pour le déblocage de vos crédits';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous constatons que votre règlement par virement bancaire relatif à votre dernier achat de crédits, est toujours en attente.</p><br/>

			<p>Sans réception de ce paiement, nous ne pourrons pas débloquer vos crédits ni vous permettre de publier sur Eleveurs-Online.</p>
			<p>Pour finaliser votre paiement :</p><br/>

			<ul>
				<li>1. Consultez le mail de confirmation de commande qui contient les références bancaires</li>
				<li>2. Suivez nos instructions pour effectuer votre virement (RIB, références à indiquer, etc.)</li>
				<li>3. Une fois le virement émis, vos crédits seront automatiquement débloqués et vos publications validées pour mise en ligne.</li>
			</ul>

			<p>Passé 7 jours après votre commande, celle-ci sera automatiquement annulée et vous devrez recommencer la procédure d\'achat et de mise en ligne.</p><br/>

			<p>Si vous rencontrez des difficultés ou avez des questions, notre équipe est à votre disposition : <a href="'.route('contact').'">formulaire de contact</a></p><br/>

			<p>Nous vous remercions de votre réactivité et restons à vos côtés pour vous accompagner au mieux.</p><br/>

			<p>Bien cordialement,</p>';
		}
		elseif($notifiable->type == 'bank-transfer-received') {
			$tags = ['Relance_virement'];
			$object = '✅ Virement reçu — merci !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous confirmons la bonne réception de votre virement relatif à votre commande en date du '.$notifiable->model->created_at->format('d/m/Y').'.</p><br/>

			<p>Si ce paiement concernait l’achat de crédits, ceux-ci ont été immédiatement débloqués sur votre compte — vous pouvez dès à présent publier vos annonces ou votre page de référencement entreprise ou professionnelle. 🚀</p>
			<p>Si vous avez déjà complété vos annonces ou vos pages et que celles-ci étaient en attente de paiement alors notre service client les publiera dans les meilleurs délais. </p><br/>

			<p>Pour consulter votre facture rendez-vous dans <a href="'.route('space.profile.my-orders').'">Mon compte > Commandes et Factures.</a></p><br/>

			<p>Si vous rencontrez des difficultés ou avez des questions, notre équipe est à votre disposition : <a href="'.route('contact').'">formulaire de contact</a></p><br/>

			<p>Nous vous remercions de votre réactivité et restons à vos côtés pour vous accompagner au mieux.</p><br/>

			<p>Bien cordialement,</p>';
		}
		elseif($notifiable->type == 'reminder-adopter-profile-completion') {
			$tags = ['compléter_profil', 'adoptant'];
			$object = '🎯 Mettez toutes les chances de votre côté pour adopter 🐾';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous avons remarqué que votre <b>profil adoptant</b> sur Eleveurs Online n’est pas encore entièrement complété, votre profil vous permet :</p><br/>

			<p>🔒 D\'inspirer davantage confiance aux éleveurs lors de vos futures demandes ;</p>
			<p>🎯 Il permet aux éleveurs de mieux comprendre votre projet d’adoption ;</p>
			<p>📬 Et augmente vos chances de recevoir des réponses rapidement.</p>

			<p>👉 <b>Mettez à jour votre profil</b> dès maintenant :</p>
			<p><a href="'.route('space.profile.complete-my-profile').'">Compléter mon profil</a></p><br/>

			<p>Un petit effort qui peut faire toute la différence pour l’animal qui vous attend 🐾</p><br/>

			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'user-no-connection') {
			$tags = ['relance_6m_adoptant'];
			$object = '🤔 Êtes-vous toujours en recherche d’un animal à adopter ?';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous avons remarqué que vous ne vous êtes pas connecté(e) sur <b>Eleveurs Online</b> depuis un certain temps (6 mois déjà 🕒).</p><br/>

			<p>Souhaitez-vous toujours adopter un animal ?</p><br/>

			<p>👉 Faites-nous savoir si <b>votre recherche est toujours d’actualité</b> :</p>
			<p><a href="'.route('space.profile.dashboard').'">Mettre à jour mon statut</a></p><br/>

			<p>Cela nous permet de vous envoyer uniquement les informations utiles.</p><br/>

			<p>Si vous avez déjà trouvé votre compagnon, vous pouvez simplement gérer vos alertes depuis votre espace personnel.</p><br/>

			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'a-week-after-visit') {
			if($notifiable->model->response) {
				if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
				elseif($notifiable->model->response->model instanceof Post) {
					if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
						elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->response->model->model->name;
				}
			}
			else {
				if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
				elseif($notifiable->model->model instanceof Post) {
					if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
						elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->model->model->name;
				}
			}

			$tags = ['visite_relance_1sem', 'adoptant'];
			$object = '✅ Votre visite s’est bien déroulée ? Dites-nous tout !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous espérons que votre première rencontre avec '.$notifiable->model->from->company->name.' et '.$text.' s’est déroulée à merveille ! Voici les prochaines étapes :</p><br/>

			<p><a href="'.route('space.responses.my-messages', ['response' => $notifiable->model->id]).'">👉 Demandez à l\'éleveur</a> de réserver l\'animal pour vous et de plannifier le rendez-vous de retrait.</p>
			<p>Une fois l\'adoption validée, vous pourrez accédez à vos avantages réservés aux adoptants Eleveurs-Online et au passerport digital de notre animal.</p><br/>

			<p><a href="'.route('home').'">👉 Poursuivre ma recherche et consulter d\'autres annonces</a></p><br/>

			<p><a href="'.route('space.profile.dashboard').'">👉 Mettre en place une alerte pour être informé(e) de la diffusion de nouvelles annonces répondants à mes critères.</a></p><br/>

			<p>Vous n\'êtes finalement pas intéréssé ? Annulez votre demande.</p><br/>

			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'auto-validation-adoption-for-adopter') {
			if($notifiable->model->response) {
				if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
				elseif($notifiable->model->response->model instanceof Post) {
					if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
						elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->response->model->model->name;
				}
			}
			else {
				if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
				elseif($notifiable->model->model instanceof Post) {
					if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
						elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->model->model->name;
				}
			}

			$tags = ['validation_auto_adoption', 'adoptant'];
			$object = '🎉 Le retrait de '.$text.' validé automatiquement : Félicitations pour votre adoption !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous vous informons que, n’ayant pas confirmé vous-même le retrait de '.$text.', nous l’avons validé automatiquement afin que vous puissiez récupérer le passeport de votre animal et bénéficier de vos avantages exclusifs. A ce titre nous souhaitons vous féliciter pour cette adoption ! 🎉</p>
			<p>Nous vous souhaitons à tous les deux une belle et longue aventure ensemble, remplie de complicité, de jeux, et de bonheur partagé.</p><br/>

			<p>📘 Pour vous accompagner dans les premières semaines (et bien après), nous avons rassemblé des conseils pratiques, rédigés par des experts <a href="'.route('article.index', ['arg1' => 'proprietaires']).'">ici</a></p><br/>

			<p>🎁 Et pour bien s’équiper dès le départ, vous avez débloqué votre pack d’avantages spécial "nouveau chiot / nouveau chaton" !</p>
			<p>Découvrez notre sélection de produits ser services utiles pour votre nouvel animal :</p>
			<p><a href="'.route('space.benefits.my-benefits').'">👉 Voir mes nouveaux avantages</a></p><br/>

			<p>Et n\'oubliez pas, le passeport avec toutes les informations importantes concernant votre animal sont disponibles dans votre espace rubrique <a href="'.route('space.animals.my-animals').'">"Mes animaux".</a></p><br/>

			<p>Nous restons à vos côtés tout au long de cette belle aventure 💙</p>
			<p>N’hésitez pas à revenir sur Eleveurs Online pour des infos, des conseils, ou même… des compagnons de jeu plus tard 😉</p><br/>

			<p>Si vous avez des questions ou si vous constatez une erreur dans cette validation, <a href="'.route('contact').'">signalez nous un problème.</a></p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'auto-validation-adoption-for-breeder') {
			if($notifiable->model->response) {
				if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
				elseif($notifiable->model->response->model instanceof Post) {
					if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
						elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->response->model->model->name;
				}
			}
			else {
				if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
				elseif($notifiable->model->model instanceof Post) {
					if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
						elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
					}
					else $text = $notifiable->model->model->model->name;
				}
			}

			$tags = ['validation_auto_adoption', 'éleveurs'];
			$object = '🎉 Le retrait de '.$text.' validé automatiquement';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Nous vous informons que, n’ayant pas confirmé vous-même le retrait de '.$text.', nous l’avons validé automatiquement afin que l\'adoptant puisse récupérer toutes les informations sur l\'animal adopté et puisse bénéficier de nouveaux avantages dédiés sur la plateforme.</p><br/>

			<p>Dès à présent, vous pouvez vous rendre dans votre rubrique "Mes animaux" puis filtrer sur les animaux adoptés. Il vous sera possible de configurer les messages de suivis automatisés afin de vous aider à apporter le meilleur service à l\'adoptant et son nouveau compagnon !</p>
			<p><a href="'.route('space.companies.my-company').'">👉 Accéder à mes animaux</a></p><br/>

			<p>Si vous avez des questions ou si vous constatez une erreur dans cette validation, <a href="'.route('contact').'">signalez nous un problème.</a></p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'breeder-account-validated') {
			$tags = ['Validation_compte', 'Eleveurs'];
			$object = '✅ Votre compte Eleveurs Online a été validé !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Votre compte sur Eleveurs Online a été <b>validé par notre service client</b>.</p><br/>

			<p>Vous pouvez dès maintenant :</p>
			<p>✔️ Publier vos premières annonces</p>
			<p>✔️ Échanger avec des adoptants </p>
			<p>✔️ Bénéficier de nos outils et servives</p>
			<p>✔️ Lire nos contenus</p><br/>

			<p><a href="'.route('space.profile.dashboard').'">👉 Accéder à mon espace éleveur</a></p><br/>

			<p>Nous sommes ravis de vous accueillir dans la communauté Eleveurs Online et restons à votre disposition.</p><br/>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'breeder-account-denied') {
			$reason = '';

			if($notifiable->model->reason) {
				$reason = '<p>Pour finaliser votre inscription et activer votre compte, merci de :</p>
				<p>'.__(ModerationUserDenyReasons::REASONS[$notifiable->model->reason]['Title']).' - '.$notifiable->model->description ?? ''.'</p><br/>';
			}

			$tags = ['Modération_compte', 'Eleveurs'];
			$object = '⚠️ Informations manquantes : votre compte Eleveurs Online n’a pas pu être validé';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Merci pour votre inscription sur <b>Eleveurs Online.</b></p><br/>

			<p>Après vérification, nous n’avons pas pu valider votre compte pour le moment, car <b>certaines informations nécessaires sont manquantes ou incomplètes.</b></p><br/>

			'.$reason.'

			<p><a href="'.route('space.profile.complete-my-profile').'">🔗 Me connecter</a></p><br/>

			<p>Une fois votre profil à jour, notre équipe procédera à une nouvelle validation dans les meilleurs délais.</p><br/>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'appointment-reminder') {
			$ical = $this->generateIcal($notifiable->model);

			$tags = ['Rappel_rdv', 'Eleveurs'];
			$object = '⏰ Rappel : vous avez un rendez-vous avec un adoptant dans 24h';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Vous avez un <b>rendez-vous prévu avec un adoptant dans 24h</b>, pour une visite ou un retrait d’animal.</p><br/>

			<p><a href="'.route('space.appointments.my-appointments', ['appointment' => $notifiable->model->id]).'">👉 Voir les détails du rendez-vous</a></p><br/>

			<p>Pensez à bien préparer son accueil si ce n’est pas déjà fait 😉. Une bonne expérience de rencontre renforce la confiance des adoptants et valorise votre entreprise 🫶.</p><br/>

			<p>Merci pour votre sérieux,</p>';
			$attachment = [
				'content' =>$ical,
				'name' => 'invite.ics',
				'type' => 'text/calendar; method=REQUEST; charset=UTF-8',
			];
		}
		elseif($notifiable->type == 'visit-appointment-has-passed') {
			$tags = ['Suite_visite', 'Eleveurs'];
			$object = '📅 Et maintenant  ?';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Un <b>rendez-vous de visite</b> avec un adoptant a eu lieu récemment. Et maintenant, <b>quelle est la suite ?</b></p><br/>

			<p><a href="'.$url.'">👉 Passez l\'animal en statut "Réservé" et Planifiez un rendez-vous de retrait</a> si l’adoption est confirmée</p>
			<p>👉 Ou <a href="'.route('space.responses.my-messages', ['response' => $notifiable->model->response->id]).'">refusez la demande</a> si l’adoptant ne correspond pas à vos critères</p><br/>

			<p>Cela nous permet de maintenir un suivi clair de vos échanges et d’informer au mieux l’adoptant de la suite donnée à sa demande.</p><br/>

			<p>Merci pour votre réactivité,</p>';
		}
		elseif($notifiable->type == 'adoption-appointment-from-jobboard-has-passed') {
			$tags = ['Confirmation_adoption', 'Eleveurs'];
			$object = '✅ Confirmez l\'adoption !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Un rendez-vous de retrait a récemment eu lieu pour l\'un de vos animaux. Afin de transmettre le passeport de l\'animal et de donner accès à des avantages et promotions exclusifs à votre adoptant (conseils, suivi, produits, services etc...), il vous faut maintenant :</p>
			<p><a href="'.route('space.appointments.my-messages', ['response' => $notifiable->model->response->id]).'">👉 Confirmer l\'adoption</a></p>
			<p>Vous aurez alors la possibilité de configurer un ensemble de messages de suivi automatisés afin de vous aider à apporter le meilleur service possible à l\'adoptant et son nouveau compagnon.</p><br/>

			<p>Merci pour votre réactivité,</p>';
		}
		elseif($notifiable->type == 'post-validated') {
			$tags = ['validation_annonces', 'Eleveurs'];
			$object = '✅ Votre annonce est en ligne sur Eleveurs Online !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Bonne nouvelle ! Votre annonce vient d’être <b>validée et elle est désormais en ligne sur Eleveurs Online.</b></p><br/>

			<p><a href="'.route('post-search.post.show', ['company' => $notifiable->user->company->slug, 'post' => $notifiable->model->slug, 'breed' => $notifiable->model->model->breed->slug]).'">👉 Voir mon annonce</a></p><br/>

			<p>Vous serez notifié(e) dès que vous recevrez une nouvelle demande.</p><br/>

			<p>Merci pour votre confiance,</p>';
		}
		elseif($notifiable->type == 'post-denied') {
			$reason = '';

			if($notifiable->model->reason) {
				$reason = '<p>Pour finaliser votre annonce merci de :</p>
				<p>'.__(ModerationPostDenyReasons::REASONS[$notifiable->model->reason]['Title']).' - '.$notifiable->model->description ?? ''.'</p><br/>';
			}

			$tags = ['Moderation_annonce', 'Eleveurs'];
			$object = '⚠️ Votre annonces Eleveurs Online n’a pas pu être validée';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Merci pour la diffusion de votre annonce sur <b>Eleveurs Online.</b></p><br/>

			<p>Après vérification, nous n’avons pas pu valider votre annonce pour le moment, car certaines informations nécessaires sont à modifier.</p><br/>

			'.$reason.'

			<p><a href="'.route('login').'">🔗 Me connecter</a></p><br/>

			<p>Une fois votre annonce à jour, notre équipe procédera à une nouvelle validation dans les meilleurs délais.</p><br/>

			<p>Merci pour votre compréhension.</p>
			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'company-validated') {
			$tags = ['validation_page_elevage', 'Eleveurs'];
			$object = '🎉 Votre page entreprise est maintenant en ligne !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Votre page entreprise vient d’être <b>validée et elle est désormais visible en ligne sur Eleveurs Online.</p><br/>

			<p><a href="'.route('company-search.company.show', ['company' => $notifiable->model->slug]).'">👉 Voir ma page entreprise</a></p><br/>

			<p>Votre entreprise gagne en visibilité et peut désormais être consulté par les futurs adoptants. N’hésitez pas à la mettre à jour régulièrement pour la garder attractive.</p><br/>

			<p>Merci d’être membre de notre communauté,</p>';
		}
		elseif($notifiable->type == 'company-denied') {
			$reason = '';

			if($notifiable->model->reason) {
				$reason = '<p>Pour finaliser votre page entreprise merci de :</p>
				<p>'.__(ModerationCompanyDenyReasons::REASONS[$notifiable->model->reason]['Title']).' - '.$notifiable->model->description ?? ''.'</p><br/>';
			}

			$tags = ['Moderation_page_elevage', 'Eleveurs'];
			$object = '⚠️ Votre page entreprise Eleveurs Online n’a pas pu être validée';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Merci pour la diffusion de votre page entreprise sur <b>Eleveurs Online.</b></p><br/>

			<p>Après vérification, nous n’avons pas pu valider votre page entreprise pour le moment, car certaines informations nécessaires sont à modifier.</p><br/>

			'.$reason.'

			<p><a href="'.route('login').'">🔗 Me connecter</a></p><br/>

			<p>Une fois votre page entreprise à jour, notre équipe procédera à une nouvelle validation dans les meilleurs délais.</p>
			<p>Si vous avez une annonce en cours de validation également, celle-ci ne pourra être validée sans validation préalable de votre page entreprise.</p><br/>

			<p>Merci pour votre compréhension.</p>
			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'animal-denied') {
			$reason = '';

			if($notifiable->model->reason) {
				$reason = '<p>Pour finaliser votre annonce merci de :</p>
				<p>'.__(ModerationAnimalDenyReasons::REASONS[$notifiable->model->reason]['Title']).' - '.$notifiable->model->description ?? ''.'</p><br/>';
			}

			$tags = ['Moderation_animal', 'Eleveurs'];
			$object = '⚠️ Votre animal '.$notifiable->model->model->name.' n’a pas pu être validée';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Merci pour la diffusion de votre annonce sur <b>Eleveurs Online.</b></p><br/>

			<p>Après vérification, nous n’avons pas pu valider votre annonce pour le moment, car certaines informations de '.$notifiable->model->model->name.' nécessaires sont à modifier.</p><br/>

			'.$reason.'

			<p><a href="'.route('login').'">🔗 Me connecter</a></p><br/>

			<p>Une fois votre animal à jour, notre équipe procédera à une nouvelle validation dans les meilleurs délais.</p><br/>

			<p>Merci pour votre compréhension.</p>
			<p>À très bientôt,</p>';
		}
		elseif($notifiable->type == 'post-expires-in-three-days') {
			$tags = ['Expiration_annonce_J3', 'Eleveurs'];
			$object = '⏳ Votre annonce expire dans 3 jours — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Votre annonce publiée sur Eleveurs Online <b>arrive à expiration dans 3 jours.</b> Si vous souhaitez la renouveler, c\'est par ici :</p><br/>

			<p><a href="'.route('space.posts.my-post', ['post' => $notifiable->model->slug]).'">👉 Renouveler mon annonce</a></p><br/>

			<p>Si votre annonce n\'est plus d\'actualité, vous pouvez également archiver l’annonce en un clic.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'post-expires-tomorrow') {
			$tags = ['Expiration_annonce_J1', 'Eleveurs'];
			$object = '⏳ Votre annonce expire demain — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Votre annonce publiée sur Eleveurs Online <b>arrive à expiration demain.</b> Si vous souhaitez la renouveler, c\'est par ici :</p><br/>

			<p><a href="'.route('space.posts.my-post', ['post' => $notifiable->model->slug]).'">👉 Renouveler mon annonce</a></p><br/>

			<p>Si votre annonce n\'est plus d\'actualité, vous pouvez également archiver l’annonce en un clic.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'company-expires-in-a-month') {
			$tags = ['Expiration_pe_M-1', 'Eleveurs'];
			$object = '⏳ Votre page entreprise arrive à expiration prochainement — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>La diffusion de votre page entreprise sur Eleveurs Online <b>arrive à expiration dans 1 mois.</b> Pour continuer à bénéficier de votre visibilité en ligne, pensez à la renouveler dès maintenant :</p><br/>

			<p><a href="'.route('space.companies.my-company').'">👉 Renouveler mon abonnement</a></p><br/>

			<p>Vous ne souhaitez pas renouveler ? Votre page sera automatiquement basculée en forfait "Standard" à la fin de la période d’abonnement et vous serez de nouveau limité à une seule race pour vos annonces.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'company-expires-in-three-days') {
			$tags = ['Expiration_pe_J3', 'Eleveurs'];
			$object = '⏳ Votre page entreprise arrive à expiration — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>La diffusion de votre page entreprise sur Eleveurs Online <b>arrive à expiration dans 3 jours.</b> Pour continuer à bénéficier de votre visibilité en ligne, pensez à la renouveler dès maintenant :</p><br/>

			<p><a href="'.route('space.companies.my-company').'">👉 Renouveler mon abonnement</a></p><br/>

			<p>Vous ne souhaitez pas renouveler ? Votre page sera automatiquement basculée en forfait "Standard" à la fin de la période d’abonnement et vous serez de nouveau limité à une seule race pour vos annonces.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'company-expires-tomorrow') {
			$tags = ['Expiration_pe_J1', 'Eleveurs'];
			$object = '⏳ Votre page entreprise expire demain — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>La diffusion de votre page entreprise sur Eleveurs Online <b>arrive à expiration demain.</b> Pour continuer à bénéficier de votre visibilité en ligne, pensez à la renouveler dès maintenant :</p><br/>

			<p><a href="'.route('space.companies.my-company').'">👉 Renouveler mon abonnement</a></p><br/>

			<p>Vous ne souhaitez pas renouveler ? Votre page sera automatiquement basculée en forfait "Standard" à la fin de la période d’abonnement et vous serez de nouveau limité à une seule race pour vos annonces.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'acaced-expires-in-a-month' || $notifiable->type == 'acaced-expires-in-a-week') {
			$tags = ['Maj_acaced', 'Eleveurs'];
			$object = '📄 Votre certificat de formation arrive à échéance — mise à jour nécessaire';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Votre <b>certificat de formation arrive à échéance.</b> Pour continuer à être référencé en tant qu’éleveur professionnel sur <b>Eleveurs Online</b>, merci de soumettre un nouveau certificat valide dès que possible :</p><br/>

			<p><a href="'.route('space.profile.complete-my-profile').'">👉 Mettre à jour mon certificat de formation</a></p><br/>

			<p>Vous pouvez également consulter notre liste de centres de formation pour mettre à jour vos connaissances :</p>
			<p><a href="'.route('professionnal-activity-search.professionnal-activities', ['activityCategory' => 'services-prestations', 'activity' => 'formations']).'"👉 Annuaire de formations</a></p>
			<p><a href="https://cnfpro.fr/contacter-le-cnfpro-centre-de-formations/">👉 Ou consulter le site : https://cnfpro.fr/contacter-le-cnfpro-centre-de-formations/</a></p><br/>

			<p>Sans action de votre part, votre statut passera automatiquement en "éleveur particulier", avec les limitations associées.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'professionnal-activity-validated') {
			$tags = ['validation_page_pros', 'professionnels'];
			$object = '✅ Votre page professionnelle est en ligne sur Eleveurs Online !';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Bonne nouvelle ! Votre page professionnelle vient d’être <b>validée et elle est désormais visible sur Eleveurs Online.</b></p><br/>

			<p><a href="'.route('professionnal-activity-search.professionnal-activity.show', ['activityCategory' => $notifiable->model->category->slug, 'activity' => $notifiable->model->activity->slug, 'professionnalActivity' => $notifiable->model->slug]).'">👉 Voir ma page pro</a></p><br/>

			<p>Les clients peuvent maintenant vous contacter directement pour bénéficier de vos services. Pensez à maintenir votre page à jour (horaires, tarifs, photos, etc.) pour maximiser votre visibilité.</p><br/>

			<p>Bienvenue parmi les pros référencés,</p><br/>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'professionnal-activity-denied') {
			$reason = '';

			if($notifiable->model->reason) {
				$reason = '<p>Pour finaliser votre page professionnelle merci de :</p>
				<p>'.__(ModerationProfessionnalActivityDenyReasons::REASONS[$notifiable->model->reason]['Title']).' - '.$notifiable->model->description ?? ''.'</p><br/>';
			}

			$tags = ['Modération_page_pros', 'professionnels'];
			$object = '⚠️ Informations manquantes : votre page professionnelle Eleveurs Online n’a pas pu être validée';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Merci pour la diffusion de votre page professionnelle sur <b>Eleveurs Online.</b></p><br/>

			<p>Après vérification, nous n’avons pas pu valider votre page professionnelle pour le moment, car certaines informations nécessaires sont à modifier.</p><br/>

			'.$reason.'

			<p><a href="'.route('login').'">🔗 Me connecter</a></p><br/>

			<p>Une fois votre page professionnelle à jour, notre équipe procédera à une nouvelle validation dans les meilleurs délais.</p><br/>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'professionnal-activity-expires-in-three-days') {
			$tags = ['Expiration_ppro_J3', 'professionnels'];
			$object = '⏳ Votre page professionelle expire bientôt — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>La diffusion de votre page professionnelle sur Eleveurs Online <b>arrive à expiration</b> dans 3 jours.</p><br/>

			<p>Pour rester visible auprès des clients et continuer à recevoir des demandes de contact, pensez à la renouveler dès maintenant :</p><br/>

			<p><a href="'.route('space.professionnal-activities.my-professionnal-activity', ['professionnalActivity' => $notifiable->model->slug]).'">👉 Renouveler ma page professionnelle</a></p><br/>

			<p>Sans renouvellement, votre page sera automatiquement désactivée à la fin de la période.</p><br/>

			<p>Merci de votre confiance,</p>';
		}
		elseif($notifiable->type == 'professionnal-activity-expires-tomorrow') {
			$tags = ['Expiration_ppro_J1', 'professionnels'];
			$object = '⏳ Votre page professionelle expire bientôt — pensez à la renouveler';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>La diffusion de votre page professionnelle sur Eleveurs Online <b>arrive à expiration demain.</b></p><br/>

			<p>Pour rester visible auprès des clients et continuer à recevoir des demandes de contact, pensez à la renouveler dès maintenant :</p><br/>

			<p><a href="'.route('space.professionnal-activities.my-professionnal-activity', ['professionnalActivity' => $notifiable->model->slug]).'">👉 Renouveler ma page professionnelle</a></p><br/>

			<p>Sans renouvellement, votre page sera automatiquement désactivée à la fin de la période.</p><br/>

			<p>Merci de votre confiance,</p>';
		}

		// Marketing
		elseif($notifiable->type == 'welcome-check-list') {
			$template = 77;
			$tags = ['Post_inscription_Assuropoil', 'Assuropoil'];
			$object = '🐾 Bien choisir son compagnon : la check-list';
			$body = '<p>Bonjour '.$notifiable->user->firstname.',</p><br/>

			<p>Bienvenu(e) dans notre communauté de propriétaires et futurs propriétaires Eleveurs Online. Quel beau projet que celui d’accueillir un animal de compagnie !</p><br/>

			<p>Il est cependant important de bien choisir son futur compagnon, celui qui correspond à votre personnalité et style de vie.</p>
			<p>Pour conforter vos choix, n’hésitez pas à aller découvrir nos fiches de « races » et à poser vos questions.</p>
			<p>Avec notre partenaire assurance animale Assuropoil, nous vous avons préparé la check-list de toutes les informations importantes à obtenir lors de votre visite chez l’éleveur avant de succomber au coup de foudre, <a href="'.route('article.show', ['article' => 'choisir-chiot-chaton-check-list-questions-poser-eleveur']).'">consultez-là !</a></p>
			<p>Enfin, pour prévoir au mieux l’arrivée de votre animal, Assuropoil vous offre les deux premiers mois ! Pour en bénéficier c’est par <a href="https://www.assuropoil.fr/mutuelle-animaux-complete-et-transparente/?part=3500&provenance=post_register&utm_source=email_transactionnel&utm_medium=post_register">ici</a></p>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'animal-visit-guide') {
			$template = 77;
			$tags = ['Relance_visite_1sem_Assuropoil', 'Assuropoil'];
			$object = '🎉 Préparez son arrivée : le guide offert par Assuropoil';
			$body = '<p>Ca y est, vous l’avez trouvé, ce petit bonheur à poils !</p>
			<p>Encore seulement quelques semaines à attendre pour le cajoler 24 heures/24 !</p>
			<p>Afin que vous assuriez en propriétaire avisé et prévoyant, <a href="'.route('article.show', ['article' => 'premiers-jours-chiot-chaton-reussir-arrivee-maison']).'">consultez tous nos conseils pour bien accueillir votre animal.</a></p>
			<p>De plus, Assuropoil, notre partenaire assurance animale vous offre exceptionnellement les deux premiers mois pour vous permettre d’avoir l’esprit léger, face aux futurs frais de soins et de bien-être de votre animal.</p>
			<p>Pour en bénéficier c’est par <a href="https://www.assuropoil.fr/mutuelle-animaux-complete-et-transparente/?part=3500&provenance=post_resa&utm_source=email_transactionnel&utm_medium=post_resa">ici</a></p><br/>

			<p>À très bientôt,</p><br/>

			<p>Eleveurs Online x Assuropoil</p>';
		}
		elseif($notifiable->type == 'animal-adopted-guide') {
			$template = 77;
			$tags = ['Post_adoption_Assuropoil', 'Assuropoil'];
			$object = '🎉 Félicitations ! Protégez votre nouveau compagnon avec Assuropoil';
			$body = '<p>Félicitations pour votre adoption !</p><br/>

			<p>Quel bonheur doit être le vôtre d’avoir enfin votre petit compagnon pour la vie !</p>
			<p>Comme une joie ne vient jamais seule, Assuropoil, notre partenaire assurance animale est heureux de vous offrir les deux premiers mois pour la souscription d’une de ses formules à découvrir <a href="https://www.assuropoil.fr/mutuelle-animaux-complete-et-transparente/?part=3500&provenance=post_adoption&utm_source=email_transactionnel&utm_medium=post_adoption">ici</a></p>
			<ul>
				<li>Un service 100% digital en quelques clics</li>
				<li>Une formule 100% personnalisable</li>
			</ul><br/><br/>

			<p>Fini les imprévus, prenez soin de votre compagnon en toute sérénité !</p>
			<p>Ne passez pas à côté de cette opportunité !</p><br/>

			<p>A très bientôt,</p>';
		}
		elseif($notifiable->type == 'marketing-five-percent-per-animal') {
			$template = 77;
			$tags = ['reduction_2animaux_Assuropoil', 'Assuropoil'];
			$object = '🐾 Assurez toute la meute avec Assuropoil : 5 % de remise par animal';
			$body = '<p>Vous êtes sur le point d’accueillir un nouveau membre dans votre famille et vous avez déjà un ou plusieurs compagnons à quatre pattes ?</p><br/>

			<p>Afin que tous les animaux de votre foyer puissent profiter de la même protection, Assuropoil, notre partenaire assurance animal, vous offre 5 % de remise sur ses formules pour chacun d’entre eux.</p>
			<p>Assuropoil vous donne les moyens d’assurer, à vous d’en <a href="https://www.assuropoil.fr/mutuelle-animaux-complete-et-transparente/?part=3500&provenance=deuxieme_animal&utm_source=email_transactionnel&utm_medium=deuxieme_animal">profiter !</a></p><br/>

			<p>A très bientôt,</p>';
		}

		if($notifiable->type == 'welcome-check-list' || $notifiable->type == 'animal-adopted-guide' || $notifiable->type == 'marketing-five-percent-per-animal') $body .= '<p>Eleveurs Online x Assuropoil</p>';
		else $body .= $footer;

		$recipient = $notifiable->user->email;

		return [
			'recipient' => $recipient,
			'subject' => $object,
			'body' => $body,
			'tags' => $tags,
			'attachment' => $attachment,
			'template' => $template
		];
	}

	public function toDatabase($notifiable)
	{
		if(
			$notifiable->type == 'animal-adopted-for-known-user' || $notifiable->type == 'adoption-appointment-for-known-user-has-passed' ||
			$notifiable->type == 'breeder-account-validated' || $notifiable->type == 'professionnal-account-validated' || $notifiable->type == 'appointment-reminder' || $notifiable->type == 'visit-appointment-has-passed' ||
			$notifiable->type == 'adoption-appointment-from-jobboard-has-passed' || $notifiable->type == 'post-validated' || $notifiable->type == 'company-validated' ||
			$notifiable->type == 'post-expires-in-three-days' || $notifiable->type == 'post-expires-tomorrow' || $notifiable->type == 'company-expires-in-three-days' || $notifiable->type == 'company-expires-tomorrow' ||
			$notifiable->type == 'acaced-expires-in-a-month' || $notifiable->type == 'acaced-expires-in-a-week' || $notifiable->type == 'auto-validation-adoption-for-breeder' ||
			$notifiable->type == 'professionnal-activity-validated' || $notifiable->type == 'professionnal-activity-expires-in-three-days' || $notifiable->type == 'professionnal-activity-expires-tomorrow'
		) {
			if($notifiable->type == 'animal-adopted-for-known-user') {
				$body = 'Felicitations pour votre nouvelle adoption ! Vous avez débloqué de nouveaux avantages, profitez-en !';
				$url = route('space.benefits.my-benefits');
			}
			elseif($notifiable->type == 'adoption-appointment-for-known-user-has-passed') {
				if($notifiable->model->response) {
					if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					elseif($notifiable->model->response->model instanceof Post) {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
							elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					}
				}
				else {
					if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					elseif($notifiable->model->model instanceof Post) {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
							elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					}
				}

				$body = 'Comment s\'est passé votre adoption ? Validez le retrait de '.$text.' pour recevoir le passeport digital de votre animal';
				$url = route('space.responses.my-messages', ['response' => $notifiable->model->response->id]);
			}
			elseif($notifiable->type == 'breeder-account-validated' || $notifiable->type == 'professionnal-account-validated') {
				$body = 'Votre compte a été validé !';
				$url = route('space.profile.dashboard');
			}
			elseif($notifiable->type == 'appointment-reminder') {
				if($notifiable->model->response) {
					if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
					elseif($notifiable->model->response->model instanceof Post) {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
							elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->response->model->model->name;
					}
				}
				else {
					if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
					elseif($notifiable->model->model instanceof Post) {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
							elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->model->name;
					}
				}

				$body = 'N\'oubliez pas votre rendez-vous avec '.$notifiable->model->to->name.' pour '.$text.' !';
				$url = route('space.appointments.my-appointments', ['appointment' => $notifiable->model->id]);
			}
			elseif($notifiable->type == 'visit-appointment-has-passed') {
				$body = 'Comment s\'est passée la visite avec '.$notifiable->model->to->name.' ?';
				$url = route('space.responses.my-messages', ['response' => $notifiable->model->response->id]);
			}
			elseif($notifiable->type == 'adoption-appointment-from-jobboard-has-passed') {
				if($notifiable->model->response) {
					if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->response->model->name;
					elseif($notifiable->model->response->model instanceof Post) {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
							elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->response->model->model->name;
					}
				}
				else {
					if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name;
					elseif($notifiable->model->model instanceof Post) {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
							elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->model->name;
					}
				}

				$body = 'Veuillez confirmer le retrait de '.$text.' !';
				$url = route('space.responses.my-messages', ['response' => $notifiable->model->response->id]);
			}
			elseif($notifiable->type == 'post-validated') {
				$body = 'Votre annonce de type '.__($notifiable->model->type->name).' de race '.$notifiable->model->model->breed->name.' a été validée et mise en ligne !';
				$url = route('post-search.post.show', ['company' => $notifiable->user->company->slug, 'post' => $notifiable->model->slug, 'breed' => $notifiable->model->model->breed->slug]);
			}
			elseif($notifiable->type == 'company-validated') {
				$body = 'Votre page entreprise a été validée !';
				$url = route('company-search.company.show', ['company' => $notifiable->model->slug]);
			}
			elseif($notifiable->type == 'post-expires-in-three-days') {
				$body = 'Votre annonce expire dans 3 jours';
				$url = route('space.posts.my-post', ['post' => $notifiable->model->slug]);
			}
			elseif($notifiable->type == 'post-expires-tomorrow') {
				$body = 'Votre annonce expire demain';
				$url = route('space.posts.my-post', ['post' => $notifiable->model->slug]);
			}
			elseif($notifiable->type == 'company-expires-in-three-days') {
				$body = 'Votre page entreprise expire dans 3 jours';
				$url = route('space.companies.my-company');
			}
			elseif($notifiable->type == 'company-expires-tomorrow') {
				$body = 'Votre page entreprise expire demain';
				$url = route('space.companies.my-company');
			}
			elseif($notifiable->type == 'acaced-expires-in-a-month' || $notifiable->type == 'acaced-expires-in-a-week') {
				$body = 'Veuillez mettre à jour votre certificat de formation pour continuer à être référencé sur Eleveurs Online';
				$url = route('space.profile.complete-my-profile');
			}
			elseif($notifiable->type == 'auto-validation-adoption-for-breeder') {
				if($notifiable->model->response) {
					if($notifiable->model->response->model instanceof Animal) $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					elseif($notifiable->model->response->model instanceof Post) {
						if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->response->model->model->breed->name;
							elseif($notifiable->model->response->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->response->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					}
				}
				else {
					if($notifiable->model->model instanceof Animal) $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					elseif($notifiable->model->model instanceof Post) {
						if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter' || $notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') {
							if($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter') $text = 'la portée '.$notifiable->model->model->model->breed->name;
							elseif($notifiable->model->model->type->getTranslation('slug', 'en') == 'litter-yet-to-come') $text = 'la portée '.$notifiable->model->model->model->breed->name.' à venir';
						}
						else $text = $notifiable->model->model->name.' '.$notifiable->model->model->breed->name.' '.$notifiable->model->model->values->get('sex');
					}
				}

				$body = 'Félicitations pour l\'adoption de '.$text.' !';
				$url = route('space.companies.my-company');
			}
			elseif($notifiable->type == 'professionnal-activity-validated') {
				$body = 'Votre page professionelle a été validée !';
				$url = route('professionnal-activity-search.professionnal-activity.show', ['activityCategory' => $notifiable->model->category->slug, 'activity' => $notifiable->model->activity->slug, 'professionnalActivity' => $notifiable->model->slug]);
			}
			elseif($notifiable->type == 'professionnal-activity-expires-in-three-days') {
				$body = 'Votre page professionnelle expire dans 3 jours';
				$url = route('space.professionnal-activities.my-professionnal-activity', ['professionnalActivity' => $notifiable->model->slug]);
			}
			elseif($notifiable->type == 'professionnal-activity-expires-tomorrow') {
				$body = 'Votre page professionnelle expire demain';
				$url = route('space.professionnal-activities.my-professionnal-activity', ['professionnalActivity' => $notifiable->model->slug]);
			}

			return [
				'mail_log_id' => $notifiable->id,
				'body' => $body,
				'url' => $url
			];
		}
		else return [];
	}
}
