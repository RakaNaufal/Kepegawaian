<?php
session_start();
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama_departemen = mysqli_real_escape_string($koneksi, $_POST['nama_departemen']);
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    // Validasi input
    if (empty($nama_departemen)) {
        $_SESSION['error'] = "Nama departemen harus diisi!";
        header("Location: ../../pages/departemen/edit.php?id=$id");
        exit();
    }

    // Query update departemen
    $query = "UPDATE departemen SET nama_departemen = '$nama_departemen', deskripsi = '$deskripsi' WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Departemen berhasil diperbarui!";
        header("Location: ../../pages/departemen/index.php");
    } else {
        $_SESSION['error'] = "Gagal memperbarui departemen: " . mysqli_error($koneksi);
        header("Location: ../../pages/departemen/edit.php?id=$id");
    }
} else {
    header("Location: ../../pages/departemen/index.php");
}
exit();
?>