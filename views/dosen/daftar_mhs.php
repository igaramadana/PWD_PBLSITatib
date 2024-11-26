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
            <div class="container-fluid">
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Data Mahasiswa</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Daftar Mahasiswa</a></li>
                    </ol>
                </div>
                <!-- Section: Riwayat Pelanggaran Mahasiswa -->
                <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-beetween align-items-center">
                            <h4 class="card-title">Daftar Mahasiswa</h4>
                            <!-- Form Searching -->
                            <form class="d-flex" action="" method="GET">
                                <input type="text" name="search" class="form-control form-control-sm me-2" placeholder="Cari mahasiswa..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Search</button>
                            </form>
                        </div>
                        <!-- Filter -->
                        <div class="card-body align-items-center">
                            <div class="mb-3">
                                <form action="" method="GET" class="row">
                                    <div class="col-md-3">
                                        <label for="jurusan" class="form-label">Filter Jurusan</label>
                                        <select class="form-control form-control-sm" name="jurusan" id="jurusan">
                                            <option value="">Semua Jurusan</option>
                                            <option value="TI">Teknologi Informasi</option>
                                            <option value="SI">Teknik Elektro</option>
                                            <option value="TK">Teknik Sipil</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="prodi" class="form-label">Filter Prodi</label>
                                        <select class="form-control form-control-sm" name="prodi" id="prodi">
                                            <option value="">Semua Prodi</option>
                                            <option value="DIV-SIB">DIV-Sistem Informasi Bisnis</option>
                                            <option value="DIII-TI">DIV-Teknik Informatika</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="angkatan" class="form-label">Filter Angkatan</label>
                                        <select class="form-control form-control-sm" name="angkatan" id="angkatan">
                                            <option value="">Semua Angkatan</option>
                                            <option value="2023">2023</option>
                                            <option value="2022">2022</option>
                                            <option value="2021">2021</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 d-flex justify-content-center">
                                        <div class="w-100 text-end align-self-end">
                                            <button type="submit" class="btn btn-success btn-md me-2">Apply Filter</button>
                                            <a href="daftar_mahasiswa.php" class="btn btn-secondary btn-md btn-danger">Reset</a>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <!-- Table -->
                            <div class="table-responsive recentOrderTable">
                                <table class="table verticle-middle table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">NIM</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Jenis Kelamin</th>
                                            <th scope="col">Jurusan</th>
                                            <th scope="col">Prodi</th>
                                            <th scope="col">Angkatan</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2341760083</td>
                                            <td>Iga Ramadana S.</td>
                                            <td>Laki-laki</td>
                                            <td>Teknologi Informasi</td>
                                            <td>DIV-Sistem Informasi Bisnis</td>
                                            <td>2023</td>
                                            <td>
                                                <div class="dropdown custom-dropdown mb-0">
                                                    <div class="btn sharp btn-primary tp-btn" data-bs-toggle="dropdown">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <circle fill="#000000" cx="12" cy="5" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="19" r="2"></circle>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript:void();">Details</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void();">Cancel</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Tambahkan data mahasiswa lainnya di sini -->
                                        <tr>
                                            <td>2</td>
                                            <td>2341760083</td>
                                            <td>Iga Ramadana S.</td>
                                            <td>Laki-laki</td>
                                            <td>Teknologi Informasi</td>
                                            <td>DIV-Sistem Informasi Bisnis</td>
                                            <td>2023</td>
                                            <td>
                                                <div class="dropdown custom-dropdown mb-0">
                                                    <div class="btn sharp btn-primary tp-btn" data-bs-toggle="dropdown">
                                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewbox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <rect x="0" y="0" width="24" height="24"></rect>
                                                                <circle fill="#000000" cx="12" cy="5" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="12" r="2"></circle>
                                                                <circle fill="#000000" cx="12" cy="19" r="2"></circle>
                                                            </g>
                                                        </svg>
                                                    </div>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="javascript:void();">Details</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void();">Cancel</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <nav class="pb-2">
                            <ul class="pagination pagination-gutter justify-content-center">
                                <li class="page-item page-indicator">
                                    <a class="page-link" href="javascript:void(0)">
                                        <i class="la la-angle-left"></i>
                                    </a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="javascript:void(0)">1</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">2</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">3</a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript:void(0)">4</a>
                                </li>
                                <li class="page-item page-indicator">
                                    <a class="page-link" href="javascript:void(0)">
                                        <i class="la la-angle-right"></i>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            <!--**********************************
        Content body end
    ***********************************-->
        </div>

    </div>
    <!--**********************************
           Support ticket button start
        ***********************************-->

    <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    <?php
    include("footer.php");
    ?>


</body>

</html>