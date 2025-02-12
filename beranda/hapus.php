<?php
include '../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$idnya = $_POST['id'];

// Ambil nama gambar bedasarkan id SEBELUM menghapus data
$result = mysqli_query($koneksi, "SELECT gambar, video FROM beranda WHERE id = $idnya");
$data = mysqli_fetch_assoc($result);
$gambar = $data['gambar'];
$video = $data['video'];

// Hapus dari database id
mysqli_query($koneksi, "DELETE FROM beranda WHERE id = $idnya");

// Hapus gambar di folder uploads
$file_path = $_SERVER['DOCUMENT_ROOT'] . '/beranda/uploads/' . $gambar;
if (file_exists($file_path)) {
    unlink($file_path);
}
// Hapus vid di folder uploads
$file_pathvid = $_SERVER['DOCUMENT_ROOT'] . '/beranda/uploads/' . $video;
if (file_exists($file_pathvid)) {
    unlink($file_pathvid);
}

header("Location: /beranda/main.php");
?>