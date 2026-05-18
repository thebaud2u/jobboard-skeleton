<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\SitemapIndex;
use Spatie\Sitemap\Tags\Url;

use App\Enums\{AnimalStates, ArticleStates, PublicationStates};

use App\Models\{
	Activity, ActivityCategory, Admin, Animal, Article, ArticleAuthor, ArticleSection, ArticleTag, ArticleTarget,
	Breed, Company, BreedStandardGroup,
	Post, PostType, ProfessionnalActivity,
	Species
};

class CronRegenerateSiteMapCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cron:regenerate_site_map';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Regenerate the sitemaps';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('cron:regenerate_site_map Starts at ' . Carbon::now());

		$allUrls = [];

		// Static pages
		$allUrls = array_merge($allUrls, [
			'creer-compte',
			'chien/comparateur-races',
			'chat/comparateur-races',
			'chien/quelle-race-pour-moi',
			'chat/quelle-race-pour-moi',
			'resultat-race-chien',
			'resultat-race-chat',
			'/chat/toutes-les-races',
			'/chien/toutes-les-races',
			'/chat/elevages',
			'/chien/elevages',
			'/contact',
			'/',
			'/eleveurs',
			'/eleveurs/offres',
			'/professionnels',
			'/newsletter',
			'/cgu',
			'/cgv',
			'/cookies',
			'/mentions-legales',
			'/produits-services/services-prestations/assurance-animale/adoptant',
			'/confidentialite',
			'/qui-sommes-nous',
			'chien',
			'chat',
			'/prenoms',
		]);

		// Dynamic pages
		// 'article.index' => 'articles/{arg1?}/{arg2?}/{arg3?}'
		$articleSections = ArticleSection::all();
		$articleTargets = ArticleTarget::all();
		$species = Species::all();

		// toutes les sections
		foreach($articleSections as $articleSection) {
			$allUrls[] = "/articles/{$articleSection->slug}";

			// toutes les sections + sous-sections
			foreach($articleTargets as $articleTarget) {
				$allUrls[] = "/articles/{$articleSection->slug}/{$articleTarget->slug}";
			}

			foreach($species as $specie) {
				$allUrls[] = "/articles/{$articleSection->slug}/{$specie->getTranslation('slug', 'fr')}";
			}
		}

		// toutes les combinaisons tags + species
		$articleAuthors = ArticleAuthor::all();
		$articleTags = ArticleTag::all();
		$articleTargets = ArticleTarget::all();

		foreach($articleAuthors as $articleAuthor) {
			$allUrls[] = "/articles/{$articleAuthor->slug}";
		}

		foreach($articleTags as $articleTag) {
			$allUrls[] = "/articles/{$articleTag->slug}";
		}

		foreach($species as $specie) {
			$allUrls[] = "/articles/{$specie->getTranslation('slug', 'fr')}";
		}

		foreach($articleTargets as $articleTarget) {
			$allUrls[] = "/articles/{$articleTarget->slug}";
		}

		// 'article.show' => 'article/{article}'
		$articles = Article::where('state', ArticleStates::Published)
			->where(function($where) {
				$where->whereNull('end_publication_date')
					->orWhere('end_publication_date', '>=', Carbon::now());
			})
			->where(function($where) {
				$where->whereNull('start_publication_date')
					->orWhere('start_publication_date', '<=', Carbon::now());
			})
			->get();
		// tout les articles
		foreach($articles as $article) {
			$allUrls[] = "/article/{$article->slug}";
		}

		/*
			'animal-search.animal.show' => '/elevages/{company}/{post}/{breed}/{animal}-{type}-{sex}'
			'post-search.post.show' => '/elevages/{company}/{post}/{breed}'
		*/
		$posts = Post::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		foreach($posts as $post) {
			if($post->type->getTranslation('slug', 'en') == 'litter') {
				if($post->model->hasAvailableChildren()) {
					foreach($post->model->getAvailableChildren() as $animal) {
						$type = $animal->species->getTranslation('slug', 'en') == 'cat' ? __('kitten') : __('puppy');
						$sex = Str::slugify(__($animal->getSex()));

						$allUrls[] = "/elevages/{$animal->company->slug}/{$post->slug}/{$animal->breed->slug}/{$animal->id}-{$type}-{$sex}";
					}
				}
			}

			$allUrls[] = "/elevages/{$post->model->company->slug}/{$post->slug}/{$post->model->breed->slug}";
		}

		/*
			'post-search.cat-posts-with-post-type' => 'chat/{postType}'
			'post-search.dog-posts-with-post-type' => 'chien/{postType}'

			'breed-search.cat-breeds.show' => '/chat/fiche/{breed}'
			'breed-search.cat-breeds.show.standard' => '/chat/fiche/{breed}/standard'
			'company-search.cat-companies-with-breed' => '/chat/elevages/{breed}'
			'post-search.cat-posts-with-breed' => 'chat/{postType}/{breed}'

			'breed-search.dog-breeds.show' => '/chien/fiche/{breed}'
			'breed-search.dog-breeds.show.standard' => '/chien/fiche/{breed}/standard'
			'company-search.dog-companies-with-breed' => '/chien/elevages/{breed}'
			'post-search.dog-posts-with-breed' => 'chien/{postType}/{breed}'
		*/
		$breeds = Breed::all();
		$postTypes = PostType::all();

		foreach($postTypes as $postType) {
			$allUrls[] = "/chat/{$postType->getTranslation('slug', 'fr')}";
			$allUrls[] = "/chien/{$postType->getTranslation('slug', 'fr')}";
		}

		foreach($breeds as $breed) {
			if($breed->species->getTranslation('slug', 'en') == 'cat') {
				$allUrls[] = "/chat/fiche/{$breed->slug}";

				if($breed->breedStandard) $allUrls[] = "/chat/fiche/{$breed->slug}/standard";

				$allUrls[] = "/chat/elevages/{$breed->slug}";

				foreach($postTypes as $postType) {
					$allUrls[] = "/chat/{$postType->getTranslation('slug', 'fr')}/{$breed->slug}";
				}
			}
			elseif($breed->species->getTranslation('slug', 'en') == 'dog') {
				$allUrls[] = "/chien/fiche/{$breed->slug}";

				if($breed->breedStandard) $allUrls[] = "/chien/fiche/{$breed->slug}/standard";

				$allUrls[] = "/chien/elevages/{$breed->slug}";

				foreach($postTypes as $postType) {
					$allUrls[] = "/chien/{$postType->getTranslation('slug', 'fr')}/{$breed->slug}";
				}
			}
		}

		// 'breed-search.search-behavior-breeds' => '/rechercher-races-comportement/{value}'
		$allUrls[] = '/rechercher-races-comportement/'.__('affectionate');
		$allUrls[] = '/rechercher-races-comportement/'.__('protector');
		$allUrls[] = '/rechercher-races-comportement/'.__('assistance');
		$allUrls[] = '/rechercher-races-comportement/'.__('sporty');

		// 'breed-search.search-standard-group-breeds' => '/rechercher-races-du-groupe/{breedStandardGroup}/{species}'
		$breedStandardGroups = BreedStandardGroup::all();

		foreach($breedStandardGroups as $breedStandardGroup) {
			if($breedStandardGroup->breeds->first()) $allUrls[] = "/rechercher-races-du-groupe/{$breedStandardGroup->slug}/{$breedStandardGroup->breeds->first()->species->getTranslation('slug', 'fr')}";
		}

		//	'company-search.company.show' => '/elevages/{company}'
		$companies = Company::whereHas('lastPublication', function($whereHasPublication) {
				$whereHasPublication->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		foreach($companies as $company) {
			$allUrls[] = "/elevages/{$company->slug}";
		}

		//'professionnal-activity-search.professionnal-activities' => '/produits-services/{activityCategory?}/{activity?}',
		$activityCategories = ActivityCategory::all();

		foreach($activityCategories as $activityCategory) {
			$allUrls[] = "/produits-services/{$activityCategory->getTranslation('slug', 'fr')}";

			foreach($activityCategory->activities as $activity) {
				$allUrls[] = "/produits-services/{$activityCategory->getTranslation('slug', 'fr')}/{$activity->getTranslation('slug', 'fr')}";
			}
		}

		// 'professionnal-activity-search.professionnal-activity.show' => '/produits-services/{activityCategory}/{activity}/{professionnalActivity}',
		$professionnalActivities = ProfessionnalActivity::whereHas('lastPublication', function($whereHasPublication) {
				$whereHasPublication->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->get();

		foreach($professionnalActivities as $professionnalActivity) {
			$allUrls[] = "/produits-services/{$professionnalActivity->category->slug}/{$professionnalActivity->activity->slug}/{$professionnalActivity->slug}";
		}

		// 'animalname.by-letter' => '/prenoms/{letter}'
		$letters = ['a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'];
		foreach($letters as $letter) {
			$allUrls[] = "/prenoms/{$letter}";
		}

		$chunks = array_chunk($allUrls, 50000);

		$index = SitemapIndex::create();

		foreach ($chunks as $i => $urls) {
			$filename = "sitemap-" . ($i + 1) . ".xml";

			$sitemap = Sitemap::create();
			foreach ($urls as $url) {
				$sitemap->add(Url::create($url));
			}

			$sitemap->writeToFile(public_path($filename));
			$index->add(url($filename));
		}

		$index->writeToFile(public_path('sitemap.xml'));

		Log::info('cron:regenerate_site_map Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
