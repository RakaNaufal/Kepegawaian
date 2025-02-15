<?php
session_start();
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = mysqli_real_escape_string($koneksi, $_POST['id']);
    $nama_jabatan = mysqli_real_escape_string($koneksi, $_POST['nama_jabatan']);
    $id_departemen = mysqli_real_escape_string($koneksi, $_POST['id_departemen']);
    
    // Hapus titik dari input gaji
    $gaji = mysqli_real_escape_string($koneksi, str_replace('.', '', $_POST['gaji']));

    // Validasi input
    if (empty($nama_jabatan) || empty($id_departemen) || empty($gaji)) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: ../../pages/jabatan/edit.php?id=$id");
        exit();
    }

    // Query update jabatan
    $query = "UPDATE jabatan SET nama_jabatan = '$nama_jabatan', id_departemen = '$id_departemen', gaji = '$gaji' WHERE id = '$id'";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Jabatan berhasil diperbarui!";
        header("Location: ../../pages/jabatan/index.php");
    } else {
        $_SESSION['error'] = "Gagal memperbarui jabatan: " . mysqli_error($koneksi);
        header("Location: ../../pages/jabatan/edit.php?id=$id");
    }
} else {
    header("Location: ../../pages/jabatan/index.php");
}
exit();
?>