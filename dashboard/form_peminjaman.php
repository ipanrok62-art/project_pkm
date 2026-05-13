<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

$data = mysqli_query($conn,"SELECT * FROM buku WHERE id='$id'");
$row = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Form Peminjaman</title>

<style>

body{
    font-family:Poppins,sans-serif;
    background:linear-gradient(135deg,#eef2ff,#dbeafe);
    padding:40px;
}

.container{
    width:380px;
    margin:auto;
    background:rgba(255,255,255,0.95);
    padding:25px;
    border-radius:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

.btn-kembali{
    display:inline-block;
    margin-bottom:20px;
    text-decoration:none;
    color:white;
    background:#7b2ff7;
    padding:10px 18px;
    border-radius:12px;
    font-weight:bold;
}

h1{
    text-align:center;
    margin-bottom:25px;
    color:#111827;
    font-size:30px;
}

label{
    font-weight:600;
    color:#374151;
}

input{
    width:100%;
    padding:14px;
    margin-top:8px;
    margin-bottom:20px;
    border:none;
    border-radius:14px;
    background:#f3f4f6;
    font-size:15px;
    box-sizing:border-box;
}

button{
    width:100%;
    padding:14px;
    border:none;
    border-radius:14px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    font-size:17px;
    font-weight:bold;
    cursor:pointer;
}

</style>

</head>
<body>

<div class="container">


<h1>Form Peminjaman Buku</h1>

<form action="proses_peminjaman.php" method="POST">

<input type="hidden" name="id_buku" value="<?= $row['id']; ?>">

<label>Nama Siswa</label>
<input type="text" name="nama_siswa" required>

<label>Kelas</label>
<input type="text" name="kelas" required>

<label>No Induk Siswa</label>
<input type="text" name="nis" required>

<label>Nama Buku</label>
<input type="text"
value="<?= $row['nama_buku']; ?>"
readonly>

<label>Penerbit</label>
<input type="text"
value="<?= $row['penerbit']; ?>"
readonly>

<label>Tahun Terbit</label>
<input type="text"
value="<?= $row['tahun_penerbit']; ?>"
readonly>

<label>Jumlah Buku Dipinjam</label>
<input type="number"
name="jumlah"
min="1"
required>

<button type="submit">
Pinjam Buku
</button>


</form>
<br>
<a href="peminjaman.php" class="btn-kembali">
    ← Kembali
</a>
</br>
</div>

</body>
</html>