<?php
include '../../config/database.php';

// Proses jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nip = $_POST['NIP'];
    $nama = $_POST['Nama'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Hash password menggunakan algoritma yang lebih aman (misalnya bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Mulai transaksi untuk memastikan data tersimpan secara atomik
    sqlsrv_begin_transaction($conn);

    try {
        // Insert data ke tabel Users (untuk username, password, dan role)
        $role = 'dosen';  // Atau sesuaikan dengan nilai yang sesuai
        $insertUserQuery = "
            INSERT INTO Users (Username, Password, Role)
            OUTPUT INSERTED.UserID
            VALUES (?, CONVERT(VARBINARY(MAX), ?), ?)
        ";

        // Kirimkan data username, hashed password, dan role
        $insertUserStmt = sqlsrv_query($conn, $insertUserQuery, array($username, $hashedPassword, $role));

        if ($insertUserStmt === false) {
            throw new Exception("Gagal memasukkan data ke tabel Users: " . print_r(sqlsrv_errors(), true));
        }

        // Ambil UserID yang baru dimasukkan menggunakan OUTPUT
        $row = sqlsrv_fetch_array($insertUserStmt, SQLSRV_FETCH_ASSOC);
        $userID = $row['UserID'];

        // Insert data ke tabel Dosen (untuk NIP, Nama, dan UserID yang dimasukkan secara manual)
        $insertDosenQuery = "
            INSERT INTO Dosen (UserID, NIP, Nama)
            VALUES (?, ?, ?)
        ";

        // Insert data dosen (NIP, Nama, UserID)
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
                                    <div class="form-group mb-3">
                                        <label for="NIP"><strong>NIP</strong></label>
                                        <input type="text" class="form-control" id="NIP" name="NIP" placeholder="Masukkan NIP..." required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Nama"><strong>Nama Dosen</strong></label>
                                        <input type="text" class="form-control" id="Nama" name="Nama" placeholder="Masukkan Nama Dosen..." required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Username"><strong>Username</strong></label>
                                        <input type="text" class="form-control" id="Username" name="Username" placeholder="Masukkan Username..." required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Password"><strong>Password</strong></label>
                                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Masukkan Password..." required>
                                    </div>

                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success btn-md mt-3">Tambah Dosen</button>
                                    </div>
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