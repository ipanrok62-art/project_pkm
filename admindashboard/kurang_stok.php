<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

mysqli_query($conn, "
UPDATE buku 
SET jumlah_buku = jumlah_buku - 1 
WHERE id='$id' AND jumlah_buku > 0
");

header("Location:data_buku.php");

?>