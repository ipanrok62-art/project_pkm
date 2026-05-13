<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$nama = $_POST['nama_buku'];
$penerbit = $_POST['penerbit'];
$tahun = $_POST['tahun_penerbit'];
$jumlah = $_POST['jumlah_buku'];

$gambar = $_FILES['gambar']['name'];
$tmp = $_FILES['gambar']['tmp_name'];
$kategori = $_POST['kategori'];


move_uploaded_file($tmp, "upload/".$gambar);

$query = "INSERT INTO buku
(
    nama_buku,
    penerbit,
    tahun_penerbit,
    jumlah_buku,
    gambar
)

VALUES
(
    '$nama',
    '$penerbit',
    '$tahun',
    '$jumlah',
    '$gambar'
)";

mysqli_query($conn, $query);

header("Location: tambah_buku.php");

?>