<?php
    // Sesi tertentu
    session_start();
    require '../config/config.php';
    // Jika tidak ada sesi user maka akan balik ke index.php
    if (!isset($_SESSION['user_id'])) {
        header("Location: /index.php");
        exit;
    }
    

    $query = "SELECT * FROM beranda";
    $result = mysqli_query($koneksi, $query);

    $user_id = $_SESSION['user_id']; // ID pengguna yang login
    $username = $_SESSION['username'];
    $query = "SELECT beranda.*, users.profile_pic, 
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id) AS like_count,
    (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id AND likes.user_id = '$user_id') AS isLikedByUser,
    (SELECT COUNT(*) FROM follow WHERE follow.following_id = users.username) AS follower_count,
    (SELECT COUNT(*) FROM follow WHERE follow.follower_id = '$username' AND follow.following_id = users.username) AS isFollowing
    FROM beranda 
    JOIN users ON beranda.oleh = users.username";

    $result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung Social - Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">

</head>

<body class=" lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <div class=" mb-5 p-5">

        <?php

    
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $isLikedByUser = isset($row['isLikedByUser']) ? $row['isLikedByUser'] > 0 : false; 
            $profile_pic = !empty($row['profile_pic']) ? "uploads/" . $row['profile_pic'] : null;
            $isFollowing = $row['isFollowing'] > 0;
        ?>
        <div class="data-item mb-5 p-2">
            <div class="flex justify-between w-full">
                <div class="flex items-center space-x-2">
                    <?php if ($profile_pic) { ?>
                    <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="w-8 h-8 rounded-full">
                    <?php } else { ?>
                    <i class="fa-solid fa-user text-lg"></i>
                    <?php } ?>
                    <p class="font-semibold text-sm mt-[-2px]">
                        <a href="profileselect.php?username=<?php echo urlencode($row['oleh']); ?>"
                            class="text-blue-500 hover:underline">
                            @<?php echo $row['oleh']; ?>
                        </a>
                        <span class="text-xs text-gray-500">(<?php echo $row['follower_count']; ?> followers)</span>
                    </p>



                    <?php if ($username != $row['oleh']) { ?>
                    <form action="follow.php" method="POST">
                        <input type="hidden" name="following_id" value="<?php echo $row['oleh']; ?>">
                        <button type="submit"
                            class="text-xs px-2 py-1 rounded-md <?php echo $row['isFollowing'] ? 'bg-gray-400 text-white' : 'bg-blue-500 text-white'; ?>">
                            <?php echo $row['isFollowing'] ? 'Unfollow' : 'Follow'; ?>
                        </button>
                    </form>
                    <?php } ?>
                </div>
                <p class="text-sm my-auto"><b><?php echo $row['waktu'];?></b></p>
            </div>
            <?php if (!empty($row['gambar'])){ ?>
            <img class="rounded-2xl mt-3 mb-3 w-full" src="uploads/<?php echo htmlspecialchars($row['gambar']); ?>"
                alt="Gambar">
            <?php } ?>

            <?php if (!empty($row['video'])){ ?>
            <video class="rounded-2xl mt-3 mb-3 w-full" controls>
                <source src='uploads/<?php echo htmlspecialchars($row['video']) ?>' type='video/mp4'>
            </video>
            <?php } ?>

            <p><?php echo $row['teks']; ?></p>

            <div class="flex gap-2">
                <form action="like.php" method="post">
                    <input type="hidden" name="post_id" value="<?php echo $row['id']; ?>" />
                    <div class="flex">
                        <button type="submit"><?php echo $isLikedByUser ? '❤️ ' : '🤍'; ?></button>
                        <p><?php echo $row['like_count']; ?></p>
                    </div>
                </form>
                <a href="detail.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-comment mr-2"></i>Komentar</a>
            </div>



            <?php 
        if($_SESSION['username']===$row['oleh']){
        ?> <form action="hapus.php" method="post">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class=" bg-red-600 text-white p-2 rounded-md">hapus</button>
            </form>
            <?php
        }
        ?>

        </div>
        <?php
        }
        
        } else {
        ?>
        <p>Tidak ada data tersimpan.</p>
        <?php } ?>

    </div>
    <!-- Under nav -->
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