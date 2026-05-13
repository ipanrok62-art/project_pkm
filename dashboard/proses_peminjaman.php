<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id_buku     = $_POST['id_buku'];
$nama_siswa  = $_POST['nama_siswa'];
$kelas       = $_POST['kelas'];
$nis         = $_POST['nis'];
$jumlah      = $_POST['jumlah'];

$data = mysqli_query($conn,"SELECT * FROM buku WHERE id='$id_buku'");
$buku = mysqli_fetch_assoc($data);

$stok = $buku['jumlah_buku'];

if($jumlah > $stok){

    echo "
    <script>
        alert('Stok buku tidak cukup!');
        window.history.back();
    </script>
    ";

}else{

    mysqli_query($conn,"INSERT INTO peminjaman
    (
        nama_user,
        kelas,
        nis,
        nama_buku,
        penerbit,
        tahun_terbit,
        tanggal_pinjam,
        jumlah
    )

    VALUES
    (
        '$nama_siswa',
        '$kelas',
        '$nis',
        '".$buku['nama_buku']."',
        '".$buku['penerbit']."',
        '".$buku['tahun_penerbit']."',
        NOW(),
        '$jumlah'
    )");

    $sisa = $stok - $jumlah;

    mysqli_query($conn,"UPDATE buku
    SET jumlah_buku='$sisa'
    WHERE id='$id_buku'");

    echo "
    <script>
        alert('Peminjaman berhasil!');
        window.location='peminjaman.php';
    </script>
    ";

}

?>