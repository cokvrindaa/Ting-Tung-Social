<?php
session_start();
require '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil daftar followers dengan query yang benar
$followers_query = "
    SELECT users.id, users.username, users.profile_pic 
    FROM follow 
    JOIN users ON follow.follower_id = users.username 
    WHERE follow.following_id = (SELECT username FROM users WHERE id = '$user_id')
";


$followers_result = mysqli_query($koneksi, $followers_query);

$followers = [];
while ($row = mysqli_fetch_assoc($followers_result)) {
    $followers[] = $row;
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Followers</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">
</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <div class="p-5 text-center mt-10">
        <h1 class="text-2xl font-bold">Followers</h1>

        <?php if (empty($followers)) { ?>
        <p class="text-gray-600 mt-3">Kamu belum punya followers.</p>
        <?php } else { ?>
        <ul class="mt-5">
            <?php foreach ($followers as $follower) { ?>
            <li class="flex items-center gap-3 p-2 border-b">
                <!-- Jika ada foto profil -->
                <?php if (!empty($follower['profile_pic'])) { ?>
                <img src="uploads/<?php echo htmlspecialchars($follower['profile_pic']); ?>"
                    class="w-10 h-10 rounded-full">
                <?php } else { ?>
                <i class="fa-solid fa-user text-2xl"></i>
                <?php } ?>
                <a href="profile_select.php?username=<?php echo urlencode($follower['username']); ?>" class="text-lg">
                    @<?php echo htmlspecialchars($follower['username']); ?>
                </a>
            </li>
            <?php } ?>
        </ul>
        <?php } ?>
    </div>

    <div class="mt-5 text-center">
        <a href="profile.php" class="text-blue-500 hover:underline">Kembali ke Profil</a>
    </div>

    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
</body>

</html>