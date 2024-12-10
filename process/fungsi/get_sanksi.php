<?php
require_once '../../config/database.php';  // Pastikan koneksi DB sudah benar

if (isset($_GET['pelanggaran_id'])) {
    $pelanggaran_id = $_GET['pelanggaran_id'];

    // Query untuk mengambil sanksi berdasarkan tingkat pelanggaran
    $query = "SELECT SanksiID AS sanksi_id, NamaSanksi AS nama_sanksi 
              FROM Sanksi 
              WHERE TingkatID = (SELECT TingkatID FROM Pelanggaran WHERE PelanggaranID = ?)";

    // Eksekusi query dengan parameter
    $params = array($pelanggaran_id);
    $stmt = sqlsrv_query($conn, $query, $params);

    // Mengecek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    }

    $sanksi = [];
    while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
        $sanksi[] = $row;
    }

    echo json_encode($sanksi);  // Mengirim hasil dalam format JSON

    sqlsrv_free_stmt($stmt);  // Membersihkan statement
}