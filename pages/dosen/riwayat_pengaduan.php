<?php
include "../../process/dosen/fungsi_tampil_profile.php";
require_once '../../config/database.php';

session_start();
if (!isset($_SESSION['DosenID'])) {
    header("Location: ../login.php");
    exit();
}

$UserID = $_SESSION['DosenID'];  // Dosen ID dari session

$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Pagination settings
$perPage = 10;  // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Halaman saat ini
$startFrom = ($page - 1) * $perPage;  // Posisi mulai data pada halaman

// Query untuk menghitung total data pengaduan
$totalQuery = "SELECT COUNT(*) AS total
               FROM PengaduanPelanggaran pp
               JOIN Mahasiswa m ON pp.MhsID = m.MhsId
               JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
               WHERE pp.DosenID = ?";

if (!empty($search)) {
    $totalQuery .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

if (!empty($statusFilter)) {
    $totalQuery .= " AND pp.StatusPelanggaran = ?";
}

$totalParams = [$UserID];
if (!empty($search)) {
    $totalParams[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $totalParams[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $totalParams[] = $statusFilter;  // Filter status pelanggaran
}

// Eksekusi query untuk menghitung total data
$totalStmt = sqlsrv_query($conn, $totalQuery, $totalParams);
$totalRow = sqlsrv_fetch_array($totalStmt, SQLSRV_FETCH_ASSOC);
$totalPelanggaran = $totalRow['total'];

$totalPages = ceil($totalPelanggaran / $perPage);  // Menghitung jumlah halaman
sqlsrv_free_stmt($totalStmt);

// Query untuk mengambil pengaduan berdasarkan halaman dan filter
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran,
          m.FotoProfil, pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan, m.Prodi
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsId
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.DosenID = ?";

if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

$query .= " ORDER BY pp.TanggalPengaduan DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";  // Menambahkan OFFSET dan FETCH

$params = [$UserID];  // Menambahkan DosenID dari session untuk filter
if (!empty($search)) {
    $params[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $params[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $params[] = $statusFilter;  // Filter status pelanggaran
}
$params[] = $startFrom; // OFFSET untuk pagination
$params[] = $perPage;   // FETCH NEXT untuk pagination

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

<!-- Preloader -->
<div id="preloader">
    <div class="lds-ripple">
        <div></div>
        <div></div>
    </div>
</div>

<!-- Main wrapper -->
<div id="main-wrapper">

    <!-- Header -->
    <?php include("header.php"); ?>

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Content body -->
    <div class="content-body">
        <div class="container-fluid">
            <!-- Breadcrumb -->
            <div class="row page-titles">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Riwayat Pengaduan</a></li>
                </ol>
            </div>

            <!-- Rekap Pelanggaran Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Riwayat Pengaduan Mahasiswa</h4>
                        </div>
                        <div class="card-body">

                            <!-- Search and Sort Buttons -->
                            <div class="row mb-3">
                                <!-- Search Form -->
                                <div class="col-md-6">
                                    <form action="riwayat_pelanggaran.php" method="get" class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                value="<?php echo htmlspecialchars($search ?? ''); ?>"
                                                placeholder="Cari disini...">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Sort by Status -->
                                <div class="col-md-6 text-end">
                                    <form action="riwayat_pelanggaran.php" method="get">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group w-50">
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Sort by</option>
                                                    <option value="Diajukan" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diajukan') ? 'selected' : ''; ?>>Diajukan</option>
                                                    <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                    <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="bg-primary text-white">
                                        <tr>
                                            <th class="text-center">No.</th>
                                            <th class="text-center">NIM</th>
                                            <th class="text-center">Nama Mahasiswa</th>
                                            <th class="text-center">Prodi Mahasiswa</th>
                                            <th class="text-center">Nama Pelanggaran</th>
                                            <th class="text-center">Deskripsi Pelanggaran</th>
                                            <th class="text-center">Tanggal Pengaduan</th>
                                            <th class="text-center">Bukti</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
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
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['TanggalPengaduan']); ?></td>
                                                    <td class="text-center">
                                                        <img src="<?php echo '../../assets/uploads/' . htmlspecialchars($pelanggaran['BuktiPelanggaran']); ?>" alt="Bukti Pelanggaran" class="rounded-circle" width="50" height="50" style="object-fit: cover;">
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

                            <!-- Pagination Section -->
                            <nav class="pb-2 mt-3">
                                <ul class="pagination pagination-gutter justify-content-center">
                                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&status=<?php echo urlencode($statusFilter); ?>">
                                            <i class="la la-angle-right"></i>
                                        </a>
                                    </li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Scripts -->
        <?php include("footer.php"); ?>

    </div>
</div>
