<?php
$host = "localhost"; // Alamat server database (biasanya localhost)
$username = "root"; // Username untuk login ke database
$password = ""; // Password untuk login (biasanya kosong untuk localhost)
$dbname = "db_penjualan"; // Nama database yang ingin diakses

// Membuat koneksi
$conn = new mysqli ($host, $username, $password, $dbname) ;

// Mengecek koneksi
if ($conn->connect_error) {
    die( "Koneksi gagal: " . $conn->connect_error);
}
// echo "Koneksi berhasil!";
?>