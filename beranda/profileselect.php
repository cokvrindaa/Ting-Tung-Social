<?php
session_start();
require '../config/config.php';

if (!isset($_GET['username'])) {
    header("Location: /index.php");
    exit;
}

$username = $_GET['username'];

// Ambil data user berdasarkan username
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "<p>User tidak ditemukan.</p>";
    exit;
}
$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc($result);

// Ambil daftar followers
$followers_query = "SELECT follower_id FROM follow WHERE following_id = '$username'";
$followers_result = mysqli_query($koneksi, $followers_query);
$followers = [];

while ($row = mysqli_fetch_assoc($followers_result)) {
    $followers[] = $row['follower_id'];
}

$query = "SELECT beranda.*, users.profile_pic
                FROM beranda 
                JOIN users ON beranda.oleh = users.username 
                WHERE users.username = '$username'";
$result = mysqli_query($koneksi, $query);

// Ambil data pengguna yang sedang login sebagai array asosiatif
$user_data = mysqli_fetch_assoc($result);

// Cek apakah profile_pic tersedia atau tidak
$profile_pic = !empty($user_data['profile_pic']) ? "uploads/" . $user_data['profile_pic'] : null;

$queryupuser = "SELECT beranda.*, users.username 
                FROM beranda 
                JOIN users ON beranda.oleh = users.username 
                WHERE users.username = '$username'";
$resulupuser = mysqli_query($koneksi, $queryupuser);


?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - <?php echo htmlspecialchars($user['username']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">

</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto p-5">
    <a href="main.php" class="mt-2 inline-block bg-black text-white p-2 rounded-md ">Kembali</a>

    <div class="p-5 text-center mt-5">
        <!-- JIKA ADA FOTO PROFIL -->
        <?php if ($profile_pic) { ?>
        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="w-20 h-20 rounded-full mx-auto">
        <?php } else { ?>
        <i class="fa-solid fa-user text-6xl"></i>
        <?php } ?>

        <h2 class="text-2xl font-bold">@<?php echo htmlspecialchars($user['username']); ?></h2>
        <p class="text-gray-600"><?php echo count($followers); ?> Followers</p>
    </div>


    <h3 class="mt-4 font-semibold">Pengikut:</h3>
    <ul class="list-disc pl-5">
        <?php if (count($followers) > 0) { 
            foreach ($followers as $follower) {
                echo "<li><a href='profileselect.php?username=" . urlencode($follower) . "' class='text-blue-500 hover:underline'>@$follower</a></li>";
            }
        } else { ?>
        <p class="text-gray-500">Belum ada pengikut.</p>
        <?php } ?>
    </ul>
    <p class=" font-semibold  text-xl mt-5">postingan darii @<?php echo htmlspecialchars($user['username']); ?></p>




    <?php

    
        if (mysqli_num_rows($resulupuser) > 0) {
        while ($row = mysqli_fetch_assoc($resulupuser)) {
        ?>
    <div class="mt-4 mb-20  ">
        <div class=" shadow-lg rounded-lg p-5">
            <?php if (!empty($row['gambar'])){ ?>
            <img class="rounded-2xl mt-3 mb-3 w-full" src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>"
                alt="Gambar">
            <?php } ?>
            <?php if (!empty($row['video'])){ ?>
            <video class="rounded-2xl mt-3 mb-3 w-full" controls>
                <source src='uploads/<?php echo htmlspecialchars($row['video']) ?>' type='video/mp4'>
            </video>
            <?php } ?>
            <p><?php echo $row['teks']?></p>
        </div>


        <?php } ?>
        <?php } ?>
    </div>



    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>

</body>

</html>