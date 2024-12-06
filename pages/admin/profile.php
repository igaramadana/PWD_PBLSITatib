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
                <div class="container py-5 h-100">
                    <div class="row d-flex justify-content-center align-items-center h-100">
                        <div class="col-md-8 col-lg-6 mb-4">
                            <div class="card mb-3 shadow-sm" style="border-radius: .5rem;">
                                <div class="row g-0">
                                    <!-- Left Side: Profile Picture & Info -->
                                    <div class="col-md-4 bg-primary text-center text-white rounded-start">
                                        <img id="profilePreview" src="https://mdbcdn.b-cdn.net/img/Photos/new-templates/bootstrap-chat/ava1-bg.webp"
                                            alt="Profile Avatar" class="img-fluid my-4" style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%;" />
                                        <h5 class="mb-2">Marie Horwitz</h5>
                                        <p>Web Designer</p>
                                        <i class="far fa-edit mb-5" style="font-size: 20px;"></i>
                                        <!-- Upload File for Profile Picture -->
                                        <form action="process_update_profile_picture.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <input type="file" class="form-control" id="fileInput" name="fotoProfile" accept="image/*" onchange="previewImage(event)">
                                            </div>
                                            <button type="submit" class="btn btn-light btn-sm">Change Photo</button>
                                        </form>
                                    </div>

                                    <!-- Right Side: Personal Information -->
                                    <div class="col-md-8">
                                        <div class="card-body p-4">
                                            <h6>Information</h6>
                                            <hr class="mt-0 mb-4">
                                            
                                            <!-- Email & Phone Info -->
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <h6>Email</h6>
                                                    <p class="text-muted">info@example.com</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Phone</h6>
                                                    <p class="text-muted">123 456 789</p>
                                                </div>
                                            </div>

                                            <!-- Projects Info -->
                                            <h6>Projects</h6>
                                            <hr class="mt-0 mb-4">
                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <h6>Recent</h6>
                                                    <p class="text-muted">Lorem ipsum</p>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <h6>Most Viewed</h6>
                                                    <p class="text-muted">Dolor sit amet</p>
                                                </div>
                                            </div>

                                            <!-- Social Links -->
                                            <div class="d-flex justify-content-start mt-4">
                                                <a href="#!" class="text-muted me-3"><i class="fab fa-facebook-f fa-lg"></i></a>
                                                <a href="#!" class="text-muted me-3"><i class="fab fa-twitter fa-lg"></i></a>
                                                <a href="#!" class="text-muted"><i class="fab fa-instagram fa-lg"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
