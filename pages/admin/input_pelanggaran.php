<body>

    <!--*******************
Preloader start
********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--*******************
Preloader end
********************-->

    <!--**********************************
Main wrapper start
***********************************-->
    <div id="main-wrapper">

        <?php
        include("header.php");
        ?>

        <?php
        include("sidebar.php");
        ?>

        <!--**********************************
    Content body start
    ***********************************-->
        <div class="content-body">
            <!-- row -->
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">Pelanggaran</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="javascript:void(0)">Input Pelanggaran</a>
                        </li>
                    </ol>
                </div>
                <div class="row gy-4">
                    <!-- Form Input Pelanggaran -->
                    <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Input Pelanggaran Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <form action="../../process/fungsi/simpan_pelanggaran.php" method="post" enctype="multipart/form-data">

                                    <div class="mb-3">
                                        <label for="nim" class="form-label">NIM</label>
                                        <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" readonly required>
                                    </div>

                                    <!-- Dropdown Kelas -->
                                    <div class="mb-3">
                                        <label for="kelas" class="form-label">Kelas</label>
                                        <input type="text" class="form-control" id="kelas" name="kelas" placeholder="Masukkan Kelas" readonly required>
                                    </div>

                                    <!-- Dropdown Program Studi -->
                                    <div class="mb-3">
                                        <label for="prodi" class="form-label">Program Studi</label>
                                        <input type="text" class="form-control" id="prodi" name="prodi" placeholder="Masukkan Program Studi" readonly required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                        <select class="form-control" id="jenis_pelanggaran" name="jenis_pelanggaran" required onchange="loadSanksiOptions(this.value)">
                                            <option value="">-- Pilih Jenis Pelanggaran --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sanksi" class="form-label">Sanksi</label>
                                        <select class="form-control" id="sanksi" name="sanksi" required>
                                            <option value="">-- Pilih Sanksi --</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="catatan" class="form-label">Deskripsi Pelanggaran</label>
                                        <textarea class="form-control" id="catatan" name="catatan" rows="4" placeholder="Masukkan deskripsi pelanggaran" required></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tanggal" class="form-label">Tanggal Kejadian</label>
                                        <div class="input-group">
                                            <input type="date" class="form-control" id="tanggal" name="tanggal" required>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="bukti" class="form-label">Upload Bukti Foto</label>
                                        <input type="file" class="form-control" id="bukti" name="bukti" accept="image/*" required>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Simpan Pelanggaran</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--**********************************
    Content body end
    ***********************************-->

    </div>
    <!--**********************************
Main wrapper end
***********************************-->
    <?php
    include("footer.php");
    ?>

    <!-- Script untuk mengatur opsi "Lainnya" -->
    <script>
        // Function untuk autofill data mahasiswa berdasarkan NIM
        document.getElementById('nim').addEventListener('change', function() {
            var nim = this.value;

            // Ambil data mahasiswa berdasarkan NIM
            if (nim) {
                fetch('../../process/fungsi/get_mahasiswa.php?nim=' + nim)
                    .then(response => response.json())
                    .then(data => {
                        if (data) {
                            document.getElementById('nama').value = data.Nama || 'Nama tidak ditemukan';
                            document.getElementById('kelas').value = data.Kelas || 'Kelas tidak ditemukan';
                            document.getElementById('prodi').value = data.Prodi || 'Prodi tidak ditemukan';
                        } else {
                            alert('NIM tidak ditemukan!');
                        }
                    });
            }
        });

        // Function untuk mengambil data jenis pelanggaran dari database
        fetch('../../process/fungsi/get_pelanggaran.php')
            .then(response => response.json())
            .then(data => {
                const pelanggaranSelect = document.getElementById('jenis_pelanggaran');
                data.forEach(item => {
                    const option = document.createElement('option');
                    option.value = item.pelanggaran_id;
                    option.textContent = item.nama_pelanggaran;
                    pelanggaranSelect.appendChild(option);
                });
            });

        // Function untuk mengambil sanksi berdasarkan jenis pelanggaran
        function loadSanksiOptions(pelanggaranId) {
            fetch('../../process/fungsi/get_sanksi.php?pelanggaran_id=' + pelanggaranId)
                .then(response => response.json())
                .then(data => {
                    const sanksiSelect = document.getElementById('sanksi');
                    sanksiSelect.innerHTML = '<option value="">-- Pilih Sanksi --</option>'; // Clear previous options

                    data.forEach(item => {
                        const option = document.createElement('option');
                        option.value = item.sanksi_id;
                        option.textContent = item.nama_sanksi;
                        sanksiSelect.appendChild(option);
                    });
                });
        }
    </script>

</body>