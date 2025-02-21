<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['following_id'])) {
    header("Location: /index.php");
    exit;
}

$follower = $_SESSION['username']; // User yang login
$following = $_POST['following_id']; // Target yang di-follow

// Cek apakah user sudah follow
$query = "SELECT * FROM follow WHERE follower_id = '$follower' AND following_id = '$following'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) > 0) {
    // Jika sudah follow, hapus (unfollow)
    mysqli_query($koneksi, "DELETE FROM follow WHERE follower_id = '$follower' AND following_id = '$following'");
} else {
    // Jika belum follow, tambahkan
    mysqli_query($koneksi, "INSERT INTO follow (follower_id, following_id) VALUES ('$follower', '$following')");
}

// Redirect kembali
header("Location: " . $_SERVER["HTTP_REFERER"]);
exit;
?>