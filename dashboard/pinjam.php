<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

$buku = mysqli_query($conn,"
SELECT * FROM buku WHERE id='$id'
");

$row = mysqli_fetch_assoc($buku);

$nama_buku = $row['nama_buku'];

mysqli_query($conn,"
INSERT INTO peminjaman
(nama_user,nama_buku,tanggal_pinjam,jumlah)

VALUES
('User','$nama_buku',NOW(),1)
");

mysqli_query($conn,"
UPDATE buku
SET jumlah_buku = jumlah_buku - 1
WHERE id='$id' AND jumlah_buku > 0
");

header("Location: peminjaman.php");

?>