<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TempController;
use App\Http\Controllers\Admin\ {
	ArticleController,
	AuthController,
	CompanyController,
	DashboardController,
	FaqController,
	ModerationController,
	PermissionController,
	PostController,
	SettingController,
	SubscriptionController
};

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/back-office')->name('admin.')->group(function () {
	Route::get('/', [AuthController::class, 'index'])->name('index'); // admin.index
	Route::post('/login', [AuthController::class, 'store'])->name('login'); // admin.login

	/** Admin authenticated routes */
	Route::middleware(['auth:admin'])->group(function () {
		Route::get('/script/{code}/{data?}', [TempController::class, 'script']);

		Route::get('/documents/{filename}', function ($filename) {
			$disk = Storage::disk('private');
			$basePath = realpath($disk->path(''));
			$resolvedPath = realpath($disk->path($filename));

			if(!$resolvedPath || !str_starts_with($resolvedPath, $basePath . DIRECTORY_SEPARATOR)) abort(404, 'Fichier introuvable');

			return response()->file($resolvedPath);
		})->where('filename', '[a-zA-Z0-9_\-\.\/]+')->name('documents.show');

		Route::controller(ArticleController::class)->prefix('/articles')->name('articles.')->group(function () {
			Route::get('/', 'index')->name('index'); // admin.articles.index
			Route::post('/upload', 'upload')->name('upload'); // admin.articles.upload
		});

		Route::controller(AuthController::class)->group(function () {
			Route::get('/log-as-user/{user}', 'logAsUser')->name('log-as-user'); // admin.log-as-user
			Route::get('/sign-out-as-user', 'signOutAsUser')->name('sign-out-as-user'); // admin.sign-out-as-user
			Route::post('/logout', 'logout')->name('logout'); // admin.logout
		});

		Route::controller(CompanyController::class)->prefix('/companies')->name('companies.')->group(function() {
			Route::get('/', 'index')->name('index'); // admin.companies.index
		});

		Route::controller(DashboardController::class)->group(function () {
			Route::get('/dashboard', 'index')->name('dashboard'); // admin.dashboard
		});

		Route::controller(FaqController::class)->prefix('/faqs')->name('faqs.')->group(function() {
			Route::get('/', 'index')->name('index'); // admin.faqs.index
			Route::post('/upload', 'upload')->name('upload'); // admin.faqs.upload
		});

		Route::controller(ModerationController::class)->prefix('/moderations')->name('moderations.')->group(function () {
			Route::get('/', 'index')->name('index'); // admin.moderations.index
			Route::post('/moderate/update', 'updateComment')->name('update-comment'); // admin.moderations.update-comment
			Route::get('/moderate/{moderation}', 'moderate')->name('moderate'); // admin.moderations.moderate
			Route::get('/preview/{moderation}', 'preview')->name('preview-moderation'); // admin.moderations.preview-moderation
			Route::post('/decision', 'decision')->name('decision'); // admin.moderations.decision
		});

		Route::controller(PostController::class)->prefix('/posts')->name('posts.')->group(function() {
			Route::get('/', 'index')->name('index'); // admin.posts.index
		});

		Route::controller(SettingController::class)->prefix('/settings')->name('settings.')->group(function() {
			Route::get('/', 'index')->name('index'); // admin.settings.index
		});

		Route::controller(SubscriptionController::class)->prefix('/subscriptions')->name('subscriptions.')->group(function() {
			Route::get('/', 'index')->name('index'); // admin.subscriptions.index
		});

		Route::controller(PermissionController::class)->prefix('/permissions')->name('permissions.')->group(function () {
			Route::get('/index', 'index')->name('index'); // admin.permissions.index
			Route::get('/create', 'create')->name('create'); // admin.permissions.create
			Route::get('/edit', 'edit')->name('edit'); // admin.permissions.edit
			Route::get('/destroy', 'destroy')->name('destroy'); // admin.permissions.destroy
		});
	});
});
