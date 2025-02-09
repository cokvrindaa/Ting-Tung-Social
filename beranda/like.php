<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = intval($_POST['post_id']);

// Cek apakah user sudah like dari tabel likes, bedasarkan user_id dan post_id
$check = mysqli_query($koneksi, "SELECT * FROM likes WHERE user_id = $user_id AND post_id = $post_id");

// jika hasil itu lebih dari 0 atau sudah like maka delete, jika hasil itu 0 atau belum like maka akan insert
if (mysqli_num_rows($check) > 0) {
    // Jika sudah like, hapus like
    mysqli_query($koneksi, "DELETE FROM likes WHERE user_id = $user_id AND post_id = $post_id");
} else {
    // Jika belum like, tambahkan like
    mysqli_query($koneksi, "INSERT INTO likes (user_id, post_id) VALUES ($user_id, $post_id)");
}

// Kembali ke halaman sebelumnya
header("Location: main.php");
exit;
?>