<?php
require '../config/config.php';
ini_set('display_errors', 0); // Menonaktifkan error bawaan PHP

$teksberhasil = "";
$teksError = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $profile_pic = 0;  // Nilai default untuk profile_pic

    // Cek apakah username sudah ada di database
    $sql_check = "SELECT * FROM users WHERE username = '$username'";
    $result_check = mysqli_query($koneksi, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        // Username sudah ada, tampilkan pesan error
        $teksError = "Username sudah terdaftar! Coba nama lain.";
    } else {
        // Jika username belum ada, lanjutkan untuk menyimpan data
        $sql = "INSERT INTO users (username, password, profile_pic) VALUES ('$username', '$password', '$profile_pic')";
        $result = mysqli_query($koneksi, $sql);

        if ($result) {
            $teksberhasil = "User berhasil didaftarkan, silakan kembali ke halaman login :)";
        } else {
            $teksError = "Terjadi kesalahan saat mendaftar, silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung Social - Daftar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">
</head>

<body>
    <div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
        <img src="/tingtung.jpg" alt="tingtung" class="max-w-44 mx-auto">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" class="flex flex-col">
                <label for="username" class="mb-2 font-semibold">Username</label>
                <input type="text" name="username" placeholder="Ketikan username kamu.." required
                    class="rounded-md p-2 shadow-sm bg-white px-3.5 py-2 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 mb-3 lg:w-full">
                <label for="password" class="mb-2 font-semibold">Password</label>
                <input type="password" name="password" placeholder="Ketikan password kamu.." required
                    class="rounded-md p-2 shadow-sm bg-white px-3.5 py-2 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 mb-3 lg:w-full">
                <button type="submit" class="bg-black text-white font-semibold p-1 mt-5 rounded-md">Daftar</button>
                <p class="text-center mt-5">Udah terdaftar?, gass <a href="../index.php"
                        class="text-black font-semibold">login</a></p>
            </form>
            <p class="text-center mt-4 text-green-500">
                <?php echo $teksberhasil; ?>
            </p>
            <p class="text-center mt-4 text-red-500">
                <?php echo $teksError; ?>
            </p>
        </div>
    </div>
    <p class="mt-[-30px] text-center">by @cokvrindaa at github</p>
</body>

</html>