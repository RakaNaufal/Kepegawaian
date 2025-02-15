<?php
session_start();
require_once '../../config/config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($koneksi, $_GET['id']);

    // Query hapus jabatan
    $query = "DELETE FROM jabatan WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Jabatan berhasil dihapus!";
    } else {
        $_SESSION['error'] = "Gagal menghapus jabatan: " . mysqli_error($koneksi);
    }
}

header("Location: ../../pages/jabatan/index.php");
exit();
?>