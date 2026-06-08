<?php
session_start();

$page_title = "Peminjaman Buku";
$conn = mysqli_connect("localhost","root","","perpustakaan");
$data = mysqli_query($conn,"SELECT * FROM buku");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Peminjaman Buku</title>
<style>

.container {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
}

h1 {
    font-size: 20px;
    font-weight: 700;
    color: #333;
    margin-bottom: 24px;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: #073c6b;
    color: white;
    padding: 14px 16px;
    text-align: center;
    font-size: 13.5px;
    font-weight: 600;
}

th:first-child { border-radius: 10px 0 0 10px; }
th:last-child  { border-radius: 0 10px 10px 0; }

td {
    padding: 14px 16px;
    border-bottom: 1px solid #f0f0f0;
    text-align: center;
    font-size: 13.5px;
    color: #444;
}

tr:last-child td { border-bottom: none; }
tr:hover td { background: #fafafa; }

td img {
    width: 65px;
    height: 85px;
    object-fit: cover;
    border-radius: 8px;
}

.btn {
    display: inline-block;
    padding: 8px 16px;
    background: linear-gradient(to right, #7b2ff7, #4facfe);
    color: white;
    text-decoration: none;
    border-radius: 8px;
    font-size: 12.5px;
    transition: opacity 0.2s;
}

.btn:hover { opacity: 0.85; }

.stok-habis {
    color: #e53935;
    font-weight: 600;
    font-size: 12.5px;
}

.search-wrapper {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
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

.no-result {
    text-align: center;
    padding: 30px;
    color: #aaa;
    font-size: 13.5px;
    display: none;
}

</style>
</head>
<body>

<?php include '../navbar/navbar.php'; ?>

    <div class="container">

        <h1>Peminjaman Buku</h1>

        <div class="search-wrapper">
            <div class="search-box">
                <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                <input type="text" id="searchInput" placeholder="Cari nama buku...">
            </div>
        </div>

        <table id="tablePeminjaman">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Gambar</th>
                    <th>Nama Buku</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>

            <?php $no = 1; ?>
            <?php while($row = mysqli_fetch_assoc($data)) : ?>

                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <img src="../admindashboard/upload/<?= $row['gambar'] ?>"
                             onerror="this.src='../admindashboard/upload/default.jpg'">
                    </td>
                    <td><?= htmlspecialchars($row['nama_buku']) ?></td>
                    <td><?= $row['jumlah_buku'] ?></td>
                    <td>
                        <?php if($row['jumlah_buku'] > 0) : ?>
                            <a class="btn" href="form_peminjaman.php?id=<?= $row['id'] ?>">
                                Pinjam
                            </a>
                        <?php else : ?>
                            <span class="stok-habis">Stok Habis</span>
                        <?php endif; ?>
                    </td>
                </tr>

            <?php endwhile; ?>

            </tbody>
        </table>

        <div class="no-result" id="noResult">Tidak ada buku yang cocok dengan pencarian.</div>

    </div>

<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tablePeminjaman tbody tr');
    let found = 0;

    rows.forEach(function (row) {
        const text = row.innerText.toLowerCase();
        if (text.includes(keyword)) {
            row.style.display = '';
            found++;
        } else {
            row.style.display = 'none';
        }
    });

    document.getElementById('noResult').style.display = found === 0 ? 'block' : 'none';
});
</script>

<?php include '../navbar/tutup_navbar.php'; ?>

</body>
</html>