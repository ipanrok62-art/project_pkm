<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

$data = mysqli_query($conn,"
SELECT * FROM peminjaman
WHERE id='$id'
");

$p = mysqli_fetch_assoc($data);

if($p['status'] == 'Dipinjam'){

    mysqli_query($conn,"
    UPDATE peminjaman
    SET status='Dikembalikan'
    WHERE id='$id'
    ");

    mysqli_query($conn,"
    UPDATE buku
    SET jumlah_buku = jumlah_buku + ".$p['jumlah']."
    WHERE nama_buku='".$p['nama_buku']."'
    ");

}

echo "
<script>
alert('Buku berhasil dikembalikan');
window.location='riwayat_peminjaman.php';
</script>
";

?>