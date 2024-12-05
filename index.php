<?php
// Mulai sesi
session_start();
// Jika belum login, arahkan ke halaman login
header('Location: pages/login.php');
exit();
