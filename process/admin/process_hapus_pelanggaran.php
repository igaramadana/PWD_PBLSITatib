<?php
include "../../config/database.php";

// Mengecek apakah ID pelanggaran ada di URL
if (isset($_GET['id'])) {
    $pelanggaranID = $_GET['id'];

    // Query untuk menghapus data pelanggaran berdasarkan ID
    $sql = "DELETE FROM Pelanggaran WHERE PelanggaranID = ?";
    $params = array($pelanggaranID);

    // Menjalankan query
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Cek apakah penghapusan berhasil
    if ($stmt) {
<<<<<<< HEAD
        // Redirect kembali ke halaman kelola tata tertib dengan status berhasil
        header ("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=deleted");
    } else {
        // Jika gagal, redirect dengan status error
        header ("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=error");
    }
} else {
    // Jika ID tidak ditemukan, redirect ke halaman utama
=======
        // Redirect kembali ke halaman kelola pelanggaran dengan status berhasil
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=deleted");
    } else {
        // Jika gagal, redirect dengan status error
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php?status=error");
    }
} else {
    // Jika ID tidak ditemukan, redirect ke halaman kelola pelanggaran
>>>>>>> 3060951151108f4a1a1e19e7d0167a6be50a40e1
    header("Location: /PWD_PBLSITatib/pages/admin/kelola_tatatertib.php");
}
?>
