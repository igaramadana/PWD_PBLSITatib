<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : null;
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - EthicX</title>
    <link href="../assets/template/css/style.css" rel="stylesheet">
</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="auth-form">
                            <div class="text-center mb-3">
                                <h1>EthicX</h1>
                                <h4>Sistem Informasi Tata Tertib</h4>
                                <hr>
                            </div>
                            <h4 class="text-center mb-4">Sign in your account</h4>

                            <!-- Form Login -->
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger text-center"><?= $error ?></div>
                            <?php endif; ?>
                            <form action="../process/process_login.php" method="POST">
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Username</strong></label>
                                    <input type="text" class="form-control" name="username" id="username" placeholder="Masukkan Username Anda." required>
                                </div>
                                <div class="mb-3">
                                    <label class="mb-1"><strong>Password</strong></label>
                                    <input type="password" class="form-control" name="password" id="password" placeholder="Masukkan Password Anda." required>
                                </div>
                                <div class="text-center">
                                    <button type="submit" class="btn btn-dark btn-block">Masuk</button>
                                </div>
                            </form>
                            <div class="new-account mt-3">
                                <p>Don't have an account? <a class="text-dark" href="register.php">Sign up</a></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/template/vendor/global/global.min.js"></script>
    <script src="../assets/template/js/custom.min.js"></script>
</body>

</html>