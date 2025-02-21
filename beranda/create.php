<?php
  date_default_timezone_set('Asia/Makassar');
  include '../config/config.php';
  session_start();
  // Jika tidak ada sesi user maka akan balik ke index.php
  if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
  }
  $oleh = $_SESSION['username'];
  
if (isset($_POST['submit'])) {
    $teks = $_POST['teks'];
    $gambar = $_FILES['gambar'];
    $video = $_FILES['video'];
    // Simpan gambar ke folder "uploads"
    $nama_gambar = $gambar['name'];
    $tmp_gambar = $gambar['tmp_name'];
    $folder_upload = "uploads/";

    $nama_video = $video['name'];
    $tmp_video = $video['tmp_name'];
    $folder_upload_video = "uploads/";

    // Buat folder "uploads" jika belum ada
    if (!is_dir($folder_upload)) {
        mkdir($folder_upload, 0777, true);
    }

    // Pindahkan file ke folder upload
    move_uploaded_file($tmp_gambar, $folder_upload . $nama_gambar);
    move_uploaded_file($tmp_video, $folder_upload . $nama_video);
    
    // Simpan data ke database
    $waktu_sekarang = date('Y-m-d H:i:s'); // Format yang sesuai untuk DATETIME
    $query = "INSERT INTO beranda (teks, gambar, video, oleh, waktu) VALUES ('$teks', '$nama_gambar','$nama_video', '$oleh', '$waktu_sekarang')";
    if (mysqli_query($koneksi, $query)) {
        header("Location: /beranda/main.php"); // Redirect ke halaman utama
    } else {
        echo "Error: " . $query . "<br>" . mysqli_error($koneksi);
    }



}
?>