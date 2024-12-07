<?php
include "../../config/database.php";
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $perPage;

// Menangani pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data sanksi
$query = "SELECT Sanksi.SanksiID, Sanksi.NamaSanksi, TingkatPelanggaran.Tingkat
          FROM Sanksi
          JOIN TingkatPelanggaran ON Sanksi.TingkatID = TingkatPelanggaran.TingkatID
          WHERE Sanksi.NamaSanksi LIKE ?
          ORDER BY Sanksi.SanksiID
          OFFSET $startFrom ROWS FETCH NEXT $perPage ROWS ONLY";

$searchParam = "%" . $search . "%";
$params = array($searchParam);
$result = sqlsrv_query($conn, $query, $params);

if ($result === false) {
    die(print_r(sqlsrv_errors(), true));
}

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
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Peraturan</a></li>
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Kelola Sanksi</a></li>
                    </ol>
                </div>

                <!-- Status Message -->
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?php echo ($_GET['status'] == 'success' ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
                        <?php
                        if (isset($_GET['msg'])) {
                            echo htmlspecialchars($_GET['msg']);
                        } else {
                            echo ($_GET['status'] == 'success' ? 'Sanksi berhasil diperbarui.' : 'Terjadi kesalahan.');
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Status Message Delete -->
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?php echo ($_GET['status'] == 'deleted' ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
                        <?php
                        // Menampilkan pesan yang lebih spesifik berdasarkan status
                        if (isset($_GET['msg'])) {
                            echo htmlspecialchars($_GET['msg']);
                        } else {
                            echo ($_GET['status'] == 'deleted' ? 'Sanksi berhasil dihapus.' : 'Terjadi kesalahan saat menghapus sanksi.');
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Status Message Tambah -->
                <?php if (isset($_GET['status'])): ?>
                    <div class="alert alert-<?php echo ($_GET['status'] == 'success' ? 'success' : 'danger'); ?> alert-dismissible fade show" role="alert">
                        <?php
                        if (isset($_GET['msg'])) {
                            echo htmlspecialchars($_GET['msg']);
                        } else {
                            echo ($_GET['status'] == 'success' ? 'Sanksi berhasil ditambahkan.' : 'Terjadi kesalahan.');
                        }
                        ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <!-- Kelola Sanksi Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Kelola Sanksi</h4>
                            </div>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <!-- Search Form -->
                                    <form action="kelola_sanksi.php" method="get" class="d-flex align-items-center w-50">
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control rounded-start"
                                                name="search"
                                                value="<?php echo htmlspecialchars($search); ?>"
                                                placeholder="Cari sanksi..."
                                                aria-label="Cari sanksi" />
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                    <!-- Tambah Sanksi Button -->
                                    <button class="btn btn-md btn-success ms-3" data-bs-toggle="modal" data-bs-target="#tambahModal">+ Tambah Sanksi</button>
                                </div>

                                <!-- Table for Sanksi -->
                                <!-- Tabel Sanksi -->
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Sanksi</th>
                                                <th>Tingkat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $startFrom + 1;
                                            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['NamaSanksi']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['Tingkat']); ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- Tombol Edit -->
                                                            <button class="btn btn-warning btn-sm me-2 rounded-pill"
                                                                data-bs-toggle="modal" data-bs-target="#editModal"
                                                                data-id="<?php echo urlencode($row['SanksiID']); ?>"
                                                                data-nama="<?php echo htmlspecialchars($row['NamaSanksi']); ?>"
                                                                data-tingkat="<?php echo htmlspecialchars($row['Tingkat']); ?>"
                                                                aria-label="Edit Sanksi <?php echo htmlspecialchars($row['NamaSanksi']); ?>">
                                                                <i class="fa fa-pencil-alt me-2"></i> Edit
                                                            </button>

                                                            <!-- Tombol Hapus -->
                                                            <button class="btn btn-danger btn-sm rounded-pill"
                                                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                                                data-id="<?php echo urlencode($row['SanksiID']); ?>"
                                                                data-nama="<?php echo htmlspecialchars($row['NamaSanksi']); ?>"
                                                                aria-label="Hapus Sanksi <?php echo htmlspecialchars($row['NamaSanksi']); ?>">
                                                                <i class="fa fa-trash me-2"></i> Hapus
                                                            </button>
                                                        </div>
                                                    </td>
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
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>">
                                                <i class="la la-angle-left"></i>
                                            </a>
                                        </li>

                                        <!-- Current Page Number -->
                                        <li class="page-item active">
                                            <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
                                        </li>

                                        <!-- Next Page Button (disabled if on the last page) -->
                                        <li class="page-item <?php echo ($page >= $totalPages) ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page + 1; ?>">
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

            <?php include("footer.php"); ?>
        </div>

        <!-- Modal Edit Sanksi -->
        <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Edit Sanksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../../process/admin/process_edit_sanksi.php" method="POST">
                            <input type="hidden" name="SanksiID" id="editSanksiID">
                            <div class="form-group mb-3">
                                <label for="editNamaSanksi">Nama Sanksi</label>
                                <textarea name="NamaSanksi" id="editNamaSanksi" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group mb-3">
                                <label for="editTingkat">Tingkat</label>
                                <select name="TingkatID" id="editTingkat" class="form-control" required>
                                    <option value="">Pilih Tingkat</option>
                                    <?php
                                    // Ambil data tingkat pelanggaran
                                    $queryTingkat = "SELECT * FROM TingkatPelanggaran";
                                    $resultTingkat = sqlsrv_query($conn, $queryTingkat);

                                    if ($resultTingkat === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    while ($tingkat = sqlsrv_fetch_array($resultTingkat, SQLSRV_FETCH_ASSOC)) {
                                        echo "<option value='" . $tingkat['TingkatID'] . "'>" . $tingkat['Tingkat'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Update Sanksi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Hapus Sanksi -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">Hapus Sanksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="text-center">Apakah Anda yakin ingin menghapus sanksi ini?</p>
                        <form action="../../process/admin/process_hapus_sanksi.php" method="POST">
                            <input type="hidden" name="SanksiID" id="deleteSanksiID">
                            <div class="text-center">
                                <button type="submit" class="btn btn-danger">Hapus Sanksi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Tambah Sanksi -->
        <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Sanksi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="../../process/admin/process_tambah_sanksi.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="NamaSanksi">Nama Sanksi</label>
                                <input type="text" name="NamaSanksi" id="NamaSanksi" class="form-control" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="TingkatID">Tingkat</label>
                                <select name="TingkatID" id="TingkatID" class="form-control" required>
                                    <option value="">Pilih Tingkat</option>
                                    <?php
                                    // Ambil data tingkat pelanggaran
                                    $queryTingkat = "SELECT * FROM TingkatPelanggaran";
                                    $resultTingkat = sqlsrv_query($conn, $queryTingkat);

                                    if ($resultTingkat === false) {
                                        die(print_r(sqlsrv_errors(), true));
                                    }

                                    while ($tingkat = sqlsrv_fetch_array($resultTingkat, SQLSRV_FETCH_ASSOC)) {
                                        echo "<option value='" . $tingkat['TingkatID'] . "'>" . $tingkat['Tingkat'] . "</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-success">Tambah Sanksi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



        <script>
            // Memasukkan data ke dalam modal saat edit
            $('#editModal').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var id = button.data('id');
                var nama = button.data('nama');
                var tingkat = button.data('tingkat');

                $('#editSanksiID').val(id);
                $('#editNamaSanksi').val(nama);
                $('#editTingkat').val(tingkat);
            });

            // Memasukkan data ke dalam modal saat hapus
            $('#deleteModal').on('show.bs.modal', function(e) {
                var button = $(e.relatedTarget);
                var id = button.data('id');
                $('#deleteSanksiID').val(id);
            });
        </script>
</body>

</html>