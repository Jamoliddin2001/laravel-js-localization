<?php

use Illuminate\Support\Facades\Route;
use JsLocalization\Http\Controllers\JsLocalizationController;

Route::get('/js-localization/messages', [JsLocalizationController::class, 'createJsMessages']);
Route::get('/js-localization/config', [JsLocalizationController::class, 'createJsConfig']);
Route::get('/js-localization/localization.js', [JsLocalizationController::class, 'deliverLocalizationJS']);
Route::get('/js-localization/all.js', [JsLocalizationController::class, 'deliverAllInOne']);
