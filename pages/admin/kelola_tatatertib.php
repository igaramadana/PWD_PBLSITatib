<?php
include "../../config/database.php";

$perPage = 10; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Halaman yang diminta
$startFrom = ($page - 1) * $perPage; // Menentukan data yang akan diambil

// Menangani pencarian (jika ada)
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Query untuk mengambil data pelanggaran dengan pencarian dan pagination
$sql = "SELECT Pelanggaran.PelanggaranID, Pelanggaran.NamaPelanggaran, TingkatPelanggaran.Tingkat 
        FROM Pelanggaran
        JOIN TingkatPelanggaran ON Pelanggaran.TingkatID = TingkatPelanggaran.TingkatID
        WHERE Pelanggaran.NamaPelanggaran LIKE ?
        ORDER BY Pelanggaran.PelanggaranID
        OFFSET ? ROWS FETCH NEXT ? ROWS ONLY";

// Menyiapkan parameter pencarian
$searchParam = "%" . $search . "%";

// Menyiapkan statement dan eksekusi query
$params = array($searchParam, $startFrom, $perPage);
$stmt = sqlsrv_query($conn, $sql, $params);
?>

<body>
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
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Kelola Tata Tertib</a></li>
                    </ol>
                </div>

                <!-- Kelola Tata Tertib Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Kelola Pelanggaran</h4>
                            </div>
                            <div class="card-body">
                                <!-- Form Pencarian dan Tombol Tambah Data -->
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <!-- Form Pencarian -->
                                    <form action="kelola_tatatertib.php" method="get" class="d-flex align-items-center">
                                        <div class="input-group" style="width: 300px;">
                                            <input type="text" class="form-control rounded-start" name="search"
                                                value="<?php echo htmlspecialchars($search); ?>"
                                                placeholder="Cari nama pelanggaran..."
                                                aria-label="Cari nama pelanggaran">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="flaticon-381-search-2"></i>
                                            </button>
                                        </div>
                                    </form>

                                    <!-- Tombol Tambah Data -->
                                    <button class="btn btn-md btn-success" data-bs-toggle="modal" data-bs-target="#tambahModal">
                                        + Tambah Data
                                    </button>
                                </div>

                                <!-- Tabel Pelanggaran -->
                                <div class="table-responsive">
                                    <table class="table table-bordered text-center">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th>No.</th>
                                                <th>Nama Pelanggaran</th>
                                                <th>Tingkat</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $no = $startFrom + 1;
                                            while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) : ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo htmlspecialchars($row['NamaPelanggaran']); ?></td>
                                                    <td><?php echo htmlspecialchars($row['Tingkat']); ?></td>
                                                    <td>
                                                        <div class="d-flex justify-content-center">
                                                            <!-- Tombol Edit -->
                                                            <a href="#editModal"
                                                                class="btn btn-warning btn-sm me-2 rounded-pill d-flex align-items-center justify-content-center"
                                                                data-toggle="modal"
                                                                data-id="<?php echo urlencode($row['PelanggaranID']); ?>"
                                                                data-nama="<?php echo htmlspecialchars($row['NamaPelanggaran']); ?>"
                                                                data-tingkat="<?php echo htmlspecialchars($row['Tingkat']); ?>"
                                                                aria-label="Edit Pelanggaran <?php echo htmlspecialchars($row['NamaPelanggaran']); ?>">
                                                                <i class="fa fa-pencil-alt me-2"></i> Edit
                                                            </a>

                                                            <!-- Tombol Hapus -->
                                                            <a href="#deleteModal"
                                                                class="btn btn-danger btn-sm rounded-pill d-flex align-items-center justify-content-center"
                                                                data-toggle="modal"
                                                                data-id="<?php echo urlencode($row['PelanggaranID']); ?>"
                                                                data-nama="<?php echo htmlspecialchars($row['NamaPelanggaran']); ?>"
                                                                aria-label="Hapus Pelanggaran <?php echo htmlspecialchars($row['NamaPelanggaran']); ?>">
                                                                <i class="fa fa-trash me-2"></i> Hapus
                                                            </a>
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
                                        <?php
                                        // Query untuk menghitung total data pelanggaran
                                        $sqlCount = "SELECT COUNT(*) AS total FROM Pelanggaran WHERE NamaPelanggaran LIKE ?";
                                        $stmtCount = sqlsrv_query($conn, $sqlCount, array($searchParam));
                                        $rowCount = sqlsrv_fetch_array($stmtCount, SQLSRV_FETCH_ASSOC);
                                        $totalPages = ceil($rowCount['total'] / $perPage);
                                        ?>

                                        <!-- Halaman Sebelumnya -->
                                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                                            <a class="page-link" href="?page=<?php echo $page - 1; ?>&search=<?php echo urlencode($search); ?>">
                                                <i class="la la-angle-left"></i>
                                            </a>
                                        </li>

                                        <!-- Halaman 1 sampai Total Halaman -->
                                        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
                                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                                <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                                            </li>
                                        <?php endfor; ?>

                                        <!-- Halaman Berikutnya -->
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
    </div>

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mengambil data dari tombol Edit dan memasukkannya ke dalam modal
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var pelanggaranID = button.data('id');
            var namaPelanggaran = button.data('nama');
            var tingkat = button.data('tingkat');

            // Memasukkan data ke dalam modal
            var modal = $(this);
            modal.find('#editPelanggaranID').val(pelanggaranID);
            modal.find('#editNamaPelanggaran').val(namaPelanggaran);
            modal.find('#editTingkat').val(tingkat);
        });

        // Menangani pengambilan data ID pelanggaran untuk modal hapus
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var pelanggaranID = button.data('id');
            var namaPelanggaran = button.data('nama');

            // Memasukkan data ke dalam modal
            var modal = $(this);
            modal.find('#deletePelanggaranID').val(pelanggaranID);
            modal.find('#deleteNamaPelanggaran').text(namaPelanggaran);
        });
    </script>
</body>