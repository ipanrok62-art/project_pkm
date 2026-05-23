<?php

session_start();

// KONEKSI DATABASE
$conn = mysqli_connect("localhost", "root", "", "perpustakaan");

// CEK KONEKSI
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// AMBIL INPUT
$username = $_POST['username'];
$password = $_POST['password'];

// QUERY LOGIN
$sql = "SELECT * FROM `user` WHERE username='$username' AND password='$password'";

$query = mysqli_query($conn, $sql);

// CEK LOGIN
if (mysqli_num_rows($query) > 0) {

    $user = mysqli_fetch_assoc($query);

    $_SESSION['login'] = true;
    $_SESSION['username'] = $user['username'];
    $_SESSION['role'] = $user['role'];

    // JIKA ADMIN
    if ($user['role'] == "admin") {

        header("Location: ../admindashboard/admindashboard.php");
        exit;

    } 
    
    // JIKA USER
    else {

        header("Location: ../dashboard/dashboard.php");
        exit;

    }

} else {

    echo "
    <script>
        alert('Username atau Password salah!');
        window.location.href='login.php';
    </script>
    ";

}

?>