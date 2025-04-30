<?php
session_start();
require '../config/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

// Cek apakah ada komunitas dikirimkan
if (!isset($_GET['komunitas'])) {
    echo "Komunitas tidak ditemukan.";
    exit;
}

$komunitas = $_GET['komunitas'];

// Bersihkan nama komunitas (prevent SQL Injection)
$komunitas = preg_replace('/[^A-Za-z0-9_]/', '', $komunitas);

// Cek apakah tabel itu ada
$query = "SHOW TABLES LIKE '$komunitas'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Komunitas tidak tersedia.";
    exit;
}

// Kalau sudah ada, tampilkan halaman komunitas
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Masuk Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="p-5">
    <h1 class="text-2xl font-bold mb-5">Selamat datang di komunitas:</h1>
    <div class="text-xl text-blue-600 font-semibold mb-5">
        <?php echo htmlspecialchars($komunitas); ?>
    </div>

    <p>Di sini kamu bisa mulai bergabung, berdiskusi, dll.</p>

    <a href="/komunitas/main.php" class="mt-5 inline-block bg-gray-400 text-white px-4 py-2 rounded-md">Kembali</a>
</body>

</html>