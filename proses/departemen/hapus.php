<?php
session_start();
require_once '../../config/config.php';

// Cek apakah ID departemen diberikan
if (!isset($_GET['id']) || empty($_GET['id'])) {
    $_SESSION['error'] = "ID Departemen tidak valid";
    header("Location: ../../pages/departemen/index.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

try {
    // Mulai transaksi
    mysqli_begin_transaction($koneksi);

    // Hapus atau update jabatan yang terkait dengan departemen
    $update_jabatan_query = "UPDATE jabatan SET id_departemen = NULL WHERE id_departemen = '$id'";
    mysqli_query($koneksi, $update_jabatan_query);

    // Hapus departemen
    $delete_departemen_query = "DELETE FROM departemen WHERE id = '$id'";
    mysqli_query($koneksi, $delete_departemen_query);

    // Commit transaksi
    mysqli_commit($koneksi);

    // Set pesan sukses
    $_SESSION['success'] = "Departemen berhasil dihapus!";
    header("Location: ../../pages/departemen/index.php");
    exit();

} catch (Exception $e) {
    // Rollback transaksi jika terjadi error
    mysqli_rollback($koneksi);

    // Set pesan error
    $_SESSION['error'] = "Gagal menghapus departemen: " . $e->getMessage();
    header("Location: ../../pages/departemen/index.php");
    exit();
}
?>