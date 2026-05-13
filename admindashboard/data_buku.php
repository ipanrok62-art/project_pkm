<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$search = "";
$kategori = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

if(isset($_GET['kategori'])){
    $kategori = $_GET['kategori'];
}

$query = "SELECT * FROM buku WHERE 1";

if($search != ""){
    $query .= " AND nama_buku LIKE '%$search%'";
}

if($kategori != ""){
    $query .= " AND kategori='$kategori'";
}

$data = mysqli_query($conn, $query);

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
            font-family:Poppins, sans-serif;
        }

        body{
            background:#eef1f7;
            padding:40px;
        }

        .container{
            width:100%;
            background:white;
            padding:30px;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,0.1);
        }

        h1{
            margin-bottom:20px;
            color:#333;
        }

        .btn{
            display:inline-block;
            margin-bottom:20px;
            padding:10px 18px;
            background:#7b2ff7;
            color:white;
            text-decoration:none;
            border-radius:10px;
        }

        .search-box{
            display:flex;
            gap:10px;
            margin-bottom:25px;
            flex-wrap:wrap;
        }

        .search-box input,
        .search-box select{
            padding:12px;
            border-radius:10px;
            border:1px solid #ddd;
            font-size:15px;
        }

        .search-box input{
            width:300px;
        }

        .search-box button{
            padding:12px 20px;
            border:none;
            border-radius:10px;
            background:linear-gradient(to right,#7b2ff7,#4facfe);
            color:white;
            cursor:pointer;
            font-weight:bold;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{
            background:linear-gradient(to right,#7b2ff7,#4facfe);
            color:white;
            padding:15px;
        }

        table td{
            padding:15px;
            border-bottom:1px solid #ddd;
            text-align:center;
        }

        table tr:hover{
            background:#f5f5f5;
        }

        img{
            width:80px;
            border-radius:10px;
        }

    </style>

</head>
<body>

<div class="container">

    <a href="admindashboard.php" class="btn">
        ← Kembali
    </a>

    <h1>Data Buku</h1>

    <form method="GET" class="search-box">

        <input 
        type="text" 
        name="search"
        placeholder="Cari buku..."
        value="<?= $search; ?>">

        <select name="kategori">

            <option value="">Semua Kategori</option>

            <option value="Novel">Novel</option>
            <option value="Pelajaran">Pelajaran</option>
            <option value="Komik">Komik</option>
            <option value="Teknologi">Teknologi</option>
            <option value="Agama">Agama</option>

        </select>

        <button type="submit">
            Cari
        </button>

    </form>

    <table>

        <tr>
            <th>No</th>
            <th>Gambar</th>
            <th>Nama Buku</th>
            <th>Penerbit</th>
            <th>Kategori</th>
            <th>Tahun</th>
            <th>Jumlah</th>
            <th>Aksi</th>
        </tr>

        <?php $no = 1; ?>

        <?php while($row = mysqli_fetch_assoc($data)) : ?>

        <tr>

            <td><?= $no++; ?></td>

            <td>
                <img src="upload/<?= $row['gambar']; ?>">
            </td>

            <td><?= $row['nama_buku']; ?></td>

            <td><?= $row['penerbit']; ?></td>

            <td><?= $row['kategori']; ?></td>

            <td><?= $row['tahun_penerbit']; ?></td>

            <td><?= $row['jumlah_buku']; ?></td>
            <td>

    <a href="tambah_stok.php?id=<?= $row['id']; ?>" 
    style="
    padding:8px 12px;
    background:#4CAF50;
    color:white;
    text-decoration:none;
    border-radius:8px;
    ">
        +
    </a>

    <a href="kurang_stok.php?id=<?= $row['id']; ?>" 
    style="
    padding:8px 12px;
    background:#ff9800;
    color:white;
    text-decoration:none;
    border-radius:8px;
    ">
        -
    </a>

    <a href="hapus_buku.php?id=<?= $row['id']; ?>" 
    onclick="return confirm('Yakin hapus buku?')"
    style="
    padding:8px 12px;
    background:red;
    color:white;
    text-decoration:none;
    border-radius:8px;
    ">
        Hapus
    </a>

</td>
        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>