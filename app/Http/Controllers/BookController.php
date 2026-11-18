<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    // 1. Menampilkan daftar buku
    public function index(Request $request)
    {
        $filters = $request->validate([
            'q' => ['sometimes', 'nullable', 'string', 'max:100'],
            'kategori' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in(Book::KATEGORI),
            ],
            'bahasa' => [
                'sometimes',
                'nullable',
                'string',
                Rule::in(Book::BAHASA),
            ],
            'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            'page' => ['sometimes', 'integer', 'min:1'],
        ]);

        $books = Book::query()
            ->when(
                !empty($filters['q']),
                function ($query) use ($filters) {
                    $keyword = trim($filters['q']);

                    $query->where(function ($search) use ($keyword) {
                        $search->where('judul', 'like', "%{$keyword}%")
                            ->orWhere('penulis', 'like', "%{$keyword}%")
                            ->orWhere('kode', 'like', "%{$keyword}%");
                    });
                }
            )
            ->when(
                !empty($filters['kategori']),
                fn($query) => $query->where(
                    'kategori',
                    $filters['kategori']
                )
            )
            ->when(
                !empty($filters['bahasa']),
                fn($query) => $query->where(
                    'bahasa',
                    $filters['bahasa']
                )
            )
            ->orderBy('judul')
            ->paginate($filters['per_page'] ?? 8);

        return BookResource::collection($books);
    }

    // 2. Menampilkan detail buku
    public function show(Book $book)
    {
        return new BookResource($book);
    }

    // 3. Menampilkan statistik koleksi
    public function stats()
    {
        $perBahasa = Book::query()
            ->select('bahasa')
            ->selectRaw('COUNT(*) as jumlah')
            ->groupBy('bahasa')
            ->orderBy('bahasa')
            ->get();

        return response()->json([
            'data' => [
                'total_buku' => Book::count(),
                'total_stok' => (int) Book::sum('stok'),
                'jumlah_per_bahasa' => $perBahasa,
            ],
        ]);
    }

    // 4. Menambahkan buku
    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    // 5. Mengubah data buku
    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->validated());

        return new BookResource($book->refresh());
    }

    // 6. Menghapus buku
    public function destroy(Book $book)
    {
        $book->delete();

        return response()->noContent();
    }
}
