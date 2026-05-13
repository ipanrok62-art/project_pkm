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
    padding:30px;
}

.container{
    width:100%;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

h1{
    margin-bottom:25px;
    color:#333;
}

.search-box{
    display:flex;
    gap:10px;
    margin-bottom:25px;
}

.search-box input{
    padding:12px;
    width:300px;
    border:1px solid #ddd;
    border-radius:10px;
}

.search-box button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    cursor:pointer;
}

.book-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(250px,1fr));
    gap:20px;
}

.book-card{
    background:#fff;
    border-radius:20px;
    overflow:hidden;
    box-shadow:0 5px 20px rgba(0,0,0,0.1);
    transition:0.3s;
}

.book-card:hover{
    transform:translateY(-5px);
}

.book-card img{
    width:100%;
    height:300px;
    object-fit:cover;
}

.book-content{
    padding:20px;
}

.book-content h3{
    margin-bottom:10px;
    color:#333;
    line-height:1.5;
}

.book-content p{
    color:#666;
    margin-bottom:8px;
}

.btn{
    display:inline-block;
    margin-top:10px;
    padding:10px 15px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    text-decoration:none;
    border-radius:10px;
    transition:0.3s;
}

.btn:hover{
    opacity:0.9;
}

.stok-habis{
    color:red;
    font-weight:bold;
    margin-top:10px;
    display:inline-block;
}

</style>

</head>
<body>

<div class="container">

<h1>Data Buku</h1>

<div class="search-box">

<input type="text" placeholder="Cari buku...">

<button>Cari</button>

</div>

<div class="book-grid">

<?php while($row=mysqli_fetch_assoc($data)) : ?>

<div class="book-card">

<img src="../admindashboard/upload/<?= $row['gambar']; ?>">

<div class="book-content">

<h3><?= $row['nama_buku']; ?></h3>

<p><b>Penerbit:</b> <?= $row['penerbit']; ?></p>

<p><b>Kategori:</b> <?= $row['kategori']; ?></p>

<p><b>Tahun:</b> <?= $row['tahun_penerbit']; ?></p>

<p><b>Stok:</b> <?= $row['jumlah_buku']; ?></p>

<?php if($row['jumlah_buku'] > 0) : ?>

<a class="btn"
href="../dashboard/peminjaman.php?id=<?= $row['id']; ?>">
Pinjam
</a>

<?php else : ?>

<span class="stok-habis">
Stok Habis
</span>

<?php endif; ?>

</div>

</div>

<?php endwhile; ?>

</div>

</div>

</body>
</html>