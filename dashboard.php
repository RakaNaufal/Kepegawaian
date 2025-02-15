<?php
include 'tampilan/navbar.php';
require_once 'config/config.php';

// Query statistik
$query_total_pegawai = "SELECT COUNT(*) as total FROM pegawai";
$result_total_pegawai = mysqli_query($koneksi, $query_total_pegawai);
$total_pegawai = mysqli_fetch_assoc($result_total_pegawai)['total'];

$query_total_departemen = "SELECT COUNT(*) as total FROM departemen";
$result_total_departemen = mysqli_query($koneksi, $query_total_departemen);
$total_departemen = mysqli_fetch_assoc($result_total_departemen)['total'];

$query_total_jabatan = "SELECT COUNT(*) as total FROM jabatan";
$result_total_jabatan = mysqli_query($koneksi, $query_total_jabatan);
$total_jabatan = mysqli_fetch_assoc($result_total_jabatan)['total'];

$query_total_gaji = "SELECT SUM(gaji) as total_gaji FROM pegawai";
$result_total_gaji = mysqli_query($koneksi, $query_total_gaji);
$total_gaji = mysqli_fetch_assoc($result_total_gaji)['total_gaji'];

$query_pegawai_gender = "SELECT jenis_kelamin, COUNT(*) as total FROM pegawai GROUP BY jenis_kelamin";
$result_pegawai_gender = mysqli_query($koneksi, $query_pegawai_gender);
$pegawai_gender = mysqli_fetch_all($result_pegawai_gender, MYSQLI_ASSOC);

$query_gaji_departemen = "
    SELECT d.nama_departemen, AVG(p.gaji) as rata_rata_gaji
    FROM departemen d
    LEFT JOIN pegawai p ON d.id = p.id_departemen
    GROUP BY d.id, d.nama_departemen
";
$result_gaji_departemen = mysqli_query($koneksi, $query_gaji_departemen);
$rata_rata_gaji = mysqli_fetch_all($result_gaji_departemen, MYSQLI_ASSOC);

$departemen_labels = [];
$rata_gaji_values = [];
foreach ($rata_rata_gaji as $data) {
    $departemen_labels[] = $data['nama_departemen'];
    $rata_gaji_values[] = $data['rata_rata_gaji'];
}
?>

<div class="container mx-auto px-4 py-8">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-blue-700 text-white rounded-lg shadow-lg p-6 transition transform hover:scale-105">
            <h3 class="text-lg font-semibold">Total Pegawai</h3>
            <p class="text-3xl font-bold"><?php echo $total_pegawai; ?></p>
        </div>
        
        <div class="bg-blue-700 text-white rounded-lg shadow-lg p-6 transition transform hover:scale-105">
            <h3 class="text-lg font-semibold">Total Departemen</h3>
            <p class="text-3xl font-bold"><?php echo $total_departemen; ?></p>
        </div>

        <div class="bg-blue-700 text-white rounded-lg shadow-lg p-6 transition transform hover:scale-105">
            <h3 class="text-lg font-semibold">Total Jabatan</h3>
            <p class="text-3xl font-bold"><?php echo $total_jabatan; ?></p>
        </div>
        
        <div class="bg-blue-700 text-white rounded-lg shadow-lg p-6 transition transform hover:scale-105">
            <h3 class="text-lg font-semibold">Total Gaji Pegawai</h3>
            <p class="text-3xl font-bold">Rp <?php echo number_format($total_gaji, 0, ',', '.'); ?></p>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Komposisi Pegawai Berdasarkan Gender</h3>
            <canvas id="genderBarChart" style="max-width: 100%; height: 300px;"></canvas>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h3 class="text-xl font-semibold mb-4 text-gray-800 text-center">Rata-rata Gaji Pegawai per Departemen</h3>
            <canvas id="gajiBarChart" style="max-width: 100%; height: 300px;"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Grafik Komposisi Pegawai Berdasarkan Gender
const genderCtx = document.getElementById('genderBarChart').getContext('2d');
const genderData = {
    labels: [<?php foreach($pegawai_gender as $gender) { echo "'" . $gender['jenis_kelamin'] . "',"; } ?>],
    datasets: [{
        data: [<?php foreach($pegawai_gender as $gender) { echo $gender['total'] . ","; } ?>],
        backgroundColor: ['#4CAF50', '#FF5733'],
        borderWidth: 1
    }]
};
new Chart(genderCtx, {
    type: 'bar',
    data: genderData,
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false } // Sembunyikan label legend
        }
    }
});

// Grafik Rata-rata Gaji Pegawai per Departemen
const gajiCtx = document.getElementById('gajiBarChart').getContext('2d');
const gajiData = {
    labels: <?php echo json_encode($departemen_labels); ?>,
    datasets: [{
        data: <?php echo json_encode($rata_gaji_values); ?>,
        backgroundColor: [
            'rgba(54, 162, 235, 0.7)', 
            'rgba(255, 99, 132, 0.7)', 
            'rgba(255, 206, 86, 0.7)', 
            'rgba(75, 192, 192, 0.7)', 
            'rgba(153, 102, 255, 0.7)'
        ],
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
    }]
};

new Chart(gajiCtx, {
    type: 'bar',
    data: gajiData,
    options: {
        responsive: true,
        maintainAspectRatio: true,
        aspectRatio: 2,
        scales: {
            y: { beginAtZero: true }
        },
        plugins: {
            legend: { display: false } // Sembunyikan label legend
        }
    }
});

   
</script>
