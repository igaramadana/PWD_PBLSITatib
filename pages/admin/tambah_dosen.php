<?php
include '../../config/database.php';

// Proses jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $userID = $_POST['UserID'];  // Ambil UserID yang dimasukkan oleh admin
    $nip = $_POST['NIP'];
    $nama = $_POST['Nama'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Cek apakah UserID ada di tabel Users
    $checkUserQuery = "SELECT 1 FROM Users WHERE UserID = ?";
    $checkUserStmt = sqlsrv_query($conn, $checkUserQuery, array($userID));

    if ($checkUserStmt === false) {
        die("Error: " . print_r(sqlsrv_errors(), true));
    }

    $userExists = sqlsrv_fetch_array($checkUserStmt, SQLSRV_FETCH_ASSOC);

    if (!$userExists) {
        die("Error: UserID yang dimasukkan tidak ada di tabel Users.");
    }

    // Hash password menggunakan algoritma yang lebih aman (misalnya bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Mengonversi hashed password menjadi format binary yang bisa disimpan di SQL Server
    $binaryPassword = bin2hex($hashedPassword); // Mengubah hash password menjadi format hexadecimal
    $binaryPassword = strtoupper($binaryPassword); // Menjamin formatnya sesuai dengan SQL Server expectation

    // Mulai transaksi untuk memastikan data tersimpan secara atomik
    sqlsrv_begin_transaction($conn);

    try {
        // Insert data ke tabel Users (untuk username, password, dan role)
        $role = 'dosen';  // Atau sesuaikan dengan nilai yang sesuai
        $insertUserQuery = "
            INSERT INTO Users (Username, Password, Role)
            VALUES (?, CONVERT(VARBINARY(MAX), ?), ?)
        ";

        // Kirimkan password dalam bentuk hexadecimal dan role
        $insertUserStmt = sqlsrv_query($conn, $insertUserQuery, array($username, $binaryPassword, $role));

        if ($insertUserStmt === false) {
            throw new Exception("Gagal memasukkan data ke tabel Users: " . print_r(sqlsrv_errors(), true));
        }

        // Insert data ke tabel Dosen (untuk NIP, Nama, dan UserID yang dimasukkan secara manual)
        $insertDosenQuery = "
            INSERT INTO Dosen (UserID, NIP, Nama)
            VALUES (?, ?, ?)
        ";

        $insertDosenStmt = sqlsrv_query($conn, $insertDosenQuery, array($userID, $nip, $nama));

        if ($insertDosenStmt === false) {
            throw new Exception("Gagal memasukkan data ke tabel Dosen: " . print_r(sqlsrv_errors(), true));
        }

        // Jika kedua query berhasil, commit transaksi
        sqlsrv_commit($conn);

        // Redirect ke daftar dosen setelah berhasil menambah
        header("Location: daftar_dosen.php");
        exit();
    } catch (Exception $e) {
        // Jika terjadi error, rollback transaksi
        sqlsrv_rollback($conn);
        die("Error: " . $e->getMessage());
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Dosen</title>
</head>
<body>
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen User</a></li>
                        <li class="breadcrumb-item"><a href="daftar_dosen.php">Daftar Dosen</a></li>
                        <li class="breadcrumb-item active">Tambah Dosen</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Dosen</h4>
                            </div>
                            <div class="card-body">
                                <form action="tambah_dosen.php" method="post">
                                    <div class="form-group">
                                        <label for="UserID">User ID</label>
                                        <input type="text" class="form-control" id="UserID" name="UserID" required> 
                                    </div>
                                    <div class="form-group">
                                        <label for="NIP">NIP</label>
                                        <input type="text" class="form-control" id="NIP" name="NIP" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Nama">Nama Dosen</label>
                                        <input type="text" class="form-control" id="Nama" name="Nama" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Username">Username</label>
                                        <input type="text" class="form-control" id="Username" name="Username" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="password" class="form-control" id="Password" name="Password" required>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Tambah Dosen</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>
    </div>
</body>
</html>
