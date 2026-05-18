<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Support\LazyCollection;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use Cmgmyr\Messenger\Models\{Participant, Thread};

use App\Enums\{Affixes, AffixTypes, AlertTypes, AnimalSexes, AnimalStates, AppointmentTypes, ArticleStates,
	CatTests, CatVaccines, DogTests, DogVaccines, ModerationStates, PublicationStates, ResponseStates, ResponseTypes};

use App\Models\{
	Activity, ActivityCategory, Admin, Alert, Animal, Appointment, Article, ArticleAuthor, ArticleTag,
	Breed, Company, BreedStandard, BreedStandardGroup,
	City, Country, Crossing,
	Offer,
	Litter,
	MailLog, Message, Moderation,
	Post, PostType, ProfessionnalActivity,
	ReadNotification, Response,
	Section, Species, Subscription, SubSection,
	User
};

use App\Models\Migrations\{
	MigrationAnimal,
	MigrationAnnonce,
	MigrationAnnonceSansElevage,
	MigrationArticle,
	MigrationChiotChaton,
	MigrationElevage,
	MigrationEleveur,
	MigrationRaceChat,
	MigrationRaceChien,
	MigrationRace,
	MigrationRaceDedoublonnee,
	MigrationStandardRace,
	UrlMatch
};

class TempController extends Controller
{
	public $catTests = array();
	public $catVaccines = array();
	public $dogTests = array();
	public $dogVaccines = array();

	public function getBreed($libelleRace, $type): Breed|Null
	{
		$breed = Breed::where('name', 'like', '%'.$libelleRace.'%')
			/*->whereHas('species', function($whereHas) use($type) {
				$whereHas->where('slug->fr', str_replace('s', '', $type));
			})*/
			->first();

		// Recherche de la race dans les standards
		if(!$breed) {
			$breedStandard = BreedStandard::where('name', 'like', '%'.$libelleRace.'%')
				->first();

			if($breedStandard) {
				$breed = Breed::whereHas('breedStandard', function($whereHas) use($breedStandard) {
						$whereHas->where('slug', $breedStandard->slug);
					})
					->first();
			}
		}

		if(!$breed) {
			$migrationStandardRace = MigrationStandardRace::where('races', 'like', '%'.$libelleRace.'%')
				->first();

			if($migrationStandardRace) {
				$idMigrationRace = null;
				$explodeRace = explode(',', $migrationStandardRace->races);
				$explodeIdRace = explode(',', $migrationStandardRace->id_races);

				foreach($explodeRace as $index => $explodedRace) {
					if($explodedRace == $libelleRace) {
						$idMigrationRace = $explodeIdRace[$index];
						break;
					}
				}

				if($idMigrationRace) {
					if($type == 'chiens') {
						$migrationRace = MigrationRaceChien::where('id_ancienne_liste', $idMigrationRace)
							->first();
					}
					elseif($type == 'chats') {
						$migrationRace = MigrationRaceChat::where('ancien_id', $idMigrationRace)
							->first();
					}

					if($migrationRace) {
						$breed = Breed::where('name', $migrationRace->nom)
							->first();
					}
				}
			}
		}

		return $breed;
	}

	public function getBreedForNewAnimal($animal, $type): Breed|Null
	{
		if($type == 'chiens') $species = 1;
		elseif($type == 'chats') $species = 2;

		$breed = Breed::where('name', 'like', '%'.$animal->race.'%')
			->where('species_id', $species)
			->first();

		// Recherche de la race dans les standards
		if(!$breed) {
			$breedStandard = BreedStandard::where('name', 'like', '%'.$animal->race.'%')
				->first();

			if($breedStandard) {
				$breed = Breed::whereHas('breedStandard', function($whereHas) use($breedStandard) {
						$whereHas->where('slug', $breedStandard->slug);
					})
					->first();
			}
		}

		if(!$breed) {
			$migrationStandardRace = MigrationStandardRace::where('races', 'like', '%'.$animal->race.'%')
				->first();

			if($migrationStandardRace) {
				$idMigrationRace = null;
				$explodeRace = explode(',', $migrationStandardRace->races);
				$explodeIdRace = explode(',', $migrationStandardRace->id_races);

				foreach($explodeRace as $index => $explodedRace) {
					if($explodedRace == $animal->race) {
						$idMigrationRace = $explodeIdRace[$index];
						break;
					}
				}

				if($idMigrationRace) {
					if($type == 'chiens') {
						$migrationRace = MigrationRaceChien::where('id_ancienne_liste', $idMigrationRace)
							->first();
					}
					elseif($type == 'chats') {
						$migrationRace = MigrationRaceChat::where('ancien_id', $idMigrationRace)
							->first();
					}

					if($migrationRace) {
						$breed = Breed::where('name', $migrationRace->nom)
							->first();
					}
				}
			}
		}

		return $breed;
	}

