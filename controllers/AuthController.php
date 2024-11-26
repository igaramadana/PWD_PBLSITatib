<?php
class AuthController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        // Membuat instance dari Database dan User model
        $this->db = new Database();
        $connection = $this->db->getConnection();
        $this->userModel = new User($connection);
    }

    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Mengambil input dari form
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Memanggil fungsi login dari UserModel
        $user = $this->userModel->login($username, $password);

        if ($user) {
            // Jika login berhasil, buat session untuk user
            session_start();
            $_SESSION['user_id'] = $user['UserID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['role'] = $user['Role'];

            // Redirect berdasarkan role
            switch ($user['Role']) {
                case 'admin':
                    header("Location: views/admin/dashboard.php");
                    break;
                case 'dosen':
                    header("Location: views/dosen/dashboard.php");
                    break;
                case 'mahasiswa':
                    header("Location: views/mahasiswa/dashboard.php");
                    break;
                default:
                    header("Location: /index.php");
                    break;
            }
            exit();
        } else {
            // Jika login gagal, tampilkan pesan error
            $error = "Invalid login credentials";
            include 'views/login.php';
        }
    } else {
        // Jika bukan POST request, tampilkan form login
        include 'views/login.php';
    }
}


    public function logout()
    {
        // Menghancurkan session untuk logout
        session_start();
        session_destroy();
        header("Location: /index.php"); // Redirect ke halaman login
        exit();
    }
}
