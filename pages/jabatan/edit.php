<?php
include '../../tampilan/navbar.php';
require_once '../../config/config.php';

// Periksa apakah ID jabatan valid
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = mysqli_real_escape_string($koneksi, $_GET['id']);

// Query untuk mendapatkan daftar departemen
$query_departemen = "SELECT * FROM departemen";
$result_departemen = mysqli_query($koneksi, $query_departemen);

// Ambil data jabatan yang akan diedit
$query = "SELECT * FROM jabatan WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    header("Location: index.php");
    exit();
}

$jabatan = mysqli_fetch_assoc($result);
?>

<div class="container mx-auto px-4 py-8">
    <div class="max-w-md mx-auto bg-gray-200 text-gray-900 shadow-lg rounded-lg px-8 pt-6 pb-8 mb-4">
        <h2 class="text-2xl font-bold mb-6 text-center text-green-600">Edit Jabatan</h2>
        
        <form action="../../proses/jabatan/edit.php" method="POST" class="p-6">
            <input type="hidden" name="id" value="<?php echo $jabatan['id']; ?>">
            
            <div class="mb-4">
                <label for="nama_jabatan" class="block text-green-700 text-sm font-bold mb-2">Nama Jabatan</label>
                <input type="text" name="nama_jabatan" id="nama_jabatan" required 
                       value="<?php echo htmlspecialchars($jabatan['nama_jabatan']); ?>"
                       class="shadow appearance-none border border-green-500 bg-gray-100 text-gray-900 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-400"
                        placeholder="Masukkan nama jabatan">
            </div>

            <div class="mb-4">
                <label for="nama_jabatan" class="block text-green-700 text-sm font-bold mb-2">Departemen</label>
                <select name="id_departemen" id="id_departemen" required
                class="shadow appearance-none border border-green-500 bg-gray-100 text-gray-900 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-400">
                    <option value="">Pilih Departemen</option>
                    <?php 
                    mysqli_data_seek($result_departemen, 0); // Reset pointer result
                    while($departemen = mysqli_fetch_assoc($result_departemen)): ?>
                        <option value="<?php echo $departemen['id']; ?>"
                            <?php echo ($departemen['id'] == $jabatan['id_departemen']) ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($departemen['nama_departemen']); ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div class="mb-6">
                <label for="nama_jabatan" class="block text-green-700 text-sm font-bold mb-2">Gaji</label>
                <input type="text" name="gaji" id="gaji" required 
                       value="<?php echo number_format($jabatan['gaji'], 0, ',', '.'); ?>"
                        class="shadow appearance-none border border-green-500 bg-gray-100 text-gray-900 rounded w-full py-2 px-3 leading-tight focus:outline-none focus:ring-2 focus:ring-green-400"
                        placeholder="Masukkan Gaji"
                       onkeyup="formatRupiah(this)">
            </div>

            <div class="flex items-center justify-end space-x-4">
                <a href="index.php" class="inline-block align-baseline font-bold text-sm text-green-600 hover:text-green-500">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

</body>
<script>
function formatRupiah(input) {
    // Hapus karakter selain angka
    let value = input.value.replace(/[^\d]/g, '');
    
    // Format dengan titik sebagai pemisah ribuan
    input.value = formatNumber(value);
}

function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
</script>
</html>