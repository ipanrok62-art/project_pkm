<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$data = mysqli_query($conn,"SELECT * FROM buku");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Peminjaman Buku</title>


<style>

body{
    font-family:Poppins,sans-serif;
    background:#eef1f7;
    padding:40px;
}

.container{
    background:white;
    padding:30px;
    border-radius:20px;
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
    text-align:center;
    border-bottom:1px solid #ddd;
}

.btn{
    padding:10px 15px;
    background:#7b2ff7;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

img{
    width:70px;
}

</style>

</head>
<body>

<div class="container">

<h1>Peminjaman Buku</h1>
<a href="dashboard.php" class="btn-kembali">
    ← Kembali
</a>


<table>

<tr>
    <th>No</th>
    <th>Gambar</th>
    <th>Nama Buku</th>
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

<td><?= $row['jumlah_buku']; ?></td>

<td>

<a class="btn"
href="form_peminjaman.php?id=<?= $row['id']; ?>">
Pinjam
</a>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>