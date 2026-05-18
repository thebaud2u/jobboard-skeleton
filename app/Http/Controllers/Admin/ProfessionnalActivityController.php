<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProfessionnalActivityController extends Controller
{
	/**
	 * Display a listing of all posts
	 *
	 * @return view
	 */
	public function index()
	{
		return view('admin.professionnal-activities.index');
	}
}
