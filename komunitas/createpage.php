<?php 
    // Sesi tertentu
    session_start();
    require '../config/config.php';
    // Jika tidak ada sesi user maka akan balik ke index.php
    if (!isset($_SESSION['user_id'])) {
        header("Location: /index.php");
        exit;
    }
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung - Buat Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">
</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <form action="create.php" method="POST" enctype="multipart/form-data" class="p-5 flex flex-col">
        <label for="nama" class="mb-2 font-semibold">Nama Komunitas</label>
        <input type="text" name="nama" placeholder="ketikan nama komunitas muu.." required
            class="rounded-md p-2 shadow-sm bg-white px-3.5 py-2 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 mb-3 lg:w-full">

        <!-- Tambahkan checkbox untuk pilih Privat -->
        <div class="mb-3">
            <input type="checkbox" id="privat" name="privat" class="mr-2">
            <label for="privat" class="font-semibold">Buat Komunitas Privat</label>
        </div>

        <button type="submit" name="submit" class="bg-black text-white rounded-md p-2">Upload</button>
    </form>

    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl pl-0  ">
        <div class="mt-3 flex justify-between mx-6">
            <a href="/beranda/main.php"> <i class="fa-solid fa-house text-3xl text-gray-400"></i>

                <a href="/beranda/createpage.php"> <i class="fa-solid fa-plus text-4xl text-gray-400 mt-[-2px]"></i>
                </a>
                <a href="/komunitas/main.php"><i class="fa-solid fa-comments text-3xl text-black "></i></a>
                <a href="/beranda/profile.php"> <i class="fa-solid fa-user text-3xl text-gray-400"></i>
                </a>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>

</body>

</html>