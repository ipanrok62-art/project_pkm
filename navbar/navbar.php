<?php

$current_page = basename($_SERVER['PHP_SELF']);
?>

<style>
* {
    margin:0; padding:0;
    box-sizing:border-box;
    font-family:Poppins,sans-serif;
}

body {
    background:#eef1f7;
    display:flex;
}

.sidebar {
    width:230px;
    min-height:100vh;
    background: #092d6b;
    display:flex;
    flex-direction:column;
    position:fixed;
    top:0; left:0;
    height:100vh;
    z-index:100;
}

.sidebar-logo {
    padding:22px 20px;
    border-bottom:1px solid rgba(255,255,255,0.2);
    display:flex;
    align-items:center;
    gap:10px;
    color:white;
    font-size:16px;
    font-weight:700;
}

.sidebar-logo svg {
    width:24px; height:24px;
    stroke:white; fill:none; stroke-width:2;
    flex-shrink:0;
}

.nav-label {
    font-size:10px;
    color:rgba(255,255,255,0.5);
    text-transform:uppercase;
    letter-spacing:1.2px;
    padding:16px 20px 6px;
}

.nav-item {
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

.nav-item svg {
    width:20px; height:20px;
    stroke:currentColor; fill:none;
    stroke-width:1.8; flex-shrink:0;
}

.nav-item:hover {
    background:rgba(255,255,255,0.12);
    color:white;
}

.nav-item.active {
    background:rgba(255,255,255,0.2);
    color:white;
    border-left:3px solid white;
    font-weight:600;
}

.sidebar-footer {
    margin-top:auto;
    padding:20px;
    border-top:1px solid rgba(255,255,255,0.2);
}

.sidebar-footer a {
    display:flex;
    align-items:center;
    gap:10px;
    color:rgba(255,255,255,0.8);
    text-decoration:none;
    font-size:13px;
    transition:0.2s;
}

.sidebar-footer a:hover { color:white; }

.sidebar-footer svg {
    width:18px; height:18px;
    stroke:currentColor; fill:none; stroke-width:1.8;
}

.main-content {
    margin-left:230px;
    flex:1;
    padding:30px;
    min-height:100vh;
}

.topbar {
    display:flex;
    align-items:center;
    justify-content:space-between;
    background:white;
    padding:14px 22px;
    border-radius:14px;
    margin-bottom:25px;
    box-shadow:0 2px 12px rgba(0,0,0,0.06);
}

.topbar-title {
    font-size:17px;
    font-weight:700;
    color:#333;
}

.topbar-user {
    display:flex;
    align-items:center;
    gap:10px;
}

.topbar-avatar {
    width:36px; height:36px;
    border-radius:50%;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    display:flex;
    align-items:center;
    justify-content:center;
    color:white;
    font-size:13px;
    font-weight:700;
}

.topbar-name {
    font-size:13px;
    color:#555;
    font-weight:500;
}
</style>


<div class="sidebar">

    <div class="sidebar-logo">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
        </svg>
        Perpustakaan
    </div>

    <span class="nav-label">Menu Utama</span>

    <a href="/perpustakaan/dashboard/dashboard.php"
       class="nav-item <?= ($current_page=='dashboard.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <rect x="3" y="3" width="7" height="7" rx="1"/>
            <rect x="14" y="3" width="7" height="7" rx="1"/>
            <rect x="3" y="14" width="7" height="7" rx="1"/>
            <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
    </a>

    <a href="/perpustakaan/databuku/databuku.php"
       class="nav-item <?= ($current_page=='databuku.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25"/>
        </svg>
        Data Buku
        
    </a>

    <a href="/perpustakaan/dashboard/peminjaman.php"
       class="nav-item <?= ($current_page=='peminjaman.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5M16.5 12L12 16.5m0 0L7.5 12m4.5 4.5V3"/>
        </svg>
        Peminjaman
    </a>

    <a href="/perpustakaan/dashboard/riwayat_peminjaman.php"
       class="nav-item <?= ($current_page=='riwayat_peminjaman.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        Riwayat
    </a>

    <a href="/perpustakaan/dashboard/sedang_dipinjam.php"
       class="nav-item <?= ($current_page=='sedang_dipinjam.php') ? 'active' : '' ?>">
        <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z"/>
        </svg>
        Sedang Dipinjam
    </a>


    <div class="sidebar-footer">
        <a href="/perpustakaan/dashboard/logout.php">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75"/>
            </svg>
            Logout
        </a>
    </div>

</div>

<div class="main-content">

    <div class="topbar">
        <span class="topbar-title"><?= $page_title ?? 'Perpustakaan' ?></span>
        <div class="topbar-user">
            <div class="topbar-avatar">
                <?= strtoupper(substr($_SESSION['nama'] ?? 'U', 0, 1)) ?>
            </div>
            <span class="topbar-name">
                <?= htmlspecialchars($_SESSION['nama'] ?? 'User') ?>
            </span>
        </div>
    </div>