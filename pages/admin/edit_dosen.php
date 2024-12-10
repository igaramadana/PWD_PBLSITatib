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
    SELECT d.DosenID, d.NIP, d.Nama, d.JKDosen, d.PhoneDosen, d.EmailDosen, u.Username, u.Password
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
    $jenisKelamin = $_POST['JKDosen'];
    $phone = $_POST['PhoneDosen'];
    $email = $_POST['EmailDosen'];

    // Hash password jika password diubah
    if (!empty($password)) {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    } else {
        // Jika password kosong, biarkan password tetap sama (tidak diubah)
        $hashedPassword = $dosen['Password'];  // Menyimpan password lama
    }

    // Mulai transaksi untuk memastikan data tersimpan secara atomik
    sqlsrv_begin_transaction($conn);

    try {
        // Update data username dan password pada tabel Users
        $updateQuery = "
        UPDATE Users
        SET Username = ?, Password = ?
        WHERE UserID = (SELECT UserID FROM Dosen WHERE DosenID = ?)
    ";

        $updateStmt = sqlsrv_query($conn, $updateQuery, array($username, $hashedPassword, $dosenID));

        if ($updateStmt === false) {
            throw new Exception("Update gagal: " . print_r(sqlsrv_errors(), true));
        }

        // Update data NIP, Nama, Jenis Kelamin, No HP, dan Email pada tabel Dosen
        $updateDosenQuery = "
            UPDATE Dosen
            SET NIP = ?, Nama = ?, JKDosen = ?, PhoneDosen = ?, EmailDosen = ?
            WHERE DosenID = ?
        ";

        $updateDosenStmt = sqlsrv_query($conn, $updateDosenQuery, array($nip, $nama, $jenisKelamin, $phone, $email, $dosenID));

        if ($updateDosenStmt === false) {
            throw new Exception("Update data dosen gagal: " . print_r(sqlsrv_errors(), true));
        }

        // Commit transaksi
        sqlsrv_commit($conn);

        // Redirect setelah sukses update
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
    <title>Edit Dosen</title>
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
                                        <label for="NIP"><strong>NIP</strong></label>
                                        <input type="text" class="form-control" id="NIP" name="NIP" value="<?php echo $dosen['NIP']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Nama"><strong>Nama Dosen</strong></label>
                                        <input type="text" class="form-control" id="Nama" name="Nama" value="<?php echo $dosen['Nama']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="JKDosen"><strong>Jenis Kelamin</strong></label>
                                        <select class="form-control" id="JKDosen" name="JKDosen" required>
                                            <option value="Laki-laki" <?php echo ($dosen['JKDosen'] == 'Laki-laki') ? 'selected' : ''; ?>>Laki-laki</option>
                                            <option value="Perempuan" <?php echo ($dosen['JKDosen'] == 'Perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                        </select>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="PhoneDosen"><strong>No. Telepon</strong></label>
                                        <input type="text" class="form-control" id="PhoneDosen" name="PhoneDosen" value="<?php echo $dosen['PhoneDosen']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="EmailDosen"><strong>Email</strong></label>
                                        <input type="email" class="form-control" id="EmailDosen" name="EmailDosen" value="<?php echo $dosen['EmailDosen']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Username"><strong>Username</strong></label>
                                        <input type="text" class="form-control" id="Username" name="Username" value="<?php echo $dosen['Username']; ?>" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="Password"><strong>Password</strong></label>
                                        <input type="password" class="form-control" id="Password" name="Password" placeholder="Masukkan Password baru (biarkan kosong jika tidak diubah)">
                                    </div>

                                    <div class="text-end">
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
