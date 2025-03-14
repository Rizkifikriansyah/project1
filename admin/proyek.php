<?php
// Konfigurasi database
include '../koneksi.php'; 

// Variabel untuk menampilkan pesan sukses
$sukses = "";

// Mendapatkan kata kunci pencarian (jika ada)
$katakunci = (isset($_GET['katakunci'])) ? $_GET['katakunci'] : "";

// Mendapatkan operasi (delete, dll.)
$op = (isset($_GET['op'])) ? $_GET['op'] : "";

// Hapus data jika operasi adalah delete
if ($op == 'delete') {
   $id = $_GET['id'];
   $sql1 = "DELETE FROM proyek WHERE id = '$id'";
   $q1 = mysqli_query($conn, $sql1);
   if ($q1) {
       $sukses = "Berhasil menghapus data.";
   }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Admin Proyek</title>

   <link rel="preconnect" href="https://fonts.googleapis.com">
   <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
   <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
   <!-- Bootstrap CSS -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
   <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet" />
   <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,700;1,900&display=swap" rel="stylesheet">

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

.header .nav {
    width: 90%;
    display: flex;
    align-items: center;
}

.header .nav .content {
    flex: 1;
}

.header .nav .user {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-left: 750px; /* Menambahkan jarak antara judul dan gambar pengguna */
}

.header .nav .user .img-case {
    position: relative;
        width: 50px;
        height: 50px;
}

.header .nav .user .img-case img {
    position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
}

/* CSS untuk judul dengan border */

.bordered-title {
font-size: 25px;
color: #000; 
text-decoration: none; /* Menghilangkan garis bawah */
font-weight: bold; /* Menebalkan teks */
}

.alert {
    margin-top: 20px;
}

.btn-danger {
    background-color: #d32f2f; /* Warna latar belakang */
    border: none; /* Menghilangkan border */
    transition: background-color 0.3s; /* Transisi halus */   
}
.btn-danger:hover {
    background-color: rgb(0, 0, 0); /* Warna lebih gelap saat hover */
}

.table th, .table td {
    vertical-align: middle;
}

.pagination .page-item.active .page-link {
    background-color: #d32f2f; /* Warna latar belakang untuk halaman aktif */
    border-color: #d32f2f; /* Border untuk halaman aktif */
}

.pagination .page-link {
    color: #000; /* Warna link */
}

.pagination .page-link:hover {
    background-color: #d32f2f; /* Warna saat hover */
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
       
   <!-- Main Content -->
   <div class="container">
       <div class="header">
           <div class="nav">
               <div class="content">
                   <a class="navbar-brand bordered-title" href="#">Tambah Proyek</a>
               </div>
           </div>
       </div>

       <div class="content" style="margin-top: 10vh;"> <!-- Tambahkan margin untuk menghindari header -->
           <!-- Pesan sukses -->
           <?php if ($sukses): ?>
               <div class="alert alert-success"><?php echo $sukses; ?></div>
           <?php endif; ?>

           <!-- Tombol buat proyek baru -->
           <div class="mb-3">
                <a href="tambah_proyek.php" class="btn-proyek">Buat Proyek Baru</a>
            </div>


           <!-- Form pencarian -->
           <form class="row g-3 mb-4" method="get">
               <div class="col-auto">
                   <input type="text" class="form-control" placeholder="Cari Proyek" name="katakunci" value="<?php echo htmlspecialchars($katakunci); ?>">
               </div>
               <div class="col-auto">
                   <button type="submit" class="btn btn-secondary"><i class="ri-search-line"></i></button>
               </div>
           </form>

           <!-- Tabel data -->
           <table class="table table-striped table-bordered">
               <thead class="table-primary">
                   <tr>
                       <th class="text-center col-1">No</th>
                       <th>Proyek</th>
                       <th>Tanggal Mulai</th>
                       <th>Divisi</th>
                       <th>Deskripsi</th>
                       <th class="text-center col-2">Aksi</th>
                   </tr>
               </thead>
               <tbody>
                   <?php
                   $sqltambahan = "";
                   $per_halaman = 5;

                   // Pencarian
                   if ($katakunci != '') {
                       $array_katakunci = explode(" ", $katakunci);
                       foreach ($array_katakunci as $kata) {
                           $sqlcari[] = "(nama LIKE '%" . mysqli_real_escape_string($conn, $kata) . "%' OR deskripsi LIKE '%" . mysqli_real_escape_string($conn, $kata) . "%')";
                       }
                       $sqltambahan = " WHERE " . implode(" OR ", $sqlcari);
                   }

                   // Pagination
                   $sql1 = "SELECT * FROM proyek $sqltambahan";
                   $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                   $mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;
                   $q1 = mysqli_query($conn, $sql1);
                   $total = mysqli_num_rows($q1);
                   $pages = ceil($total / $per_halaman);
                   $nomor = $mulai + 1;

                   $sql1 .= " ORDER BY id DESC LIMIT $mulai, $per_halaman";
                   $q1 = mysqli_query($conn, $sql1);

                   // Tampilkan data
                   if ($q1 && mysqli_num_rows($q1) > 0) {
                       while ($r1 = mysqli_fetch_assoc($q1)) {
                           ?>
                           <tr>
                               <td class="text-center"><?php echo $nomor++; ?></td>
                               <td><?php echo htmlspecialchars($r1['nama']); ?></td>
                               <td><?php echo htmlspecialchars($r1['tanggal_mulai']); ?></td>
                               <td><?php echo htmlspecialchars($r1['divisi']); ?></td>
                               <td><?php echo htmlspecialchars($r1['deskripsi']); ?></td>
                               <td class="text-center">
                                   <div class="btn-group" role="group" aria-label="Aksi">
                                       <a href="add_tugas.php?id=<?php echo $r1['id']; ?>&divisi=<?php echo urlencode($r1['divisi']); ?>" class="btn btn-info btn-sm" title="Tambah Tugas">
                                           <i class="ri-add-circle-line"></i> Tugas
                                       </a>
                                       <a href="edit_proyek.php?id=<?php echo $r1['id']; ?>" class="btn btn-primary btn-sm" title="Edit Proyek">
                                           <i class="ri-edit-box-line"></i> Edit
                                       </a>
                                       <a href="proyek.php?op=delete&id=<?php echo $r1['id']; ?>" class="btn btn-danger btn-sm" title="Hapus Proyek" onclick="return confirm('Apakah Anda yakin untuk menghapus data ini?')">
                                           <i class="ri-delete-bin-line"></i> Hapus
                                       </a>
                                   </div>
                               </td>
                           </tr>
                           <?php
                       }
                   } else {
                       echo '<tr><td colspan="6" class="text-center">Tidak ada data ditemukan.</td></tr>';
                   }
                   ?>
               </tbody>
           </table>

           <!-- Pagination -->
           <nav aria-label="Page navigation">
               <ul class="pagination justify-content-center">
                   <?php for ($i = 1; $i <= $pages; $i++): ?>
                       <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                           <a class="page-link" href="proyek.php?katakunci=<?php echo urlencode($katakunci); ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                       </li>
                   <?php endfor; ?>
               </ul>
           </nav>
       </div>
   </div>
</body>
</html>