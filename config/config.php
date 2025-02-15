<?php
// Konfigurasi koneksi database
$host = "localhost";     
$username = "root";   
$password = "";        
$database = "db_kepegawaian";   

// Definisikan base URL secara dinamis
$base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/semester5_PBD/kepegawaian/';

// Buat koneksi
$koneksi = mysqli_connect($host, $username, $password, $database);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>