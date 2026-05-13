<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin.css">
</head>
<body>

<div class="container">
    <div class="login-box">

        <h2>Admin Login</h2>

        <form action="proses_login.php" method="POST">

            <div class="input-box">

                <input type="text" name="username" required>

                <label>Username Admin</label>

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
                Login Admin
            </button>

            <p class="register">
                Masuk sebagai <a href="login.php">User?</a>
            </p>

        </form>

    </div>
</div>

</body>
</html>