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
    <title>Ting Tung Social - Buat</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">

</head>

<body class=" lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <div class=" p-5 mb-5">
        <div class="flex items-center space-x-2  ">
            <i class="fa-solid fa-user text-lg"></i>
            <p class="font-semibold text-sm mt-[-2px]">@<?php echo $_SESSION['username']; ?></p>
        </div>
        <form action="create.php" method="POST" enctype="multipart/form-data">

            <textarea type="text" class=" w-full py-2 border-none  h-28 resize-none focus:outline-none" name="teks"
                placeholder="akuuu akan mempostingg sesuatuu tentangg....." required></textarea>


            <img id="preview" src="#" alt="Preview Gambar" class=" w-full my-5" style="display: none; ">
            <div class="flex  justify-between"> <label for="gambar"
                    class="file-upload bg-black text-white rounded-md p-2">
                    <i class="fa-regular fa-image mr-3"></i>Gambar </label>
                <button type="submit" name="submit" class=" bg-black text-white rounded-md p-2">Upload</button>
            </div>

            <input type="file" hidden id="gambar" name="gambar" required accept="image/*"
                onchange="previewImage(event)">
            <!-- Tambahkan style agar tidak tampil awalnya -->

        </form>

    </div>



    <!-- Under nav -->
    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl">
        <div class="mt-3 flex justify-between mx-6">
            <a href="/beranda/main.php">
                <i class="fa-solid fa-house text-3xl text-gray-400"></i>

            </a>
            <i class="fa-solid fa-plus text-4xl text-black mt-[-2px]"></i>
            <i class="fa-solid fa-user text-3xl text-gray-400"></i>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
    <script src="/beranda/script.js"></script>
</body>

</html>