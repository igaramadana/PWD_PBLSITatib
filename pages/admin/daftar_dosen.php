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
    SELECT d.DosenID, d.NIP, d.Nama, u.Username, u.Password, d.JKDosen, d.PhoneDosen, d.EmailDosen
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
                                <!-- Search and Add Data Buttons -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <form action="daftar_dosen.php" method="get" class="d-flex">
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
                                        <a href="tambah_dosen.php" class="btn btn-md btn-success">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </a>
                                    </div>
                                </div>
                                <!-- Sort Filter -->
                                <form action="daftar_dosen.php" method="get" class="mb-3">
                                    <div class="d-flex justify-content-end">
                                        <div class="input-group w-25">
                                            <select name="sort" class="form-control" onchange="this.form.submit()">
                                                <option value="">Sort by</option>
                                                <option value="asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'asc') ? 'selected' : ''; ?>>A-Z</option>
                                                <option value="desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'desc') ? 'selected' : ''; ?>>Z-A</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>

                                <!-- Table -->
                                <div class="table-responsive">
                                    <table class="table table-bordered table-responsive-md">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">NIP</th>
                                                <th class="text-center">Nama Dosen</th>
                                                <th class="text-center">Jenis Kelamin</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Phone Dosen</th>
                                                <th class="text-center">Email Dosen</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (!empty($dosenList)) : ?>
                                                <?php
                                                $no = ($startFrom ?? 0) + 1;
                                                foreach ($dosenList as $dosen) : ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $no++; ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['NIP']); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['Nama']); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['JKDosen']); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['Username']); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['PhoneDosen']); ?></td>
                                                        <td class="text-center"><?php echo htmlspecialchars($dosen['EmailDosen']); ?></td>
                                                        <td class="text-center">
                                                            <a href="edit_dosen.php?id=<?php echo urlencode($dosen['DosenID']); ?>"
                                                                class="btn btn-warning btn-sm"
                                                                aria-label="Edit Dosen <?php echo htmlspecialchars($dosen['Nama']); ?>">
                                                                <i class="fa fa-pencil-alt"></i> Edit
                                                            </a>
                                                            <a href="delete_dosen.php?id=<?php echo urlencode($dosen['DosenID']); ?>"
                                                                class="btn btn-danger btn-sm"
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus dosen ini?')"
                                                                aria-label="Hapus Dosen <?php echo htmlspecialchars($dosen['Nama']); ?>">
                                                                <i class="fa fa-trash"></i> Hapus
                                                            </a>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php else : ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">Tidak ada data dosen yang ditemukan.</td>
                                                </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
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