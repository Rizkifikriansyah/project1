<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil ID tugas dari URL
$tugas_id = isset($_GET['id']) ? $_GET['id'] : '';

// Jika ID tidak ada, redirect ke halaman sebelumnya
if (!$tugas_id) {
    header("Location: tugas.php");
    exit;
}

// Cek apakah ID tugas valid
$check_query = "SELECT * FROM tugas WHERE id = '$tugas_id'";
$check_result = $conn->query($check_query);

if ($check_result->num_rows == 0) {
    die("Tugas tidak ditemukan!");
}

// Proses pengunggahan file
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $file_tugas = $_FILES['file_tugas'];
    $komentar = $_POST['komentar'];
    $status_pengerjaan = $_POST['status_pengerjaan'];

    // Validasi file
    $allowed_extensions = ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'jpg', 'jpeg', 'png', 'gif'];
    $file_extension = pathinfo($file_tugas['name'], PATHINFO_EXTENSION);

    if (in_array($file_extension, $allowed_extensions)) {
        // Tentukan direktori untuk menyimpan file
        $upload_dir = '../upload/';
        $file_path = $upload_dir . basename($file_tugas['name']);

        // Pindahkan file ke direktori tujuan
        if (move_uploaded_file($file_tugas['tmp_name'], $file_path)) {
            // Simpan informasi file ke database
            $query = "INSERT INTO laporan (tugas_id, file_tugas, status_pengerjaan, komentar) VALUES ('$tugas_id', '{$file_tugas['name']}', '$status_pengerjaan', '$komentar')";
            if ($conn->query($query) === TRUE) {
                // Redirect ke halaman tugas admin setelah berhasil upload
                header("Location: tugas.php?status=success");
                exit;
            } else {
                echo "Error: " . $conn->error; // Tampilkan kesalahan jika ada
            }
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "File type not allowed.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload File Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Upload File Tugas</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="file_tugas" class="form-label">File Tugas</label>
            <input type="file" class="form-control" id="file_tugas" name="file_tugas" required>
        </div>
        <div class="mb-3">
            <label for="komentar" class="form-label">Komentar</label>
            <textarea class="form-control" id="komentar" name="komentar" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="status_pengerjaan" class="form-label">Status Pengerjaan</label>
            <select class="form-select" id="status_pengerjaan" name="status_pengerjaan" required>
                <option value="Dalam Proses">Dalam Proses</option>
                <option value="Selesai">Selesai</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
        <a href="detail.php?id=<?php echo $tugas_id; ?>" class="btn btn-secondary">Kembali</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>