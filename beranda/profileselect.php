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

$user = mysqli_fetch_assoc($result);

// Ambil daftar followers
$followers_query = "SELECT follower_id FROM follow WHERE following_id = '$username'";
$followers_result = mysqli_query($koneksi, $followers_query);
$followers = [];

while ($row = mysqli_fetch_assoc($followers_result)) {
    $followers[] = $row['follower_id'];
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - <?php echo htmlspecialchars($user['username']); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto p-5">

    <h2 class="text-2xl font-bold">@<?php echo htmlspecialchars($user['username']); ?></h2>

    <p class="text-gray-600"><?php echo count($followers); ?> Followers</p>

    <h3 class="mt-4 font-semibold">Pengikut:</h3>
    <ul class="list-disc pl-5">
        <?php if (count($followers) > 0) { 
            foreach ($followers as $follower) {
                echo "<li><a href='profile.php?username=" . urlencode($follower) . "' class='text-blue-500 hover:underline'>@$follower</a></li>";
            }
        } else { ?>
        <p class="text-gray-500">Belum ada pengikut.</p>
        <?php } ?>
    </ul>

    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl pl-0  ">
        <div class="mt-3 flex justify-between mx-6">

            <i class="fa-solid fa-house text-3xl text-black"></i>
            <a href="/beranda/createpage.php"> <i class="fa-solid fa-plus text-4xl text-gray-400 mt-[-2px]"></i>
            </a>
            <a href="/beranda/profile.php"> <i class="fa-solid fa-user text-3xl text-gray-400"></i>
            </a>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>

</body>

</html>