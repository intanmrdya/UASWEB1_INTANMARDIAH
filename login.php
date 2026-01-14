<?php
session_start();
include "koneksi.php";

if (isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit;
}

if (isset($_POST['username']) && isset($_POST['password'])) {

    $username = $_POST['username'];
    $password = $_POST['password'];

    $result = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");

    if ($row = mysqli_fetch_assoc($result)) {

        if ($password == $row['password']) {

            $_SESSION['username'] = $row['username'];
            $_SESSION['nama']     = $row['nama_lengkap'];
            $_SESSION['role']     = $row['role'];

            header("Location: dashboard.php");
            exit;

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - POLGAN MART</title>
    <style>
        * {
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body {
    margin: 0;
    padding: 0;
    background: linear-gradient(135deg, #ffb3c6, #ffc6b3, #ffd9c0); /* pink-peach-salmon gradient */
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
}

.login-container {
    background: #fff5f7; /* soft pink pastel */
    padding: 2.5rem 2rem;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(255, 160, 170, 0.3);
    width: 100%;
    max-width: 400px;
    text-align: center;
}

.login-container h2 {
    margin-bottom: 1rem;
    color: #ff6f91; /* pink tua manis */
}

.login-container p {
    margin-bottom: 1.5rem;
    color: #b36f7c;
}

.input-group {
    text-align: left;
    margin-bottom: 1.2rem;
}

.input-group label {
    display: block;
    margin-bottom: 0.4rem;
    font-weight: 500;
    color: #a84e6a;
}

.input-group input {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 1px solid #f3a7b6;
    transition: 0.3s;
    background: #fff;
}

.input-group input:focus {
    border-color: #ff8fab;
    outline: none;
    box-shadow: 0 0 6px rgba(255, 143, 171, 0.4);
}

.btn {
    background: #ff8fab; /* pink salmon */
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
    font-size: 1rem;
    width: 100%;
}

.btn:hover {
    background: #ff6f91; /* lebih gelap */
}

.error-message {
    background: #ffe6ea;
    color: #b3003c;
    border: 1px solid #ffb3c6;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 1rem;
    font-size: 0.9rem;
}

.footer-text {
    margin-top: 1.5rem;
    font-size: 0.85rem;
    color: #b36f7c;
}
    </style>
</head>
<body>

    <div class="login-container">
        <h2>POLGAN MART</h2>
        <p>Silakan login untuk melanjutkan</p>

        <?php if (!empty($error)): ?>
            <div class="error-message"><?= $error; ?></div>
        <?php endif; ?>

        <form method="post">
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" name="username" id="username" placeholder="Masukkan username" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" placeholder="Masukkan password" required>
            </div>

            <button type="submit" class="btn">Login</button>
        </form>

        <div class="footer-text">
            &copy; <?= date('Y'); ?> POLGAN MART — Sistem Penjualan Sederhana
        </div>
    </div>

</body>
</html>