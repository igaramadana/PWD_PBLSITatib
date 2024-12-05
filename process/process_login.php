<?php
session_start();
include('../config/database.php'); // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mengambil data user berdasarkan username
    $sql = "SELECT UserID, Username, Password, Role 
            FROM Users 
            WHERE Username = ?";
    $params = array($username);
    $stmt = sqlsrv_query($conn, $sql, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
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
                    $infoQuery = "SELECT Nama FROM Dosen WHERE UserID = ?";
                    break;

                case 'mahasiswa':
                    $infoQuery = "SELECT Nama FROM Mahasiswa WHERE UserID = ?";
                    break;

                default:
                    $_SESSION['error'] = "Role tidak valid.";
                    header("Location: ../pages/login.php");
                    exit();
            }

            $infoStmt = sqlsrv_query($conn, $infoQuery, array($user['UserID']));
            if ($infoStmt === false) {
                die(print_r(sqlsrv_errors(), true));
            }

            $additionalInfo = sqlsrv_fetch_array($infoStmt, SQLSRV_FETCH_ASSOC);
            $_SESSION['name'] = $additionalInfo['Nama'];

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
?>
