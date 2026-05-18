<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BenefitController extends Controller
{
	public function index()
	{
		return view('admin.benefits.index');
	}
}
