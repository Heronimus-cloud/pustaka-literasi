# 📚 Pustaka Literasi

**Aplikasi Katalog Literasi dan Bacaan Umum Berbasis Laravel API dan Bootstrap**

Pustaka Literasi merupakan aplikasi katalog buku yang dikembangkan untuk memudahkan pengguna dalam menjelajahi, mencari, dan mengelola koleksi bacaan umum. Aplikasi mengintegrasikan REST API Laravel dengan Open Library sebagai sumber metadata buku eksternal.

## 📌 Informasi Proyek

| Keterangan | Detail |
|---|---|
| Mata Kuliah | Web Service |
| Pertemuan | 10 |
| Kelompok | 4 |
| Fokus | Literasi dan Bacaan Umum |
| Framework | Laravel 12 |
| Frontend | Bootstrap 5.3 |
| Database | SQLite |
| API Eksternal | Open Library |
| Autentikasi | Laravel Sanctum |

## ✨ Fitur Aplikasi

### 1. Katalog Buku
- Menampilkan daftar koleksi buku.
- Melihat detail buku.
- Mencari buku berdasarkan judul, penulis, atau kode buku.
- Filter berdasarkan kategori.
- Filter berdasarkan bahasa.
- Pagination dengan 8 buku per halaman.

### 2. Integrasi Open Library
- Mencari referensi buku melalui Open Library.
- Menampilkan metadata judul, penulis, tahun terbit, dan sampul.
- Memilih hasil pencarian untuk mengisi formulir buku.
- Menyimpan buku terpilih ke database lokal melalui akun admin.

Open Library digunakan sebagai sumber pencarian metadata. Operasi CRUD tetap dilakukan pada database aplikasi Pustaka Literasi.

### 3. Manajemen Buku (CRUD)
Admin dapat:
- Menambahkan buku.
- Melihat detail buku.
- Mengubah informasi buku.
- Menghapus buku.

Setiap data buku melewati proses validasi, termasuk pemeriksaan kode buku unik dan sumber Open Library yang tidak boleh duplikat.

### 4. Autentikasi dan Hak Akses
Aplikasi menyediakan dua jenis pengguna:

| Hak Akses | Admin | Anggota |
|---|---|---|
| Melihat katalog | Ya | Ya |
| Mencari buku | Ya | Ya |
| Melihat detail | Ya | Ya |
| Menambahkan buku | Ya | Tidak |
| Mengubah buku | Ya | Tidak |
| Menghapus buku | Ya | Tidak |

Autentikasi menggunakan Laravel Sanctum dengan Bearer Token yang berlaku selama 8 jam.

### 5. Statistik Koleksi
Halaman utama menampilkan:
- Total buku.
- Total stok buku.
- Jumlah jenis bahasa dalam koleksi.

Statistik dihitung berdasarkan data yang tersimpan dalam database.

### 6. Pengembangan Khusus Kelompok 4
Pengembangan tambahan yang diterapkan:

- **Field database:** bahasa.
- **Filter backend:** pencarian koleksi berdasarkan bahasa.
- **Ringkasan halaman:** jumlah bahasa yang tersedia dalam koleksi.

Pengembangan tersebut dihubungkan melalui migration, model, validasi, controller, respons API, dan antarmuka pengguna.

## 🛠️ Teknologi yang Digunakan

- PHP 8.3
- Laravel 12
- Laravel Sanctum
- SQLite
- Bootstrap 5.3
- JavaScript
- Open Library Search API
- Postman
- Git dan GitHub

## 🔄 Alur Kerja Sistem

1. Pengguna membuka halaman Pustaka Literasi.
2. Browser meminta daftar buku kepada REST API Laravel.
3. Laravel mengambil data koleksi dari database SQLite.
4. Data dikirim kembali dalam format JSON.
5. JavaScript menampilkan data menggunakan komponen Bootstrap.
6. Pengguna dapat mencari metadata buku melalui Open Library.
7. Admin memilih buku yang diinginkan.
8. Metadata digunakan untuk mengisi formulir buku.
9. Admin menyimpan buku melalui endpoint CRUD Laravel.
10. Laravel memvalidasi dan menyimpan data ke database lokal.

## 🔌 Daftar Endpoint REST API

Base URL:

`http://127.0.0.1:8000/api/v1`

