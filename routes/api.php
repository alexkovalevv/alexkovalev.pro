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
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36',
            'Accept-Language' => 'ru-RU,en;q=0.9' // Язык - английский
        ])->get($url);

        if ($response->successful()) {
            $html = $response->body();

            // Извлечение заголовка страницы
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


