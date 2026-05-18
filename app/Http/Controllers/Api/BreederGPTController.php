<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

use App\Services\BreederGPTService;

class BreederGPTController extends Controller
{
	protected $breederGPT;

	public function __construct(BreederGPTService $breederGPT)
	{
		$this->breederGPT = $breederGPT;
	}

	public function stream(Request $request)
	{
		$text = $request->input('text');
		$userId = $request->user()->id;
		$conversationId = $request->input('conversationId') ?? null;

		// Désactiver tous les buffers
		while(ob_get_level() > 0) {
			ob_end_clean();
		}

		if(function_exists('apache_setenv')) @apache_setenv('no-gzip', '1');

		return response()->stream(function () use ($text, $userId, $conversationId) {
			$this->breederGPT->streamMessage($text, $userId, $conversationId, function ($chunk) {
				echo "data: " . json_encode($chunk) . "\n\n";

				if(ob_get_level() > 0) ob_flush();
				flush();
			});
		}, 200, [
			'Content-Type' => 'text/event-stream',
			'Cache-Control' => 'no-cache',
			'Connection' => 'keep-alive',
			'X-Accel-Buffering' => 'no',
		]);
	}
}
