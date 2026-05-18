<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnimalController extends Controller
{
	public function index()
	{
		return view('admin.animals.index');
	}

	public function upload(Request $request)
	{
		if(!empty($_FILES['upload'])) {
			if(!empty($_FILES['upload']['tmp_name'])) {
				$fileName = time().'.'.$request->file('upload')->extension();
				$request->file('upload')->move(storage_path('app/public/animals/'), $fileName);

				return response()->json(['url' => '/storage/animals/'.$fileName]);
			}
		}

		return response()->json(['error' => ['message' => 'The image upload failed']]);
	}
}
