<?php
session_start();

if(!isset($_SESSION['login'])){
    header("Location: ../login/login.php");
    exit;
}

$page_title = "Sedang Dipinjam";
$conn = mysqli_connect("localhost","root","","perpustakaan");

// Ambil daftar peminjam unik beserta jumlah buku
$peminjam = mysqli_query($conn,"
    SELECT nama_user, kelas, nis, COUNT(*) as jumlah_buku
    FROM peminjaman
    WHERE status='Dipinjam'
    GROUP BY nama_user, kelas, nis
    ORDER BY nama_user ASC
");

$total_peminjam = mysqli_num_rows($peminjam);
$total_buku = mysqli_fetch_row(mysqli_query($conn,"SELECT COUNT(*) FROM peminjaman WHERE status='Dipinjam'"))[0];

// Ambil semua data dipinjam untuk modal (JSON)
$semua = mysqli_query($conn,"SELECT * FROM peminjaman WHERE status='Dipinjam'");
$data_json = [];
while($r = mysqli_fetch_assoc($semua)){
    $data_json[$r['nama_user']][] = [
        'nama_buku'      => $r['nama_buku'],
        'penerbit'       => $r['penerbit'],
        'jumlah'         => $r['jumlah'],
        'tanggal_pinjam' => date('d M Y', strtotime($r['tanggal_pinjam'])),
    ];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sedang Dipinjam</title>
<style>

.container {
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.07);
}

.page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 24px;
    flex-wrap: wrap;
    gap: 12px;
}

.page-header h1 {
    font-size: 20px;
    font-weight: 700;
    color: #333;
}

.badges { display: flex; gap: 8px; flex-wrap: wrap; }

.badge {
    padding: 6px 16px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    color: white;
}

