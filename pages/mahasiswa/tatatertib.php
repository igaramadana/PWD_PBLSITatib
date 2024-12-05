<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tata Tertib Mahasiswa</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 20px;
        }
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }
        .table {
            width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
        }
        .table th, .table td {
            vertical-align: middle;
        }
       
        .text-primary {
            color: #6c757d; 
        }
        .badge {
            font-size: 0.875rem;
            padding: 0.375rem 0.75rem;
            border-radius: 0.375rem;
        }
        .badge-success {
            background-color: #28a745;
            color: white;
        }
        .badge-warning {
            background-color: #ffc107;
            color: black;
        }
    </style>
</head>
<body>

<div class="container-fluid mt-5">
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-lg bg-white text-dark rounded-4 hover-shadow-lg">
                <div class="card-body p-5">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <!-- Ubah warna teks menjadi Wingi -->
                            <h2 class="fw-bold mb-2 text-primary">Tata Tertib Mahasiswa</h2>
                            <p class="mb-0 text-muted fs-5">
                                Daftar tata tertib yang harus dipatuhi oleh seluruh mahasiswa di lingkungan kampus.
                            </p>
                        </div>
                        <div class="text-end">
                            <i class="flaticon-381-dashboard fs-3 text-primary"></i>
                        </div>
                    </div>

                    <!-- Tabel Tata Tertib Mahasiswa -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Pelanggaran</th>
                                    <th>Tingkat Pelanggaran</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rules = [
                                    ["Berkomunikasi dengan tidak sopan, baik tertulis atau tidak tertulis kepada mahasiswa, dosen, karyawan, atau orang lain", "V"],
                                    ["Berbusana tidak sopan dan tidak rapi, seperti pakaian ketat, transparan, memakai t-shirt, dll.", "IV"],
                                    ["Mahasiswa laki-laki berambut tidak rapi, gondrong", "IV"],
                                    ["Mahasiswa berambut dengan model punk, dicat selain hitam dan/atau skinned", "IV"],
                                    ["Makan atau minum di dalam ruang kuliah/laboratorium/bengkel", "IV"],
                                    ["Melanggar peraturan/ketentuan yang berlaku di Polinema", "III"],
                                    ["Tidak menjaga kebersihan di seluruh area Polinema", "III"],
                                    ["Membuat kegaduhan yang mengganggu perkuliahan atau praktikum", "III"],
                                    ["Merokok di luar area kawasan merokok", "III"],
                                    ["Bermain kartu, game online di area kampus", "III"],
                                    ["Mengotori atau mencoret-coret fasilitas kampus", "III"],
                                    ["Bertingkah laku kasar atau tidak sopan", "III"],
                                    ["Merusak sarana dan prasarana kampus", "II"],
                                    ["Tidak menjaga ketertiban dan keamanan", "II"],
                                    ["Mengakses materi pornografi di kelas atau area kampus", "II"],
                                    ["Membawa/menggunakan senjata tajam/senjata api untuk hal kriminal", "II"],
                                    ["Melakukan perkelahian, membentuk geng, atau kegiatan negatif", "II"],
                                    ["Melakukan kegiatan politik praktis di kampus", "II"],
                                    ["Mengancam secara tertulis atau tidak tertulis", "II"],
                                    ["Mencuri dalam bentuk apapun", "I/II"],
                                    ["Melakukan kecurangan akademik, administratif, atau keuangan", "I/II"],
                                    ["Melakukan pelecehan atau tindakan asusila", "I/II"],
                                    ["Berjudi, minum-minuman keras, atau mabuk", "I/II"],
                                    ["Mengikuti organisasi atau menyebarkan faham terlarang", "I/II"],
                                    ["Melakukan pemalsuan dokumen", "I/II"],
                                    ["Melakukan plagiasi", "I/II"],
                                    ["Tidak menjaga nama baik Polinema", "I"],
                                    ["Melakukan tindakan yang merendahkan martabat negara atau Polinema", "I"],
                                    ["Menggunakan barang psikotropika atau zat adiktif lainnya", "I"],
                                    ["Mengedarkan barang psikotropika", "I"],
                                    ["Terlibat dalam tindakan kriminal", "I"]
                                ];

                                foreach ($rules as $index => $rule) {
                                    echo "<tr>
                                        <td>" . ($index + 1) . "</td>
                                        <td>" . $rule[0] . "</td>
                                        <td class='text-center'>" . $rule[1] . "</td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <!-- End Tabel Tata Tertib Mahasiswa -->
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
