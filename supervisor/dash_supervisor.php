<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supervisor Dashboard</title>

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

/* Styling untuk kontainer utama */
.container .content .content-2 {
    min-height: 90vh;
    display: flex;
    justify-content: space-around;
    align-items: flex-start;
    flex-wrap: wrap;
    padding: 20px;
    gap: 20px;
}

/* Styling untuk recent-payments */
.container .content .content-2 .recent-payments {
    flex: 5;
    min-height: 50vh;
    background: #ffffff;
    border-radius: 10px;
    padding: 20px;
    margin: 0 25px 25px 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

/* Styling untuk judul dalam recent-payments */
.container .content .content-2 .recent-payments .title {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

.container .content .content-2 .recent-payments .title h2 {
    font-size: 22px;
    font-weight: bold;
    color: #333;
}

/* Styling untuk grafik canvas */
.container .content .content-2 .recent-payments canvas {
    margin-top: 15px;
    max-width: 100%;
    height: auto;
}

/* Styling untuk new-tugas */
.container .content .content-2 .new-tugas {
    flex: 2;
    background: #ffffff;
    min-height: 50vh;
    border-radius: 10px;
    padding: 20px;
    margin: 0 25px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2), 0 6px 20px rgba(0, 0, 0, 0.19);
    display: flex;
    flex-direction: column;
}

/* Styling untuk judul dalam new-tugas */
.container .content .content-2 .new-tugas .title h2 {
    font-size: 22px;
    font-weight: bold;
    color: #333;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

/* Styling untuk daftar aktivitas */
.container .content .content-2 .new-tugas ul {
    list-style: none;
    padding: 0;
    margin-top: 10px;
}

.container .content .content-2 .new-tugas ul li {
    background: #f8f9fa;
    padding: 12px;
    margin: 5px 0;
    border-radius: 5px;
    border-left: 4px solid #d32f2f;
    transition: 0.3s ease-in-out;
}

.container .content .content-2 .new-tugas ul li:hover {
    background: #e9ecef;
    transform: translateX(5px);
}

/* Responsif untuk ukuran layar kecil */
@media screen and (max-width: 768px) {
    .container .content .content-2 {
        flex-direction: column;
        align-items: center;
    }

    .container .content .content-2 .recent-payments,
    .container .content .content-2 .new-tugas {
        flex: 1;
        width: 90%;
        margin: 10px 0;
    }
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
            <li> <a href="dash_supervisor.php" class="active"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li> <a href="proyek.php"><img src="../image/out.png" alt="">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>
    <div class="container">
        <div class="header">
            <div class="nav">
                <h2>Dashboard Supervisor</h2> 
                <div class="user">
                    <a href="profil.php">
                        <div class="img-case">
                            <img src="../image/user.png" alt="">
                        </div>
                    </a>

                </div>
            </div>
        </div>
        
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h2>Divisi Inovasi</h2>
                        <a href="kelola_pengguna.php?divisi=Inovasi" class="btn">Kelola Pengguna</a>
                    </div>
                    <div class="icon-case">
                        <img src="../image/students.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Divisi Riset</h2>
                        <a href="kelola_pengguna.php?divisi=Riset" class="btn">Kelola Pengguna</a>
                    </div>
                    <div class="icon-case">
                        <img src="../image/teachers.png" alt="">
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Divisi Kreatif</h2>
                        <a href="kelola_pengguna.php?divisi=Kreatif" class="btn">Kelola Pengguna</a>
                    </div>
                    <div class="icon-case">
                        <img src="../image/camera.png" alt="">
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Chart</h2>
                        <a href="#" class="btn">Lihat detail</a>
                    </div>
                    <h6>Statistic</h6>
                        <canvas id="chart" height="300"></canvas>
                </div>

                <div class="new-tugas">
                    <div class="title">
                        <h2>Aktivitas</h2>
                    </div>
                    
                    <ul>
                            <li>Admin 1: Lorem ipsum dolor sit amet...</li>
                            <li>Admin 2: Lorem ipsum dolor sit amet...</li>
                            <li>Admin 3: Lorem ipsum dolor sit amet...</li>
                            <li>Admin 4: Lorem ipsum dolor sit amet...</li>
                        </ul>
                   
                </div>
            </div>
        </div>
    </div>

        <!-- Bootstrap JS and Chart.js -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Example chart data
        const ctx = document.getElementById('chart').getContext('2d');
        const chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Selesai', 'Belum'],
                datasets: [{
                    label: 'Gain',
                    data: [12, 19],
                    backgroundColor: ['#666666', '#333333'],
                    borderColor: ['#333333', '#000000'],
                    borderWidth: 1
                }]
            }
        });
    </script>
    
</body>
</html>