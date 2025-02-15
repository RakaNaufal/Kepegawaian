<?php
include '../../tampilan/navbar.php';
require_once '../../config/config.php';

// Query untuk mendapatkan daftar jabatan dengan nama departemen
$query = "SELECT jabatan.*, departemen.nama_departemen 
          FROM jabatan 
          LEFT JOIN departemen ON jabatan.id_departemen = departemen.id";
$result = mysqli_query($koneksi, $query);
?>

<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <div class="flex justify-between items-center p-6  bg-gray-800 text-orange-400 border-b">
            <h3 class="text-xl font-semibold">Daftar Jabatan</h3>
            <a href="tambah.php" class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600 transition duration-300 flex items-center">
                <i class="fas fa-plus mr-2"></i> Tambah Jabatan
            </a>
        </div>
        
        <?php 
        if(isset($_SESSION['success'])) {
            echo '<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative m-4" role="alert">' . 
                 $_SESSION['success'] . 
                 '</div>';
            unset($_SESSION['success']);
        }

        if(isset($_SESSION['error'])) {
            echo '<div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative m-4" role="alert">' . 
                 $_SESSION['error'] . 
                 '</div>';
            unset($_SESSION['error']);
        }
        ?>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                <tr class="bg-gray-200 text-gray-700 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left w-16">No</th>
                        <th class="py-3 px-6 text-left">Nama Jabatan</th>
                        <th class="py-3 px-6 text-left">Departemen</th>
                        <th class="py-3 px-6 text-left">Gaji</th>
                        <th class="py-3 px-6 text-center w-24">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600 text-sm font-light">
                    <?php 
                    $no = 1;
                    while($row = mysqli_fetch_assoc($result)): 
                    ?>
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left whitespace-nowrap font-semibold text-gray-900">
                            <div class="flex items-center">
                                <?php echo $no++; ?>
                            </div>
                        </td>
                        <td class="py-3 px-6 text-left font-semibold text-gray-900">
                            <?php echo htmlspecialchars($row['nama_jabatan']); ?>
                        </td>
                        <td class="py-3 px-6 text-left font-semibold text-gray-900">
                            <?php echo htmlspecialchars($row['nama_departemen'] ?? 'Tidak Ada'); ?>
                        </td>
                        <td class="py-3 px-6 text-left font-semibold text-gray-900">
                            <?php echo 'Rp ' . number_format($row['gaji'], 0, ',', '.'); ?>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center">
                                <a href="edit.php?id=<?php echo $row['id']; ?>" 
                                   class="w-4 mr-2 transform text-yellow-500 hover:text-yellow-700 hover:scale-110">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="../../proses/jabatan/hapus.php?id=<?php echo $row['id']; ?>" 
                                   class="w-4 transform text-red-500 hover:text-red-700 hover:scale-110"
                                   onclick="return confirm('Yakin ingin menghapus pegawai ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>