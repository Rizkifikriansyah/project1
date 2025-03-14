<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); // Redirect ke halaman login jika belum login
    exit();
}

$user_id = $_SESSION['user_id'];
$divisi = $_SESSION['divisi']; // Divisi yang diambil dari sesi login

// Query untuk mengambil daftar proyek berdasarkan divisi user
$query_proyek = "SELECT * FROM proyek WHERE divisi = '$divisi'";
$result_proyek = $conn->query($query_proyek);

// Query untuk mengambil daftar tugas berdasarkan user_id dan divisi
$query_tugas = "SELECT tugas.*, proyek.nama AS proyek_nama FROM tugas
                JOIN proyek ON tugas.proyek_id = proyek.id
                WHERE tugas.user_id = '$user_id' AND proyek.divisi = '$divisi'";

$result_tugas = $conn->query($query_tugas);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Dashboard User</h2>
        <p>Divisi: <?php echo htmlspecialchars($divisi); ?></p>
        
        <h3>Daftar Proyek</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Proyek</th>
                    <th>Tanggal Mulai</th>
                    <th>Deskripsi</th>
                    <th>Divisi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_proyek->num_rows > 0) {
                    $no = 1;
                    while ($row = $result_proyek->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama']}</td>
                                <td>{$row['tanggal_mulai']}</td>
                                <td>{$row['deskripsi']}</td>
                                <td>{$row['divisi']}</td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada proyek untuk divisi ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>
        
        <h3>Daftar Tugas</h3>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Nama Tugas</th>
                    <th>Tanggal Mulai</th>
                    <th>Deadline</th>
                    <th>Deskripsi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tugas->num_rows > 0) {
                    $no = 1;
                    while ($row = $result_tugas->fetch_assoc()) {
                        echo "<tr>
                                <td>{$no}</td>
                                <td>{$row['nama_tugas']}</td>
                                <td>{$row['tanggal_mulai']}</td>
                                <td>{$row['deadline']}</td>
                                <td>{$row['deskripsi']}</td>
                            </tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='5'>Tidak ada tugas untuk divisi ini.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>