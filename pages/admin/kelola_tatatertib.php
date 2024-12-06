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
                                    <form action="kelola_pelanggaran.php" method="get" class="d-flex align-items-center">
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
                                                                onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggaran ini?')"
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

    <!-- Modal Edit Pelanggaran -->
    <div class="modal fade" id="editModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center fs-3">Edit Pelanggaran</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../process/admin/process_edit_pelanggaran.php" method="POST">
                        <input type="hidden" name="PelanggaranID" id="editPelanggaranID">
                        <div class="form-group text-start fs-4 mb-3">
                            <label for="editNamaPelanggaran" class="text-start">Nama Pelanggaran</label>
                            <textarea name="NamaPelanggaran" id="editNamaPelanggaran" class="form-control fs-4"></textarea>
                        </div>
                        <div class="form-group text-start fs-4">
                            <label for="editTingkat" class="text-start">Tingkat</label>
                            <select name="TingkatID" id="editTingkat" class="default-select form-control wide mb-3 fs-4" required>
                                <option value="">Pilih Tingkat</option>
                                <?php
                                // Mengambil daftar tingkat pelanggaran
                                $sqlTingkat = "SELECT * FROM TingkatPelanggaran";
                                $stmtTingkat = sqlsrv_query($conn, $sqlTingkat);
                                while ($tingkat = sqlsrv_fetch_array($stmtTingkat, SQLSRV_FETCH_ASSOC)) {
                                    echo "<option value='" . $tingkat['TingkatID'] . "'>" . $tingkat['Tingkat'] . "</option>";
                                }
                                ?>
                            </select>
                            <!-- Tombol Simpan Perubahan -->
                            <button type="submit" class="btn btn-success fs-5">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Tambah Pelanggaran -->
    <div class="modal fade" id="tambahModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center fs-3">Tambah Data Pelanggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../process/admin/process_tambah_pelanggaran.php" method="POST">
                        <!-- Nama Pelanggaran -->
                        <div class="form-group fs-4 mb-4">
                            <label for="NamaPelanggaran" class="mb-2 d-block text-start">Nama Pelanggaran</label>
                            <textarea name="NamaPelanggaran" id="NamaPelanggaran" class="form-control fs-4" rows="3" placeholder="Masukkan nama pelanggaran" required></textarea>
                        </div>

                        <!-- Tingkat -->
                        <div class="form-group fs-4 mb-4">
                            <label for="Tingkat" class="mb-2 d-block text-start">Tingkat</label>
                            <select name="TingkatID" id="Tingkat" class="form-select fs-4" required>
                                <option value="" disabled selected>Pilih Tingkat</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                            </select>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-left">
                            <button type="submit" class="btn btn-success fs-5">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Modal Konfirmasi Hapus Pelanggaran -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">

                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus data pelanggaran "<strong id="deleteNamaPelanggaran"></strong>"?
                </div>
                <div class="modal-footer">
                    <!-- Tombol Batal -->
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <!-- Tombol Hapus -->
                    <a href="../../process/admin/process_hapus_pelanggaran.php?id=<?php echo $row['PelanggaranID']; ?>" id="deleteLink" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
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

        // Jika modal ditutup dengan cara lain (misalnya klik di luar modal atau tekan Esc)
        $('#editModal').on('hidden.bs.modal', function() {
            // Tidak perlu ada aksi tambahan karena modal sudah tertutup
        });

        // Menangani pengambilan data ID pelanggaran untuk modal hapus
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang memicu modal
            var pelanggaranID = button.data('id');
            var namaPelanggaran = button.data('nama');

            // Memasukkan data ke dalam modal
            var modal = $(this);
            modal.find('#deleteNamaPelanggaran').text(namaPelanggaran);

            // Mengarahkan link Hapus ke URL yang benar dengan ID yang sesuai
            modal.find('#deleteLink').attr('href', '../../process/admin/process_hapus_pelanggaran.php?id=' + pelanggaranID);
        });
    </script>

</body>

</html>

<?php
// Menutup koneksi
sqlsrv_close($conn);
?>