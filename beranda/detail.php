<?php
session_start();
require '../config/config.php';

// Pastikan ID postingan ada di URL
if (!isset($_GET['id'])) {
    header("Location: /index.php");
    exit;
}

$post_id = intval($_GET['id']);

$query = "SELECT beranda.*, 
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id) AS like_count,
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id AND likes.user_id = {$_SESSION['user_id']}) AS isLikedByUser
    FROM beranda WHERE id = $post_id";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 0) {
    echo "Postingan tidak ditemukan.";
    exit;
}

$row = mysqli_fetch_assoc($result);
$isLikedByUser = isset($row['isLikedByUser']) ? $row['isLikedByUser'] > 0 : false;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung Social - Postingan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">

</head>

<body class=" lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">

    <div class=" p-5 mb-5">
        <div class="data-item mb-5 p-2">
            <div class="flex items-center space-x-2">
                <i class="fa-solid fa-user text-lg"></i>
                <p class="font-semibold text-sm mt-[-2px]">@<?php echo $row['oleh']; ?></p>
            </div>

            <img class="rounded-2xl mt-3 mb-3 w-9/12" src="uploads/<?php echo $row['gambar']; ?>" alt="Gambar">
            <p><?php echo $row['teks']; ?></p>

            <div class="flex gap-2">
                <form action="like.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>" />
                    <div class="flex">
                        <button type="submit"><?php echo $isLikedByUser ? '❤️ ' : '🤍'; ?></button>
                        <p><?php echo $row['like_count']; ?></p>
                    </div>
                </form>

                <button class="mt-[-15px]"><i class="fa-solid fa-comment mr-[3px]"></i>Komentar</button>
            </div>

            <form action="komentar.php" method="post">
                <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>">
                <textarea type="text" class=" w-full py-2 border-none  h-28 resize-none focus:outline-none"
                    name="tekskomentar" placeholder="akuuu akan komentar sesuatuu tentangg...." required></textarea>
                <button type="submit" class="mt-5 inline-block bg-black text-white p-2 rounded-md ">Kirim!</button>
            </form>

            <div class="mt-3">
                <p class="font-bold">Komentar:</p>
                <?php
                $queryKomentar = "SELECT komentar, user FROM komentar WHERE post_id = $post_id";
                $resultKomentar = mysqli_query($koneksi, $queryKomentar);

                if (mysqli_num_rows($resultKomentar) > 0) {
                    while ($komentar = mysqli_fetch_assoc($resultKomentar)) {
                ?>
                <p><b>@<?php echo htmlspecialchars($komentar['user']); ?></b></p>
                <p><?php echo htmlspecialchars($komentar['komentar']); ?></p>
                <?php 
                    }
                } else { 
                ?>
                <p>Tidak ada komentar.</p>
                <?php 
                } 
                ?>
            </div>
        </div>
    </div>

    <a href="main.php" class="mt-5 inline-block bg-black text-white p-2 rounded-md ml-6">Kembali</a>

    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
</body>

</html>