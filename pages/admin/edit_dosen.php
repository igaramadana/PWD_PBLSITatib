<?php
include '../../config/database.php';

// Ambil ID Dosen dari URL
if (isset($_GET['id'])) {
    $dosenID = $_GET['id'];
} else {
    die("ID Dosen tidak ditemukan.");
}

// Query untuk mengambil data dosen berdasarkan DosenID
$query = "
    SELECT d.DosenID, d.NIP, d.Nama, u.Username, u.Password
    FROM Dosen d
    INNER JOIN Users u ON d.UserID = u.UserID
    WHERE d.DosenID = ?
";

// Persiapkan dan eksekusi query
$stmt = sqlsrv_query($conn, $query, array($dosenID));

// Cek apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true));
}

// Ambil data dosen
$dosen = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC);

if (!$dosen) {
    die("Data dosen tidak ditemukan.");
}

// Proses jika formulir disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data yang dikirimkan melalui form
    $nip = $_POST['NIP'];
    $nama = $_POST['Nama'];
    $username = $_POST['Username'];
    $password = $_POST['Password'];

    // Update data username dan password pada tabel Users
    $updateQuery = "
    UPDATE Users
    SET Username = ?, Password = CONVERT(varbinary(max), ?)
    WHERE UserID = (SELECT UserID FROM Dosen WHERE DosenID = ?)
";

    $updateStmt = sqlsrv_query($conn, $updateQuery, array($username, $password, $dosenID));

    if ($updateStmt === false) {
        die("Update gagal: " . print_r(sqlsrv_errors(), true));
    }

    // Update data NIP dan Nama pada tabel Dosen
    $updateDosenQuery = "
        UPDATE Dosen
        SET NIP = ?, Nama = ?
        WHERE DosenID = ?
    ";

    $updateDosenStmt = sqlsrv_query($conn, $updateDosenQuery, array($nip, $nama, $dosenID));

    if ($updateDosenStmt === false) {
        die("Update data dosen gagal: " . print_r(sqlsrv_errors(), true));
    }

    // Redirect setelah sukses update
    header("Location: daftar_dosen.php");
    exit();
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
                        <li class="breadcrumb-item"><a href="daftar_dosen.php">Daftar Dosen</a></li>
                        <li class="breadcrumb-item active">Edit Dosen</li>
                    </ol>
                </div>

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Edit Profil Dosen</h4>
                            </div>
                            <div class="card-body">
                                <form action="edit_dosen.php?id=<?php echo $dosenID; ?>" method="post">
                                    <div class="form-group mb-3">
                                        <label for="NIP">NIP</label>
                                        <input type="text" class="form-control" id="NIP" name="NIP" value="<?php echo $dosen['NIP']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Nama">Nama Dosen</label>
                                        <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo $dosen['Nama']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Username">Username</label>
                                        <input type="text" class="form-control" id="Username" name="Username" value="<?php echo $dosen['Username']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Password">Password</label>
                                        <input type="password" class="form-control" id="Password" name="Password" value="<?php echo $dosen['Password']; ?>" required>
                                    </div>

                                    <div class="text-center">
                                        <button type="submit" class="btn btn-success"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
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