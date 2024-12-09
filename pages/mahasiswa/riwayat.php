<<<<<<< HEAD
<?php
require_once '../../config/database.php';
session_start();  // Pastikan session sudah dimulai

// Memastikan mahasiswa sudah login dan MhsID tersedia dalam session
if (!isset($_SESSION['MhsID'])) {
    // Jika MhsID tidak ditemukan dalam session, tampilkan pesan error atau redirect ke halaman login
    echo "Anda harus login terlebih dahulu.";
    // Optional: Redirect ke halaman login
    // header('Location: login.php');
    // exit();
}

// Ambil MhsID dari session
$MhsID = $_SESSION['MhsID']; 
// Variabel untuk pencarian dan status (pastikan input dicuci untuk mencegah SQL injection)
$search = isset($_GET['search']) ? htmlspecialchars($_GET['search']) : '';  // Sanitasi input pencarian
$statusFilter = isset($_GET['status']) ? htmlspecialchars($_GET['status']) : '';  // Sanitasi filter status

// Query dasar untuk menampilkan riwayat pelanggaran mahasiswa berdasarkan MhsID
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran, m.FotoProfil,
          pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsID
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE pp.MhsID = ?";  // Filter berdasarkan MhsID mahasiswa yang login

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
$params = [$MhsID];  // Menambahkan MhsID untuk memastikan hanya data mahasiswa ini yang ditampilkan

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
=======
<?php 
include "../../process/mahasiswa/fungsi_tampil_profile.php"; 
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
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
<<<<<<< HEAD
                    <li class="breadcrumb-item"><a href="javascript:void(0)">Pelanggaran</a></li>
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Rekap Pelanggaran</a></li>
                </ol>
            </div>

            <!-- Rekap Pelanggaran Section -->
=======
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Riwayat Pelanggaran</a></li>
                </ol>
            </div>

            <!-- Riwayat Pelanggaran Section -->
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
<<<<<<< HEAD
                            <h4 class="card-title">Riwayat Pelanggaran Saya</h4>
                        </div>
                        <div class="card-body">

                            <!-- Search and Sort Buttons -->
                            <div class="row mb-3">
                                <!-- Search Form -->
                                <div class="col-md-6">
                                    <form action="rekap_pelanggaran.php" method="get" class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="search"
                                                value="<?php echo htmlspecialchars($search ?? ''); ?>"
                                                placeholder="Cari disini...">
=======
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
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

<<<<<<< HEAD
                                <!-- Sort by Status -->
                                <div class="col-md-6 text-end">
                                    <form action="rekap_pelanggaran.php" method="get">
                                        <div class="d-flex justify-content-end">
                                            <div class="input-group w-50">
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="">Sort by</option>
                                                    <option value="Diajukan" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diajukan') ? 'selected' : ''; ?>>Diajukan</option>
                                                    <option value="Diproses" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Diproses') ? 'selected' : ''; ?>>Diproses</option>
                                                    <option value="Selesai" <?php echo (isset($_GET['status']) && $_GET['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
=======
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
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
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
<<<<<<< HEAD
                                            <th class="text-center">Foto Profil</th>
                                            <th class="text-center">NIM</th>
                                            <th class="text-center">Nama Mahasiswa</th>
                                            <th class="text-center">Nama Pelanggaran</th>
                                            <th class="text-center">Deskripsi Pelanggaran</th>
                                            <th class="text-center">Tanggal Pelanggaran</th>
                                            <th class="text-center">Bukti Pelanggaran</th>
=======
                                            <th class="text-center">Tanggal</th>
                                            <th class="text-center">Deskripsi Pelanggaran</th>
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
<<<<<<< HEAD
=======
                                        <!-- Loop untuk menampilkan data pelanggaran -->
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
                                        <?php if (!empty($pelanggaranList)) : ?>
                                            <?php
                                            $no = 1;
                                            foreach ($pelanggaranList as $pelanggaran) : ?>
                                                <tr>
<<<<<<< HEAD
                                                    <td class="text-center"><?php echo $no++; ?></td>
                                                    <?php
                                                    $fotoProfil = $pelanggaran['FotoProfil'] ? '../../assets/uploads/' . $pelanggaran['FotoProfil'] : '../../assets/uploads/profile.svg';
                                                    ?>
                                                    <td class="text-center">
                                                        <img src='<?php echo htmlspecialchars($fotoProfil); ?>' alt='Foto Profil' class='rounded-circle' width='50' height='50' style='object-fit: cover;'>
                                                    </td>
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['NIM']); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Nama']); ?></td>
                                                    <td class="text-start"><?php echo htmlspecialchars($pelanggaran['NamaPelanggaran']); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($pelanggaran['Catatan']); ?></td>
                                                    <td class="text-center">
                                                        <?php
                                                        // if ($pelanggaran['TanggalPengaduan']) {
                                                        //     echo date('d F Y', strtotime($pelanggaran['TanggalPengaduan']));
                                                        // } else {
                                                        //     echo '-';
                                                        // }
                                                        ?>
                                                    </td>
                                                    <?php
                                                    $buktiPelanggaran = $pelanggaran['BuktiPelanggaran'] ? "../../assets/uploads/" . $pelanggaran['BuktiPelanggaran'] : '../../assets/uploads/no-image.png';
                                                    ?>
                                                    <td class="text-center">
                                                        <img src='<?php echo htmlspecialchars($buktiPelanggaran); ?>' alt='Bukti Pelanggaran' class='rounded-circle' width='50' height='50' style='object-fit: cover;'>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php echo htmlspecialchars($pelanggaran['StatusPelanggaran']); ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <tr>
                                                <td colspan="9" class="text-center">Tidak ada riwayat pelanggaran</td>
=======
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
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
<<<<<<< HEAD

=======
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
                        </div>
                    </div>
                </div>
            </div>
<<<<<<< HEAD

        </div>
    </div>

=======
        </div>

        <!-- Footer -->
        <?php include("footer.php"); ?>
    </div>
>>>>>>> b490799673c0dc9617df25030657daf62cff068d
</div>
