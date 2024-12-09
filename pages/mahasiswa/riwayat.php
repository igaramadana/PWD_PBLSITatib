<?php 
include "../../process/mahasiswa/fungsi_tampil_profile.php"; 
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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Riwayat Pelanggaran</a></li>
                </ol>
            </div>

            <!-- Riwayat Pelanggaran Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Riwayat Pelanggaran Anda</h4>
                        </div>
                        <div class="card-body">

                            <!-- Search Form -->
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <form action="riwayat_pelanggaran.php" method="get" class="d-flex">
                                        <div class="input-group">
                                            <!-- Input pencarian berdasarkan keyword -->
                                            <input type="text" class="form-control" name="search"
                                                value="<?php echo htmlspecialchars($search ?? ''); ?>"
                                                placeholder="Cari berdasarkan deskripsi...">
                                            <!-- Tombol submit pencarian -->
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Sort by Date -->
                                <div class="col-md-6 text-end">
                                    <form action="riwayat_pelanggaran.php" method="get">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group w-50">
                                                <!-- Dropdown untuk sort -->
                                                <select name="sort" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Sort by</option>
                                                    <option value="tanggal_asc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'tanggal_asc') ? 'selected' : ''; ?>>Tanggal: Terlama</option>
                                                    <option value="tanggal_desc" <?php echo (isset($_GET['sort']) && $_GET['sort'] == 'tanggal_desc') ? 'selected' : ''; ?>>Tanggal: Terbaru</option>
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
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Deskripsi Pelanggaran</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Loop untuk menampilkan data pelanggaran -->
                                        <?php if (!empty($pelanggaranList)) : ?>
                                            <?php
                                            $no = 1;
                                            foreach ($pelanggaranList as $pelanggaran) : ?>
                                                <tr>
                                                    <!-- Nomor urut -->
                                                    <td><?php echo $no++; ?></td>
                                                    <!-- Tanggal -->
                                                    <td><?php echo htmlspecialchars($pelanggaran['Tanggal']); ?></td>
                                                    <!-- Deskripsi pelanggaran -->
                                                    <td><?php echo htmlspecialchars($pelanggaran['Deskripsi']); ?></td>
                                                    <!-- Status -->
                                                    <td><?php echo htmlspecialchars($pelanggaran['Status']); ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <!-- Jika data kosong -->
                                            <tr>
                                                <td colspan="4" class="text-center">Tidak ada data pelanggaran yang ditemukan.</td>
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

        <!-- Footer -->
        <?php include("footer.php"); ?>
    </div>
</div>
