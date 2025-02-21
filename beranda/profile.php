<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data pengguna yang sedang login
$query = "SELECT username, profile_pic FROM users WHERE id = '$user_id'";
$result = mysqli_query($koneksi, $query);

if (!$result || mysqli_num_rows($result) == 0) {
    echo "<p>Error: User tidak ditemukan.</p>";
    exit;
}

$user = mysqli_fetch_assoc($result);
$profile_pic = !empty($user['profile_pic']) ? "uploads/" . $user['profile_pic'] : null;

// Ambil username dari user yang login
$username_query = "SELECT username FROM users WHERE id = '$user_id'";
$username_result = mysqli_query($koneksi, $username_query);
$username_data = mysqli_fetch_assoc($username_result);
$username = $username_data['username'];

// Hitung jumlah followers berdasarkan username
$followers_query = "SELECT COUNT(*) AS total_followers FROM follow WHERE following_id = '$username'";
$followers_result = mysqli_query($koneksi, $followers_query);
$followers_data = mysqli_fetch_assoc($followers_result);
$total_followers = $followers_data['total_followers'];


$posts_query = "SELECT beranda.*, 
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id) AS like_count,
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id AND likes.user_id = '$user_id') AS isLikedByUser
    FROM beranda 
    WHERE oleh = '$user[username]'";
$posts_result = mysqli_query($koneksi, $posts_query);



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung Social - Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">
</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <div class=" bg-black w-24 text-white rounded-md p-2 mt-4 ml-5">
        <a href="/beranda/logout.php">Log Out <i class="fa-solid fa-right-from-bracket"></i></a>
    </div>
    <div class="p-5 text-center mt-10">
        <!-- JIKA ADA FOTO PROFIL -->
        <?php if ($profile_pic) { ?>
        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="w-20 h-20 rounded-full mx-auto">
        <?php } else { ?>
        <i class="fa-solid fa-user text-6xl"></i>
        <?php } ?>

        <p class="text-2xl font-bold mt-3">@<?php echo htmlspecialchars($user['username']); ?></p>
        <div class="flex flex-col gap-1 mt-1">
            <a href="profilefollow.php" class="text-black font-bold hover:underline">
                <?php echo $total_followers; ?> Followers
            </a>


            <a href="/beranda/editprofile.php" class="text-blue-500">Edit Profile</a>
        </div>

    </div>
    <div class="p-5">
        <h2 class="text-xl font-bold">Postingan Saya</h2>
        <?php while ($row = mysqli_fetch_assoc($posts_result)) { ?>
        <?php if (!empty($row['gambar'])){ ?>
        <img class="rounded-2xl mt-3 mb-3 w-10/12" src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>"
            alt="Gambar">
        <?php } ?>

        <?php if (!empty($row['video'])){ ?>
        <video class="rounded-2xl mt-3 mb-3 w-10/12" controls>
            <source src='uploads/<?php echo htmlspecialchars($row['video']) ?>' type='video/mp4'>
        </video>
        <?php } ?>

        <p><?php echo $row['teks']; ?></p>
        <!-- Tombol Like -->
        <div class="flex gap-2">
            <form action="like.php" method="post">
                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>" />
                <p><?php echo $row['like_count']; ?> suka</p>
            </form>
        </div>

        <?php } ?>

    </div>

    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl pl-0">
        <div class="mt-3 flex justify-between mx-6">
            <a href="/beranda/main.php">
                <i class="fa-solid fa-house text-3xl text-gray-400"></i>
            </a>
            <a href="/beranda/createpage.php">
                <i class="fa-solid fa-plus text-4xl text-gray-400"></i>
            </a>
            <i class="fa-solid fa-user text-3xl text-black"></i>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
</body>

</html>