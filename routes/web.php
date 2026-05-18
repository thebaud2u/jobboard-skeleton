<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\UppyController;
use App\Http\Controllers\Front\{
	ArticleController,
	CompanyController as FrontCompanyController,
	ContactController,
	HomeController,
	LegalPageController,
	NewsletterController,
	PostController as FrontPostController
};
use App\Http\Controllers\Front\Space\{
	AlertController,
	CompanyController,
	FavoriteController,
	PostController,
	ProfileController,
	ResponseController,
	SearchController
};

use App\Models\Media;

/* ===================================================================== *
 * Register / SSO routes
 * ===================================================================== */

require __DIR__ . '/auth.php';

/* ===================================================================== *
 * Admin (app back-office)
 * ===================================================================== */

require __DIR__ . '/admin.php';

/* ===================================================================== *
 * public routes
 * ===================================================================== */
Route::get('/redirect-to-login', function (Request $request) {
	$from = $request->query('from', '/');

	$parsedFrom = parse_url($from);
	$parsedApp  = parse_url(config('app.url'));

	$isInternal = !isset($parsedFrom['host']) || $parsedFrom['host'] === $parsedApp['host'];

	session(['url.intended' => $isInternal ? $from : '/']);

	return redirect()->route('login');
})->name('redirect.to.login');

Route::controller(ContactController::class)->group(function() {
	Route::get(__('routes.contact.index'), 'index')->name('contact');
	Route::post(__('routes.contact.submit'), 'submit')->name('contact.submit');
});

Route::controller(HomeController::class)->group(function() {
	Route::get(__('routes.home.index'), 'index')->name('home');
	Route::get(__('routes.home.offer'), 'indexOffer')->name('home.offer');
	Route::get('/faq', 'faq')->name('faq');
});

Route::controller(NewsletterController::class)->group(function() {
	Route::get(__('routes.newsletter.index'), 'index')->name('newsletter.index');
	Route::post(__('routes.newsletter.subscribe'), 'subscribe')->name('newsletter.subscribe');
	Route::get(__('routes.newsletter.unsubscribe'), 'unsubscribe')->name('newsletter.unsubscribe');
	Route::post(__('routes.newsletter.form-unsubscribe'), 'formUnsubscribe')->name('newsletter.form-unsubscribe');
});

Route::name('legal-pages.')->group(function() {
	Route::controller(LegalPageController::class)->group(function() {
		Route::get(__('routes.legal-pages.cgu'), 'cgu')->name('cgu');
		Route::get(__('routes.legal-pages.cgv'), 'cgv')->name('cgv');
		Route::get(__('routes.legal-pages.cookies'), 'cookies')->name('cookies');
		Route::get(__('routes.legal-pages.mentions'), 'mentionsLegales')->name('mentions');
		Route::get(__('routes.legal-pages.confidentialite'), 'politiqueConfidentialite')->name('confidentialite');
		Route::get(__('routes.legal-pages.lp.figo'), 'figo')->name('figo');
		Route::get(__('routes.legal-pages.quisommesnous'), 'quiSommesNous')->name('quisommesnous');
	});
});

/* ------------- *
*  Uppy uploader *
* -------------- */
Route::middleware(['auth.any'])->group(function() {
	Route::post('/uppy-upload', [UppyController::class, 'uppyUpload'])->name('uppy-upload');
});

/* ===================================================================== *
 * User authenticated routes
 * ===================================================================== */
