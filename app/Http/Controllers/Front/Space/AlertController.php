<?php

namespace App\Http\Controllers\Front\Space\Alerts;

use App\Http\Controllers\Controller;

class AlertController extends Controller
{
	public function index()
	{
		return view('front.space.alerts.index');
	}
}
