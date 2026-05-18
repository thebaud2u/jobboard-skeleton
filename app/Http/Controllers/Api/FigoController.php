<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Services\FigoService;

class FigoController extends Controller
{
	protected FigoService $figoService;

	public function __construct(FigoService $figoService)
	{
		$this->figoService = $figoService;
	}

	public function handle(Request $request)
	{
		return $this->figoService->handle($request);
	}
}
