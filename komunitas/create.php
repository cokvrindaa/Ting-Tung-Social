<?php 
  include '../config/config.php';
  session_start();
  // Jika tidak ada sesi user maka akan balik ke index.php
  if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
  }
  $namakomunitas = $_POST['nama'];

//   Generate random string untuk mengidentifikasi suatu komunias.
    function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    // Cek apakah checkbox 'privat' dicentang
    $status = isset($_POST['privat']) ? "_privat" : "_publik";

    // Generate random 10 karakter
    $randomString = generateRandomString(10);

    // Gabungkan: [randomstring]_[namakomunitas]_[privat/publik]
    $namakomunitas = $randomString . "_" . $namakomunitas . $status;

    // Amankan nama tabel (hapus karakter aneh kecuali underscore dan huruf/angka)
  $sql = "CREATE TABLE `$namakomunitas`(
    id INT(2)  PRIMARY KEY, 
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    email VARCHAR(50)
    )";
    if (mysqli_query($koneksi, $sql)) {
        header("Location: /komunitas/main.php"); // Redirect ke halaman utama

    } else {
        echo "Error creating table: " . mysqli_error($koneksi);
    }
    mysqli_close($koneksi);
?>