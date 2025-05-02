<?php 
include '../config/config.php';
session_start();

// Cek sesi user login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$username = $_SESSION['username'];

if (isset($_POST['submit'])) {
    $tabel = $_POST['tabel'] ?? '';
    $chat = $_POST['chat'] ?? '';

    if ($tabel === '' || $chat === '') {
        echo "Data tidak lengkap.";
        exit;
    }

    // Simpan chat
    $query = "INSERT INTO `$tabel` (chat, username) VALUES ('$chat', '$username')";
    
    if (mysqli_query($koneksi, $query)) {
        header("Location: /komunitas/masuk_komunitas.php?komunitas=" . urlencode($tabel));
        exit;
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }
}
?>