<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$data = mysqli_query($conn,"
SELECT * FROM peminjaman
ORDER BY id DESC
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Riwayat Peminjaman</title>

<style>

body{
    font-family:Poppins,sans-serif;
    background:#eef2ff;
    padding:40px;
}

.container{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

h1{
    margin-bottom:25px;
}

.btn-dashboard{
    display:inline-block;
    margin-bottom:20px;
    background:#7b2ff7;
    color:white;
    padding:12px 18px;
    border-radius:12px;
    text-decoration:none;
    font-weight:bold;
}

.table-wrapper{
    overflow-x:auto;
}

.riwayat-table{
    width:100%;
    border-collapse:collapse;
    margin-top:20px;
}

.riwayat-table th{
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    padding:14px;
    text-align:center;
}

.riwayat-table td{
    padding:14px;
    border-bottom:1px solid #ddd;
    text-align:center;
}

.nama-buku{
    max-width:250px;
    white-space:normal;
    line-height:1.5;
}

.status-pinjam{
    background:#facc15;
    color:black;
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:bold;
}

.status-kembali{
    background:#22c55e;
    color:white;
    padding:6px 12px;
    border-radius:10px;
    font-size:13px;
    font-weight:bold;
}

.btn-kembali-buku{
    background:#ef4444;
    color:white;
    padding:8px 14px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:bold;
}

</style>

</head>
<body>

<div class="container">

<a href="dashboard.php" class="btn-dashboard">
← Kembali ke Dashboard
</a>

<h1>Riwayat Peminjaman Buku</h1>

<div class="table-wrapper">

<table class="riwayat-table">

<tr>
    <th>No</th>
    <th>Nama Siswa</th>
    <th>Kelas</th>
    <th>NIS</th>
    <th>Nama Buku</th>
    <th>Tanggal</th>
    <th>Jumlah</th>
    <th>Status</th>
    <th>Aksi</th>
</tr>

<?php $no=1; ?>

<?php while($r=mysqli_fetch_assoc($data)) : ?>

<tr>

<td><?= $no++; ?></td>

<td><?= $r['nama_user']; ?></td>

<td><?= $r['kelas']; ?></td>

<td><?= $r['nis']; ?></td>

<td class="nama-buku">
<?= $r['nama_buku']; ?>
</td>

<td><?= $r['tanggal_pinjam']; ?></td>

<td><?= $r['jumlah']; ?></td>

<td>

<?php if(isset($r['status']) && $r['status'] == 'Dipinjam') : ?>

<span class="status-pinjam">
Dipinjam
</span>

<?php else : ?>

<span class="status-kembali">
Dikembalikan
</span>

<?php endif; ?>

</td>

<td>

<?php if(isset($r['status']) && $r['status'] == 'Dipinjam') : ?>

<a href="kembalikan.php?id=<?= $r['id']; ?>"
class="btn-kembali-buku">
Kembalikan
</a>

<?php else : ?>

-

<?php endif; ?>

</td>

</tr>

<?php endwhile; ?>

</table>

</div>

</div>

</body>
</html>