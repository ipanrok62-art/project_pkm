<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$id = $_GET['id'];

mysqli_query($conn, "
DELETE FROM user
WHERE id='$id'
");

header("Location:kelola_user.php");

?>