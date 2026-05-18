<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Enums\{ArticleStates};

use App\Models\{Article, ArticleAuthor, ArticleTag};

class CronRegenerateArticlesGoogleDiscoverSiteMapCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'cron:regenerate_articles_google_discover_site_map';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Regenerate the articles site map for Google Discover';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('cron:regenerate_articles_google_discover_site_map Starts at ' . Carbon::now());

		$articles = Article::where('state', ArticleStates::Published)
		     ->where(function($where) {
				$where->whereNull('end_publication_date')
					  ->orWhere('end_publication_date', '>=', Carbon::now());
			})
			->where(function($where) {
				$where->whereNull('start_publication_date')
					  ->orWhere('start_publication_date', '<=', Carbon::now());
			})
			->latest('created_at')
			->get();

		if($articles->isNotEmpty()) {
			$filename = 'sitemap-discover.xml';
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
			$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">' . PHP_EOL;

			foreach ($articles as $article) {
				$xml .= '  <url>' . PHP_EOL;
				$xml .= '    <loc>' . route('article.show', ['article' => $article->slug]) . '</loc>' . PHP_EOL;
				$xml .= '    <news:news>' . PHP_EOL;
				$xml .= '      <news:publication>' . PHP_EOL;
				$xml .= '        <news:name>' . config('app.name') . '</news:name>' . PHP_EOL;
				$xml .= '        <news:language>fr</news:language>' . PHP_EOL;
				$xml .= '      </news:publication>' . PHP_EOL;
				$xml .= '      <news:publication_date>' . optional($article->start_publication_date ?? $article->created_at)->toIso8601String() . '</news:publication_date>' . PHP_EOL;
				$xml .= '      <news:title>' . htmlspecialchars($article->title) . '</news:title>' . PHP_EOL;
				$xml .= '    </news:news>' . PHP_EOL;
				$xml .= '  </url>' . PHP_EOL;
			}

			$xml .= '</urlset>';

			file_put_contents(public_path('sitemap-discover.xml'), $xml);
		}
		

		Log::info('cron:regenerate_articles_google_discover_site_map Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
