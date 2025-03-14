<?php
session_start();
include '../koneksi.php'; // Pastikan file koneksi ada dan benar

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM user WHERE id = '$user_id'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user) {
    die("User  tidak ditemukan.");
}

// Proses update profil
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_profile'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);
    $divisi = mysqli_real_escape_string($conn, $_POST['divisi']);

    // Proses upload gambar
    $profil = $user['profil']; // Default tetap menggunakan yang lama
    if (!empty($_FILES['profil']['name'])) {
        $file_name = time() . "_" . basename($_FILES['profil']['name']);
        $target_dir = "../image/";
        $target_file = $target_dir . $file_name;

        // Pastikan folder uploads/image ada
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0755, true);
        }

        if (move_uploaded_file($_FILES['profil']['tmp_name'], $target_file)) {
            // Hapus gambar lama jika ada
            if ($profil && file_exists($profil)) {
                unlink($profil);
            }
            $profil = $target_file;
        }
    }

    $update_query = "UPDATE user SET nama='$nama', username='$username', role='$role', divisi='$divisi', profil='$profil' WHERE id='$user_id'";
    
    if (mysqli_query($conn, $update_query)) {
        echo "<script>alert('Profil berhasil diperbarui!'); window.location='dashboard_admin.php';</script>";
    } else {
        echo "Terjadi kesalahan: " . mysqli_error($conn);
    }
}

// Proses update password
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_password'])) {
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    if ($password_baru === $konfirmasi_password) {
        $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
        $update_password_query = "UPDATE user SET password='$hashed_password' WHERE id='$user_id'";

        if (mysqli_query($conn, $update_password_query)) {
            echo "<script>alert('Password berhasil diperbarui!'); window.location='profil.php';</script>";
        } else {
            echo "Terjadi kesalahan: " . mysqli_error($conn);
        }
    } else {
        echo "<script>alert('Konfirmasi password tidak cocok!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pengguna</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2, h3 {
            margin-bottom: 15px;
            color: #28a745;
        }

        .profile-section {
            margin-bottom: 20px;
        }

        .profile-pic {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #28a745;
        }

        label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input:focus {
            outline: none;
            border: 2px solid #28a745;
        }

        button {
            margin-top: 20px;
            background: #28a745;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background: #218838;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Profil Pengguna</h2>
        <div class="profile-section">
            <img src="<?php echo $user['profil'] ? $user['profil'] : 'default.png'; ?>" class="profile-pic" alt="Foto Profil">
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <label for="profil">Ganti Foto Profil:</label>
            <input type="file" id="profil" name="profil" accept="../image/*">

            <label for="nama">Nama:</label>
            <input type="text" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required>
            
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

            <label for="role">Role:</label>
            <input type="text" id="role" name="role" value="<?php echo htmlspecialchars($user['role']); ?>" required>

            <label for="divisi">Divisi:</label>
            <input type="text" id="divisi" name="divisi" value="<?php echo htmlspecialchars($user['divisi']); ?>" required>
            
            <button type="submit" name="update_profile">Simpan Perubahan</button>
        </form>

        <h3>Ganti Password</h3>
        <form action="" method="POST">
            <label for="password_baru">Password Baru:</label>
            <input type="password" id="password_baru" name="password_baru" required>

            <label for="konfirmasi_password">Konfirmasi Password:</label>
            <input type="password" id="konfirmasi_password" name="konfirmasi_password" required>

            <button type="submit" name="update_password">Ubah Password</button>
        </form>
    </div>
</body>
</html>