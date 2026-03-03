(function () {
  // ===== KONSTANTA PENYIMPANAN =====
  const THEME_KEY = 'bookmanager-theme';
  const WISHLIST_KEY = 'bookmanager-wishlist';

  function buat(tag, cls, teks) {
    const el = document.createElement(tag);
    if (cls) el.className = cls;
    if (teks) el.textContent = teks;
    return el;
  }

  // Membuat elemen ikon Bootstrap Icons 
  function ikon(cls) {
    return buat('i', cls);
  }

  // Mengosongkan semua child dari suatu elemen
  function kosongkan(el) {
    while (el.firstChild) el.removeChild(el.firstChild);
  }

  // Tema (dark/light) ke halaman dan mengubah ikon tombol tema
  function terapkanTema(tema) {
    document.body.classList.toggle('dark-mode', tema === 'dark');
    const btn = document.getElementById('theme-toggle');
    if (!btn) return;
    // Bersihkan isi tombol lalu isi ulang sesuai tema aktif
    kosongkan(btn);
    const gelap = tema === 'dark';
    btn.appendChild(ikon(gelap ? 'bi bi-sun-fill' : 'bi bi-moon-stars-fill'));
    btn.appendChild(buat('span', '', gelap ? ' Terang' : ' Gelap'));
    btn.title = gelap ? 'Aktifkan Mode Terang' : 'Aktifkan Mode Gelap';
  }

  // Toggle tema antara dark dan light mode, simpan ke localStorage
  function gantiTema() {
    const saat = localStorage.getItem(THEME_KEY) || 'light';
    const baru = saat === 'dark' ? 'light' : 'dark';
    localStorage.setItem(THEME_KEY, baru);
    terapkanTema(baru);
  }

  /** Mengambil data wishlist dari sessionStorage */
  function ambilWishlist() {
    return JSON.parse(sessionStorage.getItem(WISHLIST_KEY) || '[]');
  }

  /** Menyimpan data wishlist ke sessionStorage */
  function simpanWishlist(list) {
    sessionStorage.setItem(WISHLIST_KEY, JSON.stringify(list));
  }

  /** Update tampilan tombol wishlist (ikon heart) pada setiap kartu buku */
  function updateTombol() {
    const list = ambilWishlist();
    // Iterasi semua tombol wishlist yang ada di halaman
    document.querySelectorAll('[data-wishlist-btn]').forEach(function (btn) {
      const ada = list.some(function (b) { return b.id === btn.getAttribute('data-wishlist-btn'); });
      const ic = btn.querySelector('i');
      if (ic) ic.className = ada ? 'bi bi-heart-fill' : 'bi bi-heart';
      btn.classList.toggle('wishlisted', ada);
      btn.title = ada ? 'Hapus dari Wishlist' : 'Tambah ke Wishlist';
    });
  }

  /** Update badge jumlah wishlist di navbar */
  function updateBadge() {
    const badge = document.getElementById('wishlist-badge');
    if (!badge) return;
    const n = ambilWishlist().length;
    badge.textContent = n;
    // Sembunyikan badge jika wishlist kosong
    badge.style.display = n > 0 ? 'flex' : 'none';
  }

  function refreshUI() {
    updateTombol();
    updateBadge();
  }

  // Toggle buku masuk/keluar wishlist dan tampilkan alert konfirmasi
  function toggleWishlist(id, judul, penulis, status) {
    const list = ambilWishlist();
    const idx = list.findIndex(function (b) { return b.id === id; });

    if (idx > -1) {
      // Buku sudah ada di wishlist -> hapus
      list.splice(idx, 1);
      alert('Buku "' + judul + '" berhasil dihapus dari wishlist.');
    } else {
      // Buku belum ada -> tambahkan ke wishlist
      list.push({ id: id, title: judul, author: penulis, status: status });
      alert('Buku "' + judul + '" berhasil ditambahkan ke wishlist!');
    }

    simpanWishlist(list);
    refreshUI();
  }

  // Menghapus satu item dari wishlist berdasarkan ID (Bonus: remove spesifik)
  function hapusItem(id) {
    let list = ambilWishlist();
    const buku = list.find(function (b) { return b.id === id; });
    // Filter item yang dihapus
    list = list.filter(function (b) { return b.id !== id; });
    simpanWishlist(list);
    refreshUI();
    renderModalBody();
    if (buku) alert('Buku "' + buku.title + '" berhasil dihapus dari wishlist.');
  }


  function buatModalWishlist() {
    // Cegah pembuatan ganda
    if (document.getElementById('wishlistModal')) return;

    // Container modal utama
    const modal = buat('div', 'modal fade');
    modal.id = 'wishlistModal';
    modal.setAttribute('tabindex', '-1');
    modal.setAttribute('aria-labelledby', 'wishlistModalLabel');
    modal.setAttribute('aria-hidden', 'true');

    const dialog = buat('div', 'modal-dialog modal-dialog-centered modal-dialog-scrollable');
    const content = buat('div', 'modal-content');
    const header = buat('div', 'modal-header');
    header.style.background = 'linear-gradient(135deg, #0f0c29, #1a1a2e)';
    header.style.color = '#fff';

    const title = document.createElement('h5');
    title.className = 'modal-title';
    title.id = 'wishlistModalLabel';
    const heartIcon = ikon('bi bi-heart-fill');
    heartIcon.style.color = '#e94560';
    heartIcon.style.marginRight = '8px';
    title.appendChild(heartIcon);
    title.appendChild(document.createTextNode('Wishlist Peminjaman '));
    const countBadge = buat('span', 'badge bg-danger ms-2', '0');
    countBadge.id = 'wishlist-modal-count';
    title.appendChild(countBadge);
    header.appendChild(title);

    const closeBtn = buat('button', 'btn-close btn-close-white');
    closeBtn.type = 'button';
    closeBtn.setAttribute('data-bs-dismiss', 'modal');
    closeBtn.setAttribute('aria-label', 'Tutup');
    header.appendChild(closeBtn);

    // --- Body Modal ---
    const body = buat('div', 'modal-body');
    body.id = 'wishlistModalBody';
    body.style.maxHeight = '400px';

    // --- Footer Modal ---
    const footer = buat('div', 'modal-footer');
    footer.id = 'wishlistModalFooter';

    const tutupBtn = buat('button', 'btn btn-secondary', 'Tutup');
    tutupBtn.type = 'button';
    tutupBtn.setAttribute('data-bs-dismiss', 'modal');
    footer.appendChild(tutupBtn);

    // Tombol Hapus Semua (Bonus: clear all)
    const hapusSemua = buat('button', 'btn btn-danger');
    hapusSemua.id = 'clearWishlistBtn';
    hapusSemua.type = 'button';
    hapusSemua.appendChild(ikon('bi bi-trash3'));
    hapusSemua.appendChild(document.createTextNode(' Hapus Semua'));
    hapusSemua.addEventListener('click', function () {
      if (!confirm('Hapus semua item dari wishlist?')) return;
      simpanWishlist([]);
      refreshUI();
      renderModalBody();
    });
    footer.appendChild(hapusSemua);

    // Susun hierarki modal
    content.appendChild(header);
    content.appendChild(body);
    content.appendChild(footer);
    dialog.appendChild(content);
    modal.appendChild(dialog);
    document.body.appendChild(modal);
  }

  // Render isi body Bootstrap Modal wishlist 
  function renderModalBody() {
    const body = document.getElementById('wishlistModalBody');
    if (!body) return;
    kosongkan(body);

    const list = ambilWishlist();

    // Update badge count di dalam modal
    const countBadge = document.getElementById('wishlist-modal-count');
    if (countBadge) countBadge.textContent = list.length;

    // Sembunyikan tombol hapus semua jika wishlist kosong
    const clearBtn = document.getElementById('clearWishlistBtn');
    if (clearBtn) clearBtn.style.display = list.length > 0 ? '' : 'none';

    // Tampilan saat wishlist kosong
    if (list.length === 0) {
      const empty = buat('div', 'wishlist-empty');
      empty.appendChild(ikon('bi bi-heart'));
      empty.appendChild(buat('p', '', 'Wishlist Anda masih kosong'));
      empty.appendChild(buat('small', '', 'Tekan ikon \u2764 pada kartu buku untuk menambahkan'));
      body.appendChild(empty);
      return;
    }

    // Render setiap item wishlist menggunakan DOM manipulation
    list.forEach(function (buku) {
      const item = buat('div', 'wishlist-item');

      // Info buku (judul, penulis, status)
      const info = buat('div', 'wishlist-item-info');
      info.appendChild(buat('div', 'wishlist-item-title', buku.title));

      const aut = buat('div', 'wishlist-item-author');
      aut.appendChild(ikon('bi bi-pen-fill'));
      aut.appendChild(document.createTextNode(' ' + buku.author));
      info.appendChild(aut);

      // Status ketersediaan buku
      const tersedia = buku.status === 'available';
      const st = buat('span', 'wishlist-item-status ' + buku.status);
      st.appendChild(ikon(tersedia ? 'bi bi-check-circle-fill' : 'bi bi-clock-fill'));
      st.appendChild(document.createTextNode(tersedia ? ' Tersedia' : ' Dipinjam'));
      info.appendChild(st);

      item.appendChild(info);

      // Tombol hapus item spesifik (Bonus: remove dari modal)
      const del = buat('button', 'wishlist-remove-btn');
      del.title = 'Hapus dari wishlist';
      del.appendChild(ikon('bi bi-x-lg'));
      del.addEventListener('click', function () {
        hapusItem(buku.id);
      });
      item.appendChild(del);

      body.appendChild(item);
    });
  }

  // Buka Bootstrap Modal wishlist: buat modal jika belum ada, lalu tampilkan 
  function bukaModalWishlist() {
    buatModalWishlist();
    renderModalBody();
    const modalEl = document.getElementById('wishlistModal');
    if (modalEl) {
      // Gunakan Bootstrap Modal API untuk menampilkan pop-up
      const bsModal = new bootstrap.Modal(modalEl);
      bsModal.show();
    }
  }

  // Handler klik pada tombol wishlist di kartu buku (event delegation) 
  function handleKlikWishlist(e) {
    const btn = e.target.closest('[data-wishlist-btn]');
    if (!btn) return;
    const card = btn.closest('.book-card');
    if (!card) return;
    // Ambil data buku dari elemen kartu
    const id = btn.getAttribute('data-wishlist-btn');
    const judul = (card.querySelector('.book-title') || {}).textContent || '';
    const penulis = (card.querySelector('.book-author') || {}).textContent || '';
    const elStatus = card.querySelector('.book-status');
    const status = elStatus && elStatus.classList.contains('available') ? 'available' : 'unavailable';
    toggleWishlist(id, judul.trim(), penulis.trim(), status);
  }

  function handlePinjam(e) {
    const btn = e.target.closest('.btn-pinjam');
    // Abaikan jika bukan tombol pinjam atau sudah disabled
    if (!btn || btn.disabled) return;

    const card = btn.closest('.book-card');
    if (!card) return;

    // Ambil elemen penampil stok
    const stockEl = card.querySelector('.stock-count');
    if (!stockEl) return;

    const judul = (card.querySelector('.book-title') || {}).textContent || 'Buku';
    let stok = parseInt(stockEl.textContent) || 0;

    // Cek apakah stok masih tersedia
    if (stok <= 0) {
      alert('Maaf, stok buku "' + judul.trim() + '" sudah habis.');
      return;
    }

    // Konfirmasi peminjaman dengan dialog confirm
    if (!confirm('Apakah Anda yakin ingin meminjam buku "' + judul.trim() + '"?')) return;

    // Kurangi stok secara real-time
    stok -= 1;
    stockEl.textContent = stok;

    // Alert konfirmasi berhasil
    alert('Buku "' + judul.trim() + '" berhasil dipinjam!\nSisa stok: ' + stok);

    // Jika stok habis, ubah status menjadi "Dipinjam" dan nonaktifkan tombol
    if (stok <= 0) {
      btn.disabled = true;
      btn.title = 'Stok Habis';
      const statusEl = card.querySelector('.book-status');
      if (statusEl) {
        statusEl.className = 'book-status unavailable';
        kosongkan(statusEl);
        statusEl.appendChild(ikon('bi bi-clock-fill'));
        statusEl.appendChild(document.createTextNode(' Dipinjam'));
      }
    }

    // Update localStorage untuk buku dinamis
    const bookId = card.getAttribute('data-book-id');
    if (bookId && bookId.startsWith('dynamic-')) {
      const realId = parseInt(bookId.replace('dynamic-', ''));
      let books = JSON.parse(localStorage.getItem('bookCollection') || '[]');
      const bookIdx = books.findIndex(function (b) { return b.id === realId; });
      if (bookIdx > -1) {
        books[bookIdx].copy = stok;
        if (stok <= 0) books[bookIdx].status = 'Dipinjam';
        localStorage.setItem('bookCollection', JSON.stringify(books));
      }
    }
  }

  window.updateWishlistUI = refreshUI;

  function init() {
    const nav = document.getElementById('navbarNav');

    // Tombol Dark/Light Mode di Navbar
    if (!document.getElementById('theme-toggle')) {
      const btnTema = buat('button', 'theme-toggle-btn');
      btnTema.id = 'theme-toggle';
      btnTema.type = 'button';
      btnTema.addEventListener('click', gantiTema);
      if (nav) nav.parentNode.insertBefore(btnTema, nav);
    }

    // Terapkan tema yang tersimpan dari localStorage
    const tersimpan = localStorage.getItem(THEME_KEY);
    const tema = tersimpan || (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
    if (!tersimpan) localStorage.setItem(THEME_KEY, tema);
    terapkanTema(tema);

    // Tombol Wishlist di Navbar 
    if (!document.getElementById('wishlist-nav-btn')) {
      const btnWish = buat('button', 'wishlist-nav-btn');
      btnWish.id = 'wishlist-nav-btn';
      btnWish.type = 'button';
      btnWish.title = 'Daftar Wishlist Peminjaman';
      btnWish.appendChild(ikon('bi bi-heart-fill'));
      btnWish.appendChild(buat('span', 'wishlist-nav-text', 'Wishlist'));
      const badge = buat('span', '', '0');
      badge.id = 'wishlist-badge';
      badge.style.display = 'none';
      btnWish.appendChild(badge);
      // Klik tombol navbar -> buka Bootstrap Modal
      btnWish.addEventListener('click', bukaModalWishlist);
      const btnTema = document.getElementById('theme-toggle');
      if (btnTema) btnTema.parentNode.insertBefore(btnWish, btnTema);
      else if (nav) nav.parentNode.insertBefore(btnWish, nav);
    }

    refreshUI();
    document.addEventListener('click', handleKlikWishlist);
    document.addEventListener('click', handlePinjam);
  }

  // Jalankan init saat DOM siap
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
