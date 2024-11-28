<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="">
    <meta name="author" content="">
    <meta name="robots" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:title" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:description" content="Fillow : Fillow Saas Admin  Bootstrap 5 Template">
    <meta property="og:image" content="https://fillow.dexignlab.com/xhtml/social-image.png">
    <meta name="format-detection" content="telephone=no">

    <!-- PAGE TITLE HERE -->
    <title>Register Mahasiswa</title>

    <!-- FAVICONS ICON -->
    <link rel="shortcut icon" type="image/png" href="images/favicon.png">
    <link href="../assets/template/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <div class="text-center mb-3">
                                        <a href="index.html"><img src="images/logo-full.png" alt=""></a>
                                    </div>
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <!-- Form Action Diperbaiki ke process_register.php -->
                                    <form action="../process/process_register.php" method="POST">
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Nomor Induk Mahasiswa</strong></label>
                                            <input type="text" class="form-control" id="nim" name="nim" placeholder="Masukkan Nomor Induk Mahasiswa" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Nama Lengkap</strong></label>
                                            <input type="text" class="form-control" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Jurusan</strong></label>
                                            <div class="basic-form">
                                                <form>
                                                    <select class="default-select form-control wide mb-3" id="jurusan" name="jurusan" required>
                                                        <option value="Teknologi Informasi">Teknologi Informasi</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Program Studi</strong></label>
                                            <div class="basic-form">
                                                <form>
                                                    <select class="default-select form-control wide mb-3" id="prodi" name="prodi" onchange="updateClasses()" required>
                                                        <option value="" disabled selected>Pilih Program Studi</option>
                                                        <option value="Sistem Informasi Bisnis">D-IV Sistem Informasi Bisnis</option>
                                                        <option value="Teknik Informatika">D-IV Teknik Informatika</option>
                                                        <option value="PPL">D-II Pengembangan Piranti Lunak</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Kelas</strong></label>
                                            <div class="basic-form">
                                                <form>
                                                    <select class="default-select form-control wide mb-3" id="kelas" name="kelas" required>
                                                        <option value="" disabled selected>Pilih Kelas</option>
                                                    </select>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="text-center mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Sign me up</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Already have an account? <a class="text-primary" href="page-login.html">Sign in</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
    Scripts
    ***********************************-->
    <script>
        function updateClasses() {
            const prodi = document.getElementById('prodi').value;
            const kelas = document.getElementById('kelas');
            kelas.innerHTML = "";

            let options = [];
            if (prodi === "Sistem Informasi Bisnis") {
                options = [
                    "SIB 1-A", "SIB 1-B", "SIB 1-C", "SIB 1-D", "SIB 1-E", "SIB 1-F", "SIB 1-G",
                    "SIB 2-A", "SIB 2-B", "SIB 2-C", "SIB 2-D", "SIB 2-E", "SIB 2-F", "SIB 2-G",
                    "SIB 3-A", "SIB 3-B", "SIB 3-C", "SIB 3-D", "SIB 3-E", "SIB 3-F", "SIB 3-G"
                ];
            } else if(prodi === "Teknik Informatika") {
                options = [
                    "TI 1-A", "TI 1-B", "TI 1-C", "TI 1-D", "TI 1-E", "TI 1-F", "TI 1-G", "TI 1-H", "TI 1-I",
                    "TI 2-A", "TI 2-B", "TI 2-C", "TI 2-D", "TI 2-E", "TI 2-F", "TI 2-G", "TI 2-H", "TI 2-I",
                    "TI 3-A", "TI 3-B", "TI 3-C", "TI 3-D", "TI 3-E", "TI 3-F", "TI 3-G", "TI 3-H", "TI 3-I"
                ];
            } else {
                options = [
                    "PPL-1","PPL-2"
                ];
            }
            options.forEach(function (kelasName) {
                const option = document.createElement("option");
                option.value = kelasName;
                option.textContent = kelasName;
                kelas.appendChild(option);
            });
        }
    </script>

    <!-- Required vendors -->
    <script src="../assets/template/vendor/global/global.min.js"></script>
    <script src="../assets/template/js/custom.min.js"></script>
    <script src="../assets/template/js/dlabnav-init.js"></script>
</body>

</html>
