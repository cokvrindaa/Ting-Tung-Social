<?php
session_start();
require '../config/config.php';

// Pastikan user sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: /index.php");
    exit;
}

// Cek apakah ada komunitas dikirimkan
if (!isset($_GET['komunitas'])) {
    echo "Komunitas tidak ditemukan.";
    exit;
}

$komunitas = $_GET['komunitas'];
$nama_komunitas = substr($komunitas, 11, -7);

// Bersihkan nama komunitas (prevent SQL Injection)
// $komunitas = preg_replace('/[^A-Za-z0-9_]/', '', $komunitas);

// Cek apakah tabel itu ada
$query = "SHOW TABLES LIKE '$komunitas'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    echo "Komunitas tidak tersedia.";
    exit;
}
$chat = mysqli_query($koneksi, "SELECT * FROM `$komunitas` ORDER BY id ASC");

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title> <?php echo htmlspecialchars($nama_komunitas);?> - Ting Tung</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="shortcut icon" href="/favicon-16x16.png" type="image/x-icon">

</head>

<body class="lg:max-w-xl lg:mx-auto md:max-w-xl md:mx-auto flex flex-col h-screen">

    <div class="p-5">
        <div class="text-xl text-blue-600 font-semibold mb-4">
            <?php echo htmlspecialchars($nama_komunitas); ?>
        </div>
        <p class="mb-4">Di sini kamu bisa mulai bergabung, berdiskusi, dll.</p>
    </div>

    <div id="chat-container" class="flex-1 overflow-y-auto px-5 mb-20">
        <?php while ($row = mysqli_fetch_assoc($chat)) { ?>
        <?php if ($row['username'] === $_SESSION['username']) { ?>
        <div class="flex flex-col items-end mb-2">
            <p class="bg-blue-500 text-white p-2 rounded-xl">
                <span class="block text-sm text-white/80 mb-1">@<?php echo htmlspecialchars($row['username']); ?></span>
                <?php echo htmlspecialchars($row['chat']); ?>
            </p>
        </div>
        <?php } else { ?>
        <div class="flex flex-col items-start mb-2">
            <p class="bg-gray-200 text-black p-2 rounded-xl">
                <span class="block text-sm text-gray-500 mb-1">@<?php echo htmlspecialchars($row['username']); ?></span>
                <?php echo htmlspecialchars($row['chat']); ?>
            </p>
        </div>
        <?php } ?>
        <?php } ?>
        <div id="bottom-chat"></div>
    </div>

    <div class="fixed bottom-0 w-full max-w-xl bg-white/80 backdrop-blur-md p-3">
        <form action="chat.php" method="POST" class="flex gap-2">
            <input type="hidden" name="tabel" value="<?= htmlspecialchars($komunitas) ?>">
            <input type="text" name="chat" placeholder="Ketik pesan..."
                class="flex-1 border border-gray-300 rounded-lg px-3 py-2">
            <button type="submit" name="submit" class="bg-blue-500 text-white px-4 py-2 rounded-lg">Kirim</button>
        </form>
    </div>

    <script>
    window.onload = function() {
        const chatBottom = document.getElementById("bottom-chat");
        if (chatBottom) {
            chatBottom.scrollIntoView({
                behavior: "smooth"
            });
        }
    };
    </script>
</body>


</html>