<?php
// Koneksi ke database
include '../koneksi.php';

$proyek_id = isset($_GET['proyek_id']) ? $_GET['proyek_id'] : '';

if (!$proyek_id) {
    die("Proyek ID tidak ditemukan!");
}

// Menampilkan pesan sukses jika ada
if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <div class="alert alert-success" role="alert">
        File tugas berhasil diunggah!
    </div>
<?php endif; 

// Pagination
$per_halaman = 5; // Jumlah data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$mulai = ($page > 1) ? ($page * $per_halaman) - $per_halaman : 0;

// Query untuk menghitung total tugas
$total_query = "SELECT COUNT(*) as total FROM tugas WHERE proyek_id = '$proyek_id'";
$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total = $total_row['total'];
$pages = ceil($total / $per_halaman);

// Query untuk mengambil tugas berdasarkan proyek_id dengan pagination
$query = "SELECT tugas.*, proyek.divisi, laporan.id as laporan_id, user.nama as nama_user 
          FROM tugas
          JOIN proyek ON tugas.proyek_id = proyek.id
          LEFT JOIN laporan ON tugas.id = laporan.tugas_id
          LEFT JOIN user ON tugas.user_id = user.id
          WHERE tugas.proyek_id = '$proyek_id'
          ORDER BY tugas.id DESC LIMIT $mulai, $per_halaman";

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error); // Menangani error query
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Tugas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
            z-index: 10;
        }

        .content {
            margin-top: 10vh;
            padding: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .table th, .table td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .table th {
            background-color: #007bff;
            color: white;
        }

        .table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .btn {
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            transition: background 0.3s ease-in-out;
        }

        .btn-info {
            background: #17a2b8;
            color: white;
        }

        .btn-info:hover {
            background: #138496;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }
    </style>
</head>
<body>
    <div class="side-menu">
        <div class="brand-name">
            <h1>BRIDA</h1>
        </div>
        <ul>
            <li><a href="dashboard_admin.php"><img src="../image/dashboard (2).png">&nbsp;<span>Dashboard</span></a></li>
            <li><a href="proyek.php"><img src="../image/reading-book (1).png">&nbsp;<span>Tambah Proyek</span></a></li>
            <li><a href="daftar_proyek.php" class="active"><img src="../image/planning.png">&nbsp;<span>Daftar Proyek</span></a></li>
            <li><a href="preview.php"><img src="../image/website(1).png">&nbsp;<span>Preview</span></a></li>
            <li><a href="../logout.php"><img src="../image/out.png">&nbsp;<span>Logout</span></a></li>
        </ul>
    </div>

    <div class="container">
        <div class="header">
            <div class="nav">
                <h2 class="navbar-brand">Daftar Tugas Proyek</h2>
            </div>
        </div>
        
        <div class="content">
            <a href="daftar_proyek.php" class="btn btn-danger">Kembali</a>
            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Tugas</th>
                            <th>Pegawai</th>
                            <th>Tanggal Mulai</th>
                            <th>Deadline</th>
                            <th>Deskripsi</th>
                            <th>Divisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            $no = 1;
                            while ($row = $result->fetch_assoc()) {
                                // Tentukan status tugas berdasarkan apakah sudah ada laporan atau belum
                                $status_tugas = $row['laporan_id'] ? 'Selesai' : 'Belum Selesai';

                                // URL untuk hapus tugas
                                $delete_url = "hapus_tugas.php?id=" . $row['id'] . "&proyek_id=" . $proyek_id;

                                echo "<tr>
                                        <td>{$no}</td>
                                        <td>{$row['nama_tugas']}</td>
                                        <td>{$row['nama_user']}</td>
                                        <td>{$row['tanggal_mulai']}</td>
                                        <td>{$row['deadline']}</td>
                                        <td>{$row['deskripsi']}</td>
                                        <td>{$row['divisi']}</td>
                                        <td>{$status_tugas}</td>
                                        <td>
                                            <a href='detail.php?id={$row['id']}' class='btn btn-info btn-sm'>Lihat Detail</a>
                                            <a href='{$delete_url}' class='btn btn-danger btn-sm' onclick='return confirm(\"Apakah Anda yakin ingin menghapus tugas ini?\");'>Hapus</a>
                                        </td>
                                    </tr>";
                                $no++;
                            }
                        } else {
                            echo "<tr><td colspan='9' class='text-center'>Tidak ada tugas untuk proyek ini</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
                <!-- Pagination -->
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php for ($i = 1; $i <= $pages; $i++): ?>
                            <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                                <a class="page-link" href="tugas.php?proyek_id=<?php echo $proyek_id; ?>&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor; ?>
                    </ul>
                </nav>
            </div>  
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.5.0/dist/sweetalert2.all.min.js"></script>
    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const status = urlParams.get('status');

        if (status === 'success') {
            Swal.fire({
                title: 'Berhasil!',
                text: 'Tugas berhasil dihapus.',
                icon: 'success',
                confirmButtonText: 'OK'
            });
        } else if (status === 'error') {
            Swal.fire({
                title: 'Gagal!',
                text: 'Terjadi kesalahan saat menghapus tugas.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>