<?php
include('../../config/database.php');  // Pastikan koneksi DB sudah benar

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Mengambil data dari form
    $nim = $_POST['nim'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $prodi = $_POST['prodi'];
    $jenis_pelanggaran = $_POST['jenis_pelanggaran'];
    $catatan = $_POST['catatan'];  // Mengganti 'deskripsi' dengan 'catatan'
    $tanggal = $_POST['tanggal'];
    $sanksi = $_POST['sanksi'];
    $bukti = $_FILES['bukti']['name'];

    // Mengupload foto bukti
    $uploadDir = "../../assets/uploads/";  // Folder untuk menyimpan bukti
    $uploadFile = $uploadDir . basename($bukti);

    // Pastikan file berhasil diupload
    if (move_uploaded_file($_FILES['bukti']['tmp_name'], $uploadFile)) {
        // Menyusun query untuk insert data
        $query = "
            INSERT INTO PengaduanPelanggaran 
            (MhsID, PelanggaranID, TanggalPengaduan, SanksiID, Catatan, BuktiPelanggaran, StatusPelanggaran) 
            VALUES 
            ((SELECT MhsID FROM Mahasiswa WHERE NIM = ?), ?, ?, ?, ?, ?, 'Diproses')
        ";

        // Menyusun parameter untuk query
        $params = array($nim, $jenis_pelanggaran, $tanggal, $sanksi, $catatan, $bukti);  // Ganti 'deskripsi' dengan 'catatan'

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
    } else {
        // Jika file gagal diupload, beri pesan error
        echo "Gagal mengupload bukti foto.";
    }
}
