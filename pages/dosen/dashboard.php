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
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Dashboard</a></li>
                </ol>
            </div>
            <div class="row gy-4">
                <!-- Total Pelanggaran -->
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-danger">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <span class="me-3">
                                    <i class="fa-solid fa-graduation-cap fs-3 text-white"></i>
                                </span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 fw-bold">Total Mahasiswa</p>
                                    <h3 class="text-white mb-0">504</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Point Pelanggaran -->
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-success">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <span class="me-3">
                                    <i class="fa-solid fa-clipboard fs-3 text-white"></i>
                                </span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 fw-bold">Input Pelanggaran</p>
                                    <h3 class="text-white mb-0">12</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status Terkini -->
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-info">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <span class="me-3">
                                    <i class="fa-solid fa-check fs-3 text-white"></i>
                                </span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 fw-bold text-white">Selesai</p>
                                    <h3 class="text-white mb-0">2</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sanksi Saat Ini -->
                <div class="col-xl-3 col-lg-6 col-sm-6">
                    <div class="widget-stat card bg-primary">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center">
                                <span class="me-3">
                                    <i class="fa-solid fa-clock fs-3 text-white"></i>
                                </span>
                                <div class="media-body text-white text-end">
                                    <p class="mb-1 fw-bold">Pending</p>
                                    <h3 class="text-white mb-0">4</h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Content Pelanggaran Terkini -->
                <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Input Pelanggaran Terkini</h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive recentOrderTable">
                                <table class="table verticle-middle table-responsive-md">
                                    <thead>
                                        <tr>
                                            <th scope="col">No.</th>
                                            <th scope="col">NIM</th>
                                            <th scope="col">Nama</th>
                                            <th scope="col">Tanggal</th>
                                            <th scope="col">Pelanggaran</th>
                                            <th scope="col">Tingkat</th>
                                            <th scope="col">Status</th>
                                            <th scope="col"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1</td>
                                            <td>2341760083</td>
                                            <td>Iga Ramadana S.</td>
                                            <td>10-11-2024</td>
                                            <td>Melakukan plagiasi</td>
                                            <td class="text-center">I/II</td>
                                            <td><span class="badge badge-rounded badge-success">Selesai</span></td>
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
                                                        <a class="dropdown-item" href="javascript:void();;">Details</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void();;">Cancel</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2</td>
                                            <td>2341760083</td>
                                            <td>Iga Ramadana S.</td>
                                            <td>10-11-2024</td>
                                            <td>Melakukan plagiasi</td>
                                            <td class="text-center">I/II</td>
                                            <td><span class="badge badge-rounded badge-warning">Pending</span></td>
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
                                                        <a class="dropdown-item" href="javascript:void();;">Details</a>
                                                        <a class="dropdown-item text-danger" href="javascript:void();;">Cancel</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <a href="riwayat.php">
                                    <button class="btn btn-primary btn-sm">Selengkapnya</button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!--**********************************
    Content body end
    ***********************************-->

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