<?php
include "../../config/database.php";
include "../../process/mahasiswa/fungsi_tampil_profile.php";

session_start();
if (!isset($_SESSION['MhsID'])) {
    header("Location: ../login.php");
}

$UserID = $_SESSION['MhsID'];

// Jumlah data per halaman
$perPage = 10;

// Mengambil nomor halaman dari URL, jika tidak ada maka default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Menghitung posisi awal (offset) untuk query
$startFrom = ($page - 1) * $perPage;

// Mengambil parameter pencarian dan status filter dari URL
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Query untuk mengambil pelanggaran terbaru dengan pagination
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran,
          p.NamaPelanggaran, pp.TanggalPengaduan, p.TingkatID, pp.BuktiPelanggaran
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsId
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.MhsID = ?";  // Filter berdasarkan MhsID yang login

// Jika ada parameter pencarian, tambahkan kondisi pencarian
if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

// Jika ada status filter, tambahkan kondisi untuk status
if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

// Menambahkan limit dan offset untuk pagination
$query .= " ORDER BY pp.TanggalPengaduan DESC OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

// Menyusun parameter query
$params = [$UserID];
if (!empty($search)) {
    $params[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $params[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $params[] = $statusFilter;  // Filter status pelanggaran
}
$params[] = $startFrom; // OFFSET
$params[] = $perPage;   // FETCH NEXT

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil query
$pelanggaranList = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $row['TanggalPengaduan'] = $row['TanggalPengaduan'] ? $row['TanggalPengaduan']->format('d F Y') : 'N/A'; // Format tanggal
    $pelanggaranList[] = $row;
}

sqlsrv_free_stmt($stmt);

// Query untuk menghitung total data pelanggaran
$totalQuery = "SELECT COUNT(*) AS total
               FROM PengaduanPelanggaran pp
               JOIN Mahasiswa m ON pp.MhsID = m.MhsId
               WHERE pp.MhsID = ?";  // Filter berdasarkan MhsID yang login

if (!empty($search)) {
    $totalQuery .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

if (!empty($statusFilter)) {
    $totalQuery .= " AND pp.StatusPelanggaran = ?";
}

$totalStmt = sqlsrv_query($conn, $totalQuery, [$UserID, "%$search%", "%$search%", $statusFilter]);

$totalRow = sqlsrv_fetch_array($totalStmt, SQLSRV_FETCH_ASSOC);
$totalPelanggaran = $totalRow['total'];

$totalPages = ceil($totalPelanggaran / $perPage);
sqlsrv_free_stmt($totalStmt);
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
                                                    <td class="text-start"><?php echo htmlspecialchars($pelanggaran['NamaPelanggaran']) ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Catatan']); ?></td>
                                                    <td class="text-center">
                                                        <?php echo htmlspecialchars($pelanggaran['TanggalPengaduan']); ?>
                                                    </td>
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

                            <!-- Pagination -->
                            <div class="pagination">
                                <ul class="pagination justify-content-center">
                                    <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a>
                                    </li>
                                </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Scripts -->
        <?php include("footer.php"); ?>

    </div>
</div>
