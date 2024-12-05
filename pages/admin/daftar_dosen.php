<?php
include '../../config/database.php';

// Jumlah data per halaman
$perPage = 10;

// Mengambil nomor halaman dari URL, jika tidak ada maka default ke halaman 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Mengambil parameter pencarian dari URL
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Menghitung posisi awal (offset) untuk query
$startFrom = ($page - 1) * $perPage;

// Query untuk mengambil data dosen beserta username dan password dari tabel Users
$query = "
    SELECT d.DosenID, d.NIP, d.Nama, u.Username, u.Password
    FROM Dosen d
    INNER JOIN Users u ON d.UserID = u.UserID
    WHERE d.NIP LIKE ? OR d.Nama LIKE ? OR u.Username LIKE ?
    ORDER BY d.DosenID
    OFFSET ? ROWS FETCH NEXT ? ROWS ONLY
";

// Persiapkan parameter pencarian
$searchTerm = '%' . $search . '%';  // Menambahkan wildcard (%) untuk pencarian partial

// Eksekusi query untuk mengambil data dosen berdasarkan halaman dan pencarian
$stmt = sqlsrv_query($conn, $query, array($searchTerm, $searchTerm, $searchTerm, $startFrom, $perPage));

// Cek apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
}

// Mengambil data hasil query
$dosenList = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $dosenList[] = $row;
}

// Cek apakah ada data
if (empty($dosenList)) {
    echo "Tidak ada data dosen yang ditemukan.";
    exit; // Menghentikan eksekusi script jika tidak ada data
}

// Query untuk menghitung total data dosen sesuai dengan pencarian
$totalQuery = "
    SELECT COUNT(*) AS total
    FROM Dosen d
    INNER JOIN Users u ON d.UserID = u.UserID
    WHERE d.NIP LIKE ? OR d.Nama LIKE ? OR u.Username LIKE ?
";
$totalStmt = sqlsrv_query($conn, $totalQuery, array($searchTerm, $searchTerm, $searchTerm));

// Mengambil total jumlah dosen
$totalRow = sqlsrv_fetch_array($totalStmt, SQLSRV_FETCH_ASSOC);
$totalDosen = $totalRow['total'];

// Menghitung total halaman
$totalPages = ceil($totalDosen / $perPage);
?>
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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen User</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Dosen</a></li>
                    </ol>
                </div>

                <!-- Daftar Dosen Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Daftar Dosen</h4>
                            </div>
                            <div class="card-body">
                                <!-- Pencarian dan Tombol Tambah Data -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <form action="daftar_dosen.php" method="get" class="d-flex">
                                            <div class="input-group">
                                                <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari disini...">
                                                <span class="input-group-append">
                                                    <button type="submit" class="btn btn-primary">Search</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <a href="tambah_dosen.php"><button class="btn btn-md btn-success">+ Tambah Data</button></a>
                                    </div>
                                </div>

                                <!-- Filter A-Z dan Z-A -->
                                <form action="daftar_dosen.php" method="get" class="mb-3">
                                    <div class="d-flex justify-content-end">
                                        <div class="input-group w-25">
                                            <select name="sort" class="form-control" onchange="this.form.submit()">
                                                <option value="">Sort by</option>
                                                <option value="asc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'asc' ? 'selected' : ''; ?>>A-Z</option>
                                                <option value="desc" <?php echo isset($_GET['sort']) && $_GET['sort'] == 'desc' ? 'selected' : ''; ?>>Z-A</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive-md">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Foto Profil</th>
                                                <th class="text-center">NIP</th>
                                                <th class="text-center">Nama Dosen</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $startFrom + 1; // Menyesuaikan nomor urut per halaman
                                            foreach ($dosenList as $dosen) {
                                                echo "<tr>";
                                                echo "<td class='text-center'>" . $no++ . "</td>";
                                                echo "<td class='text-center'><img src='../../assets/template/images/avatar/1.jpg' alt='Foto Profil' class='img-fluid' width='50' height='50'></td>"; // Ganti dengan path foto profil yang sesuai
                                                echo "<td class='text-center'>{$dosen['NIP']}</td>";
                                                echo "<td class='text-center'>{$dosen['Nama']}</td>";
                                                echo "<td class='text-center'>{$dosen['Username']}</td>";
                                                echo "<td class='text-center'>
                                                        <a href='edit_dosen.php?id={$dosen['DosenID']}' class='btn btn-warning btn-sm'><i class='fa-solid fa-pencil'></i></a>
                                                        <a href='delete_dosen.php?id={$dosen['DosenID']}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus dosen ini?\")'><i class='fa-solid fa-trash'></i></a>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Pagination Section -->
                            <nav class="pb-2 text-center">
                                <ul class="pagination pagination-gutter justify-content-center">
                                    <!-- Halaman Sebelumnya -->
                                    <li class="page-item<?php echo $page <= 1 ? ' disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>

                                    <!-- Halaman 1 sampai Total Halaman -->
                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>

                                    <!-- Halaman Berikutnya -->
                                    <li class="page-item <?php echo $page >= $totalPages ? ' disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>&search=<?php echo urlencode($search); ?>&sort=<?php echo urlencode($sort); ?>">
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

    <!-- Footer Scripts -->
    <?php include("footer.php"); ?>

</body>

</html>