<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil parameter divisi dari URL
$currentDivisi = isset($_GET['divisi']) ? $_GET['divisi'] : '';

// Proses saat form disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $divisi = $_POST['divisi'];

    // Hash password dengan bcrypt
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Menyimpan data pengguna ke dalam database
    $query = "INSERT INTO user (nama, username, password, role, divisi) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sssss', $nama, $username, $hashed_password, $role, $divisi);


    if ($stmt->execute()) {
        // Pengguna berhasil ditambahkan, redirect kembali ke halaman dengan divisi yang sama dan status success
        header("Location: kelola_pengguna.php?divisi=$currentDivisi&status=success");
        exit();
    } else {
        // Jika gagal menambahkan pengguna
        echo "<script>alert('Gagal menambahkan pengguna!');</script>";
    }
}

// Filter berdasarkan divisi jika ada
$query = "SELECT * FROM user WHERE role IN ('admin', 'user')";
if ($currentDivisi) {
    $query .= " AND divisi = '$currentDivisi'";
}

// Ambil data pengguna untuk ditampilkan
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Pengguna</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- SweetAlert2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,700;1,900&display=swap" rel="stylesheet">
    
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
        font-weight: bold;
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

        .btn-secondary{
            background: #444;
            color: white;
            padding: 5px 10px;
            text-align: center;
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
        margin: 20px auto;
    }

    .table th,td{
        text-align: left;
        padding: 10px;
     

    text-align: center; /* Memusatkan teks sel */
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
        z-index: 100;
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
    #form-container {
    display: none; /* Awalnya form disembunyikan */
    margin-top: 40px;
    margin-left: 70px;
    border: 1px solid #ddd; /* Border untuk form */
    padding: 35px; /* Padding di dalam form */
    background-color: #fff; /* Warna latar belakang form */
    border-radius: 10px; /* Sudut melengkung untuk form */
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Bayangan untuk form */
    transition: all 0.3s ease; /* Transisi halus saat muncul */
}

#form-container h3 {
    margin-bottom: 20px; /* Jarak bawah untuk judul form */
    color: #d32f2f; /* Warna judul form */
    font-weight: bold; /* Membuat judul lebih tebal */
    text-align: center; /* Memusatkan judul */
}

.form-label {
    font-weight: bold; /* Membuat label lebih tebal */
    color: #444; /* Warna label */
}

.form-control {
    border: 1px solid #ccc; /* Border untuk input */
    border-radius: 5px; /* Sudut melengkung untuk input */
    transition: border-color 0.3s; /* Transisi halus saat fokus */
}

.form-control:focus {
    border-color: #d32f2f; /* Warna border saat fokus */
    box-shadow: 0 0 5px rgba(211, 47, 47, 0.5); /* Bayangan saat fokus */
}


        #content-container {
            display: block; /* Konten utama tampil secara default */
        }
    </style>
</head>
<body>

<div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li> <a href="dash_supervisor.php" class="active"><img src="../image/dashboard (2).png">&nbsp;<span>Kembali ke Dashboard</span></a></li>
            <li> <a href="proyek.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <h2>Kelola Pengguna</h2> 
                <div class="user">
                    <a href="profil.php">
                        <div class="img-case">
                            <img src="../image/user.png" alt="">
                        </div>
                    </a>

                </div>
            </div>
        </div>


            
            <!-- Main Content -->
            <div class="col-md-10">
                <h2 class="my-4">Kelola Pengguna Divisi <?php echo $currentDivisi ?></h2>

                <!-- Konten Utama -->
                <div id="content-container">
                    <!-- Tabel Pengguna -->
                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Divisi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>{$no}</td>
                                    <td>{$row['nama']}</td>
                                    <td>{$row['username']}</td>
                                    <td>{$row['role']}</td>
                                    <td>{$row['divisi']}</td>
                                    <td><a href='hapus_pengguna.php?id={$row['id']}&divisi=$currentDivisi' class='btn btn-danger btn-sm'>Hapus</a></td>
                                </tr>";
                                $no++;
                            }
                            ?>
                        </tbody>
                    </table>

                    <!-- Tombol untuk Menampilkan Form -->
                    <button class="btn btn-primary" id="toggle-form-btn">Tambah Pengguna Baru</button>
                </div>

                <!-- Form Tambah Pengguna -->
                <div id="form-container">
                    <h3>Tambah Pengguna Baru</h3>
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama" id="nama" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select name="role" id="role" class="form-select" required>
                                <option value="admin">Admin</option>
                                <option value="user">User</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="divisi" class="form-label">Divisi</label>
                            <select name="divisi" id="divisi" class="form-select" required>
                                <option value="Riset" <?php echo $currentDivisi == 'Riset' ? 'selected' : ''; ?>>Riset</option>
                                <option value="Inovasi" <?php echo $currentDivisi == 'Inovasi' ? 'selected' : ''; ?>>Inovasi</option>
                                <option value="Kreatif" <?php echo $currentDivisi == 'Kreatif' ? 'selected' : ''; ?>>Kreatif</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Tambah Akun</button>
                        <button type="button" class="btn btn-secondary" id="hide-form-btn">Kembali</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Mengecek apakah ada parameter 'status' di URL
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        // Jika status = 'success', tampilkan notifikasi
        if (status === 'success') {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Pengguna baru telah ditambahkan.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        }

        // JavaScript untuk mengatur visibilitas form dan konten utama
        const toggleFormBtn = document.getElementById('toggle-form-btn');
        const formContainer = document.getElementById('form-container');
        const contentContainer = document.getElementById('content-container');
        const hideFormBtn = document.getElementById('hide-form-btn');

        toggleFormBtn.addEventListener('click', () => {
            contentContainer.style.display = 'none'; // Sembunyikan konten utama
            formContainer.style.display = 'block';   // Tampilkan form
        });

        hideFormBtn.addEventListener('click', () => {
            formContainer.style.display = 'none';    // Sembunyikan form
            contentContainer.style.display = 'block'; // Tampilkan konten utama
        });
    </script>
</body>
</html>
