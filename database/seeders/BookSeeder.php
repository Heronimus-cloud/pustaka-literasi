<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'kode' => 'LIT001',
                'judul' => 'Lentera di Ujung Senja',
                'penulis' => 'Aruna Pradipta',
                'tahun' => 2021,
                'kategori' => 'Fiksi',
                'stok' => 12,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT002',
                'judul' => 'Berpikir Jernih Setiap Hari',
                'penulis' => 'Nara Wijaksana',
                'tahun' => 2022,
                'kategori' => 'Pengembangan Diri',
                'stok' => 8,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT003',
                'judul' => 'Jejak Pengetahuan Nusantara',
                'penulis' => 'Dimas Pratama',
                'tahun' => 2020,
                'kategori' => 'Pendidikan',
                'stok' => 15,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT004',
                'judul' => 'Cerita Sejarah dari Masa Lalu',
                'penulis' => 'Ratna Kusumadewi',
                'tahun' => 2019,
                'kategori' => 'Sejarah',
                'stok' => 6,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT005',
                'judul' => 'Ruang Kata dan Imajinasi',
                'penulis' => 'Bima Adinata',
                'tahun' => 2023,
                'kategori' => 'Sastra',
                'stok' => 10,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT006',
                'judul' => 'Belajar dari Alam Sekitar',
                'penulis' => 'Citra Maharani',
                'tahun' => 2024,
                'kategori' => 'Sains Populer',
                'stok' => 9,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT007',
                'judul' => 'Petualangan di Pulau Aksara',
                'penulis' => 'Raka Firmansyah',
                'tahun' => 2022,
                'kategori' => 'Anak',
                'stok' => 14,
                'bahasa' => 'Indonesia',
            ],
            [
                'kode' => 'LIT008',
                'judul' => 'A Simple Guide to Reading',
                'penulis' => 'Daniel Harper',
                'tahun' => 2023,
                'kategori' => 'Nonfiksi',
                'stok' => 7,
                'bahasa' => 'Inggris',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['kode' => $book['kode']],
                $book
            );
        }
    }
}
