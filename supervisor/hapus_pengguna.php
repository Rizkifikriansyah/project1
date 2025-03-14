<?php
// Koneksi ke database
include '../koneksi.php';

// Periksa apakah ID pengguna ada di URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Periksa apakah parameter divisi ada di URL
    $currentDivisi = isset($_GET['divisi']) ? $_GET['divisi'] : '';

    // Query untuk menghapus pengguna berdasarkan ID
    $query = "DELETE FROM user WHERE id = '$id'";

    // Eksekusi query
    if ($conn->query($query) === TRUE) {
        // Pengguna berhasil dihapus, redirect ke halaman yang sesuai dengan divisi
        echo "<script>alert('Data sudah terhapus');window.location.href='kelola_pengguna.php?divisi=$currentDivisi';</script>";
    } else {
        // Jika ada error, tampilkan pesan dan tetap di halaman kelola_pengguna.php
        echo "<script>alert('Gagal menghapus pengguna!'); window.location.href='kelola_pengguna.php?divisi=$currentDivisi';</script>";
    }
} else {
    // Jika ID tidak ada di URL, arahkan kembali ke halaman kelola pengguna
    echo "<script>alert('ID pengguna tidak ditemukan!'); window.location.href='kelola_pengguna.php';</script>";
}
?>
