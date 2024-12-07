<?php
// Pastikan koneksi ke database sudah dibuat
include '../../config/database.php'; // Sesuaikan dengan koneksi database Anda

// Mulai sesi
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Alihkan ke halaman login jika belum login
    exit();
}

// Ambil UserID dari sesi
$UserID = $_SESSION['user_id'];

// Query untuk mengambil data mahasiswa
$sql = "SELECT MhsID, NIM, Nama, Jurusan, Prodi, Kelas, Angkatan, FotoProfil FROM Mahasiswa WHERE UserID = ?";
$params = array($UserID);

// Menyiapkan dan mengeksekusi query
$stmt = sqlsrv_query($conn, $sql, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Mengecek hasil query
if (sqlsrv_has_rows($stmt)) {
    // Ambil data mahasiswa
    $mahasiswa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);
} else {
    echo "Data mahasiswa tidak ditemukan.";
    exit();
}

// Tutup koneksi
sqlsrv_free_stmt($stmt);
sqlsrv_close($conn);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
</head>

<body>
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Profile</a></li>
                    </ol>
                </div>

                <!-- Profile Content -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Foto Profil</h4>
                            </div>
                            <div class="card-body text-center">
                                <!-- Mengecek apakah foto profil ada, jika tidak, gunakan gambar default -->
                                <?php
                                // Cek apakah ada foto profil
                                $fotoProfil = $mahasiswa['FotoProfil'];
                                if (empty($fotoProfil) || $fotoProfil == NULL) {
                                    // Jika foto profil NULL, gunakan gambar default
                                    $fotoProfil = 'profile.svg'; // Ganti dengan nama gambar default yang Anda inginkan
                                }
                                ?>
                                <!-- Menampilkan foto profil -->
                                <img src="../../assets/uploads/<?php echo $fotoProfil; ?>" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px; height: 150px; object-fit: cover;">
                                <h5 class="my-3"><?php echo $mahasiswa['Nama']; ?></h5>
                                <p class="text-muted mb-1">Mahasiswa</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <!-- Tombol ganti foto profil -->
                                    <button type="button" class="btn btn-warning btn-sm mt-4" data-toggle="modal" data-target="#uploadModal">Change Profile Picture</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Informasi Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <!-- Menampilkan informasi mahasiswa -->
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nomor Induk Mahasiswa</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['NIM']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama Lengkap</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['Nama']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Jurusan</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['Jurusan']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Program Studi</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['Prodi']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Kelas</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['Kelas']; ?></p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Angkatan</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0"><?php echo $mahasiswa['Angkatan']; ?></p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>
    </div>

    <!-- Modal untuk upload foto profil -->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="uploadModalLabel">Upload Foto Profil</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../process/process_upload_profile.php" method="POST" enctype="multipart/form-data">
                        <label for="fotoProfil">Pilih Foto Profil</label>
                        <div class="form-file">
                            <input type="file" class="form-file-input form-control" id="fotoProfil" name="fotoProfil" accept="image/*" required>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary mt-3">Upload</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Script untuk preview gambar -->
    <script>
        // Fungsi untuk melihat preview foto profil
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>

</html>