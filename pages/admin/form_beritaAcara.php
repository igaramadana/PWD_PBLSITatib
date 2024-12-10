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
                            <a href="javascript:void(0)">Form Berita Acara</a>
                        </li>
                    </ol>
                </div>
                <div class="row gy-4">
                    <!-- Form Input Pelanggaran -->
                    <div class="col-xl-12 col-lg-12 col-xxl-12 col-sm-12">
                        <div class="card">
                            <div class="card-header">
                                <h4 class="card-title">Berita Acara Pelanggaran Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <h5>Download Berita Acara (PDF)</h5>
                                <p>Silakan klik tombol di bawah ini untuk mengunduh file PDF berita acara.</p>
                                <a href="berita acara.pdf" download class="btn btn-success">
                                    <i class="fas fa-download me-2"></i> Download PDF
                                </a>
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