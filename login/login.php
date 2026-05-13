<?php

session_start();

header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login Form</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

    <div class="login-box">

        <h2>Login</h2>

        <form action="proses_login.php" method="POST">

            <div class="input-box">

                <input type="text" name="username" required>

                <label>Username</label>

            </div>

            <div class="input-box">

                <input type="password" name="password" required>

                <label>Password</label>

            </div>

            <div class="options">

                <label>
                    <input type="checkbox"> Remember Me
                </label>

            </div>

            <button type="submit">
                Log in
            </button>

            <p class="register">
                Masuk sebagai Admin?
                <a href="admin_login.php">Admin</a>
            </p>

        </form>

    </div>

</div>

</body>
</html>
<script>
window.history.forward();
function noBack() {
    window.history.forward();
}
setTimeout("noBack()", 0);

window.onunload = function () { };
</script>