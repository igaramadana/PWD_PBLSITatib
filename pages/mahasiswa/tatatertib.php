<?php
require_once '../../config/database.php';
include "../../process/mahasiswa/fungsi_tampil_profile.php";

// Menangani pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $perPage;

// Query untuk menghitung total data
$countQuery = "SELECT COUNT(*) AS total FROM Pelanggaran WHERE Pelanggaran.NamaPelanggaran LIKE ?";
$search = isset($_GET['search']) ? $_GET['search'] : '';  // Inisialisasi dengan nilai default
$searchParam = "%" . $search . "%";
$countParams = array($searchParam);
$countResult = sqlsrv_query($conn, $countQuery, $countParams);

if ($countResult === false) {
    die(print_r(sqlsrv_errors(), true));
}

$countRow = sqlsrv_fetch_array($countResult, SQLSRV_FETCH_ASSOC);
$totalData = $countRow['total'];

// Menghitung jumlah total halaman
$totalPages = ceil($totalData / $perPage);

// Query untuk mengambil data sanksi
$query = "SELECT Pelanggaran.PelanggaranID, Pelanggaran.NamaPelanggaran, TingkatPelanggaran.Tingkat
        FROM Pelanggaran
        JOIN TingkatPelanggaran ON Pelanggaran.TingkatID = TingkatPelanggaran.TingkatID
        WHERE Pelanggaran.NamaPelanggaran LIKE ?
        ORDER BY Pelanggaran.PelanggaranID
        OFFSET $startFrom ROWS FETCH NEXT $perPage ROWS ONLY";

$params = array($searchParam);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tata Tertib Mahasiswa</title>
    <!-- Tambahkan CSS dan JS yang diperlukan di sini -->
</head>
<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Peraturan</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Sanksi</a></li>
                    </ol>
                </div>

                <!-- Kelola Sanksi Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Daftar Tata Tertib Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <!-- Search Form -->
                                    <form action="tatatertib.php" method="get" class="d-flex align-items-center w-50">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control rounded-start"
                                                name="search"
                                                value="<?php echo htmlspecialchars($search); ?>"
                                                placeholder="Cari pelanggaran..."
                                                aria-label="Cari pelanggaran" />
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Tabel Sanksi -->
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Pelanggaran</th>
                                                <th>Tingkat</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $startFrom + 1;
                                            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) : ?>
                                                <tr>
                                                <td><?php echo $no++; ?></td>
                                                    <td class="text-start"><?php echo htmlspecialchars($row['NamaPelanggaran']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['Tingkat']); ?></td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Pagination Section -->
                                <nav class="pb-2">
                                    <ul class="pagination pagination-gutter justify-content-center">
                                        <!-- Previous Page Button (disabled if on the first page) -->
                                        <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                                                <i class="la la-angle-left"></i>
                                            </a>
                                        </li>

                                        <!-- Pages Button -->
                                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                            <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>">
                                                    <?php echo $i; ?>
                                                </a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Next Page Button (disabled if on the last page) -->
                                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>">
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
        </div>
        <?php include("footer.php"); ?>
    </div>

    <!-- Tambahkan script JS yang diperlukan di sini -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>