Route::middleware(['auth:web'])->group(function() {
	Route::get('/documents/{filename}', function ($filename) {
		$disk = Storage::disk('private');
		$basePath = realpath($disk->path(''));
		$resolvedPath = realpath($disk->path($filename));

		if(!$resolvedPath || !str_starts_with($resolvedPath, $basePath . DIRECTORY_SEPARATOR)) abort(404, 'Fichier introuvable');

		return response()->file($resolvedPath);
	})->where('filename', '[a-zA-Z0-9_\-\.\/]+')->name('documents.show');

	Route::prefix(__('routes.space'))->name('space.')->group(function() { // 'space.*'
		Route::controller(AlertController::class)->name('alerts.')->group(function() {
			Route::get(__('routes.space.alerts.my-alerts'), 'index')->name('my-alerts'); // space.favorites.my-alerts
		});

		Route::controller(CompanyController::class)->name('companies.')->group(function() {
			Route::get(__('routes.space.companies.my-company'), 'index')->name('my-company'); // space.companies.my-company
			Route::get(__('routes.space.companies.show-offers'), 'showOffers')->name('show-offers'); // space.companies.show-offers
			Route::post(__('routes.space.companies.offer-chosen'), 'offerChosen')->name('offer-chosen'); // space.companies.offer-chosen
			Route::get(__('routes.space.companies.create'), 'create')->name('create'); // space.companies.create
			Route::get(__('routes.space.companies.update'), 'update')->name('update'); // space.companies.update
			Route::get(__('routes.space.companies.upgrade'), 'upgrade')->name('upgrade'); // space.companies.upgrade
			Route::get(__('routes.space.companies.extend-offer'), 'extendOffer')->name('extend-offer'); // space.companies.extend-offer
			Route::get(__('routes.space.companies.checkout'), 'checkout')->name('checkout'); // space.companies.checkout
		});

		Route::controller(FavoriteController::class)->name('favorites.')->group(function() {
			Route::get(__('routes.space.favorites.my-favorites'), 'index')->name('my-favorites'); // space.favorites.my-favorites
		});

		Route::controller(PostController::class)->name('posts.')->group(function() { // 'space.posts.*'
			Route::get(__('routes.space.posts.my-posts'), 'index')->name('my-posts'); // space.posts.my-posts
			Route::get(__('routes.space.posts.my-post'), 'show')->name('my-post'); // space.posts.my-post
			Route::get(__('routes.space.posts.show-offers'), 'showOffers')->name('show-offers'); // space.posts.show-offers
			Route::post(__('routes.space.posts.submit-form'), 'submitForm')->name('submit-form'); // space.posts.submit-form
			Route::post(__('routes.space.posts.offer-chosen'), 'offerChosen')->name('offer-chosen'); // space.posts.offer-chosen
			Route::get(__('routes.space.posts.create'), 'create')->name('create'); // space.posts.create
			Route::get(__('routes.space.posts.update'), 'update')->name('update'); // space.posts.update
			Route::delete(__('routes.space.posts.destroy'), 'destroy')->name('destroy'); // space.posts.destroy
			Route::get(__('routes.space.posts.unpublish'), 'unpublish')->name('unpublish'); // space.posts.unpublish
			Route::get(__('routes.space.posts.extend-offer'), 'extendOffer')->name('extend-offer'); // space.posts.extend-offer
			Route::get(__('routes.space.posts.buy-to-publish'), 'buyToPublish')->name('buy-to-publish'); // space.posts.buy-to-publish
			Route::get(__('routes.space.posts.checkout'), 'checkout')->name('checkout'); // space.posts.checkout
		});

		Route::controller(ProfileController::class)->name('profile.')->group(function() {
			Route::get(__('routes.space.profile.dashboard'), 'dashboard')->name('dashboard'); // space.profile.dashboard
			Route::get(__('routes.space.profile.my-profile'), 'myProfile')->name('my-profile'); // space.profile.my-profile
			Route::get(__('routes.space.profile.my-orders'), 'myOrders')->name('my-orders'); // space.profile.my-orders
			Route::get(__('routes.space.profile.complete-my-profile'), 'completeMyProfile')->name('complete-my-profile'); // space.profile.complete-my-profile
			Route::get(__('routes.space.profile.settings'), 'settings')->name('settings'); // space.profile.settings
			Route::get(__('routes.space.profile.settings.change-password'), 'changePassword')->name('settings.change-password'); // space.profile.settings.change-password
			Route::post(__('routes.space.profile.settings.update-password'), 'updatePassword')->name('settings.update-password'); // space.profile.settings.update-password
			Route::post(__('routes.space.profile.settings.delete-account'), 'deleteAccount')->name('settings.delete-account'); // space.profile.settings.delete-account
			Route::get(__('routes.space.profile.my-notifications'), 'myNotifications')->name('my-notifications'); // space.profile.my-notifications
		});

		Route::controller(ResponseController::class)->name('responses.')->group(function() { // 'space.responses.*'
			Route::get(__('routes.space.responses.my-messages'), 'myMessages')->name('my-messages'); // 'space.responses.my-messages'
			Route::post(__('routes.space.responses.create-conversation'), 'createConversation')->name('create-conversation'); // 'space.responses.create-conversation'
			Route::get(__('routes.space.responses.create'), 'create')->name('create'); // 'space.responses.create'
		});

		Route::controller(SearchController::class)->name('searches.')->group(function() { // 'space.searches.*'
			Route::get(__('routes.space.searches.my-searches'), 'index')->name('my-searches'); // space.searches.my-searches
			Route::post(__('routes.space.searches.save'), 'save')->name('save'); // space.searches.save
			Route::delete(__('routes.space.searches.delete'), 'delete')->name('delete'); // space.searches.delete
		});
	});
});

Route::controller(ArticleController::class)->name('article.')->group(function() {
	Route::get(__('routes.article.index'), 'index')->name('index');
	Route::get(__('routes.article.show'), 'show')->name('show');
});

Route::controller(FrontCompanyController::class)->name('company-search.')->group(function() {
	Route::get(__('routes.company-search.cat-companies'), 'indexCat')->name('cat-companies');
	Route::get(__('routes.company-search.cat-companies-with-breed'), 'indexCat')->name('cat-companies-with-breed');
	Route::get(__('routes.company-search.dog-companies'), 'indexDog')->name('dog-companies');
	Route::get(__('routes.company-search.dog-companies-with-breed'), 'indexDog')->name('dog-companies-with-breed');
	Route::get(__('routes.company-search.company.show'), 'show')->name('company.show');
});

Route::controller(FrontPostController::class)->name('post-search.')->group(function() {
	Route::get(__('routes.post-search.post.show'), 'show')->where('post', '^annonce-[a-z0-9\-]+$')->name('post.show');
	Route::get(__('routes.post-search.posts-with-post-type'), 'index')->name('posts-with-post-type');
	Route::get(__('routes.post-search.posts'), 'indexDog')->name('posts');
});
