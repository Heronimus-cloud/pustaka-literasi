<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pustaka Literasi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
            color: #263248;
        }

        .navbar {
            background: white;
        }

        .hero {
            background: linear-gradient(120deg, #173b67, #3476aa);
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
            background: #245c91;
            border-color: #245c91;
        }

        .btn-primary:hover {
            background: #173b67;
        }

        footer {
            background: white;
            margin-top: 60px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg border-bottom sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="/">
                <i class="bi bi-book-half"></i> Pustaka Literasi
            </a>

            <div class="d-flex align-items-center gap-2 ms-auto">
                <button class="btn btn-outline-primary" id="loginNavBtn" data-bs-toggle="modal"
                    data-bs-target="#loginModal">
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

    <section class="hero">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-5 fw-bold">Jelajahi Dunia Literasi</h1>
                    <p class="lead">
                        Temukan berbagai koleksi buku untuk menambah
                        wawasan dan pengetahuan.
                    </p>
                    <a href="#katalog" class="btn btn-light text-primary fw-semibold">
                        Jelajahi Koleksi
                    </a>
                </div>
                <div class="col-lg-4 text-center d-none d-lg-block">
                    <i class="bi bi-journal-bookmark-fill" style="font-size:120px"></i>
                </div>
            </div>
        </div>
    </section>

    <main class="container py-5">

        <section class="row g-3 mb-5">
            <div class="col-md-4">
                <div class="stat-card p-4">
                    <small class="text-muted">Total Buku</small>
                    <h2 id="statTotalBooks" class="fw-bold mt-2">-</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card p-4">
                    <small class="text-muted">Total Stok</small>
                    <h2 id="statTotalStock" class="fw-bold mt-2">-</h2>
                </div>
            </div>

            <div class="col-md-4">
                <div class="stat-card p-4">
                    <small class="text-muted">Bahasa Koleksi</small>
                    <h2 id="statLanguages" class="fw-bold mt-2">-</h2>
                </div>
            </div>
        </section>

        <section id="katalog">

            <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-3">
                <div>
                    <h2 class="fw-bold">Katalog Buku</h2>
                    <p class="text-muted mb-0">
                        Koleksi bacaan Pustaka Literasi
                    </p>
                </div>

                <button id="addBookBtn" class="btn btn-primary d-none">
                    <i class="bi bi-plus-lg"></i> Tambah Buku
                </button>
            </div>

            <div class="card border-0 shadow-sm p-3 mb-4">
                <div class="row g-2">
                    <div class="col-md-6">
                        <input type="text" id="searchInput" class="form-control"
                            placeholder="Cari judul, penulis, atau kode buku...">
                    </div>

                    <div class="col-md-3">
                        <select id="categoryFilter" class="form-select">
                            <option value="">Semua Kategori</option>
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
                            <option value="">Semua Bahasa</option>
                            <option>Indonesia</option>
                            <option>Inggris</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- PENCARIAN BUKU EKSTERNAL OPEN LIBRARY -->
            <section class="card border-0 shadow-sm p-4 mb-4">
                <div class="mb-3">
                    <h5 class="fw-bold mb-1">
                        <i class="bi bi-globe2 text-primary"></i>
                        Cari Referensi dari Open Library
                    </h5>
                    <p class="text-muted small mb-0">
                        Cari buku dari katalog Open Library. Admin dapat menggunakan
                        data hasil pencarian untuk mengisi form buku.
                    </p>
                </div>

                <div class="row g-2">
                    <div class="col-md-9">
                        <input type="search" id="openLibraryInput" class="form-control" maxlength="100"
                            placeholder="Contoh: Harry Potter, teknologi, sejarah...">
                    </div>

                    <div class="col-md-3">
                        <button type="button" id="openLibrarySearchBtn" class="btn btn-outline-primary w-100">
                            <i class="bi bi-search"></i> Cari Open Library
                        </button>
                    </div>
                </div>

                <div id="openLibraryLoading" class="text-center py-4 d-none">
                    <div class="spinner-border spinner-border-sm text-primary"></div>
                    <span class="ms-2">Mencari referensi buku...</span>
                </div>

                <p id="openLibraryMessage" class="small text-muted mt-3 mb-0" role="status" aria-live="polite">
                    Masukkan minimal 2 karakter, lalu tekan tombol cari.
                </p>

                <div id="openLibraryResults" class="row g-3 mt-1"></div>
            </section>

            <div id="loading" class="text-center py-5 d-none">
                <div class="spinner-border text-primary"></div>
                <p class="mt-2">Memuat koleksi buku...</p>
            </div>

            <div id="bookGrid" class="row g-4"></div>

            <div id="pagination" class="d-flex justify-content-center mt-4 gap-2"></div>

        </section>

    </main>

    <footer class="py-4 border-top text-center">
        <div class="container">
            <strong>Pustaka Literasi</strong>
            <p class="text-muted mb-0">
                Sistem Informasi Literasi dan Bacaan Umum
            </p>
        </div>
    </footer>


    <!-- MODAL LOGIN -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="loginForm">
                    <div class="modal-header">
                        <h5 class="modal-title">Login Pengguna</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div id="loginError" class="alert alert-danger d-none"></div>

                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control mb-3" required>

                        <label class="form-label">Password</label>
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


    <!-- MODAL TAMBAH / EDIT BUKU -->
    <div class="modal fade" id="bookModal" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <form id="bookForm">

                    <div class="modal-header">
                        <h5 class="modal-title" id="bookModalTitle">
                            Tambah Buku
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" name="id">

                        <div id="bookError" class="alert alert-danger d-none"></div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Kode Buku</label>
                                <input name="kode" class="form-control" maxlength="24" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Judul Buku</label>
                                <input name="judul" class="form-control" maxlength="250" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Penulis</label>
                                <input name="penulis" class="form-control" maxlength="200" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Tahun Terbit</label>
                                <input type="number" name="tahun" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Kategori</label>
                                <select name="kategori" class="form-select" required>
                                    <option value="">Pilih kategori</option>
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
                                <label class="form-label">Bahasa</label>
                                <select name="bahasa" class="form-select" required>
                                    <option value="">Pilih bahasa</option>
                                    <option>Indonesia</option>
                                    <option>Inggris</option>
                                </select>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Stok</label>
                                <input type="number" name="stok" min="0" class="form-control" required>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Open Library Key (Opsional)</label>
                                <input name="open_library_key" class="form-control" placeholder="/works/OL123W">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Cover ID (Opsional)</label>
                                <input type="number" name="cover_id" min="1" class="form-control">
                            </div>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>

                        <button type="submit" class="btn btn-primary">
                            Simpan Buku
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>


    <!-- MODAL DETAIL -->
    <div class="modal fade" id="detailModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Detail Buku</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body" id="detailContent"></div>
            </div>
        </div>
    </div>


    <!-- NOTIFIKASI -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3">
        <div id="appToast" class="toast">
            <div class="toast-header">
                <strong class="me-auto">Pustaka Literasi</strong>
                <button type="button" class="btn-close" data-bs-dismiss="toast"></button>
            </div>
            <div class="toast-body" id="toastMessage"></div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/pustaka.js') }}"></script>

</body>

</html>