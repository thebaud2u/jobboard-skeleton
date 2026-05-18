<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class BreedClubController extends Controller
{
	public function index()
	{
		return view('admin.breed-clubs.index');
	}
}
