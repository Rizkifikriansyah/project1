<?php include '../koneksi.php'; ?>
<?php
// Inisialisasi variabel
$nama = "";
$tanggal_mulai = "";
$deskripsi = "";
$divisi = "";
$error = "";
$sukses = "";

// Mendapatkan ID dari URL jika ada
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM proyek WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $r1 = $result->fetch_assoc();

    if ($r1) {
        $nama = $r1['nama'];
        $tanggal_mulai = $r1['tanggal_mulai'];
        $deskripsi = $r1['deskripsi'];
        $divisi = $r1['divisi'];
    } else {
        $error = "Data tidak ditemukan";
    }
    $stmt->close();
}

// Proses penyimpanan data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $tanggal_mulai = trim($_POST['tanggal_mulai']);
    $deskripsi = trim($_POST['deskripsi']);
    $divisi = trim($_POST['divisi']);

    if (empty($nama) || empty($deskripsi) || empty($divisi)) {
        $error = "Silahkan masukkan semua data (nama, deskripsi, divisi)";
    } else {
        if ($id > 0) {
            $stmt = $conn->prepare("UPDATE proyek SET nama = ?, tanggal_mulai = ?, deskripsi = ?, divisi = ? WHERE id = ?");
            $stmt->bind_param("ssssi", $nama, $tanggal_mulai, $deskripsi, $divisi, $id);
        } else {
            $stmt = $conn->prepare("INSERT INTO proyek (nama, tanggal_mulai, deskripsi, divisi) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $nama, $tanggal_mulai, $deskripsi, $divisi);
        }

        if ($stmt->execute()) {
            $sukses = "Sukses menyimpan data";
        } else {
            $error = "Gagal menyimpan data: " . $stmt->error;
        }
        $stmt->close();
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

<div class="container">
    <form action="" method="post">
        <div class="mb-3 row">
            <label for="nama" class="col-sm-2 col-form-label">Nama</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="nama" name="nama" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="tanggal_mulai" class="col-sm-2 col-form-label">Tanggal Mulai</label>
            <div class="col-sm-10">
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="divisi" class="col-sm-2 col-form-label">Divisi</label>
            <div class="col-sm-10">
                <select id="divisi" name="divisi" class="form-select" required>
                    <option value="" disabled selected>-- Pilih Divisi --</option>
                    <option value="Inovasi">Inovasi</option>
                    <option value="Riset">Riset</option>
                    <option value="Kreatif">Kreatif</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="deskripsi" class="col-sm-2 col-form-label">Deskripsi</label>
            <div class="col-sm-10">
                <textarea name="deskripsi" class="form-control" id="deskripsi" required></textarea>
            </div>
        </div>
        <div class="mb-3 row">
            <div class="col-sm-10 offset-sm-2">
                <a href="proyek.php" class="btn btn-secondary">Kembali</a>
                <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary">
            </div>
        </div>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