| Method | Endpoint | Fungsi | Akses |
|---|---|---|---|
| GET | `/books` | Daftar buku | Publik |
| GET | `/books/{id}` | Detail buku | Publik |
| GET | `/stats` | Statistik koleksi | Publik |
| GET | `/open-library?q=` | Pencarian Open Library | Publik |
| POST | `/auth/login` | Login pengguna | Publik |
| GET | `/auth/me` | Identitas pengguna | Token |
| POST | `/auth/logout` | Logout pengguna | Token |
| POST | `/books` | Tambah buku | Admin |
| PATCH | `/books/{id}` | Ubah buku | Admin |
| DELETE | `/books/{id}` | Hapus buku | Admin |

Parameter pencarian katalog:
- `q`: kata kunci judul, penulis, atau kode.
- `kategori`: filter kategori.
- `bahasa`: filter bahasa.
- `page`: nomor halaman.
- `per_page`: jumlah data per halaman, default 8 dan maksimum 50.

## 🗄️ Struktur Data Buku

| Field | Keterangan |
|---|---|
| id | Identitas buku |
| kode | Kode buku unik |
| judul | Judul buku |
| penulis | Nama penulis |
| tahun | Tahun terbit |
| kategori | Kategori buku |
| stok | Jumlah stok |
| open_library_key | Identitas buku dari Open Library |
| cover_id | Identitas sampul buku |
| bahasa | Bahasa buku |

## 🚀 Instalasi dan Menjalankan Proyek

### Persyaratan
- PHP 8.3 atau versi kompatibel dengan Laravel 12.
- Composer.
- Git.
- SQLite dan ekstensi `pdo_sqlite`.
- Browser.

### 1. Clone Repository

```bash
git clone https://github.com/Heronimus-cloud/pustaka-literasi.git
```

Masuk ke direktori proyek:

```bash
cd pustaka-literasi
```

### 2. Instalasi Dependensi

```bash
composer install
```

### 3. Konfigurasi Environment

Salin file konfigurasi:

```powershell
Copy-Item .env.example .env
```

Buat database SQLite apabila belum tersedia:

```powershell
if (!(Test-Path "database/database.sqlite")) {
    New-Item -ItemType File -Path "database/database.sqlite"
}
```

Buka file `.env`, kemudian sesuaikan konfigurasi berikut:

```env
APP_NAME="Pustaka Literasi"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

SEED_ADMIN_EMAIL=admin@example.test
SEED_ADMIN_PASSWORD=GantiPasswordAdmin

SEED_MEMBER_EMAIL=anggota@example.test
SEED_MEMBER_PASSWORD=GantiPasswordAnggota
```

Gunakan kredensial lokal masing-masing. Jangan mengunggah file `.env` ke GitHub.

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Migrasi dan Seeder

```bash
php artisan config:clear
php artisan migrate --seed
```

Perintah tersebut membuat struktur database, akun demo, dan data awal buku.

### 6. Jalankan Aplikasi

```bash
php artisan serve
```

Buka browser:

`http://127.0.0.1:8000`

## 🔐 Keamanan

- Password disimpan menggunakan hashing.
- Endpoint pengelolaan buku dilindungi middleware autentikasi dan admin.
- Token menggunakan Laravel Sanctum.
- Token memiliki masa berlaku.
- Validasi dilakukan pada backend.
- File `.env` dan database SQLite lokal dikecualikan dari repository.

## 📁 Struktur Folder Utama

```text
pustaka-literasi/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Middleware/
│   │   ├── Requests/
│   │   └── Resources/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── js/
│       └── pustaka.js
├── resources/
│   └── views/
│       └── books/
│           └── index.blade.php
├── routes/
│   ├── api.php
│   └── web.php
├── .env.example
├── composer.json
└── README.md
```

## 🧪 Pengujian

Pengujian API dilakukan menggunakan Postman, meliputi:

- Pengambilan daftar dan detail buku.
- Pencarian serta filter buku.
- Pagination.
- Login dan logout.
- Pengujian token.
- Pengujian hak akses admin dan anggota.
- Penambahan, perubahan, dan penghapusan buku.
- Validasi data.
- Pencarian metadata Open Library.
- Pengujian persistensi database.

## 🌐 Repository

GitHub:

https://github.com/Heronimus-cloud/pustaka-literasi

---

**Pustaka Literasi — Jelajahi Dunia Literasi, Perluas Wawasan, Bangun Pengetahuan.**