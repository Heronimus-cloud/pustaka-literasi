<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    protected $fillable = [
        'kode',
        'judul',
        'penulis',
        'tahun',
        'kategori',
        'stok',
        'open_library_key',
        'cover_id',
        'bahasa',
    ];

    public const KATEGORI = [
        'Fiksi',
        'Nonfiksi',
        'Pendidikan',
        'Sejarah',
        'Biografi',
        'Sastra',
        'Pengembangan Diri',
        'Sains Populer',
        'Anak',
    ];

    public const BAHASA = [
        'Indonesia',
        'Inggris',
    ];
}
