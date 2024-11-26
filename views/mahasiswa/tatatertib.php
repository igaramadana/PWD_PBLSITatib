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

        <!-- Sidebar -->
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
                            <p class="card-text">Untuk mendorong agar mahasiswa menjaga ketertiban dan kedisiplinan di
                                lingkungan kampus diperlukan tata tertib kehidupan kampus.</p>
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
                            <h4 class="card-title">Daftar Pelanggaran dan Tingkatannya</h4>
                            <div class="table-responsive border border-light">
                                <table class="table table-striped table-responsive-sm">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pelanggaran</th>
                                            <th>Tingkat Pelanggaran</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th>1</th>
                                            <td>Berkomunikasi dengan tidak sopan, baik tertulis atau tidak
                                                tertuliskepada mahasiswa, dosen, karyawan, atau orang lain</td>
                                            <td class="text-center">V</td>
                                        </tr>
                                        <tr>
                                            <th>2</th>
                                            <td>Berbusana tidak sopan dan tidak rapi. Yaitu antara lain adalah:
                                                berpakaian ketat, transparan, memakai t-shirt (baju kaos tidak
                                                berkerah), tank top, hipster, you can see, rok mini, backless,
                                                celanapendek, celana tiga per empat, legging, model celana
                                                atau baju koyak, sandal, sepatu sandal di lingkungan kampus</td>
                                            <td class="text-center">IV</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--**********************************
            Content body end
			***********************************-->




            <!--**********************************
            Footer start
        ***********************************-->

            <!--**********************************
            Footer end
        ***********************************-->

            <!--**********************************
           Support ticket button start
        ***********************************-->

            <!--**********************************
           Support ticket button end
        ***********************************-->


        </div>
        <?php
        include("footer.php");
        ?>
        <!--**********************************
        Main wrapper end
    ***********************************-->
</body>

</html>