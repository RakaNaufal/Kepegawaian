<?php
session_start();
require_once '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_jabatan = mysqli_real_escape_string($koneksi, $_POST['nama_jabatan']);
    $id_departemen = mysqli_real_escape_string($koneksi, $_POST['id_departemen']);
    
    // Hapus titik dari input gaji
    $gaji = mysqli_real_escape_string($koneksi, str_replace('.', '', $_POST['gaji']));

    // Validasi input
    if (empty($nama_jabatan) || empty($id_departemen) || empty($gaji)) {
        $_SESSION['error'] = "Semua field harus diisi!";
        header("Location: ../../pages/jabatan/tambah.php");
        exit();
    }

    // Query tambah jabatan
    $query = "INSERT INTO jabatan (nama_jabatan, id_departemen, gaji) VALUES ('$nama_jabatan', '$id_departemen', '$gaji')";
    $result = mysqli_query($koneksi, $query);

    if ($result) {
        $_SESSION['success'] = "Jabatan berhasil ditambahkan!";
        header("Location: ../../pages/jabatan/index.php");
    } else {
        $_SESSION['error'] = "Gagal menambahkan jabatan: " . mysqli_error($koneksi);
        header("Location: ../../pages/jabatan/tambah.php");
    }
} else {
    header("Location: ../../pages/jabatan/index.php");
}
exit();
?>