<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$idnya = $_POST['id'];

mysqli_query($koneksi, "UPDATE beranda SET teks");


?>