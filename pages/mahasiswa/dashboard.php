<?php
include "../../process/mahasiswa/fungsi_tampil_profile.php"
?>

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

                <!-- Selamat Datang & Dashboard Info dalam Satu Card -->
                <div class="row mb-5">
                    <div class="col-12">
                        <div class="card border-0 shadow-lg bg-white text-dark rounded-4 hover-shadow-lg">
                            <div class="card-body p-5">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <!-- Teks Selamat Datang -->
                                    <div>
                                        <h2 class="fw-bold mb-2 text-primary">Selamat Datang, <?= $mahasiswa['Nama']; ?></h2>
                                        <p class="mb-0 text-muted fs-5">
                                            Pantau dan kelola informasi pelanggaran dengan mudah di sini. Semoga harimu menyenangkan!
                                        </p>
                                    </div>
                                    <!-- Ikon Teks Modern -->
                                    <div class="text-end">
                                        <i class="flaticon-381-dashboard fs-3 text-primary"></i>
                                    </div>
                                </div>

                                <!-- Dashboard Stats -->
                                <div class="row gy-4">
                                    <!-- Content Pelanggaran Terkini -->
                                    <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                                        <div class="card border-0 shadow-sm rounded-4">
                                            <div class="card-header d-flex justify-content-between align-items-center" style="background-color: #6f42c1;">
                                                <h4 class="card-title mb-0" style="color: white">Pelanggaran Terkini</h4>
                                                <a href="riwayat.php" class="btn btn-sm" style="color: white; border: 1px solid white; background-color: transparent; transition: background-color 0.3s ease, color 0.3s ease;"
                                                    onmouseover="this.style.backgroundColor='white'; this.style.color='#007bff';" onmouseout="this.style.backgroundColor='transparent'; this.style.color='white';">
                                                    Selengkapnya
                                                </a>

                                            </div>
                                            <div class="card-body">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="text-center">No.</th>
                                                                <th class="text-center">Tanggal Pelanggaran</th>
                                                                <th class="text-center">Nama Pelanggaran</th>
                                                                <th class="text-center">Tingkat Pelanggaran</th>
                                                                <th class="text-center">Status</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td class="text-center" >1</td>
                                                                <td class="text-center">10-11-2024</td>
                                                                <td class="text-center">Melakukan plagiasi</td>
                                                                <td class="text-center">I/II</td>
                                                                <td class="text-center">
                                                                    <span class="badge badge-success">Selesai</span>
                                                                    <div class="dropdown d-inline-block ms-2">
                                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="flaticon-381-settings-1 fs-5 text-muted"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <li><a class="dropdown-item" href="javascript:void(0);">Details</a></li>
                                                                            <li><a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td class="text-center">2</td>
                                                                <td class="text-center">10-11-2024</td>
                                                                <td class="text-center">Melakukan plagiasi</td>
                                                                <td class="text-center">I/II</td>
                                                                <td class="text-center">
                                                                    <span class="badge badge-warning">Pending</span>
                                                                    <div class="dropdown d-inline-block ms-2">
                                                                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                                                                            <i class="flaticon-381-settings-1 fs-5 text-muted"></i>
                                                                        </button>
                                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                            <li><a class="dropdown-item" href="javascript:void(0);">Details</a></li>
                                                                            <li><a class="dropdown-item text-danger" href="javascript:void(0);">Cancel</a></li>
                                                                        </ul>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- End Dashboard Stats -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .card {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card:hover {
                transform: translateY(-5px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            }

            .table {
                width: 100%;
                margin-bottom: 1rem;
                background-color: transparent;
            }

            .table th,
            .table td {
                vertical-align: middle;
            }

            .badge {
                font-size: 0.875rem;
                padding: 0.375rem 0.75rem;
                border-radius: 0.375rem;
            }

            .badge-success {
                border-radius: 1.5rem;
                background-color: #28a745;
                color: white;
            }

            .badge-warning {
                border-radius: 1.5rem;
                background-color: #ffc107;
                color: white;
            }

            .table-striped tbody tr:nth-of-type(odd) {
                background-color: #f9f9f9;
            }

            .dropdown-toggle::after {
                display: none;
            }

            .btn-outline-primary {
                border-color: #4e73df;
                color: #4e73df;
            }

            .btn-outline-primary:hover {
                background-color: #4e73df;
                color: white;
            }
        </style>

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