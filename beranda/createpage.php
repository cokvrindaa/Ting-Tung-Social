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
    
    if(isset($_post['submit'])){
        header("Location: /beranda/createpage.php");
        exit;
    }
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

            <video id="previewVideo" controls style="display: none;" class="w-full my-5"></video>
            <img id="preview" src="#" alt="Preview Gambar" class=" w-full my-5" style="display: none; ">
            <div class="flex  justify-between">
                <div class="flex gap-4">
                    <label for="gambar" class="file-upload bg-black text-white rounded-md p-2">
                        <i class="fa-regular fa-image mr-3"></i>Gambar
                    </label>
                    <label for="video" class=" bg-black text-white rounded-md p-2">
                        <i class="fa-solid fa-video mr-3"></i>Video
                    </label>
                </div>


                <button type="submit" name="submit" class=" bg-black text-white rounded-md p-2">Upload</button>
            </div>

            <input type="file" hidden name="video" accept="video/*" id="video" onchange="previewVideo(event)">
            <input type="file" hidden id="gambar" name="gambar" accept="image/*" onchange="previewImage(event)">
        </form>
        <form action="createpage.php" method="post">
            <button type="submit" class=" bg-red-600 text-white p-2 rounded-md">batalkan</button>
        </form>
    </div>



    <!-- Under nav -->
    <div class="fixed bottom-0 w-full h-14 bg-white/80 backdrop-blur-lg lg:max-w-xl md:max-w-xl">
        <div class="mt-3 flex justify-between mx-6">
            <a href="/beranda/main.php">
                <i class="fa-solid fa-house text-3xl text-gray-400"></i>

            </a>
            <i class="fa-solid fa-plus text-4xl text-black mt-[-2px]"></i>
            <a href="/beranda/profile.php">

                <i class="fa-solid fa-user text-3xl text-gray-400"></i>
            </a>
        </div>
    </div>
    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
    <script>
    function previewVideo(event) {
        const videoPreview = document.getElementById("previewVideo");
        const file = event.target.files[0];

        if (file) {
            const fileURL = URL.createObjectURL(file);
            videoPreview.src = fileURL;
            videoPreview.style.display = "block";
            videoPreview.load();
        } else {
            videoPreview.style.display = "none";
        }
    }

    function previewImage(event) {
        const preview = document.getElementById("preview");
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(imglink) {
                preview.src = imglink.target.result;
                preview.style.display = "block"; // Tampilkan gambar setelah dipilih
            };
            reader.readAsDataURL(file);
        } else {
            preview.style.display = "none"; // Sembunyikan jika tidak ada file
        }
    }
    </script>
</body>

</html>