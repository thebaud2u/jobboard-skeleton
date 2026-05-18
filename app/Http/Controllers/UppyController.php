<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class UppyController extends Controller
{
	/**
	 * Single image file upload
	 *
	 * @param  \Illuminate\Http\Request
	 * @return \Illuminate\Http\JsonResponse
	 *
	 * @todo   Make use of Request, Storage, Validator ?
	 */
	public function uppyUpload(Request $request): JsonResponse
	{
		$request->validate([
			'file' => 'required|file|mimes:jpg,jpeg,png|max:16000',
		]);

		$file = $request->file('file');

		// Sécurité : check que c'est bien une image attendue
		$allowedMimeTypes = [
			'image/jpeg' => '.jpg',
			'image/png'  => '.png',
		];

		$mimeType = $file->getMimeType();

		if(!array_key_exists($mimeType, $allowedMimeTypes)) {
			return response()->json([
				'status'  => 0,
				'message' => 'Invalid file type',
			]);
		}

		$baseFilename = Str::uuid();
		$extension = $allowedMimeTypes[$file->getMimeType()];
		$filename = $baseFilename . $extension;

		// Sauvegarde dans storage/app/uploads
		$path = $file->storeAs('uploads', $filename);

		if($path) {
			return response()->json([
				'status'   => 200,
				'message'  => 'success',
				'filename' => $filename,
				'extension'=> $extension,
				'path'     => $path
			]);
		}

		return response()->json([
			'status'  => 0,
			'message' => 'Could not save file',
		]);
	}
}
