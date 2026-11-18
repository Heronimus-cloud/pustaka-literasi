<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class BookRequest extends FormRequest
{
    /**
     * Hak akses diperiksa melalui middleware route.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi data buku.
     */
    public function rules(): array
    {
        // Mengambil buku yang sedang diubah.
        $book = $this->route('book');

        $bookId = $book instanceof Book
            ? $book->id
            : $book;

        // Membedakan POST dan PATCH.
        $isUpdate = $this->isMethod('PATCH')
            || $this->isMethod('PUT');


        $required = $isUpdate
            ? ['sometimes', 'required']
            : ['required'];


        // Kode dan sumber unik, tetapi boleh tetap
        // menggunakan nilai milik buku yang sedang diedit.
        $uniqueKode = Rule::unique('books', 'kode');

        $uniqueOpenLibrary = Rule::unique(
            'books',
            'open_library_key'
        );

        if ($bookId) {
            $uniqueKode->ignore($bookId);
            $uniqueOpenLibrary->ignore($bookId);
        }

        return [
            'kode' => [
                ...$required,
                'string',
                'max:24',
                $uniqueKode,
            ],

            'judul' => [
                ...$required,
                'string',
                'max:250',
            ],

            'penulis' => [
                ...$required,
                'string',
                'max:200',
            ],

            'tahun' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
                'max:' . ((int) date('Y') + 1),
            ],

            'kategori' => [
                ...$required,
                'string',
                Rule::in(Book::KATEGORI),
            ],

            'stok' => [
                ...$required,
                'integer',
                'min:0',
            ],

            'open_library_key' => [
                'sometimes',
                'nullable',
                'string',
                'max:80',
                'regex:/^\/works\/OL[0-9]+W$/',
                $uniqueOpenLibrary,
            ],

            'cover_id' => [
                'sometimes',
                'nullable',
                'integer',
                'min:1',
            ],

            // Pengembangan Kelompok 4.
            'bahasa' => [
                ...$required,
                'string',
                Rule::in(Book::BAHASA),
            ],
        ];
    }

    /**
     * Pesan validasi dalam Bahasa Indonesia.
     */
    public function messages(): array
    {
        return [
            'kode.required' => 'Kode buku wajib diisi.',
            'kode.unique' => 'Kode buku sudah digunakan.',
            'kode.max' => 'Kode buku maksimal 24 karakter.',

            'judul.required' => 'Judul buku wajib diisi.',
            'judul.max' => 'Judul buku maksimal 250 karakter.',

            'penulis.required' => 'Nama penulis wajib diisi.',
            'penulis.max' => 'Nama penulis maksimal 200 karakter.',

            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun tidak valid.',
            'tahun.max' => 'Tahun tidak boleh melebihi tahun depan.',

            'kategori.required' => 'Kategori buku wajib diisi.',
            'kategori.in' => 'Kategori buku tidak tersedia.',

            'stok.required' => 'Stok buku wajib diisi.',
            'stok.integer' => 'Stok harus berupa bilangan bulat.',
            'stok.min' => 'Stok tidak boleh negatif.',

            'open_library_key.unique' => 'Buku dari Open Library sudah diimpor.',
            'open_library_key.regex' => 'Format Open Library Key tidak valid.',

            'cover_id.integer' => 'Cover ID harus berupa angka.',
            'cover_id.min' => 'Cover ID harus lebih besar dari nol.',

            'bahasa.required' => 'Bahasa buku wajib diisi.',
            'bahasa.in' => 'Bahasa buku tidak tersedia.',
        ];
    }

    /**
     * Nama atribut untuk pesan validasi.
     */
    public function attributes(): array
    {
        return [
            'kode' => 'kode buku',
            'judul' => 'judul buku',
            'penulis' => 'penulis',
            'tahun' => 'tahun terbit',
            'kategori' => 'kategori',
            'stok' => 'stok',
            'bahasa' => 'bahasa buku',
        ];
    }
}
