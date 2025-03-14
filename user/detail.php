<?php
// Koneksi ke database
include '../koneksi.php';

$tugas_id = isset($_GET['id']) ? $_GET['id'] : '';

if (!$tugas_id) {
    die("ID tugas tidak ditemukan!");
}

// Query untuk mengambil detail tugas
$query = "SELECT tugas.*, user.nama as nama_user, laporan.id as laporan_id 
          FROM tugas 
          LEFT JOIN user ON tugas.user_id = user.id 
          LEFT JOIN laporan ON tugas.id = laporan.tugas_id 
          WHERE tugas.id = '$tugas_id'";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$tugas = $result->fetch_assoc();

if (!$tugas) {
    die("Tugas tidak ditemukan!");
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Detail Tugas</h2>
        <p><strong>Nama Tugas:</strong> <?php echo htmlspecialchars($tugas['nama_tugas']); ?></p>
        <p><strong>Pegawai:</strong> <?php echo htmlspecialchars($tugas['nama_user']); ?></p>
        <p><strong>Tanggal Mulai:</strong> <?php echo htmlspecialchars($tugas['tanggal_mulai']); ?></p>
        <p><strong>Deadline:</strong> <?php echo htmlspecialchars($tugas['deadline']); ?></p>
        <p><strong>Deskripsi:</strong> <?php echo htmlspecialchars($tugas['deskripsi']); ?></p>
        <p><strong>Status:</strong> <?php echo isset($tugas['laporan_id']) && $tugas['laporan_id'] ? 'Selesai' : 'Belum Selesai'; ?></p>
        <a href="tugas.php" class="btn btn-primary">Kembali</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>