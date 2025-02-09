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
        $result = mysqli_query($koneksi, "SELECT beranda.*, 
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id) AS like_count,
        (SELECT COUNT(*) FROM likes WHERE likes.post_id = beranda.id AND likes.user_id = {$_SESSION['user_id']}) AS isLikedByUser
        FROM beranda");
    
        if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $isLikedByUser = isset($row['isLikedByUser']) ? $row['isLikedByUser'] > 0 : false; 

        ?>
        <div class="data-item mb-5 p-2">
            <div class="flex justify-between w-9/12">
                <div class="flex items-center space-x-2">
                    <i class="fa-solid fa-user text-lg"></i>
                    <p class="font-semibold text-sm mt-[-2px]">@<?php echo $row['oleh']; ?></p>
                </div>
                <p class="text-sm"><b><?php echo $row['waktu'];?></b></p>
            </div>

            <img class=" rounded-2xl mt-3 mb-3 w-9/12" src="uploads/<?php echo $row['gambar']; ?>" alt="Gambar">
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
                <button type="submit">hapus</button>
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