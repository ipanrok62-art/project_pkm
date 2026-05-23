<?php
session_start();

$page_title = "Riwayat Peminjaman";
$conn = mysqli_connect("localhost","root","","perpustakaan");
$data = mysqli_query($conn,"SELECT * FROM peminjaman ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Riwayat Peminjaman</title>
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

.table-wrapper {
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    min-width: 700px;
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

.nama-buku {
    max-width: 220px;
    white-space: normal;
    line-height: 1.5;
    text-align: left;
}

.status-pinjam {
    display: inline-block;
    background: #fef9c3;
    color: #92400e;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.status-kembali {
    display: inline-block;
    background: #dcfce7;
    color: #166534;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.btn-kembalikan {
    display: inline-block;
    background: linear-gradient(to right, #ef4444, #f97316);
    color: white;
    padding: 7px 14px;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12.5px;
    font-weight: 600;
    transition: opacity 0.2s;
}

.btn-kembalikan:hover { opacity: 0.85; }

</style>
</head>
<body>

<?php include '../navbar/navbar.php'; ?>

    <div class="container">

        <h1>Riwayat Peminjaman Buku</h1>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>NIS</th>
                        <th>Nama Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Jumlah</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php $no = 1; ?>
                <?php while($r = mysqli_fetch_assoc($data)) : ?>

                    <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($r['nama_user']) ?></td>
                        <td><?= htmlspecialchars($r['kelas']) ?></td>
                        <td><?= htmlspecialchars($r['nis']) ?></td>
                        <td class="nama-buku"><?= htmlspecialchars($r['nama_buku']) ?></td>
                        <td><?= htmlspecialchars($r['tanggal_pinjam']) ?></td>
                        <td><?= $r['jumlah'] ?></td>
                        <td>
                            <?php if(isset($r['status']) && $r['status'] == 'Dipinjam') : ?>
                                <span class="status-pinjam">Dipinjam</span>
                            <?php else : ?>
                                <span class="status-kembali">Dikembalikan</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if(isset($r['status']) && $r['status'] == 'Dipinjam') : ?>
                                <a href="kembalikan.php?id=<?= $r['id'] ?>"
                                   class="btn-kembalikan"
                                   onclick="return confirm('Kembalikan buku ini?')">
                                    Kembalikan
                                </a>
                            <?php else : ?>
                                <span style="color:#aaa;">—</span>
                            <?php endif; ?>
                        </td>
                    </tr>

                <?php endwhile; ?>

                </tbody>
            </table>
        </div>

    </div>

<?php include '../navbar/tutup_navbar.php'; ?>

</body>
</html>