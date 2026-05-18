<?php

namespace App\Http\Controllers\Front\Companies;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Enums\ResponseTypes;

use App\Models\{Breed, Company, Response, Species, UsersViews};

class CompanyController extends Controller
{
	public function indexDog(?Breed $breed)
	{
		$species = Species::findBySlug('dog', 'en');

		if(!$breed->exists) $breed = new Breed;

		return view('front.companies.index', compact('species', 'breed'));
	}

	public function indexCat(?Breed $breed)
	{
		$species = Species::findBySlug('cat', 'en');

		if(!$breed->exists) $breed = new Breed;

		return view('front.companies.index', compact('species', 'breed'));
	}

	/**
	 * Display the specified company
	 *
	 * @param  \App\Models\Company $company
	 * @return \Illuminate\View\View
	 */
	public function show(Company $company)
	{
		$lastPublication = $company->lastPublication;

		if($lastPublication) {
			if(
				($lastPublication->isDraft() || $lastPublication->isDraftWaitingModerationForPublication()) &&
				((!Auth::guard('web')->check() || $company->user->id != Auth::guard('web')->user()->id) && !Auth::guard('admin')->check())
			) {
				return redirect()->route('home')->withError(__(':element is not yet published', ['element' => __('This company')]));
			}
			elseif(!$company->user) abort(410);
			else {
				views($company)->record();

				$name = $company->name;
				$userId = $company->user->id;
				$breeds = $company->breeds;
				$description = $company->description;
				$medias = [];
				$hasContacted = false;
				$response = new Response;

				if($company->address) {
					$addressMain = $company->displayPartOfAddress('department+country');
					$addressPart = $company->displayPartOfAddress('department+zipcode+city');
				}
				else {
					$addressMain = null;
					$addressPart = null;
				}

				if($company->offer()->hasOption('contact-button')) {
					if(Auth::guard('web')->check()) {
						$hasContacted = Auth::guard('web')->user()->hasContacted($company);

						if($hasContacted) {
							$response = Response::whereHasMorph('model', [Company::class], function($whereHasMorph) use($company) {
									$whereHasMorph->where('id', $company->id);
								})
								->whereHas('from', function($whereHas) {
									$whereHas->where('id', Auth::guard('web')->user()->id);
								})
								->whereHas('to', function($whereHas) use($company) {
									$whereHas->where('id', $company->user->id);
								})
								->where('type', ResponseTypes::Messaging)
								->first();
						}

						UsersViews::firstOrCreate([
							'user_id' => Auth::guard('web')->user()->id,
							'element_type' => Company::class,
							'element_id' => $company->id
						]);
					}
				}

				foreach($company->getMedia('photos') as $photo) {
					array_push($medias, ['type' => 'image', 'url' => $photo->getAvailableUrl(['optimized'])]);
				}

				if($company->values->has('videos')) {
					foreach($company->values->get('videos') as $value) {
						array_push($medias, ['type' => 'video', 'url' => $value]);
					}
				}

				$companiesUrl = $company->species->first()->getTranslation('slug', 'en') === 'dog' ? 'company-search.dog-companies' : 'company-search.cat-companies';
				$breadcrumb = [
					['title' =>  'Élevages', 'url' => $companiesUrl],
				];

				return view('front.companies.show', [
					'addressMain' => $addressMain,
					'addressPart' => $addressPart,
					'breadcrumb' => $breadcrumb,
					'company' => $company,
					'breeds' => $breeds,
					'description' => $description,
					'hasContacted' => $hasContacted,
					'logo' => $company->getFirstMedia('logo'),
					'medias' => json_encode($medias),
					'name' => $name,
					'photos' => $company->getMedia('photos'),
					'response' => $response,
					'userId' => $userId,
				]);
			}
		}
		else abort(410);
	}
}
