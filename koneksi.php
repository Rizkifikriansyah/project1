<?php
// Konfigurasi database
$host = "localhost"; // Host database, biasanya 'localhost'
$user = "root";      // Username MySQL (default XAMPP adalah 'root')
$password = "";      // Password MySQL (default XAMPP adalah kosong)
$dbname = "taskreport"; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $user, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi ke database gagal: " . $conn->connect_error);
} else {
    // echo "Koneksi berhasil"; // Opsional, untuk debugging
}
?>