<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$data = mysqli_query($conn,"SELECT * FROM buku");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Buku</title>


<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins,sans-serif;
}

body{
    background:#eef1f7;
    padding:40px;
}

.container{
    background:white;
    padding:30px;
    border-radius:20px;
}

h1{
    margin-bottom:20px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th{
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    padding:15px;
}

td{
    padding:15px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

img{
    width:80px;
    border-radius:10px;
}

.btn{
    display:inline-block;
    padding:10px 15px;
    background:#7b2ff7;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

</style>

</head>
<body>

<div class="container">

<h1>Data Buku</h1>
<div class="container">

<a href="../dashboard/dashboard.php" class="btn-kembali">
    ← Kembali
</a>

<h1>Data Buku</h1>

<table>

<tr>
    <th>No</th>
    <th>Gambar</th>
    <th>Nama Buku</th>
    <th>Penerbit</th>
    <th>Kategori</th>
    <th>Tahun</th>
    <th>Stok</th>
    <th>Aksi</th>
</tr>

<?php $no=1; ?>

<?php while($row=mysqli_fetch_assoc($data)) : ?>

<tr>

<td><?= $no++; ?></td>

<td>
<img src="../admindashboard/upload/<?= $row['gambar']; ?>">
</td>

<td><?= $row['nama_buku']; ?></td>

<td><?= $row['penerbit']; ?></td>

<td><?= $row['kategori']; ?></td>

<td><?= $row['tahun_penerbit']; ?></td>

<td><?= $row['jumlah_buku']; ?></td>

<td>

<a class="btn"
href="pinjam.php?id=<?= $row['id']; ?>">
Pinjam
</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>