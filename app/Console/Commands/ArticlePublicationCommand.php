<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

use App\Enums\ArticleStates;

use App\Models\{Article};

class ArticlePublicationCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'article:publication';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Check articles publication schedule : publish or unpublish articles';

	/**
	 * Execute the console command.
	 *
	 * @return int
	 */
	public function handle()
	{
		Log::info('article:publication Starts at ' . Carbon::now());

		$articlesToUnpublish = Article::where('state', ArticleStates::Published)
			->where('end_publication_date', '<=', Carbon::now())
			->get();

		if($articlesToUnpublish->isNotEmpty()) {
			foreach($articlesToUnpublish as $article) {
				$article->state = ArticleStates::Unpublished;
				$article->save();
			}
		}

		Log::info('articlesToUnpublish is done ' . Carbon::now());

		$articleToPublish = Article::where('state', ArticleStates::WaitingPublication)
			->where('start_publication_date', '<=', Carbon::now())
			->get();

		if($articleToPublish->isNotEmpty()) {
			foreach($articleToPublish as $article) {
				$article->state = ArticleStates::Published;
				$article->save();
			}
		}

		Log::info('articleToPublish is done ' . Carbon::now());
		Log::info('article:publication Ended at ' . Carbon::now());

		return Command::SUCCESS;
	}
}
