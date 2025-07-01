<?php
session_start();
require 'db.php';

if (isset($_POST['register'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $whatsapp = mysqli_real_escape_string($conn, $_POST['whatsapp']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Cek apakah email sudah terdaftar
    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($result) > 0) {
        $error = "Email sudah terdaftar.";
    } else {
        $query = "INSERT INTO users (nama, email, password, whatsapp, role) 
                  VALUES ('$nama', '$email', '$password', '$whatsapp', 'user')";
        if (mysqli_query($conn, $query)) {
            $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
            header("Location: login.php");
            exit;
        } else {
            $error = "Pendaftaran gagal: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar - Angel Beauty</title>
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', Arial, sans-serif;
    }

    body {
        background: linear-gradient(135deg, #fff5f5, #ffecef);
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        padding: 20px;
    }

    .register-container {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(255, 107, 107, 0.1);
        width: 100%;
        max-width: 450px;
        padding: 40px;
        text-align: center;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .logo {
        margin-bottom: 30px;
    }

    .logo img {
        width: 80px;
        height: 80px;
        object-fit: contain;
    }

    .logo h1 {
        color: #333;
        font-size: 28px;
        margin-top: 10px;
    }

    .logo h1 span {
        color: #ff6b6b;
    }

    .register-form {
        margin-top: 20px;
    }

    .input-group {
        margin-bottom: 20px;
        text-align: left;
        position: relative;
    }

    .input-group label {
        display: block;
        margin-bottom: 8px;
        color: #555;
        font-weight: 500;
    }

    .input-group input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.3s;
    }

    .input-group input:focus {
        border-color: #ff6b6b;
        box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
        outline: none;
    }

    .password-container {
        position: relative;
    }

    .toggle-password {
        position: absolute;
        right: 15px;
        top: 42px;
        transform: translateY(-50%);
        cursor: pointer;
        color: #999;
    }

    .register-btn {
        width: 100%;
        padding: 12px;
        background-color: #ff6b6b;
        color: white;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .register-btn:hover {
        background-color: #e55a5a;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
    }

    .error-message {
        color: #ff4444;
        background-color: #ffebee;
        padding: 10px;
        border-radius: 5px;
        margin-bottom: 20px;
        font-size: 14px;
    }

    .login-link {
        margin-top: 20px;
        color: #666;
        font-size: 14px;
    }

    .login-link a {
        color: #ff6b6b;
        text-decoration: none;
        font-weight: 500;
    }

    .login-link a:hover {
        text-decoration: underline;
    }

    .whatsapp-note {
        font-size: 12px;
        color: #888;
        margin-top: -15px;
        margin-bottom: 15px;
        text-align: left;
    }

    @media (max-width: 480px) {
        .register-container {
            padding: 30px 20px;
        }

        .logo h1 {
            font-size: 24px;
        }
    }
    </style>
</head>

<body>
    <div class="register-container">
        <div class="logo">
            <img src="logo.png" alt="Angel Beauty Logo">
            <h1>Angel<span>Beauty</span></h1>
        </div>

        <?php if (isset($error)) : ?>
        <div class="error-message"><?= $error ?></div>
        <?php endif; ?>

        <form class="register-form" method="POST">
            <div class="input-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" id="nama" name="nama" placeholder="Masukkan nama lengkap Anda" required>
            </div>

            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="contoh@email.com" required>
            </div>

            <div class="input-group">
                <label for="whatsapp">Nomor WhatsApp</label>
                <input type="tel" id="whatsapp" name="whatsapp" placeholder="081234567890" required>
            </div>

            <div class="input-group">
                <label for="password">Password</label>
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Buat password minimal 8 karakter"
                        required>
                    <span class="toggle-password" onclick="togglePassword()">👁️</span>
                </div>
            </div>

            <button type="submit" name="register" class="register-btn">Daftar Sekarang</button>
        </form>

        <p class="login-link">Sudah punya akun? <a href="login.php">Login di sini</a></p>
    </div>

    <script>
    function togglePassword() {
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.querySelector('.toggle-password');

        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            toggleIcon.textContent = '👁️‍🗨️';
        } else {
            passwordInput.type = 'password';
            toggleIcon.textContent = '👁️';
        }
    }

    // Format nomor WhatsApp saat input
    document.getElementById('whatsapp').addEventListener('input', function(e) {
        this.value = this.value.replace(/[^0-9]/g, '');
    });
    </script>
</body>

</html>