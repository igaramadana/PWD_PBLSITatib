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

// Persiapkan parameter pencarian
$searchTerm = '%' . $search . '%';  // Menambahkan wildcard (%) untuk pencarian partial

// Eksekusi stored procedure untuk mengambil data mahasiswa berdasarkan halaman dan pencarian
$query = "EXEC sp_GetMahasiswa ?, ?, ?";
$stmt = sqlsrv_query($conn, $query, array($searchTerm, $startFrom, $perPage));

// Cek apakah query berhasil
if ($stmt === false) {
    die("Query gagal: " . print_r(sqlsrv_errors(), true)); // Menampilkan error jika query gagal
}

// Mengambil data hasil query
$mahasiswaList = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $mahasiswaList[] = $row;
}

// Cek apakah ada data
if (empty($mahasiswaList)) {
    echo "Tidak ada data mahasiswa yang ditemukan.";
    exit; // Menghentikan eksekusi script jika tidak ada data
}

// Eksekusi stored procedure untuk menghitung total data mahasiswa sesuai dengan pencarian
$totalQuery = "EXEC sp_CountMahasiswa ?";
$totalStmt = sqlsrv_query($conn, $totalQuery, array($searchTerm));

// Mengambil total jumlah mahasiswa
$totalRow = sqlsrv_fetch_array($totalStmt, SQLSRV_FETCH_ASSOC);
$totalMahasiswa = $totalRow['total'];

// Menghitung total halaman
$totalPages = ceil($totalMahasiswa / $perPage);
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

        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Manajemen User</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Daftar Mahasiswa</a></li>
                    </ol>
                </div>

                <!-- Daftar Mahasiswa Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Daftar Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <form action="daftar_mahasiswa.php" method="get" class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Search Area -->
                                    <div class="search-area w-50">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari disini...">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa-solid fa-search"></i>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Add Data Button -->
                                    <div class="add-button">
                                        <a href="tambah_mahasiswa.php" class="btn btn-md btn-success d-flex align-items-center">
                                            <i class="fa-solid fa-plus me-2"></i> Tambah Data
                                        </a>
                                    </div>
                                </form>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Foto Profil</th>
                                                <th class="text-center">NIM</th>
                                                <th class="text-center">Nama Mahasiswa</th>
                                                <th class="text-center">Jurusan</th>
                                                <th class="text-center">Prodi</th>
                                                <th class="text-center">Kelas</th>
                                                <th class="text-center">Username</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $startFrom + 1; // Menyesuaikan nomor urut per halaman
                                            foreach ($mahasiswaList as $mahasiswa) {
                                                echo "<tr>";
                                                echo "<td class='text-center'>" . $no++ . "</td>";

                                                // Menampilkan foto profil
                                                $fotoProfil = $mahasiswa['FotoProfil'] ? '../../assets/uploads/' . $mahasiswa['FotoProfil'] : '../../assets/uploads/profile.svg'; // Default jika tidak ada foto
                                                echo "<td class='text-center'><img src='" . htmlspecialchars($fotoProfil) . "' alt='Foto Profil' class='rounded-circle' width='50' height='50' style='object-fit: cover;'></td>";

                                                // Menampilkan data lainnya
                                                echo "<td class='text-center'>{$mahasiswa['NIM']}</td>";
                                                echo "<td class='text-center'>{$mahasiswa['Nama']}</td>";
                                                echo "<td class='text-center'>{$mahasiswa['Jurusan']}</td>";
                                                echo "<td class='text-center'>{$mahasiswa['Prodi']}</td>";
                                                echo "<td class='text-center'>{$mahasiswa['Kelas']}</td>";
                                                echo "<td class='text-center'>{$mahasiswa['Username']}</td>";
                                                echo "<td class='text-center'>
                                                        <div class='dropdown'>
                                                            <button class='btn btn-secondary dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-expanded='false'>
                                                                <i class='fa-solid fa-ellipsis-vertical'></i>
                                                            </button>
                                                            <ul class='dropdown-menu'>
                                                                <li><a class='dropdown-item' href='edit_mahasiswa.php?id={$mahasiswa['MhsID']}'><i class='fa-solid fa-pencil text-warning me-2'></i>Edit</a></li>
                                                                <li><a class='dropdown-item' href='delete_mahasiswa.php?id={$mahasiswa['MhsID']}' onclick='return confirm(\"Apakah Anda yakin ingin menghapus mahasiswa ini?\")'><i class='fa-solid fa-trash text-danger me-2'></i>Hapus</a></li>
                                                            </ul>
                                                        </div>
                                                      </td>";
                                                echo "</tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Pagination Section -->
                            <nav class="pb-2">
                                <ul class="pagination pagination-gutter justify-content-center">
                                    <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                                            <i class="la la-angle-left"></i>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                        <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php echo $page >= $totalPages ? 'disabled' : ''; ?>">
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
</body>