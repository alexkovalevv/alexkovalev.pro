<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/fetch-title', function (Request $request) {
    $url = $request->query('url');

    if (!$url) {
        return response()->json(['error' => 'URL is required'], 400);
    }

    try {
        // Получаем содержимое страницы
        $response = Http::get($url);

        if ($response->successful()) {
            // Парсим HTML и извлекаем заголовок
            $html = $response->body();
            preg_match('/<title>(.*?)<\/title>/s', $html, $matches);
            $title = $matches[1] ?? 'No title found';

            return response()->json(['title' => $title]);
        } else {
            return response()->json(['error' => 'Unable to fetch the URL'], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
});

