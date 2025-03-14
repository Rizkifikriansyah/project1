<?php
session_start();
include '../koneksi.php';

// Inisialisasi variabel
$sukses = "";
$error = "";

// Mendapatkan ID proyek yang dipilih sebelumnya
$id_proyek = isset($_GET['id']) ? $_GET['id'] : "";
// Ambil data proyek berdasarkan ID untuk ditampilkan di dropdown
$sql_proyek = "SELECT * FROM proyek WHERE id = '$id_proyek'";
$q_proyek = mysqli_query($conn, $sql_proyek);
$proyek = mysqli_fetch_assoc($q_proyek);

$divisi = isset($_GET['divisi']) ? $_GET['divisi'] : '';

$sql_users = "SELECT * FROM user WHERE divisi = '$divisi' AND role = 'user'";
$result_users = mysqli_query($conn, $sql_users);


// Jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_tugas   = mysqli_real_escape_string($conn, $_POST['nama_tugas']);
    $tanggal_mulai = mysqli_real_escape_string($conn, $_POST['tanggal_mulai']);
    $deadline     = mysqli_real_escape_string($conn, $_POST['deadline']);
    $id_proyek    = mysqli_real_escape_string($conn, $_POST['proyek_id']);
    $user_id      = mysqli_real_escape_string($conn, $_POST['user_id']);
    $deskripsi    = mysqli_real_escape_string($conn, $_POST['deskripsi']);

    // Validasi input
    if ($nama_tugas && $tanggal_mulai && $deadline && $id_proyek && $user_id && $deskripsi) {
        $sql = "INSERT INTO tugas (nama_tugas, tanggal_mulai, deadline, deskripsi, proyek_id, user_id) 
                VALUES ('$nama_tugas', '$tanggal_mulai', '$deadline', '$deskripsi', '$id_proyek', '$user_id')";
        $q1 = mysqli_query($conn, $sql);
        if ($q1) {
            $sukses = "Tugas berhasil ditambahkan.";
        } else {
            $error = "Gagal menambahkan tugas: " . mysqli_error($conn);
        }
    } else {
        $error = "Harap mengisi semua data tugas.";
    }
}

// Ambil daftar divisi dari database
$sql_divisi = "SELECT DISTINCT divisi FROM user";
$q_divisi = mysqli_query($conn, $sql_divisi);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tugas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,700;1,900&display=swap" rel="stylesheet">
</head>
<style>
    *{
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body{
        min-height: 100vh;
    }

    a{
        text-decoration: none;
    }

    li{
        list-style: none;
    }

    h1 {
        color: #f1f1f1;
    }
    h2{
        color: #444;
    }

    h3{
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

    .title{
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 15px 10px;
        border-bottom: 2px solid #999;
    }

    table{
        padding: 10px;
    }

    th,td{
        text-align: left;
        padding: 8px;
    }

    .side-menu{
        position: fixed;
    background: #333;
    width: 20vw;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    padding-top: 5px; /* Tambahkan padding atas */
    }

    .side-menu .brand-name{
        text-align: center;
        color: white;
        font-size: 22px;
        font-weight: bold;
    }

    .side-menu li a{
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

    .side-menu li a.active{
        background: #d32f2f;
    }

    .side-menu li a:hover{
        background: #d32f2f;
    }

    .container{
        position: absolute;
        right: 0;
        width: 80vw;
        height: 100vh;
        background: #f1f1f1;
    }

    .container .header{
        position: fixed;
        top: 0;
        right: 0;
        width: 80vw;
        height: 10vh;
        background: white;
        display: flex;
        align-items: center;
        justify-content: space-between; /* Menyelaraskan konten */
        padding: 0 20px; /* Menambahkan padding */
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        z-index: 10;
    }

    .container .header .nav{
        display: flex;
        align-items: center;
    }

    .container .header .nav h2 {
        margin-right: auto; /* Menambahkan margin untuk memisahkan judul dari user */
    }

    .container .header .nav .user {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 750px; /* Menambahkan jarak antara judul dan gambar pengguna */
}

    .container .header .nav .user .img{
        width: 40px;
        height: 40px;
    }

    .container .header .nav .user .img-case{
        position: relative;
        width: 50px;
        height: 50px;
    }

    .container .header .nav .user .img-case img{
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }

</style>
<body>
<div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li> <a href="dashboard_admin.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li> <a href="proyek.php" class="active"> <img src="../image/reading-book (1).png" alt="">&nbsp;<span>Tambah Proyek</span></a></li>
            <li> <a href="daftar_proyek.php"> <img src="../image/planning.png" alt="">&nbsp;<span>Daftar Proyek</span></a></li>
            <li> <a href="preview.php"> <img src="../image/website(1).png" alt="">&nbsp;<span>Preview</span></a></li>
            <li> <a href="../logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <h2>Tambah Tugas</h2> 
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
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-container">
                <?php if ($sukses): ?>
                    <div class="alert alert-success"><?php echo $sukses; ?></div>
                <?php endif; ?>
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="post">
                    <div class="mb-3">
                        <label for="id_proyek" class="form-label">Nama Proyek</label>
                        <select class="form-control" id="proyek_id" disabled>
                            <option value="<?php echo $proyek['id']; ?>" selected><?php echo htmlspecialchars($proyek['nama']); ?></option>
                        </select>
                        <input type="hidden" name="proyek_id" value="<?php echo $proyek['id']; ?>">
                    </div>
                    
                    <!-- Divisi dari database -->
                    <div class="mb-3">
                            <form method="post" action="proses_tambah_tugas.php">
                            <label for="divisi">Divisi</label>
                            <input type="text" class="form-control" name="divisi" id="divisi" value="<?php echo htmlspecialchars($divisi); ?>" readonly>
                    </div>
                    
                    <div class="mb-3">
                    <label for="user">Pilih User</label>
                    <select name="user_id" id="user_id" class="form-control">
                    <option value="">-- Pilih User --</option>
        <?php while ($row = mysqli_fetch_assoc($result_users)): ?>
            <option value="<?php echo $row['id']; ?>"><?php echo $row['nama']; ?></option>
        <?php endwhile; ?>
    </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="nama_tugas" class="form-label">Nama Tugas</label>
                        <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" placeholder="Masukkan nama tugas">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai">
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi tugas"></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="proyek.php" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        var divisi = $("#divisi").val(); // Ambil divisi saat halaman dimuat
        if (divisi) {
            loadUsers(divisi);
        }

        $("#divisi").change(function() {
            var divisi = $(this).val();
            loadUsers(divisi);
        });

        function loadUsers(divisi) {
            $.ajax({
                url: 'get_user_by_divisi.php',
                type: 'GET',
                data: { divisi: divisi },
                success: function(response) {
                    $('#user_id').html(response);
                }
            });
        }
    });
</script>


</body>
</html>
