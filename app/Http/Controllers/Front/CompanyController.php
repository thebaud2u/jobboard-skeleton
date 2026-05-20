<?php

namespace App\Http\Controllers\Front\Companies;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\{Company, Response, UsersViews};

class CompanyController extends Controller
{
	public function index()
	{
		return view('front.companies.index');
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

				return view('front.companies.show', [
					'addressMain' => $addressMain,
					'addressPart' => $addressPart,
					'company' => $company,
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
