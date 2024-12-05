<?php
session_start();

// Memeriksa apakah pengguna sudah login, jika tidak, alihkan ke halaman login
if (!isset($_SESSION['user_id'])) {
    header('Location: pages/login.php');
    exit();
}