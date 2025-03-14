<?php

// Koneksi ke database

include '../koneksi.php';
$sql = "SELECT id, tanggal, id_user, id_proyek, id_tugas, file FROM preview";
$result = $conn->query($sql);

// Ambil ID tugas dari URL

$tugas_id = isset($_GET['id']) ? $_GET['id'] : '';


// Jika ID tidak ada, redirect ke halaman sebelumnya

if (!$tugas_id) {

    header("Location: tugas.php");

    exit;

}


// Ambil data tugas berdasarkan ID

$query = "SELECT tugas.*, user.nama as nama_user, laporan.tanggal_upload, laporan.file_tugas, laporan.status_pengerjaan, laporan.komentar 

          FROM tugas 

          LEFT JOIN user ON tugas.user_id = user.id 

          LEFT JOIN laporan ON tugas.id = laporan.tugas_id 

          WHERE tugas.id = '$tugas_id'";


$result = $conn->query($query);


if ($result->num_rows == 0) {

    die("Tugas tidak ditemukan!");

}


$tugas = $result->fetch_assoc();


// Menggunakan variabel sesuai permintaan

$proyek_id = $tugas['proyek_id'];

$nama_tugas = $tugas['nama_tugas'];

$tanggal_mulai = $tugas['tanggal_mulai'];

$divisi = $tugas['divisi'];

$deadline = $tugas['deadline'];

$deskripsi = $tugas['deskripsi'];

$status_tugas = $tugas['status_pengerjaan']; // Menggunakan status_pengerjaan dari laporan

$user_id = $tugas['user_id'];

$nama_user = $tugas['nama_user'];

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
    <table class="table table-bordered">
        <tr>
            <th>Nama Pegawai</th>
            <td><?php echo htmlspecialchars($tugas['nama_user']); ?></td>
        </tr>
        <tr>
            <th>Nama Tugas</th>
            <td><?php echo htmlspecialchars($tugas['nama_tugas']); ?></td>
        </tr>
        <tr>
            <th>Tanggal Upload</th>
            <td><?php echo htmlspecialchars($tugas['tanggal_upload']); ?></td>
        </tr>
        <tr>
            <th>File Tugas</th>
            <td>
                <?php if ($tugas['file_tugas']): ?>
                    <a href="../uploads/<?php echo htmlspecialchars($tugas['file_tugas']); ?>" target="_blank">Lihat File</a>
                <?php else: ?>
                    Tidak ada file yang diunggah.
                <?php endif; ?>
            </td>
            <td>
                            <button class="btn btn-primary" onclick="openPreviewModal('../upload/<?= $row['file'] ?>')">Preview</button>
                        </td>
        </tr>
        <tr>
            <th>Status Pengerjaan</th>
            <td><?php echo htmlspecialchars($tugas['status_pengerjaan']); ?></td>
        </tr>
        <tr>
            <th>Komentar</th>
            <td><?php echo htmlspecialchars($tugas['komentar']); ?></td>
        </tr>
    </table>

    <div class="modal fade" id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="previewModalLabel">Preview File</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <canvas id="pdfCanvas"></canvas>
                    <img id="imagePreview" class="img-fluid" alt="Preview Image">
                    <iframe id="iframePreview"></iframe>
                    <pre id="textPreview"></pre>
                </div>
            </div>
        </div>
    </div>
</div>


    <a href="tugas.php" class="btn btn-secondary">Kembali</a>
</div>

<script>
    function openPreviewModal(fileUrl) {
    let fileExtension = fileUrl.split('.').pop().toLowerCase();
    let modalBody = document.querySelector(".modal-body");

    if (fileExtension === 'pdf') {
        modalBody.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px"></iframe>`;
    } else if (['doc', 'docx', 'xls', 'xlsx'].includes(fileExtension)) {
        modalBody.innerHTML = `<iframe src="https://docs.google.com/gview?url=${fileUrl}&embedded=true" width="100%" height="500px"></iframe>`;
    } else {
        modalBody.innerHTML = `<p>Preview tidak tersedia untuk jenis file ini.</p>`;
    }

    let previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
    previewModal.show();
}
function openPreviewModal(fileUrl) {
        let fileExtension = fileUrl.split('.').pop().toLowerCase();

        if (fileExtension === 'pdf') {
            let modalBody = document.querySelector(".modal-body");
            modalBody.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px"></iframe>`;
        } else {
            alert("Preview tidak tersedia untuk file selain PDF.");
        }

        let previewModal = new bootstrap.Modal(document.getElementById("previewModal"));
        previewModal.show();
    }
    function openPreviewModal(fileUrl) {
    let fileExtension = fileUrl.split('.').pop().toLowerCase();
    let modalBody = document.querySelector('.modal-body');

    modalBody.innerHTML = ''; // Hapus preview sebelumnya

    if (fileExtension === 'pdf') {
        modalBody.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px"></iframe>`;
    } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileExtension)) {
        modalBody.innerHTML = `<img src="${fileUrl}" width="100%" height="auto">`;
    } else if (fileExtension === 'txt') {
        modalBody.innerHTML = `<iframe src="${fileUrl}" width="100%" height="500px"></iframe>`;
    } else {
        modalBody.innerHTML = `<p>File tidak dapat dilihat. Silakan <a href="${fileUrl}" target="_blank">download</a> file.</p>`;
    }

    new bootstrap.Modal(document.getElementById('previewModal')).show();
}
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>