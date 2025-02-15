<?php
session_start();

// Cek login
if(!isset($_SESSION['username'])) {
    header("Location: ../../login.php");
    exit();
}

require_once '../../config/config.php';

// Cek apakah form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $nip = mysqli_real_escape_string($koneksi, $_POST['nip']);
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $id_departemen = mysqli_real_escape_string($koneksi, $_POST['id_departemen']);
    $id_jabatan = mysqli_real_escape_string($koneksi, $_POST['id_jabatan']);
    $jenis_kelamin = mysqli_real_escape_string($koneksi, $_POST['jenis_kelamin']);
    $tanggal_masuk = mysqli_real_escape_string($koneksi, $_POST['tanggal_masuk']);

    // Proses gaji
    $gaji = str_replace('.', '', $_POST['gaji']); // Hapus titik
    $gaji = mysqli_real_escape_string($koneksi, $gaji);

    // Validasi input
    $errors = [];
    if (empty($nip)) $errors[] = "NIP tidak boleh kosong";
    if (empty($nama)) $errors[] = "Nama tidak boleh kosong";
    if (empty($id_departemen)) $errors[] = "Departemen harus dipilih";
    if (empty($id_jabatan)) $errors[] = "Jabatan harus dipilih";
    if (empty($jenis_kelamin)) $errors[] = "Jenis kelamin harus dipilih";
    if (empty($tanggal_masuk)) $errors[] = "Tanggal masuk harus diisi";
    if (empty($gaji) || !is_numeric($gaji) || $gaji < 0) $errors[] = "Gaji harus diisi dengan angka positif";

    // Cek NIP unik
    $cek_nip = mysqli_query($koneksi, "SELECT * FROM pegawai WHERE nip = '$nip'");
    if (mysqli_num_rows($cek_nip) > 0) {
        $errors[] = "NIP sudah digunakan";
    }

    if (!empty($errors)) {
        $_SESSION['error'] = implode(", ", $errors);
        header("Location: ../../pages/pegawai/tambah.php");
        exit();
    }

    // Query tambah pegawai
    $query = "INSERT INTO pegawai (
        nip, 
        nama, 
        id_departemen, 
        id_jabatan, 
        gaji, 
        jenis_kelamin, 
        tanggal_masuk
    ) VALUES (
        '$nip', 
        '$nama', 
        '$id_departemen', 
        '$id_jabatan', 
        '$gaji', 
        '$jenis_kelamin', 
        '$tanggal_masuk'
    )";
    
    if (mysqli_query($koneksi, $query)) {
        // Redirect dengan pesan sukses
        $_SESSION['success'] = "Pegawai berhasil ditambahkan!";
        header("Location: ../../pages/pegawai/index.php");
        exit();
    } else {
        // Redirect dengan pesan error
        $_SESSION['error'] = "Gagal menambahkan pegawai: " . mysqli_error($koneksi);
        header("Location: ../../pages/pegawai/tambah.php");
        exit();
    }
} else {
    // Jika tidak melalui POST
    header("Location: ../../pages/pegawai/tambah.php");
    exit();
}
?>