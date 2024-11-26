<body>

    <!--******************* Preloader start ********************-->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>
    <!--******************* Preloader end ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!-- Sidebar -->
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Peraturan</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Tata Tertib Mahasiswa</a></li>
                    </ol>
                </div>
                <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Tata Tertib Mahasiswa</h3>
                        </div>
                        <div class="card-body">
                            <h4 class="card-title">Tingkat Pelanggaran Tata Tertib beserta Klasifikasinya</h4>
                            <p class="card-text">Untuk mendorong agar mahasiswa menjaga ketertiban dan kedisiplinan di lingkungan kampus diperlukan tata tertib kehidupan kampus.</p>
                            <hr>
                            <h4 class="card-title">Tingkat Pelanggaran</h4>
                            <p class="card-text">Adapun tingkat pelanggaran ditentukan sebagai berikut:</p>
                            <ul>
                                <li>1. Tingkat I, yaitu pelanggaran sangat berat</li>
                                <li>2. Tingkat II, yaitu pelanggaran berat</li>
                                <li>3. Tingkat III, yaitu pelanggaran cukup berat</li>
                                <li>4. Tingkat IV, yaitu pelanggaran sedang</li>
                                <li>5. Tingkat V, yaitu pelanggaran ringan</li>
                            </ul>
                            <hr>
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title">Daftar Pelanggaran dan Tingkatannya</h4>
                                        <button type="button" class="btn btn-rounded btn-success ml-auto">
                                            <span class="btn-icon-start text-success">
                                                <i class="fa fa-plus color-info"></i>
                                            </span>Add
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-responsive-md">
                                                <thead class="bg-secondary">
                                                    <tr>
                                                        <th>No</th>
                                                        <th>Nama Pelanggaran</th>
                                                        <th>Tingkat Pelanggaran</th>
                                                        <th class="text-center">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>1</td>
                                                        <td>Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertuliskepada mahasiswa, dosen, karyawan, atau orang lain</td>
                                                        <td class="text-center">V</td>
                                                        <td class="text-center">
                                                            <div class="d-flex align-items-center">
                                                                <a href="#" class="btn btn-primary shadow btn-sm sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                                <a href="#" class="btn btn-danger shadow btn-sm sharp"><i class="fa fa-trash"></i></a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title">Daftar Pelanggaran dan Tingkatannya</h4>
                            <div class="table-responsive border border-light">
                                <table class="table table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggaran</th>
                                            <th>Tingkat Pelanggaran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!-- Example row -->
                                        <tr>
                                            <th>1</th>
                                            <td>Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertuliskepada mahasiswa, dosen, karyawan, atau orang lain</td>
                                            <td class="text-center">V</td>
                                            <td class="text-center">
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah: berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak berkerah), tank top, hipster, you can see, rok mini, backless, celanapendek, celana tiga per empat, legging, model celana atau baju koyak, sandal, sepatu sandal di lingkungan kampus</td>
                                            <td class="text-center">IV</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="#" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="#" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')"><i class="fa fa-trash"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Add more rows here -->
                                    </tbody>
                                </table>
                            </div>
                            <a href="create.php" class="btn btn-success">Tambah Tata Tertib</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!--**********************************
        Content body end
        ***********************************-->

        <?php include("footer.php"); ?>

    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
</body>

</html>