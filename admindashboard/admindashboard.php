<?php

session_start();

// Cegah cache browser
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Cek login admin
if(!isset($_SESSION['login']) || $_SESSION['role'] != 'admin'){
    header("Location: ../login/login.php");
    exit();
}

$conn = mysqli_connect("localhost","root","","perpustakaan");

// Total Judul Buku
$q_buku = mysqli_query($conn,"SELECT COUNT(*) AS total FROM buku");
$total_buku = mysqli_fetch_assoc($q_buku);

// Total Stok Buku
$q_stok = mysqli_query($conn,"SELECT SUM(jumlah_buku) AS total FROM buku");
$total_stok = mysqli_fetch_assoc($q_stok);

// Total Buku Dipinjam
$q_pinjam = mysqli_query($conn,"SELECT COUNT(*) AS total FROM peminjaman");
$total_pinjam = mysqli_fetch_assoc($q_pinjam);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="admindashboard.css">
</head>

<body>
    

<div class="sidebar">
    

    <h2>MENU ADMIN</h2>

    <ul>

        <li>
            <a href="../admindashboard/admindashboard.php">
                🏠 Dashboard
            </a>
        </li>

        <li>
            <a href="tambah_buku.php">
                ➕ Tambah Buku
            </a>
        </li>

        <li>
            <a href="data_buku.php">
                📚 Data Buku
            </a>
        </li>

        <li>
            <a href="kelola_user.php">
    👤 Kelola User
            </a>
        </li>

        <li>
            <a href="../laporan/laporan.php">
                📖 Laporan
            </a>
        </li>

        <li>
            <a href="../admindashboard/logout.php">
                🚪 Logout
            </a>
        </li>

    </ul>

</div>

<div class="content">

    <h1>Selamat Datang Admin</h1>
    <p>Silahkan pilih menu di sidebar.</p>

    <div class="dashboard-cards">

        <div class="card">
            <h3>📚 Total Judul Buku</h3>
            <h1><?= $total_buku['total']; ?></h1>
        </div>

        <div class="card">
            <h3>📦 Total Stok Buku</h3>
            <h1><?= $total_stok['total']; ?></h1>
        </div>

        <div class="card">
            <h3>📖 Buku Dipinjam</h3>
            <h1><?= $total_pinjam['total']; ?></h1>
        </div>

    </div>
    

</div>


</body>
</html>