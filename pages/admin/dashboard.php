<?php
include "../../config/database.php";

// Query untuk mengambil data jumlah pelanggaran berdasarkan TingkatID
$queryPelanggaran = "SELECT TingkatID, COUNT(*) AS Total
                     FROM Pelanggaran
                     WHERE TingkatID BETWEEN 1 AND 5
                     GROUP BY TingkatID";

$resultPelanggaran = sqlsrv_query($conn, $queryPelanggaran);

if ($resultPelanggaran === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Menyimpan data dalam array untuk digunakan di JavaScript
$pelanggaranStats = [];
while ($row = sqlsrv_fetch_array($resultPelanggaran, SQLSRV_FETCH_ASSOC)) {
    $pelanggaranStats[] = $row;
}

sqlsrv_free_stmt($resultPelanggaran);

// Mengonversi data PHP ke dalam format JSON untuk digunakan di JavaScript
echo "<script>var pelanggaranStats = " . json_encode($pelanggaranStats) . ";</script>";

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
                    <?php
                    $queryRequestPelanggaran = "SELECT COUNT(*) AS total_request FROM PengaduanPelanggaran WHERE StatusPelanggaran = 'Diajukan'";
                    $resultRequestPelanggaran = sqlsrv_query($conn, $queryRequestPelanggaran);
                    $requestRow = sqlsrv_fetch_array($resultRequestPelanggaran, SQLSRV_FETCH_ASSOC);
                    $totalRequest = $requestRow['total_request'];
                    ?>
                    <div class="col-xl-3 col-lg-6 col-sm-6">
                        <div class="widget-stat card bg-primary">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center">
                                    <span class="me-3">
                                        <i class="fa-solid fa-code-pull-request text-white fs-3"></i>
                                    </span>
                                    <div class="media-body text-white text-end">
                                        <p class="mb-1 fw-bold">Request Pelanggaran</p>
                                        <h3 class="text-white mb-0"><?= $totalRequest ?></h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Section Grafik Analitik -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title">Analitik Pelanggaran Berdasarkan Tingkat</h4>
                                </div>
                                <div class="card-body">
                                    <!-- Canvas untuk grafik -->
                                    <canvas id="pelanggaranChart"></canvas>
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

    <!-- Chart.js Script -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data untuk grafik berdasarkan tingkat pelanggaran (1-5)
        var tingkatLabels = pelanggaranStats.map(function(item) {
            return 'Tingkat ' + item.TingkatID; // Mengambil TingkatID sebagai label (Tingkat 1, 2, 3, 4, 5)
        });

        var tingkatData = pelanggaranStats.map(function(item) {
            return item.Total; // Mengambil jumlah pelanggaran berdasarkan TingkatID
        });

        // Membuat grafik
        var ctx = document.getElementById('pelanggaranChart').getContext('2d');
        var pelanggaranChart = new Chart(ctx, {
            type: 'bar', // Jenis grafik bar
            data: {
                labels: tingkatLabels, // Label sumbu X (Tingkat Pelanggaran 1-5)
                datasets: [{
                    label: 'Jumlah Pelanggaran',
                    data: tingkatData, // Data jumlah pelanggaran berdasarkan tingkat
                    backgroundColor: ['#FF5733', '#3498DB', '#2ECC71', '#F39C12', '#8E44AD'], // Warna latar belakang untuk setiap tingkat
                    borderColor: ['#FF5733', '#3498DB', '#2ECC71', '#F39C12', '#8E44AD'], // Warna border untuk setiap tingkat
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Pelanggaran'
                        }
                    }
                }
            }
        });
    </script>
</body>