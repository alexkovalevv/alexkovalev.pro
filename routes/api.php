<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/fetch-title', function (Request $request) {
    $apiKey = 'AIzaSyCEKmua1S0TSp2NVCtjkU4E1tJVPXG1Zlg'; // Вставьте ваш API Key
    $url = $request->query('url');

    // Проверяем, есть ли канал в URL
    if (!$url) {
        return response()->json(['error' => 'URL is required'], 400);
    }

    // Извлекаем ID канала из URL
    preg_match('/channel\/([a-zA-Z0-9_\-]+)/', $url, $matches);
    $channelId = $matches[1] ?? null;

    if (!$channelId) {
        return response()->json(['error' => 'Invalid YouTube URL'], 400);
    }

    try {
        // Формируем URL для API YouTube
        $apiUrl = "https://www.googleapis.com/youtube/v3/channels?part=snippet&id={$channelId}&key={$apiKey}";

        // Отправляем запрос к YouTube Data API
        $response = Http::get($apiUrl);

        if ($response->successful()) {
            $data = $response->json();

            var_dump($data);
            exit;

            // Получаем заголовок канала
            $title = $data['items'][0]['snippet']['title'] ?? 'No title found';

            return response()->json(['title' => $title]);
        } else {
            return response()->json(['error' => 'Unable to fetch channel information'], $response->status());
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
    }
});


