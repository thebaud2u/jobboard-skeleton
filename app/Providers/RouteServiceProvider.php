<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

use App\Models\{
	Activity,
	ActivityCategory,
	Animal,
	Appointment,
	Article,
	Benefit,
	Breed,
	BreedClub,
	BreedStandardGroup,
	Company,
	Offer,
	Post,
	PostType,
	ProfessionnalActivity,
	Response,
	Species,
	User
};

class RouteServiceProvider extends ServiceProvider
{
	/**
	 * The path to the "home" route for your application.
	 *
	 * Typically, users are redirected here after authentication.
	 *
	 * @var string
	 */
	public const HOME = '/';

	/**
	 * Define your route model bindings, pattern filters, and other route configuration.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->configureRateLimiting();

		$this->routes(function() {
			Route::middleware('api')
				->prefix('api')
				->group(base_path('routes/api.php'));

			Route::middleware('web')
				->group(base_path('routes/web.php'));
		});

		Route::bind('activity', function($value) {
			return Activity::findBySlug($value, 'fr');
		});

		Route::bind('activityCategory', function($value) {
			return ActivityCategory::findBySlug($value, 'fr');
		});

		Route::bind('animal', function ($value) {
			$animal = Animal::findBySlug($value);

			if(!$animal) $animal = Animal::find($value);

			return $animal;
		});

		Route::bind('appointment', function($value) {
			return Appointment::find($value);
		});

		Route::bind('article', function($value) {
			return Article::findBySlug($value);
		});

		Route::bind('benefit', function ($value) {
			return Benefit::findBySlug($value);
		});

		Route::bind('breed', function ($value) {
			return Breed::findBySlug($value);
		});

		Route::bind('breedClub', function ($value) {
			return BreedClub::findBySlug($value);
		});

		Route::bind('breedStandardGroup', function ($value) {
			return BreedStandardGroup::findBySlug($value);
		});

		Route::bind('company', function ($value) {
			return Company::findBySlug($value);
		});

		Route::bind('offer', function ($value) {
			return Offer::findBySlug($value);
		});

		Route::bind('post', function ($value) {
			return Post::findBySlug($value);
		});

		Route::bind('postType', function ($value) {
			return PostType::findBySlug($value);
		});

		Route::bind('professionnalActivity', function($value) {
			return ProfessionnalActivity::findBySlug($value);
		});

		Route::bind('response', function($value) {
			return Response::find($value);
		});

		Route::bind('species', function($value) {
			return Species::findBySlug($value, 'fr');
		});

		Route::bind('user', function ($value) {
			return User::findBySlug($value);
		});
	}

	/**
	 * Configure the rate limiters for the application.
	 *
	 * @return void
	 */
	protected function configureRateLimiting()
	{
		RateLimiter::for('api', function (Request $request) {
			return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
		});
	}
}
