<?php
include "../config/database.php";

// Cek jika form telah disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Hash password yang dimasukkan
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Query untuk memasukkan data pengguna baru ke tabel Users
    $sql = "INSERT INTO Users (Username, Password, Role) VALUES (?, ?, ?)";
    $params = array($username, $hashedPassword, $role);

    // Eksekusi query
    $stmt = sqlsrv_query($conn, $sql, $params);

    // Cek apakah query berhasil
    if ($stmt === false) {
        die(print_r(sqlsrv_errors(), true));
    } else {
        echo "User successfully registered!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register User</title>
</head>
<body>
    <h2>Register New User</h2>
    <form action="register.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <label for="role">Role:</label>
        <select id="role" name="role" required>
            <option value="admin">Admin</option>
            <option value="dosen">Dosen</option>
            <option value="mahasiswa">Mahasiswa</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>
</body>
</html>
