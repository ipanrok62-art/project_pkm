<?php

session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login/login.php");
    exit;
}

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>
<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
<link rel="stylesheet" href="../sidebar/sidebar.css">
</head>
<body>

<div class="container">

```
<!-- PANGGIL SIDEBAR -->
<?php include '../sidebar/sidebar.php'; ?>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">
        <div class="user-menu" onclick="toggleMenu()">
            <img src="https://i.imgur.com/6VBx3io.png" class="avatar">
            <span>User</span>
        </div>

        <div class="dropdown" id="dropdownMenu">
            <a href="#">Profile</a>
            <a href="../login/login.php">Logout</a>
        </div>
    </div>

    <!-- TITLE -->
    <h2>Dashboard</h2>

    <!-- CARDS -->
    <div class="cards">
        <div class="card pink">
            <p>Total buku</p>
            <h3>3 Buku</h3>
        </div>

        <div class="card blue">
            <p>Total Peminjaman</p>
            <h3>2 Kali</h3>
        </div>

        <div class="card green">
            <p>Total Peminjam</p>
            <h3>2 Orang</h3>
        </div>

        <div class="card yellow">
            <p>Total buku yang sedang dipinjam</p>
            <h3>2 Orang</h3>
        </div>
    </div>

</div>

</div>

<!-- SCRIPT -->

<script>
function toggleMenu() {
    let menu = document.getElementById("dropdownMenu");
    menu.style.display = menu.style.display === "flex" ? "none" : "flex";
}

window.onclick = function(e) {
    if (!e.target.closest('.user-menu')) {
        document.getElementById("dropdownMenu").style.display = "none";
    }
}

function cariBuku(){
    let keyword = document.querySelector('.search-box input').value;
    alert("Mencari buku: " + keyword);
}
</script>

</body>
</html>
<script>
window.history.forward();
function noBack() {
    window.history.forward();
}
setTimeout("noBack()", 0);

window.onunload = function () { };
</script>
