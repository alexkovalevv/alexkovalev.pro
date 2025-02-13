<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class FetchUrlController extends Controller
{
    public function fetchPageContent(Request $request)
    {
        $url = $request->input('url'); // Получаем URL из запроса

        if (!$url) {
            return response()->json(['error' => 'URL is required'], 400);
        }

        // Проверяем, является ли URL ссылкой на YouTube
        if ($this->isYouTubeUrl($url)) {
            // Выполняем эмуляцию через Puppeteer
            return $this->fetchUsingPuppeteer($url);
        } else {
            // Пытаемся получить title страницы
            return $this->fetchPageTitle($url);
        }
    }

    /**
     * Проверяет, является ли ссылка YouTube URL.
     */
    private function isYouTubeUrl(string $url): bool
    {
        $youtubePatterns = [
            'youtube.com',
            'youtu.be'
        ];

        // Проверяем наличие домена YouTube в URL
        foreach ($youtubePatterns as $pattern) {
            if (str_contains($url, $pattern)) {
                return true;
            }
        }

        return false;
    }

    private function fetchUsingPuppeteer(string $url)
    {
        $scriptPath = base_path('resources/node-scripts/puppeteer.js');
        $process = new Process(['node', $scriptPath, $url]);

        try {
            $process->mustRun();
            $output = $process->getOutput(); // HTML-вывод от Puppeteer

            // Извлечение заголовка страницы с использованием регулярного выражения
            preg_match('/<title>(.*?)<\/title>/s', $output, $matches);
            $title = $matches[1] ?? null;

            if ($title) {
                return response()->json(['title' => $title]);
            }

            return response()->json(['error' => 'Title not found in HTML output'], 500);
        } catch (ProcessFailedException $exception) {
            return response()->json(['error' => $exception->getMessage()], 500);
        } catch (\Exception $exception) {
            return response()->json(['error' => 'An unexpected error occurred: ' . $exception->getMessage()], 500);
        }
    }

    /**
     * Пытается извлечь заголовок страницы у не-YouTube URL.
     */
    private function fetchPageTitle(string $url)
    {
        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/132.0.0.0 Safari/537.36',
                'Accept-Language' => 'ru-RU,en;q=0.9'
            ])->get($url);

            if ($response->successful()) {
                $html = $response->body();

                // Извлечение заголовка страницы с использованием регулярного выражения
                preg_match('/<title>(.*?)<\/title>/s', $html, $matches);
                $title = $matches[1] ?? 'No title found';

                return response()->json(['title' => $title]);
            } else {
                return response()->json(['error' => 'Unable to fetch the URL'], $response->status());
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred: ' . $e->getMessage()], 500);
        }
    }
}
