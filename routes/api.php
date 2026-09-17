<?php

use App\Http\Controllers\XenditWebhookController;
use Illuminate\Routing\Route;

Route::post('/webhook/xendit', [XenditWebhookController::class, 'handle']);