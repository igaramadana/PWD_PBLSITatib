<?php 
include "../../config/database.php";
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
                <div class="row gy-4">
                    <!-- Total Pelanggaran -->
                     <?php
                     $queryTotalPelanggaran = "SELECT COUNT(*) AS total_pelanggaran FROM PengaduanPelanggaran";
                     $resultTotalPelanggaran = sqlsrv_query($conn, $queryTotalPelanggaran);
                     $rowTotalPelanggaran = sqlsrv_fetch_array($resultTotalPelanggaran, SQLSRV_FETCH_ASSOC);
                     $totalPelanggaran = $rowTotalPelanggaran['total_pelanggaran'];
                     ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-danger">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="flaticon-381-calendar-1 fs-3 text-white"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Total Pelanggaran</p>
                                        <h3 class="text-white mb-0"><?= $totalPelanggaran; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Mahasiswa -->
                    <?php
                    // Mengambil jumlah mahasiswa dari tabel Mahasiswa
                    $queryMahasiswa = "SELECT COUNT(*) AS total_mahasiswa FROM Mahasiswa";
                    $resultMahasiswa = sqlsrv_query($conn, $queryMahasiswa);
                    $mahasiswaRow = sqlsrv_fetch_array($resultMahasiswa, SQLSRV_FETCH_ASSOC);
                    $totalMahasiswa = $mahasiswaRow['total_mahasiswa'];
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-success">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-graduation-cap text-white fs-3"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Total Mahasiswa</p>
                                        <h3 class="text-white mb-0"><?php echo $totalMahasiswa; ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Total Dosen -->
                    <?php
                    // Mengambil jumlah dosen dari tabel Dosen
                    $queryDosen = "SELECT COUNT(*) AS total_dosen FROM Dosen";
                    $resultDosen = sqlsrv_query($conn, $queryDosen);
                    $dosenRow = sqlsrv_fetch_array($resultDosen, SQLSRV_FETCH_ASSOC);
                    $totalDosen = $dosenRow['total_dosen'];
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-info">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-person text-white fs-3"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Total Dosen</p>
                                        <h3 class="text-white mb-0"><?php echo $totalDosen; ?></h3>
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
                                        <i class="fa-solid fa-code-pull-request text-white fs-3"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Request Pelanggaran</p>
                                        <h3 class="text-white mb-0">Tidak ada</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Analitik Pelanggaran Terkini -->
                    <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Grafik Analitik Pelanggaran Terkini</h4>
                            </div>
                            <div class="card-body">
                                <canvas id="pelanggaranChart" width="400" height="200"></canvas>
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

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data for the chart (Example: Pelanggaran by Category)
        const data = {
            labels: ['Plagiasi', 'Keterlambatan', 'Melanggar Peraturan', 'Perilaku Tidak Baik'], // Label untuk kategori pelanggaran
            datasets: [{
                label: 'Jumlah Pelanggaran',
                data: [12, 8, 15, 6], // Data jumlah pelanggaran pada setiap kategori
                backgroundColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'], // Warna untuk setiap kategori
                borderColor: ['#ff6384', '#36a2eb', '#cc65fe', '#ffce56'], // Warna border
                borderWidth: 1
            }]
        };

        // Konfigurasi chart
        const config = {
            type: 'bar', // Jenis grafik: Bar chart
            data: data,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.raw + ' pelanggaran';
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        };

        // Menampilkan chart
        const pelanggaranChart = new Chart(
            document.getElementById('pelanggaranChart'),
            config
        );
    </script>
</body>
