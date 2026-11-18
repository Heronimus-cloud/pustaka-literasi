<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'kode' => $this->kode,
            'judul' => $this->judul,
            'penulis' => $this->penulis,
            'tahun' => $this->tahun,
            'kategori' => $this->kategori,
            'stok' => $this->stok,
            'open_library_key' => $this->open_library_key,
            'cover_id' => $this->cover_id,
            'bahasa' => $this->bahasa,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
