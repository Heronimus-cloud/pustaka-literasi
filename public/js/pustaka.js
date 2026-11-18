const API = '/api/v1';

const $ = (selector) => document.querySelector(selector);

let currentUser = null;
let currentPage = 1;
let lastPage = 1;
let booksById = new Map();
let openLibraryBooks = [];
let searchTimer;

const loginModal = new bootstrap.Modal($('#loginModal'));
const bookModal = new bootstrap.Modal($('#bookModal'));
const detailModal = new bootstrap.Modal($('#detailModal'));

function getToken() {
    return sessionStorage.getItem('pustaka_token');
}

function escapeHTML(value) {
    return String(value ?? '').replace(/[&<>"']/g, char => ({
        '&': '&amp;',
        '<': '&lt;',
        '>': '&gt;',
        '"': '&quot;',
        "'": '&#039;'
    })[char]);
}

function notify(message) {
    $('#toastMessage').textContent = message;
    bootstrap.Toast.getOrCreateInstance($('#appToast')).show();
}

async function apiRequest(path, options = {}) {
    const headers = new Headers(options.headers || {});

    headers.set('Accept', 'application/json');

    if (options.body) {
        headers.set('Content-Type', 'application/json');
    }

    if (getToken()) {
        headers.set('Authorization', `Bearer ${getToken()}`);
    }

    const response = await fetch(API + path, {
        ...options,
        headers
    });

    const text = await response.text();

    let result = null;

    try {
        result = text ? JSON.parse(text) : null;
    } catch {
        result = { message: 'Respons server tidak valid.' };
    }

    if (!response.ok) {
        const error = new Error(
            result?.message || `HTTP ${response.status}`
        );

        error.status = response.status;
        error.data = result;

        throw error;
    }

    return result;
}

function showError(element, message) {
    element.textContent = message;
    element.classList.remove('d-none');
}

function getErrorMessage(error) {
    const errors = error.data?.errors;

    if (errors) {
        return Object.values(errors).flat().join('\n');
    }

    return error.message;
}


// =============================
// TAMPILAN PENGGUNA
// =============================

function updateAuthUI() {
    const loggedIn = !!currentUser;

    $('#loginNavBtn').classList.toggle('d-none', loggedIn);
    $('#userMenu').classList.toggle('d-none', !loggedIn);
    $('#userMenu').classList.toggle('d-flex', loggedIn);

    $('#addBookBtn').classList.toggle(
        'd-none',
        !currentUser?.is_admin
    );

    if (loggedIn) {
        $('#userName').textContent = currentUser.name;

        $('#roleBadge').textContent =
            currentUser.is_admin ? 'Admin' : 'Anggota';
    }

    renderOpenLibraryBooks(openLibraryBooks);
}


// =============================
// STATISTIK BUKU
// =============================

async function loadStats() {
    try {
        const result = await apiRequest('/stats');

        const stats = result.data;

        $('#statTotalBooks').textContent =
            Number(stats.total_buku).toLocaleString('id-ID');

        $('#statTotalStock').textContent =
            Number(stats.total_stok).toLocaleString('id-ID');

        $('#statLanguages').textContent =
            stats.jumlah_per_bahasa.length;

    } catch (error) {
        console.error(error);
    }
}


// =============================
// MENAMPILKAN KATALOG
// =============================

