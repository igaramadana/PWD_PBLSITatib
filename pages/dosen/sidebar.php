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

            <!-- Data Mahasiswa Menu -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-people-fill"></i>
                    <span class="nav-text">Data Mahasiswa</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="daftar_mhs.php">Daftar Mahasiswa</a></li>
                </ul>
            </li>

            <!-- Tata Tertib dan Sanksi -->
            <li>
                <a class="has-arrow" href="javascript:void()" aria-expanded="false">
                    <i class="bi bi-bookmark-fill"></i>
                    <span class="nav-text">Peraturan</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="tatatertib.php">Tata Tertib Mahasiswa</a></li>
                    <li><a href="sanksi.php">Sanksi</a></li>
                    <li><a href="input_pelanggaran.php">Input Pelanggaran</a></li>
                </ul>
            </li>

            <!-- Riwayat Pelanggaran Menu -->
            <li>
                <a class="" href="riwayat_pengaduan.php" aria-expanded="false">
                    <i class="bi bi-file-earmark-bar-graph-fill"></i>
                    <span class="nav-text">Riwayat Pengaduan</span>
                </a>
            </li>

            <!-- Profile Menu -->
            <li>
                <a class="" href="profile_dosen.php" aria-expanded="false">
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
    Sidebar end
***********************************-->
