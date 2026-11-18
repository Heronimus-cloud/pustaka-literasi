<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();

            $table->string('kode', 24)->unique();
            $table->string('judul', 250);
            $table->string('penulis', 200);

            $table->unsignedSmallInteger('tahun')->nullable();
            $table->string('kategori', 80);
            $table->unsignedInteger('stok')->default(0);

            $table->string('open_library_key', 80)
                  ->nullable()
                  ->unique();

            $table->unsignedBigInteger('cover_id')->nullable();

            // Pengembangan khusus Kelompok 4
            $table->string('bahasa', 50)->default('Indonesia');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
