<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Enums\{PublicationStates, ModerationStates};

use App\Models\{Animal, Company, Moderation, Post, ProfessionnalActivity, Subscription, User};

class DashboardController extends Controller
{
	/**
	 * Admin dashboard
	 */
	public function index()
	{
		$countCompanies = Company::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->count();

		$countPosts = Post::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->count();

		$countProfessionnalActivities = ProfessionnalActivity::whereHas('lastPublication', function($whereHas) {
				$whereHas->whereIn('state', [
					PublicationStates::Published,
					PublicationStates::PublishedUpdatedWaitingModeration,
					PublicationStates::PublishedUpgradedWaitingModeration
				]);
			})
			->count();

		$latestModerationIds = Moderation::select(DB::raw('MAX(id) as id'))
			->groupBy('model_type', 'model_id')
			->pluck('id')
			->toArray();

		$countModeration = Moderation::whereIn('id', $latestModerationIds)
			->where('state', ModerationStates::Waiting)
			->whereHas('model', function($whereHas) {
				$whereHas->whereNull('deleted_at');
			})
			->count();

		return view('admin.dashboard', [
			'countAnimals' => Animal::all()->count(),
			'countCompanies' => $countCompanies,
			'countModerations' => $countModeration,
			'countPosts' => $countPosts,
			'countSubscriptions' => Subscription::all()->count(),
			'countUsers' => User::all()->count(),
			'countProfessionnalActivities' => $countProfessionnalActivities,
		]);
	}
}
