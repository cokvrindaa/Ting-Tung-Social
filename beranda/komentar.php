<?php 
include '../config/config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$oleh = $_SESSION['username'];
$user_id = $_SESSION['username'];

if (isset($_POST['tekskomentar'], $_POST['post_id'])) {
    $tekskomentar = trim($_POST['tekskomentar']);
    $post_id = intval($_POST['post_id']);
    if($tekskomentar !== ''){
        
        $query = "INSERT INTO komentar (komentar, user, post_id) VALUES ('$tekskomentar', '$user_id', $post_id)";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: detail.php?id=" . $post_id);
        exit;
        } else {
    echo "Error: " . mysqli_error($koneksi);
    }
    }else{
    echo "Komentar tidak boleh kosong";
    }
    } else {
    echo "Data tidak lengkap!";
    }

?>