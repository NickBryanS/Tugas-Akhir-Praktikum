<?php
session_start();

// Jika sudah login, redirect ke halaman utama
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: ../index.php');
    exit;
}

// Cek cookie "Remember Me" untuk auto-fill username
$remembered_username = '';
if (isset($_COOKIE['remember_username'])) {
    $remembered_username = htmlspecialchars($_COOKIE['remember_username'], ENT_QUOTES, 'UTF-8');
}

// Cek apakah ada pesan error dari proses login
$error = '';
if (isset($_SESSION['login_error'])) {
    $error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Manajemen Buku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/login.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="icon">
                    <i class="bi bi-book-half"></i>
                </div>
                <h2>BookManager</h2>
                <p>Masuk ke akun Anda untuk melanjutkan</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert" id="alertError">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="proses_login.php" method="POST" id="loginForm">
                <div class="form-floating">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Username" required
                           value="<?php echo $remembered_username; ?>">
                    <label for="username"><i class="bi bi-person-fill me-2"></i>Username</label>
                </div>

                <div class="form-floating password-wrapper">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Password" required>
                    <label for="password"><i class="bi bi-lock-fill me-2"></i>Password</label>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember_me"
                           <?php echo (!empty($remembered_username)) ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="remember_me">
                        <i class="bi bi-shield-check me-1"></i> Ingat Saya (Remember Me)
                    </label>
                </div>

                <button type="submit" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Masuk
                </button>
            </form>
        </div>
        <p class="footer-text">&copy; 2024 Sistem Manajemen Buku. Semua bisa membaca.</p>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Alert otomatis hilang setelah 4 detik
        const alertEl = document.getElementById('alertError');
        if (alertEl) {
            setTimeout(() => {
                const bsAlert = bootstrap.Alert.getOrCreateInstance(alertEl);
                bsAlert.close();
            }, 4000);
        }

        // Validasi form sebelum submit
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value.trim();
            
            if (username === '' || password === '') {
                e.preventDefault();
                alert('Username dan Password tidak boleh kosong!');
            }
        });
    </script>
</body>
</html>