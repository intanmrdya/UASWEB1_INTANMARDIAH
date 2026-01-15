<?php
include 'koneksi.php';

// Mengambil ID dari parameter URL
$id = $_GET['id'];

// Menjalankan query hapus
mysqli_query($conn, "DELETE FROM pelanggan WHERE id_pelanggan='$id'");

// Mengalihkan kembali ke daftar produk
header("Location: dashboard.php?page=pelanggan");
?>