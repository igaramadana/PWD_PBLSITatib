<?php
session_start();
require_once '../config/database.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mengambil dan menyaring input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validasi input (contoh: memastikan username dan password tidak kosong)
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username dan password tidak boleh kosong.";
        header("Location: ../pages/login.php");
        exit();
    }

    // Query untuk mengambil data user berdasarkan username
    $sql = "SELECT UserID, Username, Password, Role 
            FROM Users 
            WHERE Username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        // Jangan tampilkan error database di production
        $_SESSION['error'] = "Terjadi kesalahan, coba lagi nanti.";
        header("Location: ../pages/login.php");
        exit();
    }

    $user = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

    // Validasi username dan password
    if ($user) {
        // Gunakan password_verify untuk memverifikasi password
        if (password_verify($password, $user['Password'])) {
            // Jika password cocok, lanjutkan proses login
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Query tambahan untuk mengambil data sesuai role
            $additionalInfo = null;
            switch ($user['Role']) {
                case 'admin':
                    $infoQuery = "SELECT Nama FROM Admin WHERE UserID = ?";
                    break;

                case 'dosen':
                    $infoQuery = "SELECT Nama, DosenID FROM Dosen WHERE UserID = ?";
                    break;

                case 'mahasiswa':
                    // Ambil MhsID juga jika role adalah mahasiswa
                    $infoQuery = "SELECT Nama, MhsID FROM Mahasiswa WHERE UserID = ?";
                    break;

                default:
                    $_SESSION['error'] = "Role tidak valid.";
                    header("Location: ../pages/login.php");
                    exit();
            }

            $infoStmt = sqlsrv_query($conn, $infoQuery, array($user['UserID']));
            if ($infoStmt === false) {
                $_SESSION['error'] = "Terjadi kesalahan, coba lagi nanti.";
                header("Location: ../pages/login.php");
                exit();
            }

            $additionalInfo = sqlsrv_fetch_array($infoStmt, SQLSRV_FETCH_ASSOC);
            $_SESSION['name'] = $additionalInfo['Nama'];

            // Simpan MhsID atau DosenID ke session
            if ($user['Role'] == 'mahasiswa') {
                $_SESSION['MhsID'] = $additionalInfo['MhsID'];
            }

            if ($user['Role'] == 'dosen') {
                $_SESSION['DosenID'] = $additionalInfo['DosenID'];
            }

            // Regenerasi ID session untuk keamanan
            session_regenerate_id(true);

            // Redirect berdasarkan role
            switch ($user['Role']) {
                case 'admin':
                    header("Location: ../pages/admin/dashboard.php");
                    break;

                case 'dosen':
                    header("Location: ../pages/dosen/dashboard.php");
                    break;

                case 'mahasiswa':
                    header("Location: ../pages/mahasiswa/dashboard.php");
                    break;
            }
            exit();
        } else {
            // Jika password salah
            $_SESSION['error'] = "Password salah.";
            header("Location: ../pages/login.php");
            exit();
        }
    } else {
        // Jika username tidak ditemukan
        $_SESSION['error'] = "Username tidak ditemukan.";
        header("Location: ../pages/login.php");
        exit();
    }
}
