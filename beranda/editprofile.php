<?php
  session_start();
  require '../config/config.php';

  if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
  }

  $user_id = $_SESSION['user_id'];
  $query = "SELECT username, profile_pic FROM users WHERE id = '$user_id'";
  $result = mysqli_query($koneksi, $query);
  $user = mysqli_fetch_assoc($result);
  $profile_pic = !empty($user['profile_pic']) ? "uploads/" . $user['profile_pic'] : null;
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
    <div class="p-5 ">
        <!-- JIKA ADA PP -->
        <?php if ($profile_pic) { ?>
        <img src="<?php echo $profile_pic; ?>" alt="Profile Picture" class="w-20 h-20 rounded-full mx-auto ">
        <?php } else { ?>
        <i class="fa-solid fa-user text-6xl"></i>
        <?php } ?>
        <p class="text-2xl font-bold mt-3 text-center">@<?php echo $user['username']; ?></p>

        <form action="upload_profile_pic.php" method="post" enctype="multipart/form-data" class="mt-5 ">
            <!-- Label untuk input file -->
            <label for="profile_pic" class="cursor-pointer bg-black text-white px-4 py-2 rounded-md inline-block">
                Pilih Gambar
            </label>
            <!-- Input file yang disembunyikan -->
            <input type="file" name="profile_pic" id="profile_pic" accept="image/*" class="hidden">
            <!-- Pesan status file -->
            <span id="file-status" class="ml-2 text-gray-600">Belum ada file dipilih.</span>
            <button type="submit"
                class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 ml-2">Simpan</button>
        </form>
    </div>
    <a href="/beranda/profile.php" class="mt-5 inline-block bg-black text-white p-2 rounded-md ml-6">Kembali</a>

    <script src="https://kit.fontawesome.com/27ec8e2fe3.js" crossorigin="anonymous"></script>
    <script>
    // JavaScript untuk menangani perubahan pada input file
    document.getElementById('profile_pic').addEventListener('change', function(event) {
        const fileInput = event.target;
        const fileStatus = document.getElementById('file-status');

        if (fileInput.files.length > 0) {
            // Jika file dipilih
            const fileName = fileInput.files[0].name;
            fileStatus.textContent = `File dipilih: ${fileName}`;
            fileStatus.classList.remove('text-gray-600');
            fileStatus.classList.add('text-green-600');
        } else {
            // Jika tidak ada file dipilih
            fileStatus.textContent = 'Belum ada file dipilih.';
            fileStatus.classList.remove('text-green-600');
            fileStatus.classList.add('text-gray-600');
        }
    });
    </script>
</body>

</html>