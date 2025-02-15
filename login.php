<?php
session_start();
require_once 'config/config.php';

// Redirect ke dashboard jika sudah login
if(isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Proses login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil username dan password dari form
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Jangan di-escape

    // Query untuk mencari user
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    // Cek apakah user ditemukan
    if ($user = mysqli_fetch_assoc($result)) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Login berhasil
            $_SESSION['username'] = $username;
            $_SESSION['user_id'] = $user['id'];
            
            // Redirect ke dashboard
            header("Location: dashboard.php");
            exit();
        } else {
            // Password salah
            $_SESSION['error'] = "Username atau password salah!";
        }
    } else {
        // User tidak ditemukan
        $_SESSION['error'] = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistem Manajemen HR</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<body class="bg-green-50 flex items-center justify-center min-h-screen">
    <div class="max-w-md mx-auto bg-green-100 text-gray-900 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-700">Login Sistem</h2>
            
            <?php 
            if(isset($_SESSION['error'])) {
                echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">' . 
                     $_SESSION['error'] . 
                     '</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form action="" method="POST">
                <div class="mb-4">
                    <label class="block text-green-700 text-sm font-bold mb-2" for="username">
                        Username
                    </label>
                    <input 
                        class="shadow appearance-none border border-green-500 rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500" 
                        id="username" 
                        name="username" 
                        type="text" 
                        placeholder="Masukkan username"
                        required
                    >
                </div>
                <div class="mb-6">
                    <label class="block text-green-700 text-sm font-bold mb-2" for="password">
                        Password
                    </label>
                    <input 
                        class="shadow appearance-none border border-green-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-500" 
                        id="password" 
                        name="password" 
                        type="password" 
                        placeholder="Masukkan password"
                        required
                    >
                </div>
                <div class="flex items-center justify-between">
                    <button 
                        class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline w-full" 
                        type="submit">
                        Login
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
