<?php

namespace App\Http\Controllers\Front\Articles;

use App\Http\Controllers\Controller;
use App\Enums\ArticleStates;
use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Request;

class ArticleController extends Controller
{
	public function index($argument1 = null, $argument2 = null)
	{
		return view('front.articles.index', [
			'argument1' => $argument1,
			'argument2' => $argument2
		]);
	}

/**
 * Check if the article is viewable.
 *
 * An article is viewable if it is published or if it is in preview mode.
 * If the article is not published, it is viewable only if the date of embargo is not reached.
 * If the article is published, it is viewable only if the date of publication is reached
 * 
 * @param bool $isPreviewing Is the request in preview mode?
 * @param Article $article The article to check
 * @return bool True if the article is viewable, false otherwise
 */
	public function isViewable($isPreviewing, Article $article)
	{
		
		if(!$isPreviewing && $article->state != ArticleStates::Published) {
			return 'forbidden';
		}

		// On vérifie si la date d'embargo est dépassé (sauf en preview)
		if(!$isPreviewing && ($article->end_publication_date && Carbon::now()->greaterThan($article->end_publication_date)) ) {
			return 'forbidden';
		}

		// On vérifie si la date start (date de publication) est dépassé (sauf en preview)
		if(!$isPreviewing && ( $article->start_publication_date && Carbon::now()->lessThan($article->start_publication_date))) {
			return 'not_yet';
		}

		return true;
	}

	public function show(Article $article)
	{
		$isPreviewing = Request::has('previsu');
		
		$viewable = $this->isViewable($isPreviewing, $article);
		
		if($viewable === 'forbidden') {
			abort(410);
		}
		
		if($viewable === 'not_yet') {
			abort(404);
		}

		if (!$isPreviewing) {
			views($article)->record();
		}

		// EXCLURE ceux avec embargo dépassé et ceux pas encore publiés
		$relatedArticles = Article::where('state', ArticleStates::Published)
			->where(function($where) {
				$where->whereNull('end_publication_date')
					  ->orWhere('end_publication_date', '>=', Carbon::now());
			})
			->where(function($where) {
				$where->whereNull('start_publication_date')
					  ->orWhere('start_publication_date', '<=', Carbon::now());
			})
			->whereHas('sections', function($whereHas) use($article) {
				$whereHas->where('slug', $article->mainSection()->slug);
			})
			->whereNot('slug', $article->slug)
			->latest()
			->take(4)
			->get();

		return view('front.articles.show', compact('article', 'relatedArticles'));
	}
}