<?php
session_start();
$_SESSION['status_login'] = true;
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // Query untuk memeriksa username dan role
    $query = "SELECT * FROM user WHERE username = ? AND role = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $role);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Simpan informasi ke session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['divisi'] = $user['divisi'];

            // Redirect sesuai role
            if ($user['role'] === 'Supervisor') {
                header("Location: supervisor/dash_supervisor.php");
                exit;
            } elseif ($user['role'] === 'admin') {
                header("Location: admin/dashboard_admin.php");
                exit;
            } elseif ($user['role'] === 'user') {
                header("Location: user/dash_user.php");
                exit;
            }
        } else {
            echo "Password salah!";
        }
    } else {
        echo "Username atau role tidak ditemukan!";
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .login-container {
            background: #d32f2f; /* Warna merah */
            padding: 30px 20px;
            border-radius: 10px;
            width: 350px;
            text-align: center;
            color: white;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        .login-container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            font-weight: bold;
        }

        .login-container input,
        .login-container select,
        .login-container button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            box-sizing: border-box;
        }

        .login-container input::placeholder {
            color:rgb(113, 112, 112); /* Placeholder warna abu */
        }

        .login-container input,
        .login-container select {
            background-color: #fff;
            color: #555;
        }

        .login-container select {
            appearance: none;
            padding: 10px;
        }

        .login-container button {
            background-color: white;
            color: #d32f2f;
            font-weight: bold;
            cursor: pointer;
            width: 200;
        }

        .login-container button:hover {
            background-color:rgb(248, 149, 149);
            color: #000;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <form action="" method="POST">
            <input type="text" id="username" name="username" placeholder="Username" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <select id="role" name="role" required>
                <option value="" disabled selected>Role</option>
                <option value="Supervisor">Supervisor</option>
                <option value="Admin">Admin</option>
                <option value="User">User</option>
            </select>
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
