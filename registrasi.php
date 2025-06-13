<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Akun</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            background-color: #f5f9fc;
        }
        .register-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
        }
        .register-container h2 {
            text-align: center;
            color: #007b8b;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        .form-group .radio-group {
            display: flex;
            gap: 15px;
        }
        .form-group button {
            width: 100%;
            padding: 12px;
            background-color: #007b8b;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-group button:hover {
            background-color: #005f6b;
        }
        .error, .success {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            text-align: center;
        }
        .error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .success {
            background-color: #d4edda;
            color: #155724;
        }
        .links {
            text-align: center;
            margin-top: 15px;
        }
        .links a {
            color: #007b8b;
            text-decoration: none;
        }
        .links a:hover {
            text-decoration: underline;
        }
        .penyedia-fields {
            display: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registrasi Akun</h2>
        <?php
        if (isset($_GET['error'])) {
            echo '<div class="error">' . htmlspecialchars($_GET['error']) . '</div>';
        }
        if (isset($_GET['success'])) {
            echo '<div class="success">' . htmlspecialchars($_GET['success']) . '</div>';
        }
        ?>
        <form action="process_register.php" method="POST" onsubmit="return validateForm()">
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password (minimal 8 karakter)</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label>Pilih Jenis Akun</label>
                <div class="radio-group">
                    <label><input type="radio" name="role" value="pengunjung" checked onchange="togglePenyediaFields()"> Pengunjung</label>
                    <label><input type="radio" name="role" value="penyedia" onchange="togglePenyediaFields()"> Penyedia Layanan</label>
                    <!-- Opsi admin disembunyikan, aktifkan jika diperlukan -->
                    <!-- <label><input type="radio" name="role" value="admin" onchange="togglePenyediaFields()"> Admin</label> -->
                </div>
            </div>
            <div class="form-group penyedia-fields" id="penyediaFields">
                <label for="alamat">Alamat</label>
                <textarea name="alamat" id="alamat"></textarea>
            </div>
            <div class="form-group penyedia-fields" id="penyediaFieldsTelepon">
                <label for="telepon">Nomor Telepon</label>
                <input type="text" name="telepon" id="telepon">
            </div>
            <div class="form-group">
                <button type="submit">Daftar Sekarang</button>
            </div>
        </form>
        <div class="links">
            <p>Sudah memiliki akun? <a href="login.php">Login</a></p>
        </div>
    </div>

    <script>
        function togglePenyediaFields() {
            const role = document.querySelector('input[name="role"]:checked').value;
            const penyediaFields = document.querySelectorAll('.penyedia-fields');
            if (role === 'penyedia') {
                penyediaFields.forEach(field => field.style.display = 'block');
                document.getElementById('alamat').required = true;
                document.getElementById('telepon').required = true;
            } else {
                penyediaFields.forEach(field => field.style.display = 'none');
                document.getElementById('alamat').required = false;
                document.getElementById('telepon').required = false;
            }
        }

        function validateForm() {
            const password = document.getElementById('password').value;
            const email = document.getElementById('email').value;
            const telepon = document.getElementById('telepon').value;
            const role = document.querySelector('input[name="role"]:checked').value;

            // Validasi panjang kata sandi
            if (password.length < 8) {
                alert('Kata sandi harus minimal 8 karakter!');
                return false;
            }

            // Validasi format email
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Masukkan email yang valid!');
                return false;
            }

            // Validasi nomor telepon untuk penyedia
            if (role === 'penyedia') {
                const teleponRegex = /^[0-9]{10,13}$/;
                if (!teleponRegex.test(telepon)) {
                    alert('Nomor telepon harus berupa angka dan antara 10-13 digit!');
                    return false;
                }
            }

            return true;
        }
    </script>
</body>
</html>