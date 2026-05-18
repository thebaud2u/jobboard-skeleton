<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

use Illuminate\Auth\Events\Verified;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


use App\Enums\ContactTypes;

use App\Models\{TempApplication, User};

class VerifyEmailController extends Controller
{
	/**
	 * Mark the user's email address as verified.
	 */
	public function __invoke(Request $request): RedirectResponse
	{
		$user = User::findOrFail($request->route('id'));

		if(!hash_equals((string) $request->route('hash'), sha1($user->getEmailForVerification()))) {
			abort(403);
		}

		if($user->markEmailAsVerified()) event(new Verified($user));

		$hasTempApplication = TempApplication::where('email', $user->email)
			->latest()
			->first();

		if($hasTempApplication) {
			Auth::guard('web')->login($user);
			$user->last_logon = Carbon::now();
			$user->save();

			if($hasTempApplication->type === ContactTypes::Contact) session()->put('application-modals.email-verified-just-now-for-contact', true);
			elseif($hasTempApplication->type === ContactTypes::Call) session()->put('application-modals.email-verified-just-now-for-call', true);

			return redirect()->to($hasTempApplication->url);
		}
		else return redirect()->route('login')->withSuccess(__('You have successfully verified your email address, please log in'));
	}
}
