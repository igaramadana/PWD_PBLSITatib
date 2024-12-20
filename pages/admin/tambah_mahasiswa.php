<?php
include '../../config/database.php';

// Proses jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari formulir
    $nim = $_POST['NIM'];
    $nama = $_POST['Nama'];
    $jurusan = $_POST['Jurusan'];
    $prodi = $_POST['Prodi'];
    $kelas = $_POST['Kelas'];
    $angkatan = $_POST['Angkatan'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];
    $email = $_POST['EmailMhs'];

    // Hash password menggunakan algoritma yang lebih aman (misalnya bcrypt)
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Mulai transaksi untuk memastikan data tersimpan secara atomik
    sqlsrv_begin_transaction($conn);

    try {
        // Insert data ke tabel Users (untuk username, password, dan role)
        $role = 'mahasiswa';  // Menambahkan role mahasiswa
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

        // Insert data ke tabel Mahasiswa (untuk NIM, Nama, Jurusan, Prodi, Kelas, Angkatan, dan UserID)
        $insertMahasiswaQuery = "
            INSERT INTO Mahasiswa (UserID, NIM, Nama, Jurusan, Prodi, Kelas, Angkatan, EmailMhs)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ";

        // Insert data mahasiswa
        $insertMahasiswaStmt = sqlsrv_query($conn, $insertMahasiswaQuery, array($userID, $nim, $nama, $jurusan, $prodi, $kelas, $angkatan, $email));

        if ($insertMahasiswaStmt === false) {
            throw new Exception("Gagal memasukkan data ke tabel Mahasiswa: " . print_r(sqlsrv_errors(), true));
        }

        // Jika kedua query berhasil, commit transaksi
        sqlsrv_commit($conn);

        // Redirect ke daftar mahasiswa setelah berhasil menambah
        header("Location: daftar_mahasiswa.php");
        exit();
    } catch (Exception $e) {
        // Jika terjadi error, rollback transaksi
        sqlsrv_rollback($conn);
        die("Error: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mahasiswa</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            padding-top: 50px;
        }
    </style>
</head>

<body>

    <!-- Main Wrapper -->
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen User</a></li>
                        <li class="breadcrumb-item"><a href="daftar_mahasiswa.php">Daftar Mahasiswa</a></li>
                        <li class="breadcrumb-item active">Tambah Mahasiswa</li>
                    </ol>
                </div>

                <!-- Formulir Tambah Mahasiswa -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Tambah Data Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <form action="tambah_mahasiswa.php" method="post" class="form-container">
                                    <div class="form-group">
                                        <label for="NIM">NIM</label>
                                        <input type="text" class="form-control" id="NIM" name="NIM" placeholder="Masukkan Nomor Induk Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Nama">Nama Mahasiswa</label>
                                        <input type="text" class="form-control" id="Nama" name="Nama" placeholder="Masukkan Nama Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Jurusan">Jurusan</label>
                                        <input type="text" class="form-control" id="Jurusan" name="Jurusan" placeholder="Masukkan Jurusan Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Prodi">Prodi</label>
                                        <input type="text" class="form-control" id="Prodi" name="Prodi" placeholder="Masukkan Program Studi Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Kelas">Kelas</label>
                                        <input type="text" class="form-control" id="Kelas" name="Kelas" placeholder="Masukkan Kelas Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Angkatan">Angkatan</label>
                                        <input type="text" class="form-control" id="Angkatan" name="Angkatan" placeholder="Masukkan Angkatan Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="EmailMhs">Email</label>
                                        <input type="email" class="form-control" id="EmailMhs" name="EmailMhs" placeholder="Masukkan Email Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Username">Username</label>
                                        <input type="text" class="form-control" id="Username" name="Username" placeholder="Masukkan Username Mahasiswa" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="Password">Password</label>
                                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Masukkan Password Mahasiswa" required>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success ">Tambah Mahasiswa</button>
                                        <a href="daftar_mahasiswa.php" class="btn btn-danger">Batal</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer.php"); ?>
    </div>

    <!-- Include Bootstrap JS -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>