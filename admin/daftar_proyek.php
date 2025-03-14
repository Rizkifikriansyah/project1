<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil parameter divisi dari URL
$divisi = isset($_GET['divisi']) ? $_GET['divisi'] : '';

// Query untuk mengambil proyek berdasarkan divisi
if ($divisi) {
    $query = "SELECT * FROM proyek WHERE divisi = '$divisi'";
} else {
    $query = "SELECT * FROM proyek"; // Jika divisi tidak dipilih, tampilkan semua proyek
}
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Daftar Tugas</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,700;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            min-height: 100vh;
            background-color: #f4f4f4;
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
            font-weight: bold;
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
            width: 100%;
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
            padding-top: 10px; /* Tambahkan padding atas */
        }

        .side-menu .brand-name{
        text-align: center;
        color: white;
        font-size: 24px;
        font-weight: bold;
    }

        .side-menu ul {
            padding: 0;
        }

        .side-menu li a {
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

        .side-menu li a.active {
            background: #d32f2f;
        }

        .side-menu li a:hover {
            background: #d32f2f;
        }

        .container {
        margin: auto;
        position: absolute;
        right: 0;
        width: 80vw;
        height: 100vh;
        background: #f1f1f1;
}

        .container-content {
            margin-left: 20vw;
            width: calc(100% - 20vw);
            padding: 20px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 20vw;
            width: calc(100% - 20vw);
            height: 75px;
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

        .table-container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            margin-top: 80px;
        }
    </style>
</head>
<body>
<div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li> <a href="dashboard_admin.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li> <a href="proyek.php"> <img src="../image/reading-book (1).png" alt="">&nbsp;<span>Tambah Proyek</span></a></li>
            <li> <a href="daftar_proyek.php" class="active"> <img src="../image/planning.png" alt="">&nbsp;<span>Daftar Proyek</span></a></li>
            <li> <a href="preview.php"> <img src="../image/website(1).png" alt="">&nbsp;<span>Preview</span></a></li>
            <li> <a href="../logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>

    <div class="container">
       <div class="header">
           <div class="nav">
               <div class="content">
                   <a class="navbar-brand bordered-title" href="#">Daftar Proyek</a>
               </div>
           </div>
       </div>

    <div class="table-container">
        <table class="table table-bordered">
            <thead class="table-dark">
            <tr>
                <th>No</th>
                <th>Nama Proyek</th>
                <th>Divisi</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$no}</td>
                            <td>{$row['nama']}</td>
                            <td>{$row['divisi']}</td>
                            <td>{$row['deskripsi']}</td>
                            <td>
                                <a href='tugas.php?proyek_id={$row['id']}' class='btn btn-primary btn-sm'>Daftar Tugas</a>
                            </td>
                        </tr>";
                    $no++;
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>Tidak ada data proyek</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
