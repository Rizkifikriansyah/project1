<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil parameter ID tugas dari URL
$id_tugas = isset($_GET['id']) ? $_GET['id'] : '';

if (!$id_tugas) {
    die("ID Tugas tidak ditemukan!");
}

// Ambil data tugas berdasarkan ID
$query = "SELECT tugas.*, proyek.divisi FROM tugas
          JOIN proyek ON tugas.proyek_id = proyek.id
          WHERE tugas.id = '$id_tugas'";
$result = $conn->query($query);
$tugas = $result->fetch_assoc();

if (!$tugas) {
    die("Tugas tidak ditemukan!");
}

// Inisialisasi variabel untuk pesan sukses dan error
$sukses = "";
$error = "";

// Proses form saat disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_tugas   = $_POST['nama_tugas'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $deadline     = $_POST['deadline'];
    $divisi       = $_POST['divisi'];
    $deskripsi    = $_POST['deskripsi'];

    // Validasi input
    if ($nama_tugas && $tanggal_mulai && $deadline && $divisi && $deskripsi) {
        // Update data tugas di database
        $sql = "UPDATE tugas SET nama_tugas = '$nama_tugas', tanggal_mulai = '$tanggal_mulai', deadline = '$deadline', divisi = '$divisi', deskripsi = '$deskripsi' WHERE id = '$id_tugas'";
        $q1 = mysqli_query($conn, $sql);
        
        if ($q1) {
            // Jika berhasil, alihkan ke halaman edit dengan status=success
            header("Location: edit_tugas.php?id=$id_tugas&status=success");
            exit();
        } else {
            // Jika gagal, alihkan ke halaman edit dengan status=error
            header("Location: edit_tugas.php?id=$id_tugas&status=error");
            exit();
        }
    } else {
        $error = "Harap mengisi semua data tugas.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tugas</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <style>

        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    min-height: 100vh;
    background-color: #f8f9fa; /* Warna latar belakang yang lebih cerah */
}

a {
    text-decoration: none;
}

li {
    list-style: none;
}

h1 {
    color: #f1f1f1;
    font-weight: bold;
}

h2 {
    color: #444;
}

h3 {
    color: #999;
}

.btn-proyek {
    background-color: #d32f2f;
    color: white;
    padding: 5px 10px;
    text-align: center;
    display: inline-block;
    text-decoration: none;
    border: 2px solid transparent;
    margin-top: 15px;
}

.btn-proyek:hover {
    background-color: white;
    color: #d32f2f;
    padding: 5px 10px; /* Tetap sama agar ukuran tidak berubah */
    border: 2px solid #d32f2f;
}

.title{
        display: flex;
        align-items: center;
        justify-content: space-around;
        padding: 15px 10px;
        border-bottom: 2px solid #999;
        font-weight: bold;
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
    padding-top: 20px; /* Tambahkan padding atas */
}


.side-menu ul {
    padding: 0;
}

.side-menu li {
    width: 100%;
}


    .side-menu .brand-name{
        text-align: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
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

        .container {
            position: absolute;
            right: 0;
            width: 80vw;
            height: 100vh;
            background: #f1f1f1;
            padding-top: 10vh; /* Menambahkan padding atas untuk header */
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
            z-index: 2;
        }

 

        .bordered-title {

font-size: 25px;

color: #000; 

text-decoration: none; /* Menghilangkan garis bawah */

font-weight: bold; /* Menebalkan teks */


}
        
        .form-container {

background: #fff;



padding: 30px;

border-radius: 8px;

box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);

border: 1px solid #ddd; /* Border untuk form */

}


.form-label {

font-weight: bold; /* Menebalkan label */

}



        .btn-custom {
            background-color: #d32f2f;
            color: #fff;
        }

        .btn-custom:hover {
            background-color: #555;
        }
    </style>
</head>
<body>

<!-- Side Menu -->
<div class="side-menu">
    <div class="brand-name">
        <h1>BRIDA</h1>
    </div>
    <ul>
        <li><a href="dashboard_admin.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
        <li><a href="proyek.php" class="active"><img src="../image/reading-book (1).png" alt="">&nbsp;<span>Proyek</span></a></li>
        <li><a href="logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
    </ul>
</div>

<!-- Header -->
<div class="header">
    <div class="nav">
        <div class="content">
            <h2 class="navbar-brand bordered-title">Edit Tugas</h2>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="form-container">

                <!-- Pesan sukses atau error -->
                <?php if ($sukses): ?>
                    <div class="alert alert-success"><?php echo $sukses; ?></div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>

                <!-- Form edit tugas -->
                <form method="post">
                    <div class="mb-3">
                        <label for="nama_tugas" class="form-label">Nama Tugas</label>
                        <input type="text" class="form-control" id="nama_tugas" name="nama_tugas" value="<?php echo htmlspecialchars($tugas['nama_tugas']); ?>" placeholder="Masukkan nama tugas">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?php echo htmlspecialchars($tugas['tanggal_mulai']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline</label>
                        <input type="date" class="form-control" id="deadline" name="deadline" value="<?php echo htmlspecialchars($tugas['deadline']); ?>">
                    </div>
                    <div class="mb-3">
                        <label for="divisi" class="form-label">Divisi</label>
                        <input type="text" class="form-control" id="divisi" name="divisi" value="<?php echo htmlspecialchars($tugas['divisi']); ?>" placeholder="Masukkan divisi" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" placeholder="Masukkan deskripsi tugas"><?php echo htmlspecialchars($tugas['deskripsi']); ?></textarea>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-custom">Simpan</button>
                        <a href="tugas.php?proyek_id=<?php echo $tugas['proyek_id']; ?>" class="btn btn-secondary">Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- SweetAlert2 JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
<script>
    // Mengecek apakah ada parameter 'status' di URL
    const urlParams = new URLSearchParams(window.location.search);
    const status = urlParams.get('status');

    // Jika status = 'success', tampilkan notifikasi
    if (status === 'success') {
        Swal.fire({
            title: 'Berhasil!',
            text: 'Tugas berhasil diperbarui.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    } else if (status === 'error') {
        Swal.fire({
            title: 'Gagal!',
            text: 'Terjadi kesalahan saat memperbarui tugas.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    }
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>