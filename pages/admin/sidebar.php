<!--**********************************
    Sidebar Start
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

            <!-- Manajemen Pengguna Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Manajemen User</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="daftar_dosen.php">Daftar Dosen</a></li>
                    <li><a href="daftar_mahasiswa.php">Daftar Mahasiswa</a></li>
                </ul>
            </li>

            <!-- Peraturan dan Tata Tertib -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-bookmark-fill"></i>
                    <span class="nav-text">Peraturan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="kelola_tatatertib.php">Kelola Tata Tertib</a></li>
                    <li><a href="kelola_sanksi.php">Kelola Sanksi</a></li>
                </ul>
            </li>

            <!-- Pelanggaran Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-exclamation-circle-fill"></i>
                    <span class="nav-text">Pelanggaran</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="input_pelanggaran.php">Input Pelanggaran</a></li>
                    <li><a href="rekap_pelanggaran.php">Rekap Pelanggaran</a></li>
                </ul>
            </li>

            <!-- Laporan Menu -->
            <li>
                <a class="" href="laporan.php" aria-expanded="false">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span class="nav-text">Laporan</span>
                </a>
            </li>

            <!-- Pengaturan Sistem Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-gear-fill"></i>
                    <span class="nav-text">Pengaturan Sistem</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="pengaturan_role.php">Pengaturan Role</a></li>
                    <li><a href="backup_restore.php">Backup & Restore</a></li>
                </ul>
            </li>

            <!-- Profile Menu -->
            <li>
                <a class="" href="profile_admin.php" aria-expanded="false">
                    <i class="bi bi-person-circle"></i>
                    <span class="nav-text">Profile</span>
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
    document.getElementById('logoutBtn').addEventListener('click', function () {
        const confirmLogout = confirm('Apakah Anda yakin ingin keluar dari aplikasi?');
        if (confirmLogout) {
            window.location.href = '../login.php'; // Ubah URL ke halaman logout sesuai kebutuhan
        }
    });
</script>
<!--**********************************
    Sidebar End
***********************************-->
