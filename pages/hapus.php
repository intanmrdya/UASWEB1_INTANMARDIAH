<?php
include 'koneksi.php';

// Mengambil ID dari parameter URL
$id = $_GET['id'];

// Menjalankan query hapus
mysqli_query($conn, "DELETE FROM barang WHERE id_barang='$id'");

// Mengalihkan kembali ke daftar produk
header("Location: dashboard.php?page=listproducts");
?>