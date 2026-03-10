<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: controller/login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Sistem Manajemen Buku - Tambah Buku Baru">
    <meta name="keywords" content="tambah buku, buku baru, manajemen, sistem informasi, perpustakaan">
    <meta name="author" content="Praktikum SIWEB">
    
    <title>Tambah Buku - Sistem Manajemen Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/add-book.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="index.php">
                <i class="bi bi-book-half"></i>
                BookManager
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">
                            <i class="bi bi-house-fill"></i> Beranda
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="books.php">
                            <i class="bi bi-collection-fill"></i> Koleksi Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="add-book.php">
                            <i class="bi bi-plus-circle-fill"></i> Tambah Buku
                        </a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="nav-link text-danger" href="controller/logout.php" title="Logout">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section id="form" class="form-section">
            <div class="container-fluid px-4">
                <div class="section-title mb-5">
                    <h2>Tambah Buku Baru</h2>
                    <p>Masukkan data buku yang ingin ditambahkan ke dalam sistem</p>
                </div>

                <div class="form-container">
                    <div class="success-message" id="successMessage">
                        <i class="bi bi-check-circle-fill"></i> Buku berhasil ditambahkan ke sistem! 
                        <a href="books.php" style="color: #fff; text-decoration: underline; font-weight: 700;">Lihat Koleksi Buku &rarr;</a>
                    </div>

                    <form id="bookForm" novalidate>
                        <div class="form-group">
                            <label for="bookTitle">
                                <i class="bi bi-book-fill"></i> Judul Buku <span class="required-marker">*</span>
                            </label>
                            <input type="text" class="form-control" id="bookTitle" name="bookTitle" 
                                   placeholder="Masukkan judul buku" required>
                            <div class="error-message">Judul buku tidak boleh kosong</div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bookAuthor">
                                    <i class="bi bi-pen-fill"></i> Penulis <span class="required-marker">*</span>
                                </label>
                                <input type="text" class="form-control" id="bookAuthor" name="bookAuthor" 
                                       placeholder="Nama penulis" required>
                                <div class="error-message">Nama penulis tidak boleh kosong</div>
                            </div>
                            <div class="form-group">
                                <label for="bookPublisher">
                                    <i class="bi bi-bookmark-fill"></i> Penerbit <span class="required-marker">*</span>
                                </label>
                                <input type="text" class="form-control" id="bookPublisher" name="bookPublisher" 
                                       placeholder="Nama penerbit" required>
                                <div class="error-message">Nama penerbit tidak boleh kosong</div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bookYear">
                                    <i class="bi bi-calendar-fill"></i> Tahun Terbit <span class="required-marker">*</span>
                                </label>
                                <input type="number" class="form-control" id="bookYear" name="bookYear" 
                                       placeholder="2024" min="1900" max="2100" required>
                                <div class="error-message">Tahun terbit harus berupa angka antara 1900-2100</div>
                            </div>
                            <div class="form-group">
                                <label for="bookCategory">
                                    <i class="bi bi-collection-fill"></i> Kategori <span class="required-marker">*</span>
                                </label>
                                <select class="form-control" id="bookCategory" name="bookCategory" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <option value="Teknologi">Teknologi & Informatika</option>
                                    <option value="Fiksi">Fiksi & Sastra</option>
                                    <option value="Non-Fiksi">Non-Fiksi & Biografi</option>
                                    <option value="Bisnis">Bisnis & Ekonomi</option>
                                    <option value="Pendidikan">Pendidikan & Sains</option>
                                    <option value="Lainnya">Lainnya</option>
                                </select>
                                <div class="error-message">Silakan pilih kategori</div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bookCover">
                                <i class="bi bi-image-fill"></i> Cover Buku
                            </label>
                            <input type="file" class="form-control" id="bookCover" name="bookCover" 
                                   accept="image/jpeg,image/png,image/webp">
                            <small class="text-muted">Format: JPG, PNG, WEBP (Maks. 2MB)</small>
                            <div class="cover-preview" id="coverPreview" style="display:none; margin-top:10px; position:relative; max-width:200px;">
                                <img id="coverPreviewImg" src="" alt="Preview Cover" style="width:100%; border-radius:8px;">
                                <button type="button" class="cover-remove-btn" id="removeCover" title="Hapus Cover">
                                    <i class="bi bi-x-lg"></i>
                                </button>
                            </div>
                        </input>
                        <div class="form-group">
                            <label for="bookDescription">
                                <i class="bi bi-file-text-fill"></i> Deskripsi Buku <span class="required-marker">*</span>
                            </label>
                            <textarea class="form-control" id="bookDescription" name="bookDescription" 
                                      placeholder="Masukkan sinopsis atau deskripsi singkat tentang buku..." required></textarea>
                            <div class="error-message">Deskripsi buku tidak boleh kosong</div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="bookCopy">
                                    <i class="bi bi-stack"></i> Jumlah Salinan <span class="required-marker">*</span>
                                </label>
                                <input type="number" class="form-control" id="bookCopy" name="bookCopy" 
                                       placeholder="Jumlah salinan" min="1" max="1000" required>
                                <div class="error-message">Jumlah salinan harus angka positif</div>
                            </div>
                            <div class="form-group">
                                <label for="bookISBN">
                                    <i class="bi bi-barcode"></i> ISBN
                                </label>
                                <input type="text" class="form-control" id="bookISBN" name="bookISBN" 
                                       placeholder="ISBN (opsional)">
                            </div>
                        </div>
                        <div class="form-note">
                            <i class="bi bi-info-circle-fill"></i>
                            <small><strong>Catatan:</strong> Kolom yang ditandai dengan asterisk (*) wajib diisi. Dapatkan ISBN dari penerbit atau sumber terpercaya lainnya.</small>
                        </div>
                        <button type="submit" class="form-button">
                            <i class="bi bi-check-lg"></i> Tambahkan Buku
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>
                    <i class="bi bi-info-circle"></i> Tentang Kami
                </h4>
                <p>Sistem Manajemen Buku adalah platform digital yang dirancang untuk memudahkan pengelolaan koleksi buku di perpustakaan atau organisasi Anda.</p>
                <div class="footer-social">
                    <a href="#" title="Facebook" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" title="Twitter" aria-label="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" title="Instagram" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" title="LinkedIn" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h4>
                    <i class="bi bi-link-45deg"></i> Tautan Cepat
                </h4>
                <ul>
                    <li><a href="index.php">Beranda</a></li>
                    <li><a href="books.php">Koleksi Buku</a></li>
                    <li><a href="add-book.php">Tambah Buku</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>
                    <i class="bi bi-resources"></i> Sumber Daya
                </h4>
                <ul>
                    <li><a href="#">Panduan Pengguna</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Kebijakan Privasi</a></li>
                    <li><a href="#">Syarat & Ketentuan</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h4>
                    <i class="bi bi-telephone-fill"></i> Kontak Kami
                </h4>
                <ul class="footer-contact-list">
                    <li class="footer-contact-item">
                        <i class="bi bi-envelope-fill"></i> 
                        <a href="mailto:info@bookmanager.com">info@bookmanager.com</a>
                    </li>
                    <li class="footer-contact-item">
                        <i class="bi bi-telephone-fill"></i> 
                        <a href="tel:+62123456789">+62 (123) 456-789</a>
                    </li>
                    <li>
                        <i class="bi bi-geo-alt-fill"></i> 
                        Jl. Teknologi No. 123, Jakarta, Indonesia
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy;Sistem Manajemen Buku. Semua bisa membaca.</p>
            <p>Dikembangkan dengan sepenuh hati oleh Nick Bryan Andos Sianturi</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Mengambil dari form dan pesan sukses
        const bookForm = document.getElementById('bookForm');
        const successMessage = document.getElementById('successMessage');
        let coverBase64 = '';

        // Elemen untuk upload dan preview cover buku
        const coverInput = document.getElementById('bookCover');
        const coverPreview = document.getElementById('coverPreview');
        const coverPreviewImg = document.getElementById('coverPreviewImg');
        const removeCoverBtn = document.getElementById('removeCover');

        // Event listener saat file cover dipilih
        coverInput.addEventListener('change', function(e) {
            handleCoverFile(e.target.files[0]);
        });

        // Tombol hapus preview cover
        removeCoverBtn.addEventListener('click', function() {
            coverBase64 = '';
            coverInput.value = '';
            coverPreview.style.display = 'none';
        });

        // Memproses file cover: validasi tipe & ukuran, lalu tampilkan preview
        function handleCoverFile(file) {
            if (!file) return;
            if (!['image/jpeg','image/png','image/webp'].includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau WEBP.');
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                coverBase64 = e.target.result;
                coverPreviewImg.src = coverBase64;
                coverPreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }

        // Memvalidasi semua field form sebelum submit
        function validateForm() {
            let isValid = true;
            const fields = [
                { id: 'bookTitle', minLength: 3 },
                { id: 'bookAuthor', minLength: 2 },
                { id: 'bookPublisher', minLength: 2 },
                { id: 'bookYear', type: 'number', min: 1900, max: 2100 },
                { id: 'bookCategory', required: true },
                { id: 'bookDescription', minLength: 10 },
                { id: 'bookCopy', type: 'number', min: 1 }
            ];

            fields.forEach(field => {
                const input = document.getElementById(field.id);
                const formGroup = input.closest('.form-group');
                let valid = false;

                if (field.type === 'number') {
                    const value = parseInt(input.value);
                    valid = !isNaN(value) && value >= (field.min || -Infinity) && value <= (field.max || Infinity);
                } else if (field.id === 'bookCategory') {
                    valid = input.value !== '';
                } else {
                    valid = input.value.trim().length >= (field.minLength || 1);
                }

                if (!valid) {
                    formGroup.classList.add('error');
                    isValid = false;
                } else {
                    formGroup.classList.remove('error');
                }
            });

            return isValid;
        }

        // Handler submit form: validasi, simpan buku ke localStorage, reset form
        bookForm.addEventListener('submit', function(e) {
            e.preventDefault();

            if (validateForm()) {
                const newBook = {
                    id: Date.now(),
                    title: document.getElementById('bookTitle').value.trim(),
                    author: document.getElementById('bookAuthor').value.trim(),
                    publisher: document.getElementById('bookPublisher').value.trim(),
                    year: document.getElementById('bookYear').value,
                    category: document.getElementById('bookCategory').value,
                    description: document.getElementById('bookDescription').value.trim(),
                    copy: parseInt(document.getElementById('bookCopy').value),
                    isbn: document.getElementById('bookISBN').value.trim(),
                    cover: coverBase64,
                    status: 'Tersedia',
                    addedAt: new Date().toISOString()
                };
                const books = JSON.parse(localStorage.getItem('bookCollection') || '[]');
                books.push(newBook);
                localStorage.setItem('bookCollection', JSON.stringify(books));

                console.log('Data Buku yang Ditambahkan:', newBook);
                successMessage.classList.add('show');
                bookForm.reset();
                coverBase64 = '';
                coverPreview.style.display = 'none';
                setTimeout(() => {
                    successMessage.classList.remove('show');
                }, 5000);
                window.scrollTo({ top: 0, behavior: 'smooth' });
            }
        });

        // Validasi real-time saat input kehilangan fokus (blur)
        const inputs = bookForm.querySelectorAll('input:not(#bookCover), textarea, select');
        inputs.forEach(input => {
            input.addEventListener('blur', function() {
                const formGroup = this.closest('.form-group');
                let valid = true;

                if (this.id === 'bookYear' || this.id === 'bookCopy') {
                    const value = parseInt(this.value);
                    if (this.id === 'bookYear') {
                        valid = !isNaN(value) && value >= 1900 && value <= 2100;
                    } else {
                        valid = !isNaN(value) && value >= 1;
                    }
                } else if (this.id === 'bookCategory') {
                    valid = this.value !== '';
                } else {
                    valid = this.value.trim().length > 0;
                }

                if (!valid) {
                    formGroup.classList.add('error');
                } else {
                    formGroup.classList.remove('error');
                }
            });
        });

        // Mengatur navigasi link aktif sesuai halaman saat ini
        function updateActiveNavLink() {
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.classList.remove('active');
                const href = link.getAttribute('href');
                if (href === 'add-book.php' || href === window.location.pathname.split('/').pop()) {
                    link.classList.add('active');
                }
            });
        }

        // Panggil saat halaman selesai dimuat
        document.addEventListener('DOMContentLoaded', updateActiveNavLink);

        // Log informasi versi di console
        console.log('%cSelamat datang di Tambah Buku!', 'color: #3498db; font-size: 18px; font-weight: bold;');
        console.log('%cVersión: 1.0.0', 'color: #27ae60; font-size: 14px;');
    </script>
    <script src="Js/script.js"></script>
</body>
</html>
