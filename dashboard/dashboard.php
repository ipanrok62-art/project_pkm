<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login/login.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$page_title = "Dashboard";

$conn = mysqli_connect("localhost","root","","perpustakaan");
$total_buku       = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM buku"))[0];
$total_peminjaman = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM peminjaman"))[0];
$total_peminjam   = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(DISTINCT nama_user) FROM peminjaman"))[0];
$sedang_dipinjam  = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM peminjaman WHERE status='Dipinjam'"))[0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
</head>
<body>

<?php include '../navbar/navbar.php'; ?>

    <h2 style="margin-bottom:24px; color:#333; font-family:Poppins,sans-serif;">
        Dashboard
    </h2>

    <div class="cards">
        <div class="card pink">
            <p>Total Buku </p>
            <h3><?= $total_buku ?> Buku</h3>
            
        </div>
        <div class="card blue">
            <p>Total Peminjaman</p>
            <h3><?= $total_peminjaman ?> Kali</h3>
        </div>
        <div class="card green">
            <p>Total Peminjam</p>
            <h3><?= $total_peminjam ?> Orang</h3>
        </div>
        <div class="card yellow">
            <p>Sedang Dipinjam</p>
            <h3><?= $sedang_dipinjam ?> Buku</h3>
        </div>
    </div>

<?php include '../navbar/tutup_navbar.php'; ?>

<script>
window.history.forward();
function noBack() { window.history.forward(); }
setTimeout("noBack()", 0);
window.onunload = function(){};
</script>

</body>
</html>