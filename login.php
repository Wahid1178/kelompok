<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="container">
        <div class="header">Login</div>
        <?php
        // Tampilkan pesan kesalahan jika ada
        if (isset($_GET['error'])) {
            echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        // Tampilkan pesan sukses jika ada
        if (isset($_GET['success'])) {
            echo '<div class="success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
        <form action="process_login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            <button type="submit" class="btn">Login</button>
        </form>
        <div class="switch">
            <p>Don't have an account? <a href="registrasi.php">Register</a></p>
            <p><a href="reset_password.php">Forgot Your Password?</a></p>
        </div>
    </div>
</body>
</html>