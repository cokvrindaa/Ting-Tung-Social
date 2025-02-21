<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_FILES['profile_pic']['error'] == 0) {
    $folder_upload = "uploads/";
    $filename = time() . "_PPCOY_" . basename($_FILES['profile_pic']['name']);
    $target_path = $folder_upload . $filename;
    move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_path);
    

    $query = "UPDATE users SET profile_pic = '$filename' WHERE id = $user_id";
    mysqli_query($koneksi, $query);

    header("Location: profile.php");
}
?>