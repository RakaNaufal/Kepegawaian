<?php
session_start();

// Cek login
if(!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}

require_once '../../config/config.php';

// Cek apakah ID pegawai diberikan
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Cek apakah pegawai yang akan dihapus ada
    $cek_pegawai = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE id = '$id'");
    if (mysqli_num_rows($cek_pegawai) == 0) {
        $_SESSION['error'] = "Pegawai tidak ditemukan";
        header("Location: ../../pages/pegawai/index.php");
        exit();
    }

    // Proses hapus pegawai
    $query = "DELETE FROM pegawai WHERE id = '$id'";
    
    if (mysqli_query($koneksi, $query)) {
        $_SESSION['success'] = "Pegawai berhasil dihapus";
        header("Location: ../../pages/pegawai/index.php");
        exit();
    } else {
        $_SESSION['error'] = "Gagal menghapus pegawai: " . mysqli_error($koneksi);
        header("Location: ../../pages/pegawai/index.php");
        exit();
    }
} else {
    // Jika ID tidak diberikan
    $_SESSION['error'] = "ID pegawai tidak valid";
    header("Location: ../../pages/pegawai/index.php");
    exit();
}
?>