<?php
include('../../config/database.php');  // Pastikan koneksi DB sudah benar


// Variabel untuk pencarian dan status
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Query dasar
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran, m.FotoProfil,
          pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsID
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE 1=1";

// Filter berdasarkan pencarian
if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

// Filter berdasarkan status
if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

$query .= " ORDER BY pp.TanggalPengaduan DESC";  // Sorting berdasarkan tanggal pengaduan

// Persiapkan parameter
$params = [];
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
    $pelanggaranList[] = $row;
}

sqlsrv_free_stmt($stmt);  // Membersihkan statement setelah digunakan
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
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Pelanggaran</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Pelanggaran</a></li>
                </ol>
            </div>

            <!-- Rekap Pelanggaran Section -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Rekap Pelanggaran Mahasiswa</h4>
                        </div>
                        <div class="card-body">

                            <!-- Search and Sort Buttons -->
                            <div class="row mb-3">
                                <!-- Search Form -->
                                <div class="col-md-6">
                                    <form action="rekap_pelanggaran.php" method="get" class="d-flex">
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
                                    <form action="rekap_pelanggaran.php" method="get">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group w-50">
                                                <!-- Dropdown untuk sort by status -->
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
                                            <th class="text-center">Foto Profil</th>
                                            <th class="text-center">NIM</th>
                                            <th class="text-center">Nama Mahasiswa</th>
                                            <th class="text-center">Nama Pelanggaran</th>
                                            <th class="text-center">Deskripsi Pelanggaran</th>
                                            <th class="text-center">Tanggal Pelanggaran</th>
                                            <th class="text-center">Bukti Pelanggaran</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (!empty($pelanggaranList)) : ?>
                                            <?php
                                            $no = 1;
                                            foreach ($pelanggaranList as $pelanggaran) : ?>
                                                <tr>
                                                    <!-- Nomor urut -->
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <!-- Foto profil mahasiswa (sesuaikan dengan lokasi gambar) -->
                                                    <?php
                                                    $fotoProfil = $pelanggaran['FotoProfil'] ? '../../assets/uploads/' . $pelanggaran['FotoProfil'] : '../../assets/uploads/profile.svg'; // Default jika tidak ada foto
                                                    ?>
                                                    <td class='text-center'>
                                                        <img src='<?php echo htmlspecialchars($fotoProfil); ?>' alt='Foto Profil' class='rounded-circle' width='50' height='50' style='object-fit: cover;'>
                                                    </td>

                                                    <!-- NIM mahasiswa -->
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NIM']); ?></td>
                                                    <!-- Nama mahasiswa -->
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Nama']); ?></td>
                                                    <td class="text-start"><?php echo htmlspecialchars($pelanggaran['NamaPelanggaran']); ?></td>
                                                    <!-- Deskripsi pelanggaran -->
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Catatan']); ?></td>
                                                    <!-- Tanggal Pelanggaran -->
                                                    <td class="text-center">
                                                        <?php
                                                        var_dump($pelanggaran['TanggalPengaduan']);  // Debugging
                                                        if ($pelanggaran['TanggalPengaduan'] != NULL) {
                                                            echo date('d F Y', strtotime($pelanggaran['TanggalPengaduan']));
                                                        } else {
                                                            echo 'Tidak ada tanggal';
                                                        }
                                                        ?>
                                                    </td>

                                                    <!-- Bukti pelanggaran -->
                                                    <?php
                                                    $buktiPelanggaran = $pelanggaran['BuktiPelanggaran'] ? "../../assets/uploads/" . $pelanggaran['BuktiPelanggaran'] : '../../assets/uploads/no-image.png';
                                                    ?>
                                                    <td class='text-center'>
                                                        <img src='<?php echo htmlspecialchars($buktiPelanggaran); ?>' alt='Bukti Pelanggaran' class='rounded-circle' width='50' height='50' style='object-fit: cover;'>
                                                    </td>
                                                    <!-- Status pelanggaran -->
                                                    <td class="text-center">
                                                        <form action="../../process/admin/update_status.php" method="post">
                                                            <input type="hidden" name="pelanggaran_id" value="<?php echo $pelanggaran['PelanggaranID']; ?>">
                                                            <select name="status" class="form-control" onchange="this.form.submit()">
                                                                <option value="Diajukan" <?php echo ($pelanggaran['StatusPelanggaran'] == 'Diajukan') ? 'selected' : ''; ?>>Diajukan</option>
                                                                <option value="Diproses" <?php echo ($pelanggaran['StatusPelanggaran'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                                <option value="Selesai" <?php echo ($pelanggaran['StatusPelanggaran'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                                            </select>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else : ?>
                                            <!-- Jika data kosong -->
                                            <tr>
                                                <td colspan="6" class="text-center">Tidak ada data pelanggaran yang ditemukan.</td>
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