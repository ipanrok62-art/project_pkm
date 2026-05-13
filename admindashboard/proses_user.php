<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

mysqli_query($conn, "

INSERT INTO user
(username,password,role)

VALUES

('$username','$password','$role')

");

header("Location:kelola_user.php");

?>