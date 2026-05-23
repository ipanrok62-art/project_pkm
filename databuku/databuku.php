<?php
session_start();

$conn = mysqli_connect("localhost","root","","perpustakaan");

$search = "";
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : "";

if(isset($_GET['search'])){
    $search = trim($_GET['search']);
}

$params = [];
$types = "";
$conditions = [];

if($search != ""){
    $keyword = "%$search%";
    $conditions[] = "(nama_buku LIKE ? OR penerbit LIKE ? OR tahun_penerbit LIKE ?)";
    array_push($params, $keyword, $keyword, $keyword);
    $types .= "sss";
}

if($kategori != "" && $kategori != "Semua"){
    $conditions[] = "kategori = ?";
    $params[] = $kategori;
    $types .= "s";
}

if(count($conditions) > 0){
    $sql = "SELECT * FROM buku WHERE " . implode(" AND ", $conditions);
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, $types, ...$params);
    mysqli_stmt_execute($stmt);
    $data = mysqli_stmt_get_result($stmt);
} else {
    $data = mysqli_query($conn, "SELECT * FROM buku");
}

$kategori_result = mysqli_query($conn, "SELECT DISTINCT kategori FROM buku ORDER BY kategori ASC");
$kategori_list = [];
while($k = mysqli_fetch_assoc($kategori_result)){
    $kategori_list[] = $k['kategori'];
}

$current_page = basename($_SERVER['PHP_SELF']);
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
    display:flex;
}

/* ===== SIDEBAR ===== */
.sidebar{
    width:230px;
    min-height:100vh;
    background:linear-gradient(180deg,#7b2ff7 0%,#4facfe 100%);
    display:flex;
    flex-direction:column;
    position:fixed;
    top:0;
    left:0;
    height:100vh;
    z-index:100;
}

.sidebar-logo{
    padding:22px 20px;
    border-bottom:1px solid rgba(255,255,255,0.2);
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
    font-size:16px;
    font-weight:700;
}

.sidebar-logo svg{
    width:24px;
    height:24px;
    stroke:white;
    fill:none;
    stroke-width:2;
    flex-shrink:0;
}

.nav-label{
    font-size:10px;
    color:rgba(255,255,255,0.5);
    text-transform:uppercase;
    letter-spacing:1.2px;
    padding:16px 20px 6px;
}

.nav-item{
    display:flex;
    align-items:center;
    gap:12px;
    padding:12px 20px;
    color:rgba(255,255,255,0.75);
    text-decoration:none;
    font-size:13.5px;
    transition:all 0.2s;
    border-left:3px solid transparent;
}

.nav-item svg{
    width:20px;
    height:20px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
    flex-shrink:0;
}

.nav-item:hover{
    background:rgba(255,255,255,0.12);
    color:white;
}

.nav-item.active{
    background:rgba(255,255,255,0.2);
    color:white;
    border-left:3px solid white;
    font-weight:600;
}

.sidebar-footer{
    margin-top:auto;
    padding:20px;
    border-top:1px solid rgba(255,255,255,0.2);
}

.sidebar-footer a{
    display:flex;
    align-items:center;
    gap:10px;
    color:rgba(255,255,255,0.8);
    text-decoration:none;
    font-size:13px;
    transition:0.2s;
}

.sidebar-footer a:hover{
    color:white;
}

.sidebar-footer svg{
    width:18px;
    height:18px;
    stroke:currentColor;
    fill:none;
    stroke-width:1.8;
}

/* ===== MAIN CONTENT ===== */
.main-content{
    margin-left:230px;
    flex:1;
    padding:30px;
    min-height:100vh;
}

/* ===== TOPBAR ===== */
.topbar{
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:white;
    padding:14px 22px;
    border-radius:14px;
    margin-bottom:25px;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);
}

.topbar-title{
    font-size:17px;
    font-weight:700;
    color:#333;
}

.topbar-user{
    display:flex;
    align-items:center;
    gap:10px;
}

.topbar-avatar{
    width:36px;
    height:36px;
    border-radius:50%;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:13px;
    font-weight:700;
}

.topbar-name{
    font-size:13px;
    color:#555;
    font-weight:500;
}

/* ===== KONTEN BUKU ===== */
.container{
    width:100%;
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.07);
}

.page-header{
    margin-bottom:25px;
}

.page-header h1{
    color:#333;
    font-size:20px;
    font-weight:700;
}

.tab-nav{
    display:flex;
    gap:0;
    border-bottom:2px solid #e0e0e0;
    margin-bottom:25px;
    overflow-x:auto;
    scrollbar-width:none;
}

.tab-nav::-webkit-scrollbar{
    display:none;
}

.tab-item{
    padding:12px 20px;
    text-decoration:none;
    color:#666;
    font-size:14px;
    white-space:nowrap;
    border-bottom:3px solid transparent;
    margin-bottom:-2px;
    transition:all 0.2s;
}

.tab-item:hover{
    color:#7b2ff7;
}

.tab-item.active{
    color:#7b2ff7;
    border-bottom:3px solid #e07b39;
    font-weight:600;
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
    outline:none;
    font-family:Poppins,sans-serif;
}

.search-box input:focus{
    border-color:#7b2ff7;
}

.search-box button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    cursor:pointer;
    font-family:Poppins,sans-serif;
}

.book-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(200px,1fr));
    gap:20px;
}

.book-card{
    background:#fff;
    border-radius:16px;
    overflow:hidden;
    box-shadow:0 4px 16px rgba(0,0,0,0.08);
    transition:0.3s;
    border:1px solid #f0f0f0;
}

