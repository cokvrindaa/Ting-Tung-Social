<?php 
// Sesi tertentu
session_start();
require '../config/config.php';
// Jika tidak ada sesi user maka akan balik ke index.php
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

// Ambil semua nama tabel
$tables = [];
$query = "SHOW TABLES";
$result = mysqli_query($koneksi, $query);

if ($result) {
    while ($row = mysqli_fetch_row($result)) {
        $tableName = $row[0];
        // Cek apakah nama tabel diakhiri dengan '_publik'
        if (substr($tableName, -7) === '_publik') {
            $tables[] = $tableName;
        }
    }
} else {
    echo "Error fetching tables: " . mysqli_error($koneksi);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ting Tung - Komunitas</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">
</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto">
    <div class="p-5">
        <p class="font-bold text-lg mb-3">Daftar Komunitas Publik:</p>

        <?php if (count($tables) > 0): ?>
        <div class="flex flex-col gap-3">
            <?php foreach ($tables as $table): ?>
            <?php
            // Potong nama komunitas lebih simpel
            // menghapus string ke 0-11 dan juga dari belakang menghapus sebnyk 7
            $nama_komunitas = substr($table, 11, -7);
        ?>
            <div class="flex items-center justify-between p-3 rounded-md border shadow-sm">
                <div class="flex gap-1">
                    <p>Komunitas: </p>
                    <span class="font-semibold"><?php echo htmlspecialchars($nama_komunitas); ?></span>
                </div>

                <a href="masuk_komunitas.php?komunitas=<?php echo urlencode($table); ?>"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-1 rounded-md text-sm">Join</a>
            </div>
            <?php endforeach; ?>
        </div>

        <?php else: ?>
        <p>Tidak ada komunitas publik tersedia.</p>
        <?php endif; ?>

        <a href="createpage.php" class="mt-4 inline-block bg-green-500 text-white p-2 rounded-md">Buat Komunitas</a>
    </div>


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