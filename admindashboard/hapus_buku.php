<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM buku 
WHERE id='$id'
");

header("Location:data_buku.php");

?>