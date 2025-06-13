<?php
session_start();
require_once 'config.php';

// Debug mode (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    if (empty($email) || empty($password)) {
        header("Location: login.php?error=Email dan password diperlukan");
        exit();
    }

    $query = "SELECT id, name, email, password, role, is_admin FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        error_log("Prepare failed: " . $conn->error, 3, "login_debug.log");
        header("Location: login.php?error=Terjadi kesalahan pada server");
        exit();
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            // Simpan session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['is_admin'] = $user['is_admin'];
            $_SESSION['logged_in'] = true;

            // Redirect sesuai role
            if ($user['is_admin'] == 1) {
                header("Location: admin_dashboard.php");
            } elseif ($user['role'] === 'penyedia') {
                header("Location: dashboard.php");
            } elseif ($user['role'] === 'pengunjung') {
                header("Location: index.php");
            } else {
                header("Location: index.php");
            }
            exit();
        } else {
            header("Location: login.php?error=Password salah");
            exit();
        }
    } else {
        header("Location: login.php?error=Akun tidak ditemukan");
        exit();
    }

    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}
?>
