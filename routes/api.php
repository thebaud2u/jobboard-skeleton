<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\StripeWebHookController;

Route::controller(StripeWebHookController::class)->group(function () {
	Route::post('/webhook/stripe', 'handle');
});