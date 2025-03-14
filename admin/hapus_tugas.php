<?php
// Koneksi ke database
include '../koneksi.php';

// Ambil parameter ID tugas dan proyek_id dari URL
$id_tugas = isset($_GET['id']) ? $_GET['id'] : '';
$proyek_id = isset($_GET['proyek_id']) ? $_GET['proyek_id'] : '';

if (!$id_tugas || !$proyek_id) {
    die("ID Tugas atau Proyek ID tidak ditemukan!");
}

// Query untuk menghapus tugas berdasarkan ID
$query = "DELETE FROM tugas WHERE id = '$id_tugas'";

// Eksekusi query
if ($conn->query($query) === TRUE) {
    // Jika berhasil menghapus, alihkan ke halaman daftar tugas dengan status=success
    header("Location: tugas.php?proyek_id=" . $proyek_id . "&status=success");
    exit();
} else {
    // Jika gagal menghapus, alihkan ke halaman daftar tugas dengan status=error
    header("Location: tugas.php?proyek_id=" . $proyek_id . "&status=error");
    exit();
}

// Tutup koneksi
$conn->close();
?>
