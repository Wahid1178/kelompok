<?php
session_start();
require_once 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $alamat = isset($_POST['alamat']) ? $_POST['alamat'] : '';
    $telepon = isset($_POST['telepon']) ? $_POST['telepon'] : '';

    // Validate input
    if (empty($name) || empty($email) || empty($password) || empty($role)) {
        header("Location: registrasi.php?error=Semua field harus diisi");
        exit();
    }

    // Validate password length
    if (strlen($password) < 8) {
        header("Location: registrasi.php?error=Kata sandi harus minimal 8 karakter");
        exit();
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: registrasi.php?error=Masukkan email yang valid");
        exit();
    }

    // Validate penyedia fields if role is penyedia
    if ($role === 'penyedia') {
        if (empty($alamat) || empty($telepon)) {
            header("Location: registrasi.php?error=Alamat dan nomor telepon wajib diisi untuk akun penyedia layanan");
            exit();
        }
        // Validate telepon format
        if (!empty($telepon) && !preg_match('/^[0-9]{10,13}$/', $telepon)) {
            header("Location: registrasi.php?error=Nomor telepon harus berupa angka dan antara 10-13 digit");
            exit();
        }
    }

    // Check if email already exists
    $check_query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($check_query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $stmt->close();
        header("Location: registrasi.php?error=Email sudah terdaftar");
        exit();
    }
    $stmt->close();

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Set is_admin based on role
    $is_admin = ($role === 'admin') ? 1 : 0;

    // Start transaction
    mysqli_begin_transaction($conn);

    try {
        // Insert user into database
        $insert_query = "INSERT INTO users (name, email, password, role, is_admin) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($insert_query);
        $stmt->bind_param("ssssi", $name, $email, $hashed_password, $role, $is_admin);
        if (!$stmt->execute()) {
            throw new Exception("Gagal mendaftarkan pengguna");
        }

        // Get the newly created user ID
        $user_id = $conn->insert_id;

        // If role is penyedia, save additional info
        if ($role === 'penyedia') {
            $insert_provider = "INSERT INTO penyedia_info (user_id, alamat, telepon) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insert_provider);
            $stmt->bind_param("iss", $user_id, $alamat, $telepon);
            if (!$stmt->execute()) {
                throw new Exception("Gagal menyimpan informasi penyedia");
            }
        }

        // Commit transaction
        mysqli_commit($conn);

        header("Location: login.php?success=Registrasi berhasil! Silakan login");
        exit();
    } catch (Exception $e) {
        // Rollback transaction on error
        mysqli_rollback($conn);
        header("Location: registrasi.php?error=Terjadi kesalahan: " . $e->getMessage());
        exit();
    } finally {
        if (isset($stmt) && $stmt) {
            $stmt->close();
        }
    }
} else {
    header("Location: registrasi.php");
    exit();
}
?>