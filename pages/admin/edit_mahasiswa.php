<?php
include '../../config/database.php';

// Cek apakah parameter ID ada di URL
if (!isset($_GET['id'])) {
    die("ID mahasiswa tidak ditemukan.");
}

$MhsID = $_GET['id'];

// Query untuk mengambil data mahasiswa berdasarkan MhsID
$query = "
    SELECT m.MhsID, m.NIM, m.Nama, m.Jurusan, m.Prodi, m.Kelas, u.Username, m.EmailMhs
    FROM Mahasiswa m
    INNER JOIN Users u ON m.UserID = u.UserID
    WHERE m.MhsID = ?
";

$stmt = sqlsrv_query($conn, $query, array($MhsID));

// Cek apakah query berhasil dan data ditemukan
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}

$mahasiswa = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

// Jika data mahasiswa tidak ditemukan
if (!$mahasiswa) {
    die("Mahasiswa tidak ditemukan.");
}

// Proses update data jika form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nim = $_POST['NIM'];
    $nama = $_POST['Nama'];
    $jurusan = $_POST['Jurusan'];
    $prodi = $_POST['Prodi'];
    $kelas = $_POST['Kelas'];
    $email = $_POST['EmailMhs'];
    $username = $_POST['Username'];

    // 1. Update data di tabel Users
    $updateUserQuery = "
        UPDATE Users
        SET Username = ?
        WHERE UserID = (
            SELECT UserID
            FROM Mahasiswa
            WHERE MhsID = ?
        )
    ";

    $updateUserStmt = sqlsrv_query($conn, $updateUserQuery, array($username, $MhsID));

    if ($updateUserStmt === false) {
        die("Update Users gagal: " . print_r(sqlsrv_errors(), true));
    }

    // 2. Update data di tabel Mahasiswa
    $updateMahasiswaQuery = "
    UPDATE Mahasiswa
    SET NIM = ?, Nama = ?, Jurusan = ?, Prodi = ?, Kelas = ?, EmailMhs = ?
    WHERE MhsID = ?
";

    $updateMahasiswaStmt = sqlsrv_query($conn, $updateMahasiswaQuery, array($nim, $nama, $jurusan, $prodi, $kelas, $email, $MhsID));

    if ($updateMahasiswaStmt === false) {
        die("Update Mahasiswa gagal: " . print_r(sqlsrv_errors(), true));
    }


    // Redirect ke daftar mahasiswa setelah berhasil update
    header("Location: daftar_mahasiswa.php");
    exit;
}
?>

<body>
    <div id="main-wrapper">

        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen User</a></li>
                        <li class="breadcrumb-item"><a href="daftar_mahasiswa.php">Daftar Mahasiswa</a></li>
                        <li class="breadcrumb-item active">Edit Mahasiswa</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Data Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <!-- Form Edit Data Mahasiswa -->
                                <form action="edit_mahasiswa.php?id=<?php echo $MhsID; ?>" method="post">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="NIM">NIM</label>
                                                <input type="text" class="form-control" id="NIM" name="NIM" value="<?php echo htmlspecialchars($mahasiswa['NIM']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="Nama">Nama</label>
                                                <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo htmlspecialchars($mahasiswa['Nama']); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="Jurusan">Jurusan</label>
                                                <input type="text" class="form-control" id="Jurusan" name="Jurusan" value="<?php echo htmlspecialchars($mahasiswa['Jurusan']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <div class="form-group">
                                                <label for="Prodi">Prodi</label>
                                                <input type="text" class="form-control" id="Prodi" name="Prodi" value="<?php echo htmlspecialchars($mahasiswa['Prodi']); ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="Kelas">Kelas</label>
                                                <input type="text" class="form-control" id="Kelas" name="Kelas" value="<?php echo htmlspecialchars($mahasiswa['Kelas']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="EmailMhs">Email</label>
                                                <input type="email" class="form-control" id="EmailMhs" name="EmailMhs" value="<?php echo htmlspecialchars($mahasiswa['EmailMhs']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="Username">Username</label>
                                                <input type="text" class="form-control" id="Username" name="Username" value="<?php echo htmlspecialchars($mahasiswa['Username']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                                        <a href="daftar_mahasiswa.php" class="btn btn-danger"><i class="fa-solid fa-backward"></i> Kembali</a>
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