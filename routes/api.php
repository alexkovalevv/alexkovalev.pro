<?php

use App\Http\Controllers\FetchUrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/fetch-title', [FetchUrlController::class, 'fetchPageContent']);

