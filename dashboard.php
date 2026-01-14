<?php

$barang_list = [
    ["K001", "Jilbab", 35000],
    ["K002", "Celana", 70000],
    ["K003", "Rok", 80000],
    ["K004", "Sepatu", 80000],
    ["K005", "Bergo", 22000],
];

// DATA PEMBELIAN AWAL DIBUAT KOSONG DAN TOTAL DISET KE NOL
$belanja_awal = [];
$grandtotal_awal = 0;
$diskon_awal = 0;
$total_akhir_awal = 0;


// Format angka ke Rupiah
function format_rupiah($angka) {
    return "Rp " . number_format($angka, 0, ',', '.');
}

// Fungsi untuk mendapatkan teks Diskon
function get_diskon_text($diskon_amount, $grandtotal) {
    if ($grandtotal == 0 || $diskon_amount == 0) return format_rupiah(0);
    $persen = round(($diskon_amount / $grandtotal) * 100);
    return format_rupiah($diskon_amount) . ($persen > 0 ? " (" . $persen . "%)" : "");
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>POLGAN MART - Sistem Penjualan Sederhana</title>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <style>
    * {
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
        margin: 0;
        padding: 0;
    }

    body {
        background: #FFE9E3; /* soft peach */
        color: #8A5A55; /* warm brown */
        padding: 0;
    }

    .navbar {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        background: #FFB7B2; /* pink peach */
        padding: 1rem 2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        margin-bottom: 2rem;
        border-bottom: 3px solid #FFDAD4;
    }

    .left-section { 
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .logo {
        background: #FF8FA2; 
        color: white;
        font-weight: 600;
        border-radius: 8px;
        width: 45px;
        height: 45px;
        display: flex;
        justify-content: center;
        align-items: center;
        font-size: 1rem;
        box-shadow: 0 3px 6px rgba(0,0,0,0.12);
    }

    .title h2 {
        font-size: 1.2rem;
        color: white;
        margin-bottom: 3px;
    }

    .title p {
        font-size: 0.8rem;
        color: #FFEFEA;
    }

    .right-section p {
        font-size: 0.9rem;
        color: white;
        text-align: right;
        line-height: 1.4;
    }

    .right-section .role {
        color: #FFE0DA;
        font-size: 0.8rem;
    }

    .right-section a {
        display: block;
        margin-top: 5px;
        font-size: 0.9rem;
        color: #FFEFEA;
        text-decoration: none;
        font-weight: 500;
    }

    .content {
        background: #FFF6F3; 
        margin: 0 auto;
        padding: 2rem;
        width: 90%;
        max-width: 800px;
        border-radius: 15px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.06);
        border: 2px solid #FFDAD4;
    }

    .form-group {
    text-align: left;
    margin-bottom: 2rem; 
}

    .form-group label {
        font-weight: 500;
        color: #8A5A55;
        margin-bottom: 5px;
        display: block;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 10px;
        border: 2px solid #FFB7B2;
        border-radius: 8px;
        font-size: 1rem;
        background: #FFFFFF;
        color: #8A5A55;
    }

    .btn {
        padding: 10px 20px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        font-size: 0.95rem;
    }

    .btn-primary {
        background-color: #FF8FA2;
        color: white;
        box-shadow: 0 3px 8px rgba(255,143,162,0.35);
    }

    .btn-secondary {
        background-color: #FFDAD4;
        color: #8A5A55;
    }

    h3.list-title {
        text-align: center;
        margin-bottom: 1.5rem;
        font-size: 1.2rem;
        font-weight: 600;
        padding-top: 1.5rem;
        color: #8A5A55;
        border-top: 2px solid #FFB7B2;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 1rem;
    }

    thead tr {
        border-bottom: 2px solid #FFB7B2;
    }

    th {
        color: #8A5A55;
        font-weight: 600;
        padding: 10px 15px;
    }

    td {
        padding: 10px 15px;
        color: #8A5A55;
        border-bottom: 1px solid #FFDAD4;
    }

    .table-summary td {
        border: none !important;
        padding: 8px 0;
    }

    .summary-label {
        text-align: right;
        font-weight: 600;
        width: 60%;
        color: #8A5A55;
    }

    .summary-value {
        text-align: right;
        width: 40%;
        font-weight: 500;
        color: #8A5A55;
    }

    .total-pay-value {
        color: #FF8FA2;
        font-weight: 700;
    }

    #btn-kosongkan {
        background: #FFB7B2;
        color: white;
        margin-top: 15px;
        border-radius: 8px;
        box-shadow: 0 3px 6px rgba(0,0,0,0.08);
    }
</style>


</head>
<body>
    <header class="navbar">
        <div class="left-section">
            <div class="logo">PM</div>
            <div class="title">
                <h2>--POLGAN MART--</h2>
                <p>Sistem Penjualan Sederhana</p>
            </div>
        </div>
        <div class="right-section">
            <p>Selamat datang, **Intan**<br>
            <span class="role">Role: Mahasiswa</span></p>
            <a href="logout.php">Logout</a>
        </div>
    </header>

    <main class="content">
        <div class="input-form">
            <div class="form-group">
                <label for="kode_barang">Kode Barang</label>
               <select id="kode" name="kode" required>
    <?php
        include 'koneksi.php';

        $result = $conn->query("SELECT kode FROM barang");

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<option value="' . $row['kode'] . '">' . $row['kode'] . '</option>';
            }
        }
    ?>
