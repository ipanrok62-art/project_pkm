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
    background: linear-gradient(to right, #7b2ff7, #4facfe);
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

</style>
</head>
<body>

<?php include '../navbar/navbar.php'; ?>

    <div class="container">

        <h1>Peminjaman Buku</h1>

        <table>
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

    </div>

<?php include '../navbar/tutup_navbar.php'; ?>

</body>
</html>