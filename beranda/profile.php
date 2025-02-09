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
    <h1>MASIH DALAM PENGEMBANGAN</h1>
    <p>nama kamuuu.... @<?php echo $_SESSION['username']; ?></p>
    kalau mau logout:
    <a href="logout.php" class="logout">
        <button class="bg-orange-400 font-bold p-2 rounded-md">Log Out</button>
    </a>
    <!-- Under nav -->
    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl pl-0  ">
        <div class="mt-3 flex justify-between mx-6">
            <a href="/beranda/main.php">
                <i class="fa-solid fa-house text-3xl text-gray-400"></i>
            </a>
            <a href="/beranda/createpage.php"> <i class="fa-solid fa-plus text-4xl text-gray-400 mt-[-2px]"></i>
            </a>
            <i class="fa-solid fa-user text-3xl text-black"></i>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
</body>

</html>