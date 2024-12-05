<?php
include "../../config/database.php";
$perPage = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$startFrom = ($page - 1) * $perPage;

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

                <!-- Kelola Sanksi Section -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h4 class="card-title">Kelola Sanksi</h4>
                            </div>
                            <div class="card-body">
                                <!-- Search Form -->
                                <form action="kelola_sanksi.php" method="get" class="d-flex justify-content-between align-items-center mb-3">
                                    <div class="search-area w-50">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Cari disini...">
                                            <span class="input-group-text">
                                                <button type="submit" class="btn btn-link"><i class="flaticon-381-search-2"></i></button>
                                            </span>
                                        </div>
                                    </div>
                                </form>
                                <div>
                                    <button class="btn btn-md btn-success mb-3" data-bs-toggle="modal" data-bs-target="#tambahModal">+ Tambah Sanksi</button>
                                </div>

                                <!-- Table for Sanksi -->
                                <div class="table-responsive">
                                    <table class="table table-striped table-responsive-md">
                                        <thead class="bg-primary text-white">
                                            <tr>
                                                <th class="text-center">No.</th>
                                                <th class="text-center">Nama Sanksi</th>
                                                <th class="text-center">Tingkat</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            // Ambil data sanksi dari database
                                            $query = "SELECT Sanksi.SanksiID, Sanksi.NamaSanksi, TingkatPelanggaran.Tingkat
                                                      FROM Sanksi
                                                      JOIN TingkatPelanggaran ON Sanksi.TingkatID = TingkatPelanggaran.TingkatID
                                                      ORDER BY Sanksi.SanksiID
                                                      OFFSET $startFrom ROWS
                                                      FETCH NEXT $perPage ROWS ONLY";

                                            $result = sqlsrv_query($conn, $query);

                                            if ($result === false) {
                                                die(print_r(sqlsrv_errors(), true));
                                            }

                                            $no = $startFrom + 1; // Nomor urut
                                            while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                                echo "<tr>";
                                                echo "<td class='text-center'>" . $no++ . "</td>";
                                                echo "<td>" . htmlspecialchars($row['NamaSanksi']) . "</td>";
                                                echo "<td class='text-center'>" . $row['Tingkat'] . "</td>";
                                                echo "<td class='text-center'>
                        <a href='../../process/admin/process_edit_sanksi.php?id=" . $row['SanksiID'] . "' class='btn btn-primary btn-sm'>Edit</a>
                        <a href='../../process/admin/process_hapus_sanksi.php?id=" . $row['SanksiID'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Yakin ingin menghapus?\")'>Hapus</a>
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

        <?php include("footer.php"); ?>
    </div>

    <!-- Modal tambah sanksi -->
    <div class="modal fade" id="tambahModal" role="dialog">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="Modal-title text-center fs-3">Tambah Sanksi</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../../process/admin/process_tambah_sanksi.php" method="POST">
                        <div class="form-group text-center fs-4 mb-3">
                            <label for="tambahNamaSanksi">Sanksi</label>
                            <textarea name="NamaSanksi" id="tambahNamaSanksi" class="form-control fs-4" required></textarea>
                        </div>
                        <div class="form-group text-center fs-4">
                            <label for="Tingkat">Tingkat</label>
                            <select name="TingkatID" id="Tingkat" class="default-select form-control wide mb-3 fs-4" required>
                                <option value="">Pilih Tingkat</option>
                                <?php
                                // Ambil data tingkat pelanggaran dari database
                                $query = "SELECT * FROM TingkatPelanggaran";
                                $result = sqlsrv_query($conn, $query);

                                if ($result === false) {
                                    die(print_r(sqlsrv_errors(), true));
                                }

                                while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
                                    echo "<option value='" . $row['TingkatID'] . "'>" . $row['Tingkat'] . "</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-success fs-4">Tambah Sanksi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
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
                    <form action="../../process/admin/process_edit_sanksi.php?id=<?php echo $sanksiID; ?>" method="POST">
                        <div class="form-group mb-3">
                            <label for="NamaSanksi">Nama Sanksi</label>
                            <textarea name="NamaSanksi" id="NamaSanksi" class="form-control" rows="3" required><?php echo htmlspecialchars($sanksi['NamaSanksi']); ?></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Tingkat">Tingkat</label>
                            <select name="TingkatID" id="Tingkat" class="form-control" required>
                                <option value="">Pilih Tingkat</option>
                                <?php while ($row = sqlsrv_fetch_array($resultTingkat, SQLSRV_FETCH_ASSOC)) { ?>
                                    <option value="<?php echo $row['TingkatID']; ?>" <?php echo $sanksi['TingkatID'] == $row['TingkatID'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($row['Tingkat']); ?>
                                    </option>
                                <?php } ?>
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

</body>

</html>