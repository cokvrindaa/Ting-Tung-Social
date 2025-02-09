<?php
require '../config/config.php';
ini_set('display_errors', 0);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    // Enkripsi Password
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Insert user
    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    $result = mysqli_query($koneksi, $sql);
    
        

    // Error duplikat username
    if ($koneksi->errno == 1062) { 
        echo "
        <script>
            alert('User Terduplikat!, coba nama lain!');
        </script>
        ";
    } 
}
if($result){
    $teksberhasil = "user berhasill di daftarr, silahkan balik ke halaman loginn :)";

}
else{
    $teksberhasil = " ";

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
        <img src="/tingtung.jpg" alt="tingtung" class=" max-w-44 mx-auto">
        <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
            <form method="POST" class="flex flex-col     ">
                <label for="username" class="mb-2 font-semibold">Username</label>
                <input type="text" name="username" placeholder="ketikan username muu.." required
                    class="rounded-md p-2 shadow-sm bg-white px-3.5 py-2 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 mb-3 lg:w-full">
                <label for="password" class="mb-2 font-semibold">Password</label>
                <input type="password" name="password" placeholder="ketikan password muu.." required
                    class="rounded-md p-2 shadow-sm bg-white px-3.5 py-2 outline outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline focus:outline-2 focus:-outline-offset-2 focus:outline-blue-600 mb-3 lg:w-full">
                <button type="submit" class="c bg-black text-white font-semibold p-1 mt-5 rounded-md">Daftar</button>
                <p class="text-center mt-5">Udah kedaftarr?, gass <a href="../index.php"
                        class="text-black font-semibold">login</a></p>

            </form>
            <p>
                <?php echo $teksberhasil;?>
            </p>
        </div>

    </div>
    <p class="mt-[-30px] text-center">by @cokvrindaa at github</p>

</body>

</html>