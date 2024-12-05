<?php
// Simulasi data mahasiswa (biasanya data ini diambil dari database)
$mahasiswa = [
    'nama' => 'John Doe',
    'nim' => '1234567890',
    'program_studi' => 'Teknik Informatika',
    'jurusan' => 'Fakultas Teknik',
    'email' => 'john.doe@mail.com',
    'no_telepon' => '+62 812 3456 7890',
    'alamat' => 'Jl. Contoh Alamat No. 123, Kota X',
    'foto' => 'https://via.placeholder.com/150', // Ganti dengan link foto mahasiswa
];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .profile-header img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
        }
        .profile-header h2 {
            color: #6f42c1;
        }
        .profile-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .profile-info table {
            width: 100%;
        }
        .profile-info th {
            text-align: left;
            width: 30%;
        }
        .profile-info td {
            width: 70%;
        }
        .btn-back {
            background-color: #6f42c1;
            color: white;
            border-radius: 5px;
        }
        .btn-back:hover {
            background-color: #5a30a1;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="profile-header">
        <img src="<?php echo $mahasiswa['foto']; ?>" alt="Foto Mahasiswa">
        <h2><?php echo $mahasiswa['nama']; ?></h2>
        <p><?php echo $mahasiswa['program_studi'] . ' - ' . $mahasiswa['jurusan']; ?></p>
    </div>

    <div class="profile-info">
        <h4>Informasi Profil</h4>
        <table class="table">
            <tr>
                <th>NIM</th>
                <td><?php echo $mahasiswa['nim']; ?></td>
            </tr>
            <tr>
                <th>Program Studi</th>
                <td><?php echo $mahasiswa['program_studi']; ?></td>
            </tr>
            <tr>
                <th>Jurusan</th>
                <td><?php echo $mahasiswa['jurusan']; ?></td>
            </tr>
            <tr>
                <th>Email</th>
                <td><?php echo $mahasiswa['email']; ?></td>
            </tr>
            <tr>
                <th>No. Telepon</th>
                <td><?php echo $mahasiswa['no_telepon']; ?></td>
            </tr>
            <tr>
                <th>Alamat</th>
                <td><?php echo $mahasiswa['alamat']; ?></td>
            </tr>
        </table>
    </div>

    <div class="text-center mt-4">
        <a href="dashboard.php" class="btn btn-back">Kembali ke Dashboard</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