	public function getCompany($idMembre, $identifiantElevage): Company|Null
	{
		$company = null;

		if($identifiantElevage) {
			$company = Company::where('values->identifiant', $identifiantElevage)
				->first();

			if(!$company) {
				$company = MigrationElevage::where('id_elevage', $identifiantElevage)
					->first();

				if($company) Log::error('ELEVAGE NON CREE : '.$identifiantElevage);
				$company = null;
			}
		}
		elseif($idMembre) {
			$eleveur = MigrationEleveur::where('identifiant', $idMembre)
				->first();

			if($eleveur) {
				$user = User::where('values->identifiant', $idMembre)
					->orWhere('email', $eleveur->email)
					->first();

				if($user) {
					if($user->company) $company = $user->company;
					else {
						$company = MigrationElevage::where('identifiant', $idMembre)
							->first();

						if($company) Log::error('ELEVAGE NON CREE : '.$company->id_elevage);
						$company = null;
					}
				}
			}
		}

		return $company;
	}

	public function createAnimalLife($animal, $company): void
	{
		if($animal->statut == '') $state = AnimalStates::Other;
		elseif($animal->statut == 'Petit disponible à la vente') $state = AnimalStates::Available;
		elseif($animal->statut == 'Petit réservé') $state = AnimalStates::Reserved;

		if($company) {
			$company->life()->create([
				'animal_id' => $animal->id,
				'state' => $state
			]);
		}
	}

	public function createAnimal($species, $breed, $animal, $litterAnimal = false): void
	{
		$createLife = false;
		$company = $this->getCompany($animal->id_membre, $animal->identifiant_elevage);

		if($company) {
			$animalValues = new Collection();
			$animalValues->put('affix_type', AffixTypes::Company)
				->put('sex', $animal->sexe == 'Femelle' ? AnimalSexes::Female : AnimalSexes::Male)
				->put('identifiant', $animal->id_animal)
				->put('tests', $species->getTranslation('slug', 'en') == 'dog' ? $this->dogTests : $this->catTests)
				->put('vaccines', $species->getTranslation('slug', 'en') == 'dog' ? $this->dogVaccines : $this->catVaccines);

			if($animal->robe) $animalValues->put('color', $animal->robe);
			if($animal->identification) $animalValues->put('identification', $animal->identification);

			if($animal->statut == 'Non actif') $animalValues->put('breeder_status', 'inactive');
			elseif($animal->statut == 'Reproducteur actif') {
				$animalValues->put('breeder_status', 'active')
					->put('display', true);
			}
			else $createLife = true;

			// Pour les enfants (chiots/chatons)
			if($litterAnimal) {
				if($animal->numero_livre_origine) {
					$animalValues->put('lof_number', $animal->numero_livre_origine);
					$animalValues->put('pure_breed', true);
				}
				else $animalValues->put('pure_breed', false);
			}
			// Parents (adultes)
			else {
				$animalValues->put('pure_breed', $animal->de_race == 'Oui' ? true : false);

				if($animal->date_naissance) $animalValues->put('birth_date', $animal->date_naissance);
			}

			$newAnimal = new Animal;
			$newAnimal->name = $animal->nom;

			if($animal->description) $newAnimal->description = $animal->description;

			$newAnimal->species_id = $species->id;
			$newAnimal->breed_id = $breed->id;
			$newAnimal->company_id = $company->id;
			$newAnimal->values = $animalValues;
			$newAnimal->save();

			$company->breeds()->syncWithoutDetaching($breed->id);

			if($createLife) $this->createAnimalLife($newAnimal, $company);

			// Pour les enfants (chiots/chatons)
			if($litterAnimal) {
				if($animal->photos) {
					$photos = explode(', ', $animal->photos);

					foreach($photos as $photo) {
						$photo = trim($photo);
						$photo = str_replace('/home/eol/', '', $photo);

						if(Storage::disk('public')->exists($photo)) {
							$newAnimal->addMedia(storage_path('app/public/'.$photo))
								->preservingOriginal()
								->toMediaCollection('photos'.$newAnimal->id);
						}
					}
				}
			}
			// Parents (adultes)
			else {
				$photo = str_replace('/home/eol/', '', $animal->photo);

				if(Storage::disk('public')->exists($photo)) {
					$newAnimal->addMedia(storage_path('app/public/'.$photo))
						->preservingOriginal()
						->toMediaCollection('photos'.$newAnimal->id);
				}
				else {
					$animalForPhotos = MigrationChiotChaton::where('id_animal', $animal->id_animal)
						->first();

					if($animalForPhotos) {
						if($animalForPhotos->photos) {
							$photos = explode(', ', $animalForPhotos->photos);

							foreach($photos as $photo) {
								$photo = trim($photo);
								$photo = str_replace('/home/eol/', '', $photo);

								if(Storage::disk('public')->exists($photo)) {
									$newAnimal->addMedia(storage_path('app/public/'.$photo))
										->preservingOriginal()
										->toMediaCollection('photos'.$newAnimal->id);
								}
							}
						}
					}
				}

				if($animal->mere && $animal->mere != 0) {
					$motherAnimal = MigrationAnimal::where('id_animal', $animal->mere)
						->where('date_ajout_bdd', '>=', '2024-01-01 %')
						->first();

					if($motherAnimal) {
						$existingMotherAnimal = Animal::where('values->identifiant', $motherAnimal->id_animal)
							->first();

						if(!$existingMotherAnimal) {
							$breed = $this->getBreedForNewAnimal($motherAnimal, $motherAnimal->espece);

							if($breed) {
								$species = $breed->species;

								$this->createAnimal($species, $breed, $motherAnimal);
							}
							else Log::info('Race non trouvée : '.$motherAnimal->race);
						}
						else Log::info('Animal existant : '.$existingMotherAnimal->id);
					}
					else Log::info('motherAnimal non trouvé : '.$animal->mere);
				}

				if($animal->pere && $animal->pere != 0) {
					$fatherAnimal = MigrationAnimal::where('id_animal', $animal->pere)
						->where('date_ajout_bdd', '>=', '2024-01-01 %')
						->first();

					if($fatherAnimal) {
						$existingFatherAnimal = Animal::where('values->identifiant', $fatherAnimal->id_animal)
							->first();

						if(!$existingFatherAnimal) {
							$breed = $this->getBreedForNewAnimal($fatherAnimal, $fatherAnimal->espece);

							if($breed) {
								$species = $breed->species;

								$this->createAnimal($species, $breed, $fatherAnimal);
							}
							else Log::info('Race non trouvée : '.$fatherAnimal->race);
						}
						else Log::info('Animal existant : '.$existingFatherAnimal->id);
					}
					else Log::info('fatherAnimal non trouvé : '.$animal->pere);
				}
			}
		}
		else Log::info('Elevage inexistant : '.$animal->identifiant_elevage);
	}

