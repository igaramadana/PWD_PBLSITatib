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

        <?php include("header.php"); ?>

        <!-- Sidebar -->
        <?php include("sidebar.php"); ?>

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="card shadow-sm border-0 rounded">
                            <div class="card-header">
                                <h3 class="mb-0">Profile</h3>
                            </div>
                            <div class="card-body p-4">
                                <!-- Form untuk Manage Account -->
                                <form action="update_account.php" method="POST" enctype="multipart/form-data">
                                    <!-- Ganti Foto Profil -->
                                    <div class="mb-4 text-center">
                                        <img src="../template/images/avatar/1.jpg" alt="Profile Picture" class="rounded-circle border border-3 border-primary" width="150" height="150">
                                        <div class="mt-3">
                                            <label for="profile_pic" class="form-label fw-bold">Profil Picture</label>
                                            <div class="input-group mb-3">
                                                <button class="btn btn-primary btn-sm" type="button">Submit</button>
                                                <div class="form-file">
                                                    <input type="file" class="form-file-input form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Nama Lengkap -->
                                    <div class="mb-3">
                                        <label for="name" class="form-label fw-bold">Full Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name" value="<?php echo $user['name']; ?>" required>
                                    </div>

                                    <!-- Email -->
                                    <div class="mb-3">
                                        <label for="email" class="form-label fw-bold">Email Address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" value="<?php echo $user['email']; ?>" required>
                                    </div>

                                    <!-- Username -->
                                    <div class="mb-3">
                                        <label for="username" class="form-label fw-bold">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" value="<?php echo $user['username']; ?>" required>
                                    </div>

                                    <!-- Phone Number -->
                                    <div class="mb-3">
                                        <label for="phone" class="form-label fw-bold">Phone Number</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number" value="<?php echo $user['phone']; ?>" required>
                                    </div>

                                    <!-- Password -->
                                    <div class="mb-3">
                                        <label for="password" class="form-label fw-bold">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Enter a new password">
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="mb-3">
                                        <label for="confirm_password" class="form-label fw-bold">Confirm Password</label>
                                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm your new password">
                                    </div>
                                    <!-- Submit Button -->
                                    <div class="text-center mt-4">
                                        <button type="submit" class="btn btn-success btn-md px-5">Save Changes</button>
                                        <a href="dashboard.php" class="btn btn-danger btn-md px-5">Cancel</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        <?php include("footer.php"); ?>
    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
</body>