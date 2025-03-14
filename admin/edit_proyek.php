<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil ID proyek dari URL
$id = isset($_GET['id']) ? $_GET['id'] : '';

// Jika ID tidak ada, redirect ke halaman proyek
if (!$id) {
    header("Location: proyek.php");
    exit;

}


// Ambil data proyek berdasarkan ID

$query = "SELECT * FROM proyek WHERE id = '$id'";

$result = $conn->query($query);


if ($result->num_rows == 0) {

    die("Proyek tidak ditemukan!");

}


$proyek = $result->fetch_assoc();


// Proses form jika ada pengiriman data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $nama = $_POST['nama'];

    $tanggal_mulai = $_POST['tanggal_mulai'];

    $divisi = $_POST['divisi'];

    $deskripsi = $_POST['deskripsi'];


    // Update data proyek

    $update_query = "UPDATE proyek SET nama = '$nama', tanggal_mulai = '$tanggal_mulai', divisi = '$divisi', deskripsi = '$deskripsi' WHERE id = '$id'";

    

    if ($conn->query($update_query) === TRUE) {

        header("Location: proyek.php?status=success");

        exit;

    } else {

        echo "Error updating record: " . $conn->error;

    }

}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Data Proyek</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css"
    rel="stylesheet" />
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        min-height: 100vh;
        display: flex;
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

    .title{
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 15px 10px;
        border-bottom: 2px solid #999;
    }


    .side-menu {
        position: fixed;
    background: #333;
    width: 20vw;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding-top: 5px; /* Tambahkan padding atas */
    }

    .side-menu .brand-name {
        text-align: center;
        color: white;
        font-size: 45px;
        font-weight: bold;
    }

    .side-menu ul {
        
        padding: 0;
    }

    .side-menu li a{
        font-size: 16px;
        padding: 10px 40px;
        color: white;
        display: flex;
        align-items: center;
    }

    .side-menu li a img {
        width: 20px;
        margin-right: 10px;
    }

    .side-menu li a.active{
        background: #d32f2f;
    }

    .side-menu li a:hover{
        background: #d32f2f;
    }

    .header {
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
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        z-index: 1000;
    }


    .container {
    position: absolute;
    top: 50%;
    left: 60%;
    transform: translate(-50%, -50%);
    width: 900px; /* Atur lebar */
    height: 500px; /* Atur tinggi */
    display: flex;
    flex-direction: column;
    justify-content: center;
    padding: 30px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}


/* CSS untuk judul dengan border */

.bordered-title {

font-size: 25px;

color: #000; 

text-decoration: none; /* Menghilangkan garis bawah */

font-weight: bold; /* Menebalkan teks */


}


    .btn-primary {
        background-color: #d32f2f;
        border: none;
    }

    .btn-primary:hover {
        background-color: black;
    }

    .form-control:focus {
        border-color: #d32f2f;
        box-shadow: 0 0 5px #d32f2f;
    }

    .form-label {
        font-weight: bold;
    }
    </style>
</head>
<body>

<div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li> <a href="dashboard_admin.php" ><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li> <a href="proyek.php" class="active"> <img src="../image/reading-book (1).png" alt="">&nbsp;<span>Tambah Proyek</span></a></li>
            <li> <a href="daftar_proyek.php"> <img src="../image/planning.png" alt="">&nbsp;<span>Daftar Proyek</span></a></li>
            <li> <a href="preview.php"> <img src="../image/website(1).png" alt="">&nbsp;<span>Preview</span></a></li>
            <li> <a href="../logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>

<div class="header">
    <div class="content">
        <a class="navbar-brand bordered-title" href="#">Input Proyek</a>
    </div>

</div>

<div class="container mt-5">

    <h2>Edit Proyek</h2>

    <form method="POST" action="">

        <div class="mb-3">

            <label for="nama" class="form-label">Nama Proyek</label>

            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($proyek['nama']); ?>" required>

        </div>

        <div class="mb-3">

            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>

            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo htmlspecialchars($proyek['tanggal_mulai']); ?>" required>

        </div>

        <div class="mb-3">

            <label for="divisi" class="form-label">Divisi</label>

            <input type="text" class="form-control" id="divisi" name="divisi" value="<?php echo htmlspecialchars($proyek['divisi']); ?>" required>

        </div>

        <div class="mb-3">

            <label for="deskripsi" class="form-label">Deskripsi</label>

            <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" required><?php echo htmlspecialchars($proyek['deskripsi']); ?></textarea>

        </div>

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>

        <a href="proyek.php" class="btn btn-secondary">Kembali</a>

    </form>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
