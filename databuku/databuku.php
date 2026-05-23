<?php
session_start();

$conn = mysqli_connect("localhost","root","","perpustakaan");

$search = "";
$query = "SELECT * FROM buku";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

if($search != ""){
    $keyword = "%$search%";
    $stmt = mysqli_prepare($conn, "SELECT * FROM buku WHERE nama_buku LIKE ? OR penerbit LIKE ? OR kategori LIKE ? OR tahun_penerbit LIKE ?");
    mysqli_stmt_bind_param($stmt, "ssss", $keyword, $keyword, $keyword, $keyword);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
}else{
    $data = mysqli_query($conn, $query);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Data Buku</title>

<style>

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

.search-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 25px;
}

.search-box {
    position: relative;
    width: 100%;
    max-width: 360px;
}

.search-box input {
    width: 100%;
    padding: 10px 16px 10px 40px;
    border: 1.5px solid #e0e0e0;
    border-radius: 10px;
    font-size: 13.5px;
    color: #333;
    outline: none;
    transition: border-color 0.2s;
    box-sizing: border-box;
}

.search-box input:focus {
    border-color: #7b2ff7;
    box-shadow: 0 0 0 3px rgba(123,47,247,0.08);
}

.search-box .icon-search {
    position: absolute;
    left: 12px;
    top: 50%;
    transform: translateY(-50%);
    color: #aaa;
    pointer-events: none;
}

.search-box input::placeholder { color: #bbb; }

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

<?php $page_title = 'Data Buku'; include '../navbar/navbar.php'; ?>

<div class="container">

<h1>Data Buku</h1>

<div class="search-wrapper">
    <div class="search-box">
        <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
        </svg>
        <input type="text" id="searchInput" placeholder="Cari buku...">
    </div>
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

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();
    const cards = document.querySelectorAll('.book-card');
    cards.forEach(function (card) {
        const text = card.innerText.toLowerCase();
        card.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>

<?php include '../navbar/tutup_navbar.php'; ?>

</body>
</html>