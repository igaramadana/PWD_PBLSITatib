<?php
include "../../config/database.php";
include "../../process/mahasiswa/fungsi_tampil_profile.php";

session_start();
if (!isset($_SESSION['MhsID'])) {
    header("Location: ../login.php");
}

$UserID = $_SESSION['MhsID'];

// Filter dan query untuk mengambil pelanggaran terbaru
$query = "SELECT TOP 5 p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran,
          p.NamaPelanggaran, pp.TanggalPengaduan, p.TingkatID, pp.BuktiPelanggaran
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsId
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.MhsID = ?";  // Filter berdasarkan MhsID yang login

if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

$query .= " ORDER BY pp.TanggalPengaduan DESC";  // Urutkan berdasarkan tanggal pelanggaran terbaru

$params = [$UserID];  // Menambahkan MhsID dari session untuk filter
if (!empty($search)) {
    $params[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $params[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $params[] = $statusFilter;  // Filter status pelanggaran
}

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
                                <!-- Search Form -->
                                <div class="col-md-6">
                                    <form action="riwayat_pelanggaran.php" method="get" class="d-flex">
                                        <div class="input-group">
                                            <!-- Input pencarian berdasarkan keyword -->
                                            <input type="text" class="form-control" name="search"
                                                value="<?php echo htmlspecialchars($search ?? ''); ?>"
                                                placeholder="Cari disini...">
                                            <!-- Tombol submit pencarian -->
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                <!-- Sort by Status -->
                                <div class="col-md-6 text-end">
                                    <form action="riwayat_pelanggaran.php" method="get">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group w-50">
                                                <!-- Dropdown untuk sort -->
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Scripts -->
        <?php include("footer.php"); ?>

    </div>
</div>