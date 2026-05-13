<?php

$conn = mysqli_connect("localhost","root","","perpustakaan");

$data = mysqli_query($conn, "SELECT * FROM user");

?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Kelola User</title>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family:Poppins,sans-serif;
}

body{
    background:#eef1f7;
    padding:40px;
}

.container{
    background:white;
    padding:30px;
    border-radius:20px;
    box-shadow:0 10px 30px rgba(0,0,0,0.1);
}

h1{
    margin-bottom:20px;
}

form{
    display:flex;
    gap:10px;
    margin-bottom:30px;
}

input,select{
    padding:12px;
    border-radius:10px;
    border:1px solid #ddd;
}

button{
    padding:12px 20px;
    border:none;
    border-radius:10px;
    background:linear-gradient(to right,#7b2ff7,#4facfe);
    color:white;
    cursor:pointer;
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

.btn-hapus{
    background:red;
    color:white;
    padding:8px 14px;
    text-decoration:none;
    border-radius:8px;
}

.kembali{
    display:inline-block;
    margin-bottom:20px;
    padding:10px 16px;
    background:#7b2ff7;
    color:white;
    text-decoration:none;
    border-radius:10px;
}

</style>

</head>
<body>

<div class="container">

<a href="admindashboard.php" class="kembali">
← Kembali
</a>

<h1>Kelola User</h1>

<form action="proses_user.php" method="POST">

    <input type="text" name="username"
    placeholder="Username" required>

    <input type="password" name="password"
    placeholder="Password" required>

    <select name="role" required>

        <option value="">Pilih Role</option>
        <option value="admin">Admin</option>
        <option value="pengguna">Pengguna</option>

    </select>

    <button type="submit">
        Tambah User
    </button>

</form>

<table>

<tr>
    <th>No</th>
    <th>Username</th>
    <th>Password</th>
    <th>Role</th>
    <th>Aksi</th>
</tr>

<?php $no = 1; ?>

<?php while($row = mysqli_fetch_assoc($data)) : ?>

<tr>

    <td><?= $no++; ?></td>

    <td><?= $row['username']; ?></td>

  <td><?= str_repeat('•', strlen($row['password'])); ?></td>

    <td><?= $row['role']; ?></td>

    <td>

        <a href="hapus_user.php?id=<?= $row['id']; ?>"
        onclick="return confirm('Yakin hapus user?')"
        class="btn-hapus">

            Hapus

        </a>

    </td>

</tr>

<?php endwhile; ?>

</table>

</div>

</body>
</html>