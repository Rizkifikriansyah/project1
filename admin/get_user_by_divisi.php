<?php
include '../koneksi.php';

if (isset($_GET['divisi'])) {
    $divisi = mysqli_real_escape_string($conn, $_GET['divisi']);
    $sql = "SELECT * FROM user WHERE divisi = '$divisi' AND role = 'user'";
    $result = mysqli_query($conn, $sql);
    
    echo '<option value="">-- Pilih User --</option>';
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<option value="' . $row['id'] . '">' . $row['nama'] . '</option>';
    }
}
?>
