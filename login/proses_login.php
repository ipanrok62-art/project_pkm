<?php

session_start();

$conn = mysqli_connect("localhost","root","","perpustakaan");

$username = $_POST['username'];
$password = $_POST['password'];

$query = mysqli_query($conn, "

SELECT * FROM 'user'

WHERE username='$username'

AND password='$password'

");

$cek = mysqli_num_rows($query);

if($cek > 0){

    $user = mysqli_fetch_assoc($query);

    $_SESSION['login'] = true;
    $_SESSION['role'] = $user['role'];
    $_SESSION['username'] = $user['username'];

    // JIKA ADMIN
    if($user['role'] == "admin"){

        header("Location: ../admindashboard/admindashboard.php");

    }

    // JIKA PENGGUNA
    else{

        header("Location: ../dashboard/dashboard.php");

    }

}else{

    echo "<script>
    alert('Username atau Password salah!');
    window.location.href = 'login.php';
    </script>";

}

?>