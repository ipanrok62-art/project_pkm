<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Buku</title>

    <link rel="stylesheet" href="tambah_buku.css">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

</head>
<body>

<div class="container">

    <div class="title">
        <h1>Tambah Buku</h1>
        <p>Masukkan data buku perpustakaan</p>
    </div>

    <form action="proses_tambah.php" method="POST" enctype="multipart/form-data">

        <div class="input-box">
            <label>Nama Buku</label>
            <input type="text" name="nama_buku" placeholder="Masukkan nama buku" required>
        </div>

         <div class="input-box">
            <label>Penerbit</label>
            <input type="text" name="penerbit" placeholder="Masukkan nama penerbit" required>
        </div>

        <div class="input-box">
            <label>Tahun Penerbit</label>
            <input type="number" name="tahun_penerbit" placeholder="Masukkan tahun penerbit" required>
        </div>

        <div class="input-box">
            <label>Jumlah Buku</label>
            <input type="number" name="jumlah_buku" placeholder="Masukkan jumlah buku" required>
        </div>

        <div class="input-box">
            <label>Upload Gambar Buku</label>

            <div class="upload-box">
                <input type="file" name="gambar" required>
            </div>
        </div>

        <button type="submit" class="btn">
            Tambah Buku
        </button>

        <div class="back-btn">
    <a href="admindashboard.php">
        ← Kembali ke Dashboard
    </a>
</div>
<div class="input-box">
    <label>Kategori Buku</label>

    <select name="kategori" required>

        <option value="">-- Pilih Kategori --</option>

        <option value="Novel">Novel</option>

        <option value="Pelajaran">Pelajaran</option>

        <option value="Komik">Komik</option>

        <option value="Teknologi">Teknologi</option>

        <option value="Agama">Agama</option>

    </select>

</div>

    </form>

</div>

</body>
</html>