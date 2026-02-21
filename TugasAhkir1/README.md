# SISTEM MANAJEMEN BUKU

## Deskripsi Umum

Sistem Manajemen Buku (BookManager) adalah website responsif yang dibangun untuk mengelola koleksi buku secara digital. Website ini terdiri dari 3 halaman utama yang saling terhubung melalui navigasi, menggunakan teknologi HTML5, CSS3, Bootstrap 5, dan JavaScript vanilla. Seluruh tampilan dirancang agar nyaman dilihat di berbagai ukuran layar, mulai dari desktop hingga smartphone.

---

## Struktur File

```
TugasAhkir1/
├── index.html          → Halaman Beranda
├── books.html          → Halaman Koleksi Buku
├── add-book.html       → Halaman Tambah Buku
├── README.md           → Dokumentasi proyek
├── assets/             → Gambar sampul buku
│   ├── pemrograman web modern.png
│   ├── algoritma dan strukdat.jpg
│   └── ... (gambar lainnya)
└── css/
    ├── index.css       → Stylesheet khusus halaman Beranda
    ├── books.css       → Stylesheet khusus halaman Koleksi Buku
    └── add-book.css    → Stylesheet khusus halaman Tambah Buku
```

---

## Penjelasan Tiap Halaman

### 1. index.html — Halaman Beranda

Halaman ini merupakan pintu masuk utama website. Ketika pengguna pertama kali membuka website, mereka akan disambut oleh tampilan hero section yang menampilkan judul besar dan ajakan untuk mulai menambah buku.

**Komponen utama:**
- **Navbar** — Menu navigasi sticky di bagian atas, berisi logo "BookManager" dan 3 tautan halaman (Beranda, Koleksi Buku, Tambah Buku). Pada layar kecil, navbar berubah menjadi hamburger menu.
- **Hero Section** — Area pembuka dengan background gradient biru-gelap, judul besar, deskripsi singkat, dan tombol "Mulai Sekarang" yang mengarah ke halaman Tambah Buku.
- **Footer** — Bagian bawah halaman berisi 4 kolom: informasi tentang kami + media sosial, tautan cepat, sumber daya, dan kontak.
- **JavaScript** — Fungsi `updateActiveNavLink()` yang otomatis menandai menu navigasi aktif sesuai halaman yang sedang dibuka.

### 2. books.html — Halaman Koleksi Buku

Halaman ini menampilkan daftar buku yang tersedia dalam bentuk kartu-kartu (card) yang tersusun dalam grid responsif. Setiap kartu memuat informasi ringkas tentang satu buku.

**Komponen utama:**
- **Section Title** — Judul "Koleksi Buku Lengkap" beserta deskripsi pendek, dengan garis dekoratif gradient di bawahnya.
- **Book Cards (6 kartu)** — Setiap kartu terdiri dari:
  - Area gambar di atas (menggunakan gambar dari folder `assets/` atau gradient warna sebagai fallback)
  - Judul buku, nama penulis, dan deskripsi singkat
  - Footer kartu berisi status ketersediaan (Tersedia/Dipinjam) dan tahun terbit
- **Grid Layout** — Menggunakan sistem grid Bootstrap: 3 kolom di layar besar, 2 kolom di layar sedang, dan 1 kolom di layar kecil.
- **Efek Hover** — Kartu buku bergerak naik sedikit dan bayangan bertambah saat kursor diarahkan ke atasnya.

**Daftar buku yang ditampilkan:**
1. Pemrograman Web Modern — Budi Santoso (Tersedia)
2. Algoritma & Struktur Data — Siti Nurhayati (Dipinjam)
3. Database Management System — Andi Wijayanto (Tersedia)
4. Software Engineering Principles — Dr. Rini Handayani (Tersedia)
5. Artificial Intelligence Basics — Prof. Ahmad Suberi (Dipinjam)
6. Web Security & Best Practices — I Ketut Wididana (Tersedia)

### 3. add-book.html — Halaman Tambah Buku

Halaman ini berisi formulir untuk menambahkan data buku baru ke dalam sistem. Formulir dilengkapi dengan validasi input secara real-time maupun saat dikirim.

**Komponen utama:**
- **Form dengan 8 field input:**
  - Judul Buku (teks, wajib, minimal 3 karakter)
  - Penulis (teks, wajib, minimal 2 karakter)
  - Penerbit (teks, wajib, minimal 2 karakter)
  - Tahun Terbit (angka, wajib, antara 1900–2100)
  - Kategori (dropdown pilihan, wajib)
  - Deskripsi Buku (textarea, wajib, minimal 10 karakter)
  - Jumlah Salinan (angka, wajib, minimal 1)
  - ISBN (teks, opsional)
- **Validasi JavaScript:**
  - Validasi real-time saat pengguna meninggalkan sebuah field (event `blur`)
  - Validasi menyeluruh saat tombol Submit ditekan
  - Pesan error muncul di bawah setiap field yang belum valid
- **Pesan Sukses** — Notifikasi hijau muncul di atas form setelah data berhasil ditambahkan, lalu hilang otomatis setelah 5 detik.
- **Form Note** — Catatan informasi bahwa kolom bertanda bintang (*) wajib diisi.

---

## Teknologi yang Digunakan

- **HTML5** — Struktur halaman dengan elemen semantik (`<nav>`, `<main>`, `<section>`, `<footer>`)
- **CSS3** — Styling menggunakan CSS Variables, Flexbox, Grid, animasi `@keyframes`, gradient, dan media queries untuk responsivitas
- **Bootstrap 5.3.0** — Framework CSS via CDN untuk sistem grid responsif dan komponen navbar
- **Bootstrap Icons 1.11.0** — Ikon-ikon vektor via CDN yang dipakai di seluruh halaman
- **JavaScript (Vanilla)** — Validasi form, penanda navigasi aktif, dan logging ke console

---

## Fitur CSS

- **CSS Variables** — Warna dan nilai yang sering dipakai disimpan dalam variabel `:root` agar konsisten dan mudah diubah
- **Responsif** — Tampilan menyesuaikan layar melalui media queries pada breakpoint 768px dan 576px
- **Animasi** — Efek `fadeInUp` pada hero section, efek `shimmer` pada gambar buku, dan efek `slideDown` pada pesan sukses form
- **Custom Scrollbar** — Scrollbar browser diberi warna yang sesuai tema
- **Setiap halaman punya file CSS sendiri** — Tidak ada file CSS bersama; masing-masing file CSS bersifat mandiri dan berisi seluruh style yang dibutuhkan halaman tersebut

---

## Cara Menjalankan

1. Pastikan semua file berada dalam satu folder (`TugasAhkir1/`)
2. Buka file `index.html` di browser (klik dua kali atau gunakan Live Server di VS Code)
3. Navigasi antar halaman menggunakan menu di atas
4. Diperlukan koneksi internet untuk memuat Bootstrap dan Bootstrap Icons dari CDN