</select>
            </div>
            <div class="form-group">
                <label for="nama_barang">Nama Barang</label>
                <input type="text" id="nama_barang" placeholder="Nama Barang" readonly> 
            </div>
            <div class="form-group">
                <label for="harga">Harga</label>
                <input type="number" id="harga" placeholder="Harga" step="1000" min="0" readonly>
            </div>
            <div class="form-group">
                <label for="jumlah">Jumlah</label>
                <input type="number" id="jumlah" placeholder="Masukkan Jumlah" min="1">
            </div>
            <div class="actions">
                <button class="btn btn-primary" id="btn-tambah">Tambahkan</button>
                <button class="btn btn-secondary" id="btn-batal">Batal</button>
            </div>
        </div>
        
        <h3 class="list-title">Daftar Pembelian</h3>
        <table>
           </thead>
<tbody id="keranjang"></tbody>
</table>

<!-- TABEL TOTAL PEMBAYARAN -->
<table class="table-summary" style="margin-top: 20px;">
    <tr>
        <td class="summary-label">Grand Total</td>
        <td class="summary-value" id="grandtotal">Rp 0</td>
    </tr>
    <tr>
        <td class="summary-label">Diskon</td>
        <td class="summary-value" id="diskon">Rp 0</td>
    </tr>
    <tr>
        <td class="summary-label">Total Akhir</td>
        <td class="summary-value total-pay-value" id="totalakhir">Rp 0</td>
    </tr>
</table>

<button class="btn btn-secondary" id="btn-kosongkan" style="margin-top:15px;">
    Kosongkan Barang
</button>

        </main>

  <script>
document.addEventListener('DOMContentLoaded', function() {

    const kodeInput = document.getElementById('kode_barang'); 
    const namaInput = document.getElementById('nama_barang');
    const hargaInput = document.getElementById('harga');
    const jumlahInput = document.getElementById('jumlah');
    const btnTambah = document.getElementById('btn-tambah');
    const btnBatal = document.getElementById('btn-batal');

    const keranjangBody = document.getElementById('keranjang');
    const grandtotalEl = document.getElementById('grandtotal');
    const diskonEl = document.getElementById('diskon');
    const totalakhirEl = document.getElementById('totalakhir');

    // FUNGSI FORMAT RUPIAH
    function rupiah(x) {
        return "Rp " + Number(x).toLocaleString("id-ID");
    }

    // AUTOFILL NAMA & HARGA
    kodeInput.addEventListener('change', function() {

        const selectedOption = kodeInput.options[kodeInput.selectedIndex];

        if (selectedOption.value === "") {
            namaInput.value = "";
            hargaInput.value = "";
            jumlahInput.value = "";
            return;
        }

        const nama = selectedOption.getAttribute('data-nama');
        const harga = selectedOption.getAttribute('data-harga');

        namaInput.value = nama;
        hargaInput.value = harga;
        jumlahInput.focus();
    });

    // CLEAR INPUT
    btnBatal.addEventListener('click', function() {
        kodeInput.value = "";
        namaInput.value = "";
        hargaInput.value = "";
        jumlahInput.value = "";
    });

    // TAMBAHKAN KE KERANJANG
    btnTambah.addEventListener('click', function() {

        const kode = kodeInput.value;
        const nama = namaInput.value;
        const harga = Number(hargaInput.value);
        const jumlah = Number(jumlahInput.value);

        if (!kode || !jumlah) {
            alert("Silakan pilih barang dan masukkan jumlah!");
            return;
        }

        const total = harga * jumlah;

        // Tambahkan baris baru ke tabel
        const row = `
            <tr>
                <td>${kode}</td>
                <td>${nama}</td>
                <td>${rupiah(harga)}</td>
                <td>${jumlah}</td>
                <td>${rupiah(total)}</td>
            </tr>
        `;

        keranjangBody.innerHTML += row;

        hitungTotal();

        // Clear form
        btnBatal.click();
    });

    // HITUNG TOTAL PEMBELIAN
    function hitungTotal() {
        let grandtotal = 0;

        document.querySelectorAll("#keranjang tr").forEach(tr => {
            const totalText = tr.children[4].innerText.replace(/Rp|\.|\s/g, "");
            grandtotal += Number(totalText);
        });

        let diskon = 0;
        if (grandtotal >= 100000) {
            diskon = grandtotal * 0.10;
        } else if (grandtotal >= 50000) {
            diskon = grandtotal * 0.05;
        }

        const totalakhir = grandtotal - diskon;

        grandtotalEl.innerText = rupiah(grandtotal);
        diskonEl.innerText = rupiah(diskon);
        totalakhirEl.innerText = rupiah(totalakhir);
    }

    // KOSONGKAN KERANJANG
    const btnKosongkan = document.getElementById('btn-kosongkan');

    btnKosongkan.addEventListener('click', function() {
        keranjangBody.innerHTML = "";
        grandtotalEl.innerText = rupiah(0);
        diskonEl.innerText = rupiah(0);
        totalakhirEl.innerText = rupiah(0);
        btnBatal.click();
    });

});
</script>
</body>
</html>