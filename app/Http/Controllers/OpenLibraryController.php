<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OpenLibraryController extends Controller
{
    public function __invoke(Request $request)
    {
        // Validasi kata kunci pencarian
        $validated = $request->validate([
            'q' => ['required', 'string', 'min:2', 'max:100'],
        ]);

        $query = trim($validated['q']);

        // Cache pencarian selama 5 menit
        $cacheKey = 'open-library-search:' .
            sha1(mb_strtolower($query));

        try {

            $result = Cache::remember(
                $cacheKey,
                now()->addMinutes(5),
                function () use ($query) {

                    // Request ke Open Library
                    $response = Http::acceptJson()
                        ->connectTimeout(10)
                        ->timeout(20)
                        ->get('https://openlibrary.org/search.json', [
                            'q' => $query,
                            'limit' => 8,
                            'fields' => 'key,title,author_name,first_publish_year,cover_i',
                        ]);

                    $response->throw();

                    $docs = $response->json('docs');

                    // Memastikan format respons sesuai
                    if (!is_array($docs)) {
                        throw new \UnexpectedValueException(
                            'Format respons Open Library tidak sesuai.'
                        );
                    }

                    $books = [];

                    foreach ($docs as $doc) {

                        if (!is_array($doc)) {
                            continue;
                        }

                        $key = $doc['key'] ?? '';
                        $title = trim((string) ($doc['title'] ?? ''));

                        // Validasi identitas dan judul buku
                        if (
                            $title === '' ||
                            !is_string($key) ||
                            !preg_match('/^\/works\/OL\d+W$/', $key)
                        ) {
                            continue;
                        }

                        // Menggabungkan nama penulis
                        $authors = $doc['author_name'] ?? [];

                        if (!is_array($authors)) {
                            $authors = [];
                        }

                        $authors = array_filter(
                            array_map(
                                fn($author) => trim((string) $author),
                                $authors
                            )
                        );

                        $author = count($authors)
                            ? implode(', ', array_slice($authors, 0, 3))
                            : 'Penulis tidak diketahui';

                        // Memvalidasi tahun terbit
                        $year = filter_var(
                            $doc['first_publish_year'] ?? null,
                            FILTER_VALIDATE_INT
                        );

                        if (
                            $year === false ||
                            $year < 1000 ||
                            $year > (int) now()->format('Y')
                        ) {
                            $year = null;
                        }

                        // Memvalidasi cover ID
                        $coverId = filter_var(
                            $doc['cover_i'] ?? null,
                            FILTER_VALIDATE_INT
                        );

                        if ($coverId === false || $coverId <= 0) {
                            $coverId = null;
                        }

                        // Normalisasi data buku
                        $books[] = [
                            'open_library_key' => $key,
                            'judul' => mb_substr($title, 0, 255),
                            'penulis' => mb_substr($author, 0, 255),
                            'tahun' => $year,
                            'cover_id' => $coverId,
                        ];
                    }

                    return [
                        'data' => $books,
                        'meta' => [
                            'query' => $query,
                            'total' => (int) (
                                $response->json('numFound')
                                ?? count($books)
                            ),
                            'returned' => count($books),
                            'source' => 'Open Library',
                        ],
                    ];
                }
            );

            return response()->json($result, 200);

        } catch (\Throwable $e) {

            Log::warning('Open Library request failed', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'message' =>
                    'Open Library sedang tidak dapat diakses. Coba lagi beberapa saat.',
            ], 503);
        }
    }
}
