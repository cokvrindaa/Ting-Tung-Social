<?php
    $koneksi =  mysqli_connect('localhost', 'root', '', 'tingtung');
    if ($koneksi){
        echo "
        <script>
            console.log('koneksi berhasil');
        </script>
        ";
    }
    else{
        echo "
        <script>
            console.log('koneksi tidak berhasil');
        </script>
        ";
    }
    date_default_timezone_set('Asia/Makassar');

    mysqli_query($koneksi, "SET time_zone = '+08:00'");
?>