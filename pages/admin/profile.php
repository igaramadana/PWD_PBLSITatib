<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Main wrapper -->
    <div id="main-wrapper">
        <?php include("header.php"); ?>
        <?php include("sidebar.php"); ?>

        <!-- Content body -->
        <div class="content-body">
            <div class="container-fluid">
                <!-- Breadcrumb -->
                <div class="row page-titles">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active"><a href="javascript:void(0)">Manage Profile</a></li>
                    </ol>
                </div>

                <!-- Profile Content -->
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title">Foto Profil</h4>
                            </div>
                            <div class="card-body text-center">
                                <img src="../../assets/template/images/avatar/1.jpg" alt="avatar"
                                    class="rounded-circle img-fluid" style="width: 150px;">
                                <h5 class="my-3">Username</h5>
                                <p class="text-muted mb-1">Mahasiswa</p>
                                <div class="d-flex justify-content-center mb-2">
                                    <button type="button" class="btn btn-warning btn-sm mt-4">Change Profile Picture</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-8">
                        <div class="card mb-4">
                        <div class="card-header">
                                <h4 class="card-title">Informasi Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nomor Induk Mahasiswa</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">2341760083</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Nama Lengkap</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">Iga Ramadana Sahputra</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Jurusan</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">Teknologi Informasi</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Program Studi</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">DIV-Sistem Informasi Bisnis</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Kelas</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">SIB-2C</p>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <p class="mb-0">Angkatan</p>
                                    </div>
                                    <div class="col-sm-9">
                                        <p class="text-muted mb-0">2023</p>
                                    </div>
                                </div>
                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include("footer.php"); ?>
    </div>

    <script>
        // Fungsi untuk melihat preview foto profil
        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function() {
                var output = document.getElementById('profilePreview');
                output.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>

</html>