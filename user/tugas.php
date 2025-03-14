<?php
// Koneksi ke database
include '../koneksi.php';
session_start();

// Ambil ID pengguna dari sesi
$user_id = $_SESSION['user_id']; 

// Ambil ID proyek dari URL
$proyek_id = isset($_GET['proyek_id']) ? $_GET['proyek_id'] : '';

// Query untuk mengambil tugas yang terkait dengan pengguna dan proyek
$query = "SELECT tugas.*, user.nama as nama_user, laporan.id as laporan_id 
          FROM tugas 
          JOIN user ON tugas.user_id = user.id 
          LEFT JOIN laporan ON tugas.id = laporan.tugas_id 
          WHERE tugas.user_id = '$user_id' AND tugas.proyek_id = '$proyek_id'";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Daftar Tugas Anda</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Tugas</th>
                <th>Tanggal Mulai</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    // Tentukan status tugas berdasarkan apakah sudah ada laporan atau belum
                    $status_tugas = isset($row['laporan_id']) ? ($row['laporan_id'] ? 'Selesai' : 'Belum Selesai') : 'Belum Selesai';

                    echo "<tr>
                            <td>{$no}</td>
                            <td>" . htmlspecialchars($row['nama_tugas']) . "</td>
                            <td>" . htmlspecialchars($row['tanggal_mulai']) . "</td>
                            <td>" . htmlspecialchars($row['deadline']) . "</td>
                            <td>" . htmlspecialchars($status_tugas) . "</td>
                            <td>
                                <a href='detail.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'>Detail</a>
                                <a href='upload_file.php?id=" . $row['id'] . "' class='btn btn-success btn-sm'>Upload File</a>
                            </td>
                          </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='6' class='text-center'>Tidak ada tugas untuk proyek ini</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="dash_user.php" class="btn btn-secondary">Kembali ke Dashboard</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>