.book-card:hover{
    transform:translateY(-5px);
    box-shadow:0 8px 24px rgba(0,0,0,0.12);
}

.book-card img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.book-content{
    padding:15px;
}

.book-content h3{
    margin-bottom:8px;
    color:#333;
    line-height:1.5;
    font-size:13.5px;
    font-weight:600;
}

.book-content p{
    color:#666;
    margin-bottom:5px;
    font-size:12.5px;
}

.badge-kategori{
    display:inline-block;
    padding:3px 10px;
    background:#f0e6ff;
    color:#7b2ff7;
    border-radius:20px;
    font-size:11px;
    font-weight:600;
    margin-bottom:8px;
}

.btn{
    display:inline-block;
    margin-top:8px;
    padding:9px 14px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    text-decoration:none;
    border-radius:10px;
    font-size:12.5px;
    transition:0.3s;
    font-family:Poppins,sans-serif;
}

.btn:hover{
    opacity:0.9;
}

.stok-habis{
    color:#e53935;
    font-weight:bold;
    margin-top:8px;
    display:inline-block;
    font-size:12.5px;
}

.empty-state{
    text-align:center;
    padding:60px 0;
    color:#aaa;
    grid-column:1/-1;
    font-size:14px;
}

.empty-state span{
    font-size:48px;
    display:block;
    margin-bottom:12px;
}

</style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar">

    <div class="sidebar-logo">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
        </svg>
        Perpustakaan
    </div>

    <span class="nav-label">Menu Utama</span>

    <!-- Dashboard -->
    <a href="../dashboard/dashboard.php"
       class="nav-item <?= ($current_page=='dashboard.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
    </a>

    <!-- Data Buku -->
    <a href="../dashboard/buku.php"
       class="nav-item <?= ($current_page=='buku.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
        </svg>
        Data Buku
    </a>

    <!-- Peminjaman -->
    <a href="../dashboard/peminjaman.php"
       class="nav-item <?= ($current_page=='peminjaman.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Peminjaman
    </a>

    <!-- Riwayat -->
    <a href="../dashboard/riwayat.php"
       class="nav-item <?= ($current_page=='riwayat.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Riwayat
    </a>

    <!-- Pinjaman Aktif -->
    <a href="../dashboard/pinjaman_aktif.php"
       class="nav-item <?= ($current_page=='pinjaman_aktif.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Pinjaman Aktif
    </a>

    <div class="sidebar-footer">
        <a href="../logout.php">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
            Logout
        </a>
    </div>

</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">

    <!-- Topbar -->
    <div class="topbar">
        <span class="topbar-title">Data Buku</span>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= strtoupper(substr($_SESSION['nama'] ?? 'U', 0, 1)) ?>
            </div>
            <span class="topbar-name">
                <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?>
            </span>
        </div>
    </div>

    <!-- Konten -->
    <div class="container">

        <div class="page-header">
            <h1>Data Buku</h1>
        </div>

        <!-- Tab kategori -->
        <div class="tab-nav">
            <a href="?kategori=Semua&search=<?= urlencode($search) ?>"
               class="tab-item <?= ($kategori=='' || $kategori=='Semua') ? 'active' : '' ?>">
                Semua
            </a>
            <?php foreach($kategori_list as $kat) : ?>
            <a href="?kategori=<?= urlencode($kat) ?>&search=<?= urlencode($search) ?>"
               class="tab-item <?= ($kategori==$kat) ? 'active' : '' ?>">
                <?= htmlspecialchars($kat) ?>
            </a>
            <?php endforeach; ?>
        </div>

        <!-- Search -->
        <form method="GET" class="search-box">
            <input type="hidden" name="kategori" value="<?= htmlspecialchars($kategori) ?>">
            <input
                type="text"
                name="search"
                placeholder="Cari buku..."
                value="<?= htmlspecialchars($search) ?>">
            <button type="submit">Cari</button>
        </form>

        <!-- Grid buku -->
        <div class="book-grid">

            <?php
            $count = 0;
            while($row = mysqli_fetch_assoc($data)) :
                $count++;
            ?>

            <div class="book-card">
                <img src="../admindashboard/upload/<?= $row['gambar'] ?>"
                     onerror="this.src='../admindashboard/upload/default.jpg'">
                <div class="book-content">
                    <span class="badge-kategori"><?= htmlspecialchars($row['kategori']) ?></span>
                    <h3><?= htmlspecialchars($row['nama_buku']) ?></h3>
                    <p><b>Penerbit:</b> <?= htmlspecialchars($row['penerbit']) ?></p>
                    <p><b>Tahun:</b> <?= htmlspecialchars($row['tahun_penerbit']) ?></p>
                    <p><b>Stok:</b> <?= $row['jumlah_buku'] ?></p>

                    <?php if($row['jumlah_buku'] > 0) : ?>
                        <a class="btn" href="../dashboard/peminjaman.php?id=<?= $row['id'] ?>">
                            Pinjam
                        </a>
                    <?php else : ?>
                        <span class="stok-habis">Stok Habis</span>
                    <?php endif; ?>
                </div>
            </div>

            <?php endwhile; ?>

            <?php if($count == 0) : ?>
            <div class="empty-state">
                <span>📚</span>
                <p>Tidak ada buku ditemukan.</p>
            </div>
            <?php endif; ?>

        </div>

    </div>

</div>

</body>
</html>