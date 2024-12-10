<!--**********************************
    Sidebar start
***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <!-- Dashboard Menu -->
            <li>
                <a class="" href="dashboard.php" aria-expanded="false">
                    <i class="fas fa-home"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Manajemen Tata Tertib Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-file-earmark-text"></i>
                    <span class="nav-text">Manajemen Tata Tertib</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="daftar_tatib.php">Daftar Tata Tertib</a></li>
                    <li><a href="kategori_tatatertib.php">Kategori Tata Tertib</a></li>
                    <li><a href="sanksi_tatatertib.php">Sanksi Pelanggaran</a></li>
                </ul>
            </li>

            <!-- Akses Pengguna Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-person-check"></i>
                    <span class="nav-text">Akses Pengguna</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="akses_mahasiswa.php">Akses Mahasiswa</a></li>
                    <li><a href="akses_dosen.php">Akses Dosen</a></li>
                </ul>
            </li>

            <!-- Pelaporan Pelanggaran Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-flag"></i>
                    <span class="nav-text">Pelaporan Pelanggaran</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="laporan_pelanggaran.php">Laporan Baru</a></li>
                    <li><a href="daftar_laporan.php">Daftar Laporan</a></li>
                </ul>
            </li>

            <!-- Notifikasi dan Pengingat Menu -->
            <li>
                <a class="" href="notifikasi.php" aria-expanded="false">
                    <i class="bi bi-bell-fill"></i>
                    <span class="nav-text">Notifikasi dan Pengingat</span>
                </a>
            </li>

            <!-- Manajemen Sanksi Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-file-earmark-lock"></i>
                    <span class="nav-text">Manajemen Sanksi</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="daftar_sanksi.php">Daftar Sanksi</a></li>
                    <li><a href="tindak_lanjut_sanksi.php">Tindak Lanjut Sanksi</a></li>
                </ul>
            </li>

            <!-- Laporan dan Analisis Menu -->
            <li>
                <a class="" href="laporan_analisis.php" aria-expanded="false">
                    <i class="bi bi-bar-chart-line-fill"></i>
                    <span class="nav-text">Laporan dan Analisis</span>
                </a>
            </li>

            <hr>

            <!-- Logout Button -->
            <li>
                <a href="#" id="logoutBtn" aria-expanded="false">
                    <i class="bi bi-box-arrow-left text-danger"></i>
                    <span class="nav-text text-danger">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</div>
<script>
    document.getElementById('logoutBtn').addEventListener('click', function() {
        const confirmLogout = confirm('Apakah Anda yakin ingin keluar dari aplikasi?');
        if (confirmLogout) {
            window.location.href = '../../../index.php'; // Ubah URL ke halaman logout sesuai kebutuhan
        }
    });
</script>
<!--**********************************
    Sidebar end
***********************************-->
