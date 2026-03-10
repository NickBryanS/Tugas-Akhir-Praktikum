<?php
session_start();

// Hanya terima metode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login.php');
    exit;
}

// Ambil input dari form
$username = isset($_POST['username']) ? trim($_POST['username']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$remember = isset($_POST['remember_me']);

// Hardcoded credentials untuk testing
$valid_username = 'bryan';
$valid_password = 'bryan123';

// Validasi login
if ($username === $valid_username && $password === $valid_password) {
    // Login berhasil - set session
    $_SESSION['logged_in'] = true;
    $_SESSION['username'] = $username;
    $_SESSION['login_time'] = date('Y-m-d H:i:s');

    // Remember Me - simpan cookie selama 30 hari
    if ($remember) {
        setcookie('remember_username', $username, time() + (30 * 24 * 60 * 60), '/', '', false, true);
    } else {
        // Hapus cookie jika tidak dicentang
        setcookie('remember_username', '', time() - 3600, '/', '', false, true);
    }

    header('Location: ../index.php');
    exit;
} else {
    // Login gagal - simpan pesan error di session
    $_SESSION['login_error'] = 'Username atau Password salah! Silakan coba lagi.';
    header('Location: login.php');
    exit;
}