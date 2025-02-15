<?php
session_start();
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_departemen = mysqli_real_escape_string($koneksi, $_POST['nama_departemen']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Validasi input
    if (empty($nama_departemen)) {
        $_SESSION['error'] = "Nama departemen harus diisi!";
        header("Location: ../../pages/departemen/tambah.php");
        exit();
    }

    // Query tambah departemen
    $query = "INSERT INTO departemen (nama_departemen, deskripsi) VALUES ('$nama_departemen', '$deskripsi')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Departemen berhasil ditambahkan!";
        header("Location: ../../pages/departemen/index.php");
    } else {
        $_SESSION['error'] = "Gagal menambahkan departemen: " . mysqli_error($koneksi);
        header("Location: ../../pages/departemen/tambah.php");
    }
} else {
    header("Location: ../../pages/departemen/index.php");
}
exit();
?>