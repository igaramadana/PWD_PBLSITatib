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
                            <form action="simpan_pelanggaran.php" method="post" enctype="multipart/form-data">
                                
                                <div class="mb-3">
                                    <label for="nim" class="form-label">NIM</label>
                                    <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan NIM" required>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama" required>
                                </div>

                                <!-- Dropdown Kelas -->
                                <div class="mb-3">
                                    <label for="kelas" class="form-label">Kelas</label>
                                    <select class="form-control" id="kelas" name="kelas" required>
                                        <option value="">-- Pilih Kelas --</option>
                                        <option value="A">Kelas A</option>
                                        <option value="B">Kelas B</option>
                                        <option value="C">Kelas C</option>
                                        <option value="D">Kelas D</option>
                                    </select>
                                </div>

                                <!-- Dropdown Program Studi -->
                                <div class="mb-3">
                                    <label for="prodi" class="form-label">Program Studi</label>
                                    <select class="form-control" id="prodi" name="prodi" required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        <option value="D4 Teknik Informatika">D4 Teknik Informatika</option>
                                        <option value="D4 Sistem Informasi Bisnis">D4 Sistem Informasi Bisnis</option>
                                        <option value="D2 Pengembangan Piranti Lunak Situs">D2 Pengembangan Piranti Lunak Situs</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_pelanggaran" class="form-label">Jenis Pelanggaran</label>
                                    <select class="form-control" id="jenis_pelanggaran" name="jenis_pelanggaran" required onchange="toggleLainnya(this.value)">
                                        <option value="">-- Pilih Jenis Pelanggaran --</option>
                                        <option value="Plagiasi">Plagiasi</option>
                                        <option value="Tidak Masuk Kuliah">Telat Masuk Kelas</option>
                                        <option value="Perilaku Tidak Sopan">Merokok di Area Gedung</option>
                                        <option value="Lainnya">Lainnya</option>
                                    </select>
                                </div>
                                
                                <div class="mb-3" id="lainnya-container" style="display: none;">
                                    <label for="lainnya" class="form-label">Jenis Pelanggaran (Lainnya)</label>
                                    <input type="text" class="form-control" id="lainnya" name="lainnya" placeholder="Masukkan Jenis Pelanggaran Lainnya">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Pelanggaran</label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi pelanggaran" required></textarea>
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
    function toggleLainnya(value) {
        const lainnyaContainer = document.getElementById('lainnya-container');
        if (value === 'Lainnya') {
            lainnyaContainer.style.display = 'block';
            document.getElementById('lainnya').setAttribute('required', 'required');
        } else {
            lainnyaContainer.style.display = 'none';
            document.getElementById('lainnya').removeAttribute('required');
        }
    }
</script>

</body>
