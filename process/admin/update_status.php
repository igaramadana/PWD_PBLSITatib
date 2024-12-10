<?php
include('../../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari POST
    $status = $_POST['status'];
    $pelanggaran_id = $_POST['pelanggaran_id'];

    // Update status pelanggaran
    $query = "UPDATE PengaduanPelanggaran SET StatusPelanggaran = ? WHERE PelanggaranID = ?";
    $params = array($status, $pelanggaran_id);
    $stmt = sqlsrv_query($conn, $query, $params);

    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    // Redirect kembali ke halaman rekap pelanggaran
    header("Location: ../../pages/admin/rekap_pelanggaran.php");
    exit(); // Pastikan script berhenti setelah redirect
}
