<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require '../../vendor/autoload.php';  // Memuat autoload Composer

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;

include('../../config/database.php');  // Pastikan koneksi DB sudah benar

// Variabel untuk pencarian dan status
$search = isset($_GET['search']) ? $_GET['search'] : '';
$statusFilter = isset($_GET['status']) ? $_GET['status'] : '';

// Query dasar
$query = "SELECT p.PelanggaranID, m.NIM, m.Nama, pp.Catatan, pp.StatusPelanggaran,
          pp.BuktiPelanggaran, p.NamaPelanggaran, pp.TanggalPengaduan
          FROM PengaduanPelanggaran pp
          JOIN Mahasiswa m ON pp.MhsID = m.MhsID
          JOIN Pelanggaran p ON pp.PelanggaranID = p.PelanggaranID
          WHERE 1=1";

// Filter berdasarkan pencarian
if (!empty($search)) {
    $query .= " AND (m.NIM LIKE ? OR m.Nama LIKE ?)";
}

// Filter berdasarkan status
if (!empty($statusFilter)) {
    $query .= " AND pp.StatusPelanggaran = ?";
}

$query .= " ORDER BY pp.TanggalPengaduan DESC";  // Sorting berdasarkan tanggal pengaduan

// Persiapkan parameter
$params = [];
if (!empty($search)) {
    $params[] = "%$search%";  // Pencarian berdasarkan NIM atau Nama
    $params[] = "%$search%";  // Pencarian berdasarkan Nama
}
if (!empty($statusFilter)) {
    $params[] = $statusFilter;  // Filter status pelanggaran
}

// Eksekusi query
$stmt = sqlsrv_query($conn, $query, $params);

if ($stmt === false) {
    die(print_r(sqlsrv_errors(), true));
}

// Ambil hasil query
$pelanggaranList = [];
while ($row = sqlsrv_fetch_array($stmt, SQLSRV_FETCH_ASSOC)) {
    $pelanggaranList[] = $row;
}

sqlsrv_free_stmt($stmt);  // Membersihkan statement setelah digunakan

// Membuat objek Spreadsheet baru
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Menambahkan judul kolom dengan styling
$sheet->setCellValue('A1', 'No.');
$sheet->setCellValue('B1', 'NIM');
$sheet->setCellValue('C1', 'Nama Mahasiswa');
$sheet->setCellValue('D1', 'Nama Pelanggaran');
$sheet->setCellValue('E1', 'Deskripsi Pelanggaran');
$sheet->setCellValue('F1', 'Tanggal Pengaduan');
$sheet->setCellValue('G1', 'Bukti Pelanggaran');
$sheet->setCellValue('H1', 'Status');

// Styling untuk header (menambahkan background color, tebal font, dan tengah)
$headerStyle = [
    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
    'fill' => ['fillType' => Fill::FILL_SOLID, 'color' => ['rgb' => '4F81BD']],  // Warna latar belakang biru
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'border' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
    ]
];
$sheet->getStyle('A1:H1')->applyFromArray($headerStyle);

// Menambahkan data pelanggaran
$no = 1;
$rowIndex = 2;  // Mulai dari baris kedua untuk data
foreach ($pelanggaranList as $pelanggaran) {
    $sheet->setCellValue('A' . $rowIndex, $no++);
    $sheet->setCellValue('B' . $rowIndex, $pelanggaran['NIM']);
    $sheet->setCellValue('C' . $rowIndex, $pelanggaran['Nama']);
    $sheet->setCellValue('D' . $rowIndex, $pelanggaran['NamaPelanggaran']);
    $sheet->setCellValue('E' . $rowIndex, $pelanggaran['Catatan']);

    // Format tanggal pengaduan jika ada
    if ($pelanggaran['TanggalPengaduan']) {
        $tanggalPengaduan = $pelanggaran['TanggalPengaduan']->format('Y-m-d'); // Sesuaikan dengan format yang diinginkan
    } else {
        $tanggalPengaduan = 'Tidak ada tanggal';
    }
    $sheet->setCellValue('F' . $rowIndex, $tanggalPengaduan);

    // Menambahkan Bukti Pelanggaran (file path)
    $sheet->setCellValue('G' . $rowIndex, $pelanggaran['BuktiPelanggaran']);

    // Status Pelanggaran dengan warna yang berbeda untuk memudahkan visualisasi
    $status = $pelanggaran['StatusPelanggaran'];
    $sheet->setCellValue('H' . $rowIndex, $status);
    if ($status == 'Tuntas') {
        $sheet->getStyle('H' . $rowIndex)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('A9D08E');  // Hijau
    } elseif ($status == 'Proses') {
        $sheet->getStyle('H' . $rowIndex)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('FFD966');  // Kuning
    } else {
        $sheet->getStyle('H' . $rowIndex)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('F4CCCC');  // Merah
    }
    
    $rowIndex++;
}

// Styling untuk data (border dan alignment)
$dataStyle = [
    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
    'border' => [
        'allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => '000000']]
    ]
];

// Menerapkan styling untuk data range (A2:H terakhir)
$sheet->getStyle('A2:H' . ($rowIndex - 1))->applyFromArray($dataStyle);

// Menyesuaikan lebar kolom agar pas dengan data
foreach (range('A', 'H') as $col) {
    $sheet->getColumnDimension($col)->setAutoSize(true);
}

// Menulis file Excel
$writer = new Xlsx($spreadsheet);

// Mengatur header untuk mengunduh file
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Rekap_Pelanggaran.xlsx"');
header('Cache-Control: max-age=0');

// Menyimpan file ke browser
$writer->save('php://output');
exit;
