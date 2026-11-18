<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Pustaka Literasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --primary: #245c91;
            --dark-blue: #173b67;
            --background: #f5f7fb;
        }

        body {
            background: var(--background);
            color: #263248;
        }

        .navbar {
            background: white;
        }

        .hero {
            background: linear-gradient(120deg, var(--dark-blue), #3476aa);
            color: white;
            padding: 55px 0;
        }

        .stat-card,
        .book-card {
            background: white;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .05);
        }

        .book-card {
            height: 100%;
            transition: .2s;
        }

        .book-card:hover {
            transform: translateY(-4px);
        }

        .book-cover {
            height: 190px;
            background: #e9eff7;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
        }

        .book-cover img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .btn-primary {
            background: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background: var(--dark-blue);
        }

        .app-tabs {
            background: white;
            padding: 10px;
            border-radius: 12px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
        }

        .app-tabs .nav-link {
            color: #526174;
            font-weight: 600;
            border-radius: 9px;
        }

        .app-tabs .nav-link.active {
            background: var(--primary);
            color: white;
        }

        .section-card {
            background: white;
            border: 0;
            border-radius: 14px;
            box-shadow: 0 3px 15px rgba(0, 0, 0, .04);
        }

        .api-method {
            min-width: 75px;
            display: inline-block;
            text-align: center;
        }

        .api-code {
            background: #edf2f8;
            padding: 3px 7px;
            border-radius: 5px;
            color: #173b67;
        }

        footer {
            background: white;
            margin-top: 60px;
        }

        @media (max-width: 576px) {
            .hero {
                padding: 35px 0;
            }

            .hero h1 {
                font-size: 30px;
            }

            .app-tabs {
                gap: 5px;
            }

            .app-tabs .nav-link {
                font-size: 13px;
                padding: 9px;
            }
        }
    </style>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg border-bottom sticky-top">
        <div class="container">

            <a class="navbar-brand fw-bold text-primary" href="/">
                <i class="bi bi-book-half"></i>
                Pustaka Literasi
            </a>

            <div class="d-flex align-items-center gap-2 ms-auto">

                <button class="btn btn-outline-primary" id="loginNavBtn" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
                    <i class="bi bi-box-arrow-in-right"></i>
                    Login
                </button>

                <div id="userMenu" class="d-none align-items-center gap-2">

                    <span id="userName" class="fw-semibold"></span>

                    <span id="roleBadge" class="badge bg-primary"></span>

                    <button class="btn btn-sm btn-outline-danger" id="logoutBtn">
                        Logout
                    </button>

                </div>

            </div>
        </div>
    </nav>


    <!-- HERO -->
    <section class="hero">
        <div class="container">

            <div class="row align-items-center">

                <div class="col-lg-8">

                    <span class="badge bg-light text-primary mb-3">
                        DIGITAL LIBRARY
                    </span>

                    <h1 class="display-5 fw-bold">
                        Jelajahi Dunia Literasi
                    </h1>

                    <p class="lead">
                        Temukan berbagai koleksi buku untuk menambah
                        wawasan dan pengetahuan.
                    </p>

                    <a href="#workspace" class="btn btn-light text-primary fw-semibold">
                        Mulai Jelajahi
                        <i class="bi bi-arrow-right"></i>
                    </a>

                </div>

                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="bi bi-journal-bookmark-fill" style="font-size:120px"></i>
                </div>

            </div>
        </div>
    </section>


    <!-- MAIN CONTENT -->
    <main class="container py-5" id="workspace">


        <!-- NAVIGASI HALAMAN -->
        <ul class="nav nav-pills app-tabs mb-4" id="mainTabs" role="tablist">

            <li class="nav-item" role="presentation">

                <button class="nav-link active" id="koleksi-tab" data-bs-toggle="pill" data-bs-target="#koleksi-pane"
                    type="button" role="tab">

                    <i class="bi bi-collection me-1"></i>
                    Koleksi

                </button>

            </li>

            <li class="nav-item" role="presentation">

                <button class="nav-link" id="jelajah-tab" data-bs-toggle="pill" data-bs-target="#jelajah-pane"
                    type="button" role="tab">

                    <i class="bi bi-globe me-1"></i>
                    Jelajah API

                </button>

            </li>

            <li class="nav-item" role="presentation">

                <button class="nav-link" id="panduan-tab" data-bs-toggle="pill" data-bs-target="#panduan-pane"
                    type="button" role="tab">

                    <i class="bi bi-code-square me-1"></i>
                    Panduan API

                </button>

            </li>

        </ul>


        <div class="tab-content" id="mainTabContent">


            <!-- ================================= -->
            <!-- TAB 1: KOLEKSI -->
            <!-- ================================= -->

            <div class="tab-pane fade show active" id="koleksi-pane" role="tabpanel" aria-labelledby="koleksi-tab"
                tabindex="0">

                <section id="katalog">

                    <div class="mb-4">

                        <h2 class="fw-bold">
                            Katalog Buku
                        </h2>

                        <p class="text-muted">
                            Kelola dan temukan koleksi bacaan
                            Pustaka Literasi.
                        </p>

                    </div>


                    <!-- STATISTIK -->
                    <div class="row g-3 mb-4">

                        <div class="col-md-4">

                            <div class="stat-card p-4">

                                <div class="text-muted">
                                    <i class="bi bi-book me-1"></i>
                                    Total Buku
                                </div>

                                <h2 id="statTotalBooks" class="fw-bold mt-2 mb-0">
                                    -
                                </h2>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="stat-card p-4">

                                <div class="text-muted">
                                    <i class="bi bi-box-seam me-1"></i>
                                    Total Stok
                                </div>

                                <h2 id="statTotalStock" class="fw-bold mt-2 mb-0">
                                    -
                                </h2>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="stat-card p-4">

                                <div class="text-muted">
                                    <i class="bi bi-translate me-1"></i>
                                    Bahasa Koleksi
                                </div>

                                <h2 id="statLanguages" class="fw-bold mt-2 mb-0">
                                    -
                                </h2>

                            </div>

                        </div>

                    </div>


                    <!-- HEADER KATALOG -->
                    <div class="d-flex flex-wrap justify-content-between align-items-center mb-3 gap-3">

                        <div>
                            <h4 class="fw-bold mb-1">
                                Semua Buku
                            </h4>

                            <small class="text-muted">
                                Cari berdasarkan judul, penulis, atau kategori.
                            </small>
                        </div>

                        <button id="addBookBtn" class="btn btn-primary d-none">

                            <i class="bi bi-plus-lg"></i>
                            Tambah Buku

                        </button>

                    </div>


                    <!-- SEARCH DAN FILTER -->
                    <div class="section-card p-3 mb-4">

                        <div class="row g-2">

                            <div class="col-md-6">

                                <input type="text" id="searchInput" class="form-control"
                                    placeholder="Cari judul, penulis, atau kode buku...">

                            </div>


                            <div class="col-md-3">

                                <select id="categoryFilter" class="form-select">

                                    <option value="">
                                        Semua Kategori
                                    </option>

                                    <option>Fiksi</option>
                                    <option>Nonfiksi</option>
                                    <option>Pendidikan</option>
                                    <option>Sejarah</option>
                                    <option>Biografi</option>
                                    <option>Sastra</option>
                                    <option>Pengembangan Diri</option>
                                    <option>Sains Populer</option>
                                    <option>Anak</option>

                                </select>

                            </div>


                            <div class="col-md-3">

                                <select id="languageFilter" class="form-select">

                                    <option value="">
                                        Semua Bahasa
                                    </option>

                                    <option>Indonesia</option>
                                    <option>Inggris</option>

                                </select>

                            </div>

                        </div>

                    </div>


                    <!-- LOADING -->
                    <div id="loading" class="text-center py-5 d-none">

                        <div class="spinner-border text-primary"></div>

                        <p class="mt-2 text-muted">
                            Memuat koleksi buku...
                        </p>

                    </div>


                    <!-- DATA BUKU -->
                    <div id="bookGrid" class="row g-4"></div>


                    <!-- PAGINATION -->
                    <div id="pagination" class="d-flex justify-content-center mt-4 gap-2 flex-wrap">
                    </div>

                </section>

            </div>


            <!-- ================================= -->
            <!-- TAB 2: JELAJAH OPEN LIBRARY -->
            <!-- ================================= -->

            <div class="tab-pane fade" id="jelajah-pane" role="tabpanel" aria-labelledby="jelajah-tab" tabindex="0">


                <div class="mb-4">

                    <h2 class="fw-bold">
                        Jelajah Open Library
                    </h2>

                    <p class="text-muted">
                        Temukan metadata buku dari layanan Open Library
                        dan pilih buku untuk dimasukkan ke katalog lokal.
                    </p>

                </div>


                <!-- SEARCH OPEN LIBRARY -->
                <div class="section-card p-4 mb-4">

                    <h5 class="fw-bold mb-3">
                        <i class="bi bi-search text-primary"></i>
                        Pencarian Buku Eksternal
                    </h5>

                    <div class="input-group">

                        <input type="text" id="openLibraryInput" class="form-control"
                            placeholder="Masukkan judul atau nama penulis buku...">

                        <button type="button" id="openLibrarySearchBtn" class="btn btn-primary">

                            <i class="bi bi-search"></i>
                            Cari Buku

                        </button>

                    </div>


                    <div class="mt-3">

                        <div id="openLibraryLoading" class="text-center py-3 d-none">

                            <div class="spinner-border spinner-border-sm text-primary"></div>

                            <span class="ms-2">
                                Sedang mencari buku...
                            </span>

                        </div>

                        <p id="openLibraryMessage" class="small text-muted mb-0" role="status" aria-live="polite">

                            Masukkan minimal dua karakter untuk memulai pencarian.

                        </p>

                    </div>

                </div>


                <!-- INFORMASI SUMBER -->
                <div class="alert alert-info">

                    <i class="bi bi-info-circle me-1"></i>

                    Data pencarian berasal dari
                    <strong>Open Library</strong>.
                    Data baru masuk ke katalog lokal setelah dipilih
                    dan disimpan oleh admin.

                </div>


                <!-- HASIL PENCARIAN -->
                <div class="mb-3">

                    <h5 class="fw-bold">
                        Hasil Pencarian
                    </h5>

                </div>

                <div id="openLibraryResults" class="row g-4">
                </div>


            </div>


            <!-- ================================= -->
            <!-- TAB 3: PANDUAN API -->
            <!-- ================================= -->

            <div class="tab-pane fade" id="panduan-pane" role="tabpanel" aria-labelledby="panduan-tab" tabindex="0">


                <div class="mb-4">

                    <h2 class="fw-bold">
                        Panduan REST API
                    </h2>

                    <p class="text-muted">
                        Dokumentasi endpoint yang digunakan
                        dalam aplikasi Pustaka Literasi.
                    </p>

                </div>


                <!-- INFORMASI API -->
                <div class="section-card p-4 mb-4">

                    <h5 class="fw-bold">
                        Informasi API
                    </h5>

                    <div class="row mt-3 g-3">

                        <div class="col-md-6">

                            <small class="text-muted">
                                Base URL
                            </small>

                            <p>
                                <code class="api-code">
                                    /api/v1
                                </code>
                            </p>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Format Data
                            </small>

                            <p>
                                <code class="api-code">
                                    JSON
                                </code>
                            </p>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Framework
                            </small>

                            <p class="fw-semibold mb-0">
                                Laravel 12
                            </p>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted">
                                Sumber API Publik
                            </small>

                            <p class="fw-semibold mb-0">
                                Open Library
                            </p>

                        </div>

                    </div>

                </div>


                <!-- DAFTAR ENDPOINT -->
                <div class="section-card p-4 mb-4">

                    <h5 class="fw-bold mb-3">
                        Daftar Endpoint
                    </h5>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">

                                <tr>
                                    <th>Method</th>
                                    <th>Endpoint</th>
                                    <th>Fungsi</th>
                                    <th>Akses</th>
                                </tr>

                            </thead>

                            <tbody>

                                <tr>
                                    <td>
                                        <span class="badge bg-success api-method">
                                            GET
                                        </span>
                                    </td>

                                    <td>
                                        <code>/books</code>
                                    </td>

                                    <td>Menampilkan daftar buku dan pagination.</td>

                                    <td>Publik</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-success api-method">
                                            GET
                                        </span>
                                    </td>

                                    <td>
                                        <code>/books/{id}</code>
                                    </td>

                                    <td>Menampilkan detail buku.</td>

                                    <td>Publik</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-success api-method">
                                            GET
                                        </span>
                                    </td>

                                    <td>
                                        <code>/stats</code>
                                    </td>

                                    <td>Menampilkan statistik koleksi.</td>

                                    <td>Publik</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-success api-method">
                                            GET
                                        </span>
                                    </td>

                                    <td>
                                        <code>/open-library?q=...</code>
                                    </td>

                                    <td>Mencari metadata buku eksternal.</td>

                                    <td>Publik</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-primary api-method">
                                            POST
                                        </span>
                                    </td>

                                    <td>
                                        <code>/auth/login</code>
                                    </td>

                                    <td>Login pengguna dan memperoleh token.</td>

                                    <td>Publik</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-success api-method">
                                            GET
                                        </span>
                                    </td>

                                    <td>
                                        <code>/auth/me</code>
                                    </td>

                                    <td>Melihat informasi akun aktif.</td>

                                    <td>Login</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-primary api-method">
                                            POST
                                        </span>
                                    </td>

                                    <td>
                                        <code>/auth/logout</code>
                                    </td>

                                    <td>Mengakhiri sesi token.</td>

                                    <td>Login</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-primary api-method">
                                            POST
                                        </span>
                                    </td>

                                    <td>
                                        <code>/books</code>
                                    </td>

                                    <td>Menambahkan buku baru.</td>

                                    <td>Admin</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-warning text-dark api-method">
                                            PATCH
                                        </span>
                                    </td>

                                    <td>
                                        <code>/books/{id}</code>
                                    </td>

                                    <td>Memperbarui data buku.</td>

                                    <td>Admin</td>
                                </tr>


                                <tr>
                                    <td>
                                        <span class="badge bg-danger api-method">
                                            DELETE
                                        </span>
                                    </td>

                                    <td>
                                        <code>/books/{id}</code>
                                    </td>

                                    <td>Menghapus buku.</td>

                                    <td>Admin</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                    <small class="text-muted">
                        Semua endpoint di atas menggunakan prefix
                        <code>/api/v1</code>.
                    </small>

                </div>


                <!-- KETERANGAN STATUS -->
                <div class="section-card p-4 mb-4">

                    <h5 class="fw-bold mb-3">
                        HTTP Response Status
                    </h5>

                    <div class="table-responsive">

                        <table class="table table-sm align-middle">

                            <tbody>

                                <tr>
                                    <td><code>200</code></td>
                                    <td>Request berhasil.</td>
                                </tr>

                                <tr>
                                    <td><code>201</code></td>
                                    <td>Data berhasil dibuat.</td>
                                </tr>

                                <tr>
                                    <td><code>204</code></td>
                                    <td>Data berhasil dihapus tanpa response body.</td>
                                </tr>

                                <tr>
                                    <td><code>401</code></td>
                                    <td>Pengguna belum terautentikasi.</td>
                                </tr>

                                <tr>
                                    <td><code>403</code></td>
                                    <td>Pengguna tidak memiliki izin.</td>
                                </tr>

                                <tr>
                                    <td><code>404</code></td>
                                    <td>Data tidak ditemukan.</td>
                                </tr>

                                <tr>
                                    <td><code>422</code></td>
                                    <td>Validasi request gagal.</td>
                                </tr>

                                <tr>
                                    <td><code>503</code></td>
                                    <td>Layanan eksternal tidak tersedia.</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>


                <!-- ALUR DATA -->
                <div class="section-card p-4">

                    <h5 class="fw-bold mb-3">
                        Alur Integrasi API
                    </h5>

                    <div class="row g-3 text-center">

                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded h-100">

                                <i class="bi bi-globe fs-2 text-primary"></i>

                                <h6 class="fw-bold mt-2">
                                    Open Library
                                </h6>

                                <small class="text-muted">
                                    Sumber metadata buku melalui GET.
                                </small>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded h-100">

                                <i class="bi bi-arrow-left-right fs-2 text-primary"></i>

                                <h6 class="fw-bold mt-2">
                                    Laravel REST API
                                </h6>

                                <small class="text-muted">
                                    Memproses, memvalidasi, dan mengelola data.
                                </small>

                            </div>

                        </div>


                        <div class="col-md-4">

                            <div class="p-3 bg-light rounded h-100">

                                <i class="bi bi-database fs-2 text-primary"></i>

                                <h6 class="fw-bold mt-2">
                                    Database Lokal
                                </h6>

                                <small class="text-muted">
                                    Menyimpan koleksi buku milik aplikasi.
                                </small>

                            </div>

                        </div>

                    </div>

                    <div class="alert alert-info mt-3 mb-0">

                        Open Library hanya digunakan untuk membaca metadata.
                        Operasi tambah, ubah, dan hapus dilakukan pada
                        database lokal aplikasi Laravel.

                    </div>

                </div>

            </div>

        </div>

    </main>


    <!-- FOOTER -->
    <footer class="py-4 border-top text-center">

        <div class="container">

            <strong>Pustaka Literasi</strong>

            <p class="text-muted mb-0">
                Sistem Informasi Literasi dan Bacaan Umum
            </p>

            <small class="text-muted">
                Laravel 12 | Bootstrap 5 | Open Library API
            </small>

        </div>

    </footer>


    <!-- ================================= -->
    <!-- MODAL LOGIN -->
    <!-- ================================= -->

    <div class="modal fade" id="loginModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <form id="loginForm">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Login Pengguna
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>

                    <div class="modal-body">

                        <div id="loginError" class="alert alert-danger d-none">
                        </div>

                        <label class="form-label">
                            Email
                        </label>

                        <input type="email" name="email" class="form-control mb-3" required>

                        <label class="form-label">
                            Password
                        </label>

                        <input type="password" name="password" class="form-control" required>

                    </div>

                    <div class="modal-footer">

                        <button class="btn btn-primary w-100">
                            Login
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- ================================= -->
    <!-- MODAL TAMBAH / EDIT BUKU -->
    <!-- ================================= -->

    <div class="modal fade" id="bookModal" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <form id="bookForm">

                    <div class="modal-header">

                        <h5 class="modal-title" id="bookModalTitle">
                            Tambah Buku
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <input type="hidden" name="id">

                        <div id="bookError" class="alert alert-danger d-none">
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label">
                                    Kode Buku
                                </label>

                                <input name="kode" class="form-control" maxlength="24" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Judul Buku
                                </label>

                                <input name="judul" class="form-control" maxlength="250" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Penulis
                                </label>

                                <input name="penulis" class="form-control" maxlength="200" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Tahun Terbit
                                </label>

                                <input type="number" name="tahun" class="form-control">

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Kategori
                                </label>

                                <select name="kategori" class="form-select" required>

                                    <option value="">
                                        Pilih kategori
                                    </option>

                                    <option>Fiksi</option>
                                    <option>Nonfiksi</option>
                                    <option>Pendidikan</option>
                                    <option>Sejarah</option>
                                    <option>Biografi</option>
                                    <option>Sastra</option>
                                    <option>Pengembangan Diri</option>
                                    <option>Sains Populer</option>
                                    <option>Anak</option>

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Bahasa
                                </label>

                                <select name="bahasa" class="form-select" required>

                                    <option value="">
                                        Pilih bahasa
                                    </option>

                                    <option>Indonesia</option>
                                    <option>Inggris</option>

                                </select>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Stok
                                </label>

                                <input type="number" name="stok" min="0" class="form-control" required>

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Open Library Key (Opsional)
                                </label>

                                <input name="open_library_key" class="form-control" placeholder="/works/OL123W">

                            </div>


                            <div class="col-md-6">

                                <label class="form-label">
                                    Cover ID (Opsional)
                                </label>

                                <input type="number" name="cover_id" min="1" class="form-control">

                            </div>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Batal
                        </button>

                        <button type="submit" class="btn btn-primary">
                            Simpan Buku
                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>


    <!-- ================================= -->
    <!-- MODAL DETAIL -->
    <!-- ================================= -->

    <div class="modal fade" id="detailModal" tabindex="-1">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Detail Buku
                    </h5>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body" id="detailContent">
                </div>

            </div>

        </div>

    </div>


    <!-- ================================= -->
    <!-- TOAST NOTIFIKASI -->
    <!-- ================================= -->

    <div class="toast-container position-fixed bottom-0 end-0 p-3">

        <div id="appToast" class="toast">

            <div class="toast-header">

                <strong class="me-auto">
                    Pustaka Literasi
                </strong>

                <button type="button" class="btn-close" data-bs-dismiss="toast">
                </button>

            </div>

            <div class="toast-body" id="toastMessage">
            </div>

        </div>

    </div>


    <!-- JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="{{ asset('js/pustaka.js') }}"></script>

</body>

</html>