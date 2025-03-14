<?php
// Koneksi ke database
include '../koneksi.php';
session_start();

// Ambil divisi user yang sedang login
$user_id = $_SESSION['user_id'];
$divisi = $_SESSION['divisi'];

// Query untuk mengambil proyek berdasarkan divisi user
$query_proyek = "SELECT * FROM proyek WHERE divisi = '$divisi'";
$result_proyek = $conn->query($query_proyek);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
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
    }
    h2{
        color: #444;
    }

    h3{
        color: #999;
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
        .container {
            position: absolute;
            right: 0;
            width: 80vw;
            height: 100vh;
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
            z-index: 10;
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

    .container .content {
        margin-top: 10vh;
        padding: 20px;
    }

    .table-container {
        background: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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

    .container .content{
        position: relative;
        margin-top: 10vh;
        min-height: 90vh;
        background: #f1f1f1;
    }

    .container .content .cards{
        padding: 20px 15px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
    }

    .container .content .cards .card{
        width: 350px;
        height: 150px;
        background: white;
        margin: 20px 10px;
        display: flex;
        align-items: center;
        justify-content: space-around;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
    }

    .container .content .content-2{
        min-height: 60vh;
        display: flex;
        justify-content: space-around;
        align-items: flex-start;
        flex-wrap: wrap;
    } 

    .container .content .content-2 .recent-payments{
        min-height: 50vh;
        flex: 5;
        background: white;
        margin: 0 25px 25px 25px;
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        display: flex;
        flex-direction: column;
    }

        th {
            background: #2c3e50 !important;
            color: white;
        }

        tbody tr:hover {
            background: #f1f1f1;
            transition: 0.3s;
        }

        .btn-info {
            background: #17a2b8;
            border: none;
            transition: 0.3s;
        }

        .btn-info:hover {
            background: #138496;
            transform: scale(1.05);
        }

        @media screen and (max-width: 1050px) {
        .side-menu li{
            font-size: 18px;
        }
    }

    @media screen and (max-width: 940px) {
        .side-menu li span{
            display: none;
        }
        .side-menu{
            align-items: center;
        }
        .side-menu li img{
            width: 40px;
            height: 40px;
        }
        .side-menu li:hover{
            background: #d32f2f;
            padding: 8px 38px;
            border: 2px solid white;
        }
    }
    @media screen and (max-width: 536px) {
        .brand-name h1{
            font-size: 14px;
        }
        .container .content .cards{
            justify-content: center;
        }
        .side-menu li img{
            width: 30px;
            height: 30px;
        }
        .container .content .content-2 .recent-payments table th:nth-child(2),
        .container .content .content-2 .recent-payments table td:nth-child(2){
            display: none;
        }
    }
    </style>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li><a href="dash_user.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li><a href="proyek.php" class="active"><img src="../image/reading-book (1).png">&nbsp;<span>Proyek Saya</span></a></li>
            <li><a href="../logout.php"><img src="../image/out.png">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <div class="nav">
                <h2>Proyek Saya</h2>
                <div class="user">
                    <a href="profil.php">
                        <div class="img-case">
                            <img src="<?php echo !empty($user['profil']) ? $user['profil'] : '../image/default-profile.png'; ?>" alt="Foto Profil" class="profile-pic">
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="content mt-5">
            <h2 class="mb-4 text-center text-dark">Daftar Proyek - Divisi <?php echo htmlspecialchars($divisi); ?></h2>
            <div class="table-container p-4 rounded shadow">
                <table class="table table-hover">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>No</th>
                            <th>Nama Proyek</th>
                            <th>Tanggal Mulai</th>
                            <th>Deskripsi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        if ($result_proyek->num_rows > 0) {
                            $no = 1;
                            while ($proyek = $result_proyek->fetch_assoc()) {
                                echo "<tr class='text-center align-middle'>
                                        <td>{$no}</td>
                                        <td class='fw-bold'>{$proyek['nama']}</td>
                                        <td>{$proyek['tanggal_mulai']}</td>
                                        <td class='text-muted'>{$proyek['deskripsi']}</td>
                                        <td>
                                            <a href='tugas.php?proyek_id={$proyek['id']}' class='btn btn-info btn-sm text-white fw-bold'>Lihat Tugas</a>
                                        </td>
                                      </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='5' class='text-center text-danger fw-bold'>Tidak ada proyek untuk divisi ini</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>