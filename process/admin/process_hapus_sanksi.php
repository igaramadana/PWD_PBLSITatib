<?php
include "../../config/database.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $sanksiID = isset($_POST['SanksiID']) ? $_POST['SanksiID'] : '';

    if (empty($sanksiID)) {
        header("Location: ../admin/kelola_sanksi.php?status=error&msg=ID sanksi tidak ditemukan");
        exit;
    }

    $query = "DELETE FROM Sanksi WHERE SanksiID = ?";

    $params = array($sanksiID);
    $result = sqlsrv_query($conn, $query, $params);

    if ($result) {
        // Redirect ke halaman kelola pelanggaran dengan status sukses
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_sanksi.php?status=success");
    } else {
        // Jika gagal, tampilkan error
        header("Location: /PWD_PBLSITatib/pages/admin/kelola_sanksi.php?status=error");
    }
}
