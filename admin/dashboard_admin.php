<?php
session_start();
include '../koneksi.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php"); 
    exit();
}

$user_id = $_SESSION['user_id'];
$divisi = $_SESSION['divisi']; // Divisi yang diambil dari sesi login

// Query untuk mengambil daftar proyek berdasarkan divisi user
$query_proyek = "SELECT * FROM proyek WHERE divisi = '$divisi'";
$result_proyek = $conn->query($query_proyek);

// Query untuk mengambil daftar tugas berdasarkan user_id dan divisi
$query_tugas = "SELECT tugas.*, proyek.nama AS proyek_nama FROM tugas
                JOIN proyek ON tugas.proyek_id = proyek.id
                WHERE tugas.user_id = '$user_id' AND proyek.divisi = '$divisi'";

$result_tugas = $conn->query($query_tugas);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>

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
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li> <a href="dashboard_admin.php" class="active"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li> <a href="proyek.php"> <img src="../image/reading-book (1).png" alt="">&nbsp;<span>Tambah Proyek</span></a></li>
            <li> <a href="daftar_proyek.php"> <img src="../image/planning.png" alt="">&nbsp;<span>Daftar Proyek</span></a></li>
            <li> <a href="preview.php"> <img src="../image/website(1).png" alt="">&nbsp;<span>Preview</span></a></li>
            <li> <a href="../logout.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
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
        
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Chart</h2>
                        <a href="#" class="btn">Lihat detail</a>
                    </div>
                    <table>
                        <tr>

                        </tr>
                        <tr>
                     
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>