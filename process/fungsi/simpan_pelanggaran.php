<?php
require_once '../../config/database.php';
session_start();

// Pastikan dosen sudah login dan DosenID ada dalam session
if (!isset($_SESSION['DosenID'])) {
    die("Dosen ID tidak ditemukan. Anda belum login.");
}

$dosenID = $_SESSION['DosenID'];  // Ambil DosenID dari session

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Mengambil data dari form
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $prodi = $_POST['prodi'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $catatan = $_POST['catatan'];  
    $tanggal = $_POST['tanggal'];
    $sanksi = $_POST['sanksi'];
    $bukti = $_FILES['bukti']['name'];

    // Mengupload foto bukti
    $uploadDir = "../../assets/uploads/";  // Folder untuk menyimpan bukti
    $uploadFile = $uploadDir . basename($bukti);

    // Pastikan file berhasil diupload
    if (move_uploaded_file($_FILES['bukti']['tmp_name'], $uploadFile)) {

        // Ambil MhsID berdasarkan NIM
        $query_mhs = "SELECT MhsID FROM Mahasiswa WHERE NIM = ?";
        $params_mhs = array($nim);
        $stmt_mhs = sqlsrv_query($conn, $query_mhs, $params_mhs);

        if ($stmt_mhs === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $mhs = sqlsrv_fetch_array($stmt_mhs, SQLSRV_FETCH_ASSOC);
        if (!$mhs) {
            echo "Mahasiswa dengan NIM tersebut tidak ditemukan.";
            exit();
        }

        $mhsID = $mhs['MhsID'];

        // Menyusun query untuk insert data
        $query = "
            INSERT INTO PengaduanPelanggaran 
            (MhsID, PelanggaranID, TanggalPengaduan, SanksiID, Catatan, BuktiPelanggaran, StatusPelanggaran, DosenID) 
            VALUES 
            (?, ?, ?, ?, ?, ?, 'Diajukan', ?)
        ";

        // Menyusun parameter untuk query
        $params = array($mhsID, $jenis_pelanggaran, $tanggal, $sanksi, $catatan, $bukti, $dosenID);

        // Menjalankan query
        $stmt = sqlsrv_query($conn, $query, $params);

        if ($stmt === false) {
            // Jika query gagal, tampilkan error
            die(print_r(sqlsrv_errors(), true));
        }

        // Jika query berhasil, tampilkan pesan sukses
        echo "Pelanggaran berhasil disimpan.";

        // Membersihkan statement setelah selesai
        sqlsrv_free_stmt($stmt);
        sqlsrv_free_stmt($stmt_mhs);
    } else {
        // Jika file gagal diupload, beri pesan error
        echo "Gagal mengupload bukti foto.";
    }
}
?>
