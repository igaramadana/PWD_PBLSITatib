<?php
require_once '../../config/database.php';
require_once '../../vendor/autoload.php';  // Pastikan path ke PHPMailer autoload.php benar

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

        // Ambil MhsID dan EmailMhs berdasarkan NIM
        $query_mhs = "SELECT MhsID, EmailMhs FROM Mahasiswa WHERE NIM = ?";
        $params_mhs = array($nim);
        $stmt_mhs = sqlsrv_query($conn, $query_mhs, $params_mhs);

        if ($stmt_mhs === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $mhs = sqlsrv_fetch_array($stmt_mhs, SQLSRV_FETCH_ASSOC);
        if (!$mhs) {
            echo "<script>alert('Mahasiswa dengan NIM tersebut tidak ditemukan.'); window.location.href='input_pelanggaran.php';</script>";
            exit();
        }

        $mhsID = $mhs['MhsID'];
        $emailMahasiswa = $mhs['EmailMhs'];

        // Ambil NamaPelanggaran berdasarkan PelanggaranID
        $query_pelanggaran = "SELECT NamaPelanggaran FROM Pelanggaran WHERE PelanggaranID = ?";
        $params_pelanggaran = array($jenis_pelanggaran); // Menggunakan ID pelanggaran
        $stmt_pelanggaran = sqlsrv_query($conn, $query_pelanggaran, $params_pelanggaran);

        if ($stmt_pelanggaran === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $pelanggaran = sqlsrv_fetch_array($stmt_pelanggaran, SQLSRV_FETCH_ASSOC);
        $namaPelanggaran = $pelanggaran['NamaPelanggaran'];

        // Ambil NamaSanksi berdasarkan SanksiID
        $query_sanksi = "SELECT NamaSanksi FROM Sanksi WHERE SanksiID = ?";
        $params_sanksi = array($sanksi); // Menggunakan ID pelanggaran
        $stmt_sanksi = sqlsrv_query($conn, $query_sanksi, $params_sanksi);

        if ($stmt_sanksi === false) {
            die(print_r(sqlsrv_errors(), true));
        }

        $fetchsanksi = sqlsrv_fetch_array($stmt_sanksi, SQLSRV_FETCH_ASSOC);
        $namaSanksi = $fetchsanksi['NamaSanksi'];

        // Mendapatkan dosenID dari session
        session_start();
        $dosenID = $_SESSION['DosenID'];  // Pastikan dosenID ada di session

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
            echo "<script>alert('Gagal menyimpan pelanggaran. Silakan coba lagi.'); window.location.href='../../pages/admin/input_pelanggaran.php';</script>";
        } else {
            // Kirim email kepada mahasiswa menggunakan PHPMailer
            $mail = new PHPMailer\PHPMailer\PHPMailer();

            try {
                // Konfigurasi server email
                $mail->isSMTP();                                      // Setel pengiriman email menggunakan SMTP
                $mail->Host = 'smtp.gmail.com';                         // Ganti dengan server SMTP yang digunakan (contoh: Gmail)
                $mail->SMTPAuth = true;                                // Aktifkan autentikasi SMTP
                $mail->Username = 'ethicxtatib@gmail.com';             // Ganti dengan email pengirim
                $mail->Password = 'ubthvrgtlqvozwrh';                  // Ganti dengan password email pengirim
                $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;                                    // Port untuk TLS

                // Penerima dan pengirim email
                $mail->setFrom('ethicxtatib@gmail.com', 'Ethicx Tatib');  // Ganti dengan nama dan email pengirim
                $mail->addAddress($emailMahasiswa);                        // Email penerima

                // Subjek dan isi email
                $mail->Subject = 'Pemberitahuan Pelanggaran Mahasiswa';
                $bodyContent = "
                <html>
                <head>
                    <style>
                        body {font-family: Arial, sans-serif; color: #333;}
                        .email-container {max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; border-radius: 10px;}
                        .email-header {background-color: #007BFF; color: white; padding: 10px; text-align: center; border-radius: 10px;}
                        .email-body {padding: 20px; background-color: white; border-radius: 10px;}
                        table {width: 100%; border-collapse: collapse;}
                        th, td {padding: 10px; text-align: left; border: 1px solid #ddd;}
                        th {background-color: #f2f2f2;}
                        .footer {text-align: center; font-size: 12px; color: #888;}
                    </style>
                </head>
                <body>
                    <div class='email-container'>
                        <div class='email-header'>
                            <h2>Pemberitahuan Pelanggaran Mahasiswa</h2>
                        </div>
                        <div class='email-body'>
                            <p>Yth. {$nama},</p>
                            <p>Berikut adalah informasi terkait pelanggaran yang Anda lakukan:</p>
                            <table>
                                <tr>
                                    <th>Nama Mahasiswa</th>
                                    <td>{$nama}</td>
                                </tr>
                                <tr>
                                    <th>NIM</th>
                                    <td>{$nim}</td>
                                </tr>
                                <tr>
                                    <th>Kelas</th>
                                    <td>{$kelas}</td>
                                </tr>
                                <tr>
                                    <th>Program Studi</th>
                                    <td>{$prodi}</td>
                                </tr>
                                <tr>
                                    <th>Jenis Pelanggaran</th>
                                    <td>{$namaPelanggaran}</td> <!-- Ganti dengan Nama Pelanggaran -->
                                </tr>
                                <tr>
                                    <th>Tanggal Pelanggaran</th>
                                    <td>{$tanggal}</td>
                                </tr>
                                <tr>
                                    <th>Sanksi</th>
                                    <td>{$namaSanksi}</td>
                                </tr>
                                <tr>
                                    <th>Catatan</th>
                                    <td>{$catatan}</td>
                                </tr>
                            </table>
                            <p>Terima kasih atas perhatian Anda.</p>
                        </div>
                        <div class='footer'>
                            <p>&copy; 2024 Politeknik Negeri Malang</p>
                        </div>
                    </div>
                </body>
                </html>
            ";

                $mail->isHTML(true);
                $mail->Body = $bodyContent;

                // Kirim email
                if ($mail->send()) {
                    echo "<script>alert('Pelanggaran berhasil disimpan dan email berhasil dikirim.'); window.location.href='../../pages/dosen/input_pelanggaran.php';</script>";
                } else {
                    echo "<script>alert('Pelanggaran berhasil disimpan, tetapi gagal mengirim email.'); window.location.href='../../pages/dosen/input_pelanggaran.php';</script>";
                }
            } catch (Exception $e) {
                echo "<script>alert('Terjadi kesalahan saat mengirim email: " . $mail->ErrorInfo . "'); window.location.href='../../pages/dosen/input_pelanggaran.php';</script>";
            }
        }

        // Membersihkan statement setelah selesai
        sqlsrv_free_stmt($stmt);
        sqlsrv_free_stmt($stmt_mhs);
    } else {
        // Jika file gagal diupload, beri pesan error
        echo "<script>alert('Gagal mengupload bukti foto.'); window.location.href='../../pages/dosen/input_pelanggaran.php';</script>";
    }
}
