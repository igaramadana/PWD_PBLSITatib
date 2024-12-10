<?php
include "../../config/database.php";
include "../../process/dosen/fungsi_tampil_profile.php";

session_start();
if (!isset($_SESSION['DosenID'])) {
    header("Location: ../login.php");
    exit();
}

$UserID = $_SESSION['DosenID'];  // Dosen ID dari session

$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Query untuk mengambil pengaduan hanya dari dosen yang melaporkan
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran,
          m.FotoProfil, pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan, m.Prodi
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsId
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.DosenID = ?";  // Filter berdasarkan DosenID yang login

if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

$query .= " ORDER BY pp.TanggalPengaduan DESC";

$params = [$UserID];  // Menambahkan DosenID dari session untuk filter
if (!empty($search)) {
    $params[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $params[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $params[] = $statusFilter;  // Filter status pelanggaran
}

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil query
$pelanggaranList = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    // Pastikan tanggal diubah menjadi format yang sesuai (jika perlu)
    $row['TanggalPengaduan'] = $row['TanggalPengaduan'] ? $row['TanggalPengaduan']->format('d F Y') : 'N/A'; // Format tanggal
    $pelanggaranList[] = $row;
}

sqlsrv_free_stmt($stmt);
?>

<body>

    <!--*******************
Preloader start
********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
Preloader end
********************-->

    <!--**********************************
Main wrapper start
***********************************-->
    <div id="main-wrapper">

        <?php
        include("header.php");
        ?>

        <?php
        include("sidebar.php");
        ?>

        <!--**********************************
    Content body start
***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                    </ol>
                </div>
                <div class="row gy-4">
                    <!-- Total Pelanggaran -->
                    <?php
                    // Mengambil jumlah mahasiswa dari tabel Mahasiswa
                    $queryMahasiswa = "SELECT COUNT(*) AS total_mahasiswa FROM Mahasiswa";
                    $resultMahasiswa = sqlsrv_query($conn, $queryMahasiswa);
                    $mahasiswaRow = sqlsrv_fetch_array($resultMahasiswa, SQLSRV_FETCH_ASSOC);
                    $totalMahasiswa = $mahasiswaRow['total_mahasiswa'];
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-danger">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-graduation-cap fs-3 text-white"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Total Mahasiswa</p>
                                        <h3 class="text-white mb-0"><?= $totalMahasiswa ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Point Pelanggaran -->
                    <?php
                    // Mengambil jumlah pelanggaran yang dilaporkan oleh dosen yang sedang login
                    $queryTotalInput = "SELECT COUNT(*) AS total_input 
                    FROM PengaduanPelanggaran 
                    WHERE DosenID = ?";
                    $params = [$UserID];  // Menambahkan DosenID dari session untuk filter
                    $stmtInput = sqlsrv_query($conn, $queryTotalInput, $params);

                    if ($stmtInput === false) {
                        die(print_r(sqlsrv_errors(), true));  // Menangani error jika query gagal
                    }

                    $inputRow = sqlsrv_fetch_array($stmtInput, SQLSRV_FETCH_ASSOC);
                    $totalInput = $inputRow['total_input'];
                    sqlsrv_free_stmt($stmtInput);  // Jangan lupa untuk melepaskan statement setelah digunakan
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-clipboard fs-3 text-white"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Input Pelanggaran</p>
                                        <h3 class="text-white mb-0"><?= $totalInput ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Terkini -->
                    <?php
                    // Mengambil jumlah pelanggaran yang dilaporkan oleh dosen yang sedang login
                    $queryStatusSelesai = "SELECT COUNT(*) AS total_selesai 
                    FROM PengaduanPelanggaran 
                    WHERE DosenID = ? AND StatusPelanggaran = 'Selesai'";
                    $params = [$UserID];  // Menambahkan DosenID dari session untuk filter
                    $stmtInput = sqlsrv_query($conn, $queryStatusSelesai, $params);

                    if ($stmtInput === false) {
                        die(print_r(sqlsrv_errors(), true));  // Menangani error jika query gagal
                    }

                    $inputRow = sqlsrv_fetch_array($stmtInput, SQLSRV_FETCH_ASSOC);
                    $totalSelesai = $inputRow['total_selesai'];
                    sqlsrv_free_stmt($stmtInput);  // Jangan lupa untuk melepaskan statement setelah digunakan
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-info">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-check fs-3 text-white"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold text-white">Selesai</p>
                                        <h3 class="text-white mb-0"><?= $totalSelesai ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Sanksi Saat Ini -->
                    <?php
                    // Mengambil jumlah pelanggaran yang dilaporkan oleh dosen yang sedang login
                    $queryStatusDiajukan = "SELECT COUNT(*) AS total_diajukan
                    FROM PengaduanPelanggaran 
                    WHERE DosenID = ? AND StatusPelanggaran = 'Diajukan'";
                    $params = [$UserID];  // Menambahkan DosenID dari session untuk filter
                    $stmtInput = sqlsrv_query($conn, $queryStatusDiajukan, $params);

                    if ($stmtInput === false) {
                        die(print_r(sqlsrv_errors(), true));  // Menangani error jika query gagal
                    }

                    $inputRow = sqlsrv_fetch_array($stmtInput, SQLSRV_FETCH_ASSOC);
                    $totalDiajukan = $inputRow['total_diajukan'];
                    sqlsrv_free_stmt($stmtInput);  // Jangan lupa untuk melepaskan statement setelah digunakan
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-clock fs-3 text-white"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Diajukan</p>
                                        <h3 class="text-white mb-0"><?= $totalDiajukan ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content Pelanggaran Terkini -->
                    <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Input Pelanggaran Terkini</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive recentOrderTable">
                                    <table class="table verticle-middle table-responsive-md">
                                        <thead>
                                            <tr>
                                                <th scope="col">No.</th>
                                                <th scope="col">NIM</th>
                                                <th scope="col">Nama</th>
                                                <th scope="col">Prodi</th>
                                                <th scope="col">Pelanggaran</th>
                                                <th scope="col">Deskripsi</th>
                                                <th scope="col">Tanggal</th>
                                                <th scope="col">Status</th>
                                                <th scope="col"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <?php if (!empty($pelanggaranList)) : ?>
                                                    <?php
                                                    $no = 1;
                                                    foreach ($pelanggaranList as $pelanggaran) :
                                                    ?>
                                            <tr>
                                                <td class="text-center"><?php echo $no++; ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NIM']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Nama']); ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Prodi']); ?></td>
                                                <td class="text-start"><?php echo htmlspecialchars($pelanggaran['NamaPelanggaran']) ?></td>
                                                <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Catatan']); ?></td>
                                                <td class="text-center">
                                                    <?php echo htmlspecialchars($pelanggaran['TanggalPengaduan']); ?>
                                                </td>
                                                <td class="text-center"><?php echo htmlspecialchars($pelanggaran['StatusPelanggaran']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="8" class="text-center">Tidak ada data pelanggaran yang ditemukan.</td>
                                        </tr>
                                    <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end mt-3">
                                    <a href="riwayat_pengaduan.php">
                                        <button class="btn btn-primary btn-sm">Selengkapnya</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
    Content body end
    ***********************************-->

    <!--**********************************
   Support ticket button start
***********************************-->

    <!--**********************************
   Support ticket button end
***********************************-->


    </div>
    <!--**********************************
Main wrapper end
***********************************-->
    <?php
    include("footer.php");
    ?>


</body>

</html>