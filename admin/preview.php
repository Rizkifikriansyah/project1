<?php
include '../koneksi.php';
$sql = "SELECT id, tanggal, id_user, id_proyek, id_tugas, file FROM preview";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Preview</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://mozilla.github.io/pdf.js/build/pdf.js"></script>
   <!-- Import PDF.js Express as a script tag from the lib folder using a relative path -->
<script src='/lib/webviewer.min.js'></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
        }

        a {
            text-decoration: none;
        }

        li {
            list-style: none;
        }

        h1 {
            color: #f1f1f1;
        }

        h2 {
            color: #444;
        }

        h3 {
            color: #999;
        }

        .btn {
            background: #d32f2f;
            color: white;
            padding: 5px 10px;
            text-align: center;
        }

        .btn:hover {
            color: #d32f2f;
            background-color: white;
            padding: 3px 8px;
            border: 2px solid #d32f2f;
        }

        .title {
            display: flex;
            align-items: center;
            justify-content: space-around;
            padding: 15px 10px;
            border-bottom: 2px solid #999;
        }

        table {
            padding: 10px;
        }

        th, td {
            text-align: left;
            padding: 8px;
        }

        .side-menu {
            position: fixed;
            background: #333;
            width: 20vw;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding-top: 5px;
        }

        .side-menu .brand-name {
            text-align: center;
            color: white;
            font-size: 22px;
            font-weight: bold;
        }

        .side-menu li a {
            font-size: 16px;
            padding: 10px 40px;
            color: white;
            display: flex;
            align-items: center;
        }

        .side-menu ul {
            padding: 0;
        }

        .side-menu li a img {
            width: 20px;
            margin-right: 10px;
        }

        .side-menu li a.active {
            background: #d32f2f;
        }

        .side-menu li a:hover {
            background: #d32f2f;
        }

        .container {
            position: absolute;
            right: 0;
            width: 80vw;
            height: 100vh;
            background: #f1f1f1;
        }

        .container .header {
            position: fixed;
            top: 0;
            right: 0;
            width: 80vw;
            height: 10vh;
            background: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            z-index: 10;
        }

        .container .header .nav {
            display: flex;
            align-items: center;
        }

        .container .header .nav h2 {
            margin-right: auto;
        }

        .container .header .nav .user {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-left: 750px;
        }

        .container .header .nav .user .img {
            width: 40px;
            height: 40px;
        }

        .container .header .nav .user .img-case {
            position: relative;
            width: 50px;
            height: 50px;
        }

        .container .header .nav .user .img-case img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            margin-bottom: 20px;
        }

        .table th, .table td {
            vertical-align: middle;
        }

        .table th {
            background-color: #343a40;
            color: white;
        }

        .table td {
            background-color: #f8f9fa;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        #pdfCanvas {
            border: 1px solid #ccc;
            margin-bottom: 20px;
        }

        .comment-section {
            width: 100%;
        }

        .comment-section textarea {
            width: 100%;
            height: 60px;
            margin-bottom: 10px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .comment-section button {
            width: 100%;
        }

        .comment {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 5px;
            width: 100%;
        }

        .reply {
            background: #f1f1f1;
            padding: 8px;
            border-radius: 5px;
            margin-left: 20px;
            margin-bottom: 5px;
        }
        .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #pdfViewer, #imagePreview, #textPreview, #iframePreview {
            display: none;
            width: 100%;
            max-height: 500px;
        }
        #pdfCanvas {
            border: 1px solid #ccc;
            width: 100%;
        }
        iframe {
            width: 100%;
            height: 500px;
        }
    </style>
</head>
<body>
<div class="side-menu">
    <div class="brand-name">
        <h1>BRIDA</h1>
    </div>
    <ul>
        <li><a href="dashboard_admin.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
        <li><a href="proyek.php"><img src="../image/reading-book (1).png" alt="">&nbsp;<span>Tambah Proyek</span></a></li>
        <li><a href="daftar_proyek.php"><img src="../image/planning.png" alt="">&nbsp;<span>Daftar Proyek</span></a></li>
        <li><a href="preview.php" class="active"><img src="../image/website(1).png" alt="">&nbsp;<span>Preview</span></a></li>
        <li><a href="../logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
    </ul>
</div>
<div class="container">
    <div class="header">
        <div class="nav">
            <h2>Dashboard Admin</h2>
            <div class="user">
                <a href="profil.php">
                    <div class="img-case">
                        <img src="<?php echo !empty($user['profil']) ? $user['profil'] : '../image/'; ?>" alt="Foto Profil" class="profile-pic">
                    </div>
                </a>
            </div>
        </div>
    </div>

    <div class="container mt-5">
    <h2 class="mb-3">Daftar File</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>ID User</th>
                <th>ID Proyek</th>
                <th>ID Tugas</th>
                <th>File</th>
                <th>Preview</th>
                <th>Download</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0) : ?>
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?= $row['id'] ?></td>
                        <td><?= $row['tanggal'] ?></td>
                        <td><?= $row['id_user'] ?></td>
                        <td><?= $row['id_proyek'] ?></td>
                        <td><?= $row['id_tugas'] ?></td>
                        <td><?= $row['file'] ?></td>
                        <td>
                            <button class="btn btn-primary" onclick="openPreviewModal('../upload/<?= $row['file'] ?>')">Preview</button>
                        </td>
                        <td>
                            <a href="../upload/<?= $row['file'] ?>" class="btn btn-success" download>Download</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr><td colspan="8" class="text-center">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Modal for Preview -->
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

<?php $conn->close(); ?>
</body>
</html>