	public function script($code, $data = null)
	{
		if($code == 'gghrMgcSPFS6UdQiuV92') {
			// Import race bull terrier
			$data = [
				[
					'breed_standard_group_id' => 3,
					'name' => 'Bull Terrier - Standard FCI N° 11',
					'illustration' => 'Bull_Terrier.jpg',
					'translation' => 'Prof. R. Triquet. Mise à jour : J. Mulholland / Version originale : (EN).',
					'origin' => 'Grande Bretagne',
					'published_at' => Carbon::createFromFormat('d.m.Y', '05.07.2011'),
					'use' => 'Terrier',
					'caracteristics' => "
						<h2<CLASSIFICATION FCI : </h2>
						<p>Groupe 3 Terriers. </p>
						<p>Section 3 Terriers de type bull. </p>
						<p>Sans épreuve de travail. </p>

						<h2>BREF APERCU HISTORIQUE :</h2>
						<p>C’est un certain James HINKS qui a fixé le type dans les années 1850 en sélectionnant la tête en forme ovoïde. La race, dans son type actuel, a été exposée pour la première fois à Birmingham en 1862. Le Bull Terrier Club a été fondé en 1887. A propos de cette race, ce qui est vraiment intéressant est que le standard stipule très clairement « Il n’y a pas de limite de poids ni de taille. Le chien doit donner l’impression d’avoir le maximum de substance par rapport à sa taille, en tenant compte de la qualité du sujet et du sexe. Il doit toujours être bien proportionné. »</p>
						<p>Un modèle de plus petite taille est connu depuis le début du 19ème siècle mais il a été délaissé avant la 1ère Guerre Mondiale au point d’être retiré des registres du Kennel Club en 1918. En 1938 il a été relancé par un groupe d’enthousiastes mené par le Colonel Richard GLYN qui a formé le Miniature Bull Terrier Club. Le standard est identique à celui du Bull Terrier avec l’exception d’une limite de la taille.</p>

						<h2>ASPECT GENERAL: </h2>
						<p>Bâti en force, musclé, bien proportionné et actif, l’expression est vive, résolue et intelligente. Il est unique par son chanfrein descendant et sa tête ovoïde. Quelle que soit sa taille, les caractères sexuels des mâles et des femelles doivent être bien marqués.</p>

						<h2>COMPORTEMENT / CARACTERE : </h2>
						<p>Courageux, plein d’entrain et enjoué. De tempérament égal, il est soumis aux ordres. Bien qu’obstiné, il est particulièrement gentil avec les gens.</p>

						<h2>TETE</h2>
						<p>Elle est longue, forte et pleine de substance jusqu’au bout du museau, mais elle n’est pas grossière. Vue de face elle est ovoïde et parfaitement remplie, sa surface étant exempte de creux ou de dépressions. Le profil s’incurve doucement vers le bas, du sommet du crâne à la truffe.</p>

						<h2>REGION CRANIENNE : </h2>
						<p>Crâne : La partie supérieure du crâne est presque plate d’une oreille à l’autre</p>

						<h2>REGION FACIALE : </h2>
						<p>Truffe : Noire ; à l’extrémité, elle est inclinée vers le bas. Les narines sont bien développées.</p>
						<p>Lèvres : De lignes pures, serrées.</p>
						<p>Mâchoires/dents : La mâchoire inférieure est forte et épaisse. Les dents sont saines, nettes, fortes, de bonne taille et régulièrement implantées. Elles offrent un articulé parfait, régulier et complet en ciseaux, c’est-à-dire que les incisives supérieures recouvrent les inférieures dans un contact étroit implantées à l’équerre par rapport aux mâchoires.</p>

						<h2>YEUX : </h2>
						<p>Les yeux paraissent étroits, disposés obliquement, triangulaires, bien placés dans les orbites, noir ou d’un brun aussi foncé que possible de façon à paraître presque noirs ; ils ont un éclat perçant. La distance de la truffe aux yeux doit être sensiblement supérieure à celle des yeux à l’occiput. Les yeux bleus en totalité ou en partie sont un défaut.</p>

						<h2>OREILLES : </h2>
						<p>Petites, minces, rapprochées ; le chien doit pouvoir les tenir bien droites et elles doivent alors se dresser bien verticalement.</p>

						<h2>COU : </h2>
						<p>Le cou est très musclé, long, avec un profil supérieur galbé. Il va en s’amincissant des épaules vers la tête, il est exempt de fanon.</p>

						<h2>CORPS : </h2>
						<p>Bien arrondi avec des côtes bien cintrées ; du garrot à la région sternale, la hauteur de la poitrine est grande, de sorte que celle-ci est plus près du sol que le ventre.</p>
						<p>Dos : Court et fort. La ligne du dessus est horizontale derrière le garrot. Elle forme une courbe ou arcure légère sur le rein.</p>
						<p>Rein : Large et bien musclé.</p>
						<p>Poitrine : Vu de face, le poitrail est large.</p>
						<p>Ligne du dessous et ventre : De la région sternale au ventre, elle s’incurve gracieusement vers le haut.</p>

						<h2>QUEUE : </h2>
						<p>Courte, attachée bas, portée horizontalement. Epaisse à la base, elle s’amenuise en une fine pointe.</p>

						<h2>MEMBRES ANTERIEURS :</h2>
						<p>Vue d’ensemble : Le chien doit être solidement planté sur des membres parfaitement parallèles. Chez le chien adulte, la longueur des antérieurs, du coude au sol, doit être approximativement égale à la hauteur de poitrine.</p>
						<p>Epaule : Forte et musclée sans être chargée. Les omoplates sont larges, plates et bien attachées contre la paroi thoracique. Elles doivent présenter de bas en haut une très nette inclinaison vers l’arrière de leur bord antérieur, en formant un angle presque droit avec le bras. </p>
						<p>Coude : Tenu droit et solide. </p>
						<p>Avant-bras : Ossature ronde, la plus forte possible et de qualité.</p>
						<p>Métacarpe : D’aplomb.</p>
						<p>Pieds antérieurs : Ronds et compacts avec des doigts bien cambrés.</p>

						<h2>MEMBRES POSTERIEURS : </h2>
						<p>Vue d’ensemble : Les membres postérieurs sont parallèles lorsqu’ils sont vus de derrière</p>
						<p>Cuisse : Musclée.</p>
						<p>Grasset (genou) : Bien coudé.</p>
						<p>Jambe : Bien développée.</p>
						<p>Pointe des Jarrets: Bien angulé.</p>
						<p>Métatarse : Courts et forts</p>
						<p>Pieds postérieurs : Les pieds sont ronds et compacts ; les doigts sont bien cambrés.</p>

						<h2>ALLURES : </h2>
						<p>En action, le chien donne l’impression d’être bien soudé, couvrant le terrain d’une allure régulière et facile à grandes enjambées dégagées, d’un air preste qui lui est caractéristique. Au trot, les membres se déplacent en restant parallèles, qu’ils soient vus de face ou de derrière ; ils ne convergent vers une ligne médiane que lorsque la vitesse augmente. Les antérieurs ont une bonne extension et les postérieurs, par leur action régulière au niveau des hanches et la bonne flexion des grassets et des jarrets, donnent beaucoup d’impulsion. </p>

						<h2>Peau:</h2>
						<p>Elle épouse parfaitement la forme du corps.</p>

						<h2>ROBE :</h2>
						<p>Qualité du poil : le poil est court, plat, uni, dur au toucher et bien luisant. Le chien peut présenter en hiver, un sous-poil de texture douce.</p>
						<p>Couleur du poil : Chez les chiens blancs, la robe est d’un blanc pur. La pigmentation de la peau et les marques en tête ne constituent pas des défauts. Chez les chiens de couleur, la couleur doit prédominer sur le blanc. A égalité des autres points, le bringé doit avoir la préférence. Le noir, le bringé, le rouge, le fauve et la robe tricolore sont admis. La robe blanche mouchetée ou truitée est un défaut. La robe bleue et la robe foie (marron) sont à rejeter.</p>

						<h2>TAILLE ET POIDS : </h2>
						<p>Il n’y a pas de limite de poids ni de taille. Le chien doit donner l’impression d’avoir le maximum de substance par rapport à sa taille, en tenant compte de la qualité du sujet et du sexe. </p>

						<h2>DEFAUTS : </h2>
						<p>Tout écart par rapport à ce qui précède doit être considéré comme un défaut qui sera pénalisé en fonction de sa gravité et de ses conséquences sur la santé et le bien-être du chien.</p>

						<h2>DEFAUTS ENTRAINANT L’EXCLUSION : </h2>
						<p>• Chien agressif ou peureux. </p>
						<p>• Tout chien présentant de façon évidente des anomalies d’ordre physique ou comportemental sera disqualifié.</p>

						<h2>N.B. :</h2>
						<p>• Les mâles doivent avoir deux testicules d’aspect normal complètement descendus dans le scrotum. </p>
						<p>• Seuls les chiens sains et capables d’accomplir les fonctions pour lesquelles ils ont été sélectionnés, et dont la morphologie est typique de la race, peuvent être utilisés pour la reproduction.</p>"
				]
			];

			foreach($data as $breedStandard) {
				$newBreedStandard = new BreedStandard;
				$newBreedStandard->breed_standard_group_id = $breedStandard['breed_standard_group_id'];
				$newBreedStandard->name = $breedStandard['name'];
				$newBreedStandard->translation = $breedStandard['translation'];
				$newBreedStandard->use = $breedStandard['use'];
				$newBreedStandard->origin = $breedStandard['origin'];
				$newBreedStandard->published_at = $breedStandard['published_at'];
				$newBreedStandard->caracteristics = $breedStandard['caracteristics'];
				$newBreedStandard->save();

				if(Storage::disk('public')->exists('echanges-migration/photos/standards/'.$breedStandard['illustration'])) {
					$newBreedStandard->addMedia(storage_path('app/public/echanges-migration/photos/standards/'.$breedStandard['illustration']))
						->preservingOriginal()
						->toMediaCollection('photo');
				}
			}

			LazyCollection::make(function() {
				$path = base_path("database/seeders/Migrations/csv/race_BULL_TERRIER.csv");
				$handle = fopen($path, 'r');

				$buffer = '';
				while (!feof($handle)) {
					$line = fgets($handle);

					// Nettoyage à la volée :
					// 1. Supprimer BOM éventuel
					$line = preg_replace('/^\xEF\xBB\xBF/', '', $line);

					// 2. Supprimer les retours chariot internes (Windows CR ou LF fantômes)
					// → mais seulement s'ils ne marquent pas la fin de l'enregistrement CSV
					// On les stocke dans un buffer pour reconstruire les lignes mal découpées
					$buffer .= $line;

					// On tente de parser la ligne complète :
					$tmp = str_getcsv($buffer, ';', '"');

					// Si le nombre de colonnes est insuffisant, on continue d’ajouter les lignes suivantes
					if (count($tmp) < 35 && !feof($handle)) {
						continue;
					}

					// Une fois qu'on a une ligne complète, on la renvoie
					yield $tmp;

					// Et on vide le buffer
					$buffer = '';
				}

				fclose($handle);
			})
			->skip(1)
			->chunk(1000)
			->each(function(LazyCollection $chunk) {
				$records = $chunk->map(function($row) {
					return [
						'nouvel_id' => $row[0],
						'nom' => $row[1],
						'id_ancienne_liste' => $row[2],
						'utilisation_questionnaire' => $row[3],
						'espece' => $row[4],
						'nom_commun' => $row[5],
						'numero_groupe' => $row[6],
						'top_races' => $row[7],
						'libele_groupe' => $row[8],
						'chapo_introduction' => $row[9],
						'aspect_general' => $row[10],
						'caracteristiques' => $row[11],
						'entretien' => $row[12],
						'sante' => $row[13],
						'id_photos' => $row[14],
						'poil' => $row[15],
						'taille' => $row[16],
						'protecteur' => $row[17],
						'sportif' => $row[18],
						'affectueux' => $row[19],
						'assistance' => $row[20],
						'besoin_education' => $row[21],
						'besoin_attention' => $row[22],
						'besoin_toilettage' => $row[23],
						'rarete_race' => $row[24],
						'chien_chasse' => $row[25],
						'hypoallergenique' => $row[26],
						'voyage_avion' => $row[27],
						'deuxieme_categorie' => $row[28],
						'brachicephale' => $row[29],
						'prix_moyen_etalon' => $row[30],
						'prix_moyen_chiot_LOF' => $row[31],
						'prix_moyen_retraite' => $row[32],
						'id_standard' => $row[33],
						'titre_standard' => $row[34],
					];
				})->toArray();

				DB::table('migration_race_chiens')->insert($records);
			});

			$bullTerrier = MigrationRaceChien::where('nom', 'Bull terrier')
				->first();

			if($bullTerrier) {
				$newBreed = new Breed;
				$newBreed->species_id = 1;
				$newBreed->name = $bullTerrier->nom;

				$values = new Collection();

				$texts = [
					'introduction' => str_replace(["\n", "\r"], ' ', $bullTerrier->chapo_introduction),
					'general_aspect' => str_replace(["\n", "\r"], ' ', $bullTerrier->aspect_general),
					'caracteristiques' => str_replace(["\n", "\r"], ' ', $bullTerrier->caracteristiques),
					'care' => str_replace(["\n", "\r"], ' ', $bullTerrier->entretien),
					'health' => str_replace(["\n", "\r"], ' ', $bullTerrier->sante)
				];

				$caracteristics = [
					'protector' => $bullTerrier->protecteur,
					'sporty' => $bullTerrier->sportif,
					'affectionate' => $bullTerrier->affectueux,
					'assisting_dog' => $bullTerrier->assistance == 0 ? false : true,
					'education_need' => $bullTerrier->besoin_education,
					'attention_need' => $bullTerrier->besoin_attention,
					'breed_rarity' => $bullTerrier->rarete_race == 0 ? false : true,
					'grooming_need' => $bullTerrier->besoin_toilettage,
					'hunting_breed' => $bullTerrier->chien_chasse == 0 ? false : true,
					'hypoallergenic' => $bullTerrier->hypoallergenique == 0 ? false : true,
					'plane' => $bullTerrier->voyage_avion == 0 ? false : true,
					'second_category' => $bullTerrier->deuxieme_categorie == 0 ? false : true,
					'brachicephale' => $bullTerrier->brachicephale == 0 ? false : true
				];

				$prices = [
					'stud_average_price' => $bullTerrier->prix_moyen_etalon,
					'LOF_puppy_average_price' => $bullTerrier->prix_moyen_chiot_LOF,
					'retired_average_price' => $bullTerrier->prix_moyen_retraite
				];

				$values->put('informations', $texts)
					->put('caracteristics', $caracteristics)
					->put('hairs', $bullTerrier->poil)
					->put('size', $bullTerrier->taille)
					->put('prices', $prices)
					->put('used_for_widget', $bullTerrier->utilisation_questionnaire == 1 ? true: false);

				if($bullTerrier->top_races != '') $values->put('top_breed', $bullTerrier->top_races);

				$newBreed->values = $values;

				$breedStandard = BreedStandard::where('name', 'Bull Terrier - Standard FCI N° 11')
					->first();

				if($breedStandard) {
					$newBreed->breed_standard_id = $breedStandard->id;
				}

				$newBreed->save();

				if(Storage::disk('public')->exists('echanges-migration/photos/standards/Bull_Terrier.jpg')) {
					$newBreedStandard->addMedia(storage_path('app/public/echanges-migration/photos/standards/Bull_Terrier.jpg'))
						->preservingOriginal()
						->toMediaCollection('photo');
				}
			}
		}
		elseif($code == 'Lx80L4yhr2UV5vjmyE11' && !is_null($data)) {
			/*
				pour une adresse mail donnée, il faudrait récupérer l'entreprise et rechercher tous les animaux qu'on a dans le fichier migration-animaux.
				Et pour chaque animal, on check s'il existe sur notre site ou non, s'il existe pas, on l'importe.
				Il faut le faire peu importe l'animal, un adulte, un petit, ...
			*/
			$user = User::where('email', $data)
				->first();

			if($user) {
				foreach(CatTests::asHumanArray() as $index => $value) {
					$this->catTests[] = $index;
				}

				foreach(CatVaccines::asHumanArray() as $index => $value) {
					$this->catVaccines[] = $index;
				}

				foreach(DogTests::asHumanArray() as $index => $value) {
					$this->dogTests[] = $index;
				}

				foreach(DogVaccines::asHumanArray() as $index => $value) {
					$this->dogVaccines[] = $index;
				}

				if($user->company) {
					$migrationAnimals = MigrationAnimal::where('id_membre', $user->values->get('identifiant'))
						->get();

					if($migrationAnimals->isNotEmpty()) {
						foreach($migrationAnimals as $migrationAnimal) {
							$animal = Animal::where('values->identifiant', $migrationAnimal->id_animal)
								->first();

							if(!$animal) {
								$breed = $this->getBreedForNewAnimal($migrationAnimal, $migrationAnimal->espece);

								if($breed) {
									$species = $breed->species;

									$this->createAnimal($species, $breed, $migrationAnimal);
								}
								else Log::info('Race non trouvée : '.$migrationAnimal->race);
							}
						}
					}

					$migrationChiotsChatons = MigrationChiotChaton::where('id_membre', $user->values->get('identifiant'))
						->get();

					if($migrationChiotsChatons->isNotEmpty()) {
						foreach($migrationChiotsChatons as $migrationChiotChaton) {
							$animal = Animal::where('values->identifiant', $migrationChiotChaton->id_animal)
								->first();

							if(!$animal) {
								$breed = $this->getBreed($migrationChiotChaton, $migrationChiotChaton->famille);

								if($breed) {
									$species = $breed->species;

									$this->createAnimal($species, $breed, $migrationChiotChaton, true);
								}
							}
						}
					}
				}
				else dd('le user n\'a pas d\'entreprise ou l\'entreprise n\'a pas d\'identifiant de migration');
			}
			else dd('aucun user de trouvé');
		}
		elseif($code == 'zfpgd1JuGM2DGNWXVAwc') {
			// toutes les races trouvées ou non
			$migrationElevages = MigrationElevage::all();

			foreach($migrationElevages as $index => $elevage) {
				$breed = $this->getBreed($elevage->libelle_race, $elevage->espece);

				if($breed) var_dump('migrationElevage->identifiant : '.$elevage->id_elevage.';'.$elevage->espece.';'.$elevage->libelle_race.';'.$breed->species->name.';'.$breed->name.';');
			}
		}
		elseif($code == 'HOiyD626iKyUAdqVeH1M') {
			// switch de races
			$migrationsElevage = MigrationElevage::where('id_race', 148)
				->get();

			$catOrientalBreed = Breed::find(452);
			$dogOrientalBreed = Breed::find(158);
			$speciesCat = Species::findBySlug('cat', 'en');
			$speciesDog = Species::findBySlug('dog', 'en');

			if($migrationsElevage->isNotEmpty()) {
				foreach($migrationsElevage as $migrationElevage) {
					$company = Company::where('values->identifiant', $migrationElevage->id_elevage)
						->first();

					if($company) {
						$companyHasOriental = $company->breeds()->where('breed_id', $catOrientalBreed->id)
							->first();

						if(!$companyHasOriental) {
							$companyHasDogOriental = $company->breeds()->where('breed_id', $dogOrientalBreed->id)
								->first();

							if($companyHasDogOriental) {
								$companyHasCatSpecies = $company->species()->where('species_id', 2)
									->first();

								if(!$companyHasCatSpecies) {
									$company->species()->syncWithoutDetaching($speciesCat->id);
								}

								$company->breeds()->syncWithoutDetaching($catOrientalBreed->id);
								$company->breeds()->detach($dogOrientalBreed->id);
								$company->load('species');
								$company->load('breeds');

								$companyHasOtherDogBreed = $company->breeds()->whereHas('species', function($whereHas) {
										$whereHas->where('slug->en', 'dog');
									})
									->get();

								if($companyHasOtherDogBreed->isEmpty()) $company->species()->detach($speciesDog->id);
							}
						}
					}
				}
			}
		}
		elseif($code == 'VytWzcwtTXfejtzIaF4K') {
			$companies = Company::whereHas('user')
				->whereHas('lastPublication', function($whereHasPublication) {
					$whereHasPublication->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->count();

			$companiesOfDog = Company::whereHas('user')
				->whereHas('lastPublication', function($whereHasPublication) {
					$whereHasPublication->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHas('species', function($whereHas) {
					$whereHas->where('slug->en', 'dog');
				})
				->count();

			$companiesOfCat = Company::whereHas('user')
				->whereHas('lastPublication', function($whereHasPublication) {
					$whereHasPublication->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHas('species', function($whereHas) {
					$whereHas->where('slug->en', 'cat');
				})
				->count();

			$posts = Post::whereHas('user')
				->whereHas('lastPublication', function($whereHas) {
					$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHasMorph('model', [Animal::class, Litter::class], function($whereHasMorph, $class) {
					if($class === Animal::class) {
						$whereHasMorph->where(function($where) {
							$where->whereHas('lastLife', function($whereHas) {
								$whereHas->where('state', AnimalStates::Available);
							})
							->orDoesntHave('lastLife');
						});
					}
				})
				->count();

			$postsOfDog = Post::whereHas('user')
				->whereHas('lastPublication', function($whereHas) {
					$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHasMorph('model', [Animal::class, Litter::class], function($whereHasMorph, $class) {
					if($class === Animal::class) {
						$whereHasMorph->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', 'dog');
						})
						->where(function($where) {
							$where->whereHas('lastLife', function($whereHas) {
								$whereHas->where('state', AnimalStates::Available);
							})
							->orDoesntHave('lastLife');
						});
					}
					elseif($class === Litter::class) {
						$whereHasMorph->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', 'dog');
						});
					}
				})
				->count();

			$postsOfCat = Post::whereHas('user')
				->whereHas('lastPublication', function($whereHas) {
					$whereHas->whereIn('state', [
						PublicationStates::Published,
						PublicationStates::PublishedUpdatedWaitingModeration,
						PublicationStates::PublishedUpgradedWaitingModeration
					]);
				})
				->whereHasMorph('model', [Animal::class, Litter::class], function($whereHasMorph, $class) {
					if($class === Animal::class) {
						$whereHasMorph->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', 'cat');
						})
						->where(function($where) {
							$where->whereHas('lastLife', function($whereHas) {
								$whereHas->where('state', AnimalStates::Available);
							})
							->orDoesntHave('lastLife');
						});
					}
					elseif($class === Litter::class) {
						$whereHasMorph->whereHas('species', function($whereHas) {
							$whereHas->where('slug->en', 'cat');
						});
					}
				})
				->count();

				dd([
					'posts' => $posts,
					'postsOfDog' => $postsOfDog,
					'postsOfCat' => $postsOfCat,
					'companies' => $companies,
					'companiesOfDog' => $companiesOfDog,
					'companiesOfCat' => $companiesOfCat
				]);
		}
		elseif($code == 'OiVFKuUHe3fNOKRNF7Uq') {
			$threads = Thread::whereHas('messages')
				->whereHas('participants.user') // juste pour s'assurer qu'un user existe
				->with(['participants.user' => function ($query) {
					$query->withTrashed();
				}])
				->get();

			return view('temp', compact('threads'));
		}
		elseif($code == 'GQu9auFvlcxA5IXGAASH') {
			$responses = Response::whereIn('type', [ResponseTypes::Application, ResponseTypes::Messaging])
				->get();

			foreach($responses as $response) {
				if(!$response->values->has('archive')) {
					$values = $response->values;
					$values->put('archive', collect(['asking' => false, 'answerer' => false]));
					$response->values = $values;
					$response->saveQuietly();
				}
			}
		}
		elseif($code == 'A6ZeEpt6fpDfIkBP7USk') {

		}
	}
}