async function loadBooks(page = 1) {
    currentPage = page;

    $('#loading').classList.remove('d-none');
    $('#bookGrid').innerHTML = '';

    const params = new URLSearchParams({
        per_page: 8,
        page: currentPage
    });

    const keyword = $('#searchInput').value.trim();
    const kategori = $('#categoryFilter').value;
    const bahasa = $('#languageFilter').value;

    if (keyword) params.set('q', keyword);
    if (kategori) params.set('kategori', kategori);
    if (bahasa) params.set('bahasa', bahasa);

    try {
        const result = await apiRequest(
            `/books?${params.toString()}`
        );

        const books = result.data || [];

        booksById = new Map(
            books.map(book => [Number(book.id), book])
        );

        lastPage = result.meta?.last_page || 1;

        renderBooks(books);
        renderPagination();

    } catch (error) {
        $('#bookGrid').innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger">
                    Gagal mengambil data buku:
                    ${escapeHTML(error.message)}
                </div>
            </div>
        `;

    } finally {
        $('#loading').classList.add('d-none');
    }
}

function renderBooks(books) {
    if (books.length === 0) {
        $('#bookGrid').innerHTML = `
            <div class="col-12 text-center py-5">
                <i class="bi bi-book display-3 text-muted"></i>
                <h5 class="mt-3">Buku tidak ditemukan</h5>
                <p class="text-muted">
                    Coba gunakan kata kunci lain.
                </p>
            </div>
        `;
        return;
    }

    $('#bookGrid').innerHTML = books.map(book => {
        const coverId = Number(book.cover_id);

        const cover = Number.isSafeInteger(coverId) && coverId > 0
            ? `
                <img
                    src="https://covers.openlibrary.org/b/id/${coverId}-M.jpg"
                    alt="${escapeHTML(book.judul)}"
                    onerror="this.remove()">
            `
            : `
                <i class="bi bi-book-half display-3 text-secondary"></i>
            `;

        const adminButtons = currentUser?.is_admin
            ? `
                <button class="btn btn-sm btn-warning"
                        data-action="edit" data-id="${book.id}">
                    <i class="bi bi-pencil"></i>
                </button>

                <button class="btn btn-sm btn-danger"
                        data-action="delete" data-id="${book.id}">
                    <i class="bi bi-trash"></i>
                </button>
            `
            : '';

        return `
            <div class="col-md-6 col-lg-3">
                <div class="book-card p-3">

                    <div class="book-cover mb-3">
                        ${cover}
                    </div>

                    <span class="badge bg-primary-subtle text-primary">
                        ${escapeHTML(book.kategori)}
                    </span>

                    <h6 class="fw-bold mt-2">
                        ${escapeHTML(book.judul)}
                    </h6>

                    <p class="text-muted small mb-1">
                        ${escapeHTML(book.penulis)}
                    </p>

                    <p class="small mb-3">
                        Tahun: ${escapeHTML(book.tahun || '-')}
                        <br>
                        Bahasa: ${escapeHTML(book.bahasa)}
                        <br>
                        Stok: ${escapeHTML(book.stok)}
                    </p>

                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-sm btn-primary"
                                data-action="detail"
                                data-id="${book.id}">
                            Detail
                        </button>

                        ${adminButtons}
                    </div>

                </div>
            </div>
        `;
    }).join('');
}


// =============================
// PAGINATION
// =============================

function renderPagination() {
    $('#pagination').innerHTML = `
        <button class="btn btn-outline-primary"
                data-page="${currentPage - 1}"
                ${currentPage <= 1 ? 'disabled' : ''}>
            Sebelumnya
        </button>

        <span class="btn btn-light">
            ${currentPage} / ${lastPage}
        </span>

        <button class="btn btn-outline-primary"
                data-page="${currentPage + 1}"
                ${currentPage >= lastPage ? 'disabled' : ''}>
            Berikutnya
        </button>
    `;
}


// =============================
// PENCARIAN OPEN LIBRARY
// =============================

function renderOpenLibraryBooks(books) {
    const container = $('#openLibraryResults');

    if (!container) return;

    if (!books.length) {
        container.innerHTML = '';
        return;
    }

    container.innerHTML = books.map((book, index) => {
        const coverId = Number(book.cover_id);

        const cover = Number.isSafeInteger(coverId) && coverId > 0
            ? `
                <img
                    src="https://covers.openlibrary.org/b/id/${coverId}-M.jpg"
                    alt="${escapeHTML(book.judul)}"
                    onerror="this.remove()">
            `
            : `
                <i class="bi bi-book-half display-3 text-secondary"></i>
            `;

        const adminAction = currentUser?.is_admin
            ? `
                <button
                    type="button"
                    class="btn btn-sm btn-primary w-100"
                    data-open-library-index="${index}">
                    <i class="bi bi-plus-circle"></i> Gunakan Data
                </button>
            `
            : `
                <small class="text-muted">
                    Login sebagai admin untuk memasukkan buku ke katalog.
                </small>
            `;

        return `
            <div class="col-md-6 col-lg-3">
                <div class="book-card p-3 h-100">

                    <div class="book-cover mb-3">
                        ${cover}
                    </div>

                    <h6 class="fw-bold">
                        ${escapeHTML(book.judul)}
                    </h6>

                    <p class="text-muted small mb-1">
                        ${escapeHTML(book.penulis || 'Penulis tidak diketahui')}
                    </p>

                    <p class="small text-muted mb-3">
                        Tahun: ${escapeHTML(book.tahun || '-')}
                    </p>

                    ${adminAction}

                </div>
            </div>
        `;
    }).join('');
}


async function searchOpenLibrary() {
    const query = $('#openLibraryInput').value.trim();

    const button = $('#openLibrarySearchBtn');
    const loading = $('#openLibraryLoading');
    const message = $('#openLibraryMessage');
    const results = $('#openLibraryResults');

    if (query.length < 2) {
        openLibraryBooks = [];

        renderOpenLibraryBooks(openLibraryBooks);

        message.textContent =
            'Masukkan minimal 2 karakter untuk mencari buku.';

        return;
    }

    button.disabled = true;

    loading.classList.remove('d-none');

    message.textContent =
        'Sedang mencari buku dari Open Library...';

    results.innerHTML = '';

    try {
        const params = new URLSearchParams({
            q: query
        });

        const result = await apiRequest(
            `/open-library?${params.toString()}`
        );

        openLibraryBooks = Array.isArray(result.data)
            ? result.data
            : [];

        renderOpenLibraryBooks(openLibraryBooks);

        const returned =
            result.meta?.returned ?? openLibraryBooks.length;

        const total =
            result.meta?.total ?? returned;

        message.textContent = openLibraryBooks.length
            ? `Menampilkan ${returned} hasil. Total hasil yang dilaporkan Open Library: ${total}.`
            : 'Tidak ada buku yang cocok dengan kata kunci tersebut.';

    } catch (error) {
        openLibraryBooks = [];

        results.innerHTML = `
            <div class="col-12">
                <div class="alert alert-danger mb-0">
                    Gagal mencari buku:
                    ${escapeHTML(getErrorMessage(error))}
                </div>
            </div>
        `;

        message.textContent = '';

    } finally {
        loading.classList.add('d-none');

        button.disabled = false;
    }
}


// =============================
// LOGIN
// =============================

$('#loginForm').addEventListener('submit', async event => {
    event.preventDefault();

    $('#loginError').classList.add('d-none');

    const form = new FormData(event.target);

    try {
        const result = await apiRequest('/auth/login', {
            method: 'POST',
            body: JSON.stringify({
                email: form.get('email'),
                password: form.get('password')
            })
        });

        sessionStorage.setItem(
            'pustaka_token',
            result.access_token
        );

        currentUser = result.user;

        sessionStorage.setItem(
            'pustaka_user',
            JSON.stringify(currentUser)
        );

        updateAuthUI();

        loginModal.hide();

        event.target.reset();

        await loadBooks(1);

        await loadStats();

        notify('Login berhasil. Selamat datang!');

    } catch (error) {
        showError(
            $('#loginError'),
            getErrorMessage(error)
        );
    }
});


// =============================
// MEMERIKSA SESSION
// =============================

async function checkSession() {
    if (!getToken()) return;

    try {
        const result = await apiRequest('/auth/me');

        currentUser = result.data;

        sessionStorage.setItem(
            'pustaka_user',
            JSON.stringify(currentUser)
        );

    } catch (error) {
        sessionStorage.removeItem('pustaka_token');

        sessionStorage.removeItem('pustaka_user');

        currentUser = null;
    }

    updateAuthUI();
}


// =============================
// LOGOUT
// =============================

$('#logoutBtn').addEventListener('click', async () => {
    try {
        await apiRequest('/auth/logout', {
            method: 'POST'
        });

    } catch (error) {
        console.error(error);
    }

    sessionStorage.removeItem('pustaka_token');

    sessionStorage.removeItem('pustaka_user');

    currentUser = null;

    updateAuthUI();

    await loadBooks(1);

    notify('Logout berhasil.');
});


// =============================
// FORM TAMBAH DAN EDIT
// =============================

function openBookModal(book = null) {
    const form = $('#bookForm');

    form.reset();

    form.elements.id.value = book?.id || '';

    if (book) {
        Object.keys(book).forEach(key => {
            if (form.elements[key]) {
                form.elements[key].value = book[key] ?? '';
            }
        });
    }

    $('#bookModalTitle').textContent =
        book?.id ? 'Edit Buku' : 'Tambah Buku';

    $('#bookError').classList.add('d-none');

    bookModal.show();
}


$('#addBookBtn').addEventListener('click', () => {
    openBookModal();
});


$('#bookForm').addEventListener('submit', async event => {
    event.preventDefault();

    $('#bookError').classList.add('d-none');

    const form = new FormData(event.target);

    const id = form.get('id');

    const payload = {
        kode: form.get('kode').trim(),

        judul: form.get('judul').trim(),

        penulis: form.get('penulis').trim(),

        tahun: form.get('tahun')
            ? Number(form.get('tahun'))
            : null,

        kategori: form.get('kategori'),

        stok: Number(form.get('stok')),

        bahasa: form.get('bahasa'),

        open_library_key:
            form.get('open_library_key').trim() || null,

        cover_id: form.get('cover_id')
            ? Number(form.get('cover_id'))
            : null
    };

    try {
        await apiRequest(
            id ? `/books/${id}` : '/books',
            {
                method: id ? 'PATCH' : 'POST',

                body: JSON.stringify(payload)
            }
        );

        bookModal.hide();

        await loadBooks(currentPage);

        await loadStats();

        notify(
            id
                ? 'Data buku berhasil diperbarui.'
                : 'Buku berhasil ditambahkan.'
        );

    } catch (error) {
        showError(
            $('#bookError'),
            getErrorMessage(error)
        );
    }
});


// =============================
// DETAIL, EDIT, DELETE
// =============================

$('#bookGrid').addEventListener('click', async event => {
    const button = event.target.closest('[data-action]');

    if (!button) return;

    const id = Number(button.dataset.id);

    const action = button.dataset.action;

    const book = booksById.get(id);

    if (!book) return;

    if (action === 'detail') {
        $('#detailContent').innerHTML = `
            <h5 class="fw-bold">
                ${escapeHTML(book.judul)}
            </h5>

            <hr>

            <p><strong>Kode:</strong> ${escapeHTML(book.kode)}</p>

            <p><strong>Penulis:</strong> ${escapeHTML(book.penulis)}</p>

            <p><strong>Tahun:</strong> ${escapeHTML(book.tahun || '-')}</p>

            <p><strong>Kategori:</strong> ${escapeHTML(book.kategori)}</p>

            <p><strong>Bahasa:</strong> ${escapeHTML(book.bahasa)}</p>

            <p><strong>Stok:</strong> ${escapeHTML(book.stok)}</p>
        `;

        detailModal.show();
    }

    if (action === 'edit') {
        if (!currentUser?.is_admin) return;

        openBookModal(book);
    }

    if (action === 'delete') {
        if (!currentUser?.is_admin) return;

        if (!confirm(`Hapus buku "${book.judul}"?`)) return;

        try {
            await apiRequest(`/books/${id}`, {
                method: 'DELETE'
            });

            await loadBooks(currentPage);

            await loadStats();

            notify('Buku berhasil dihapus.');

        } catch (error) {
            notify(getErrorMessage(error));
        }
    }
});


// =============================
// MENGGUNAKAN HASIL OPEN LIBRARY
// =============================

$('#openLibrarySearchBtn').addEventListener(
    'click',
    searchOpenLibrary
);


$('#openLibraryInput').addEventListener('keydown', event => {
    if (event.key === 'Enter') {
        event.preventDefault();

        searchOpenLibrary();
    }
});


$('#openLibraryResults').addEventListener('click', event => {
    const button = event.target.closest(
        '[data-open-library-index]'
    );

    if (!button) return;

    if (!currentUser?.is_admin) {
        notify(
            'Hanya admin yang dapat menambahkan buku ke katalog.'
        );

        return;
    }

    const book = openLibraryBooks[
        Number(button.dataset.openLibraryIndex)
    ];

    if (!book) return;

    openBookModal({
        kode: '',

        judul: book.judul || '',

        penulis: book.penulis || '',

        tahun: book.tahun ?? '',

        kategori: '',

        bahasa: 'Indonesia',

        stok: 0,

        open_library_key: book.open_library_key || '',

        cover_id: book.cover_id ?? ''
    });

    notify(
        'Data referensi dimasukkan. Lengkapi kode, kategori, dan stok buku.'
    );
});


// =============================
// PENCARIAN DAN FILTER KATALOG LOKAL
// =============================

$('#searchInput').addEventListener('input', () => {
    clearTimeout(searchTimer);

    searchTimer = setTimeout(() => {
        loadBooks(1);
    }, 350);
});


$('#categoryFilter').addEventListener('change', () => {
    loadBooks(1);
});


$('#languageFilter').addEventListener('change', () => {
    loadBooks(1);
});


$('#pagination').addEventListener('click', event => {
    const button = event.target.closest('[data-page]');

    if (!button || button.disabled) return;

    loadBooks(Number(button.dataset.page));
});


// =============================
// INISIALISASI APLIKASI
// =============================

async function initializeApp() {
    await checkSession();

    await Promise.all([
        loadBooks(1),
        loadStats()
    ]);
}

initializeApp();