.badge-orang { background: linear-gradient(to right, #56ab2f, #a8e063); }
.badge-buku  { background: linear-gradient(to right, #f7971e, #ffd200); }

.search-wrapper { margin-bottom: 20px; }

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

table {
    width: 100%;
    border-collapse: collapse;
}

th {
    background: linear-gradient(to right, #56ab2f, #a8e063);
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
tr:hover td { background: #f9fff5; }

.btn-detail {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 7px 16px;
    background: linear-gradient(to right, #7b2ff7, #4facfe);
    color: white;
    border: none;
    border-radius: 8px;
    font-size: 12.5px;
    font-weight: 500;
    cursor: pointer;
    transition: opacity 0.2s;
}

.btn-detail:hover { opacity: 0.85; }

.no-result {
    text-align: center;
    padding: 40px;
    color: #aaa;
    font-size: 13.5px;
    display: none;
}

.empty-state {
    text-align: center;
    padding: 60px 20px;
    color: #bbb;
    font-size: 14px;
}

/* ===== MODAL ===== */
.modal-overlay {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.45);
    z-index: 999;
    align-items: center;
    justify-content: center;
}

.modal-overlay.show { display: flex; }

.modal {
    background: white;
    border-radius: 20px;
    padding: 30px;
    width: 90%;
    max-width: 620px;
    max-height: 80vh;
    overflow-y: auto;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    animation: slideUp 0.25s ease;
}

@keyframes slideUp {
    from { transform: translateY(30px); opacity: 0; }
    to   { transform: translateY(0);    opacity: 1; }
}

.modal-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    margin-bottom: 20px;
    gap: 10px;
}

.modal-header h2 {
    font-size: 17px;
    font-weight: 700;
    color: #333;
}

.modal-header p {
    font-size: 13px;
    color: #888;
    margin-top: 4px;
}

.modal-close {
    background: #f0f0f0;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 18px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    color: #555;
    transition: background 0.2s;
}

.modal-close:hover { background: #e0e0e0; }

.modal table th {
    background: linear-gradient(to right, #7b2ff7, #4facfe);
    border-radius: 0;
}

.modal table th:first-child { border-radius: 10px 0 0 10px; }
.modal table th:last-child  { border-radius: 0 10px 10px 0; }
.modal table td { font-size: 13px; }

</style>
</head>
<body>

<?php include '../navbar/navbar.php'; ?>

<div class="container">

    <div class="page-header">
        <h1>Sedang Dipinjam</h1>
        <div class="badges">
            <span class="badge badge-orang"><?= $total_peminjam ?> Peminjam</span>
            <span class="badge badge-buku"><?= $total_buku ?> Buku</span>
        </div>
    </div>

    <div class="search-wrapper">
        <div class="search-box">
            <svg class="icon-search" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <input type="text" id="searchInput" placeholder="Cari nama peminjam...">
        </div>
    </div>

    <?php if($total_peminjam > 0): ?>
    <table id="tabelPeminjam">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Kelas</th>
                <th>NIS</th>
                <th>Jumlah Buku</th>
                <th>Detail</th>
            </tr>
        </thead>
        <tbody>
        <?php $no = 1; while($row = mysqli_fetch_assoc($peminjam)): ?>
            <tr>
                <td><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_user']) ?></td>
                <td><?= htmlspecialchars($row['kelas']) ?></td>
                <td><?= htmlspecialchars($row['nis']) ?></td>
                <td><?= $row['jumlah_buku'] ?> Buku</td>
                <td>
                    <button class="btn-detail" onclick="lihatDetail('<?= htmlspecialchars($row['nama_user'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['kelas'], ENT_QUOTES) ?>', '<?= htmlspecialchars($row['nis'], ENT_QUOTES) ?>')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>
                        </svg>
                        Lihat Buku
                    </button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
    <div class="no-result" id="noResult">Tidak ada peminjam yang cocok.</div>

    <?php else: ?>
    <div class="empty-state">📚 Tidak ada buku yang sedang dipinjam.</div>
    <?php endif; ?>

</div>

<!-- MODAL DETAIL BUKU -->
<div class="modal-overlay" id="modalOverlay" onclick="tutupModal(event)">
    <div class="modal">
        <div class="modal-header">
            <div>
                <h2 id="modalNama"></h2>
                <p id="modalInfo"></p>
            </div>
            <button class="modal-close" onclick="document.getElementById('modalOverlay').classList.remove('show')">×</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Buku</th>
                    <th>Penerbit</th>
                    <th>Jumlah</th>
                    <th>Tgl Pinjam</th>
                </tr>
            </thead>
            <tbody id="modalTbody"></tbody>
        </table>
    </div>
</div>

<script>
const dataPeminjam = <?= json_encode($data_json, JSON_UNESCAPED_UNICODE) ?>;

function lihatDetail(nama, kelas, nis) {
    document.getElementById('modalNama').textContent = nama;
    document.getElementById('modalInfo').textContent = 'Kelas: ' + kelas + '   |   NIS: ' + nis;

    const buku = dataPeminjam[nama] || [];
    let html = '';
    buku.forEach(function(b, i) {
        html += '<tr>' +
            '<td>' + (i+1) + '</td>' +
            '<td>' + b.nama_buku + '</td>' +
            '<td>' + b.penerbit + '</td>' +
            '<td>' + b.jumlah + '</td>' +
            '<td>' + b.tanggal_pinjam + '</td>' +
        '</tr>';
    });

    document.getElementById('modalTbody').innerHTML = html;
    document.getElementById('modalOverlay').classList.add('show');
}

function tutupModal(e) {
    if(e.target === document.getElementById('modalOverlay')) {
        document.getElementById('modalOverlay').classList.remove('show');
    }
}

document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.toLowerCase().trim();
    const rows = document.querySelectorAll('#tabelPeminjam tbody tr');
    let found = 0;
    rows.forEach(function(row) {
        const text = row.innerText.toLowerCase();
        if(text.includes(keyword)) { row.style.display = ''; found++; }
        else { row.style.display = 'none'; }
    });
    document.getElementById('noResult').style.display = found === 0 ? 'block' : 'none';
});
</script>

<?php include '../navbar/tutup_navbar.php'; ?>

</body>
</html>