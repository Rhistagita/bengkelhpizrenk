<?php
include 'koneksi.php'; // Koneksi ke database

// Ambil data jasa dari database
$query = "SELECT id, nama, keluhan, harga FROM jasa"; 
$result = $conn->query($query);

// Jika tombol hapus semua ditekan
if (isset($_POST['hapus_semua'])) {
    $conn->query("DELETE FROM jasa");
    echo "<script>alert('Semua data jasa telah dihapus!'); window.location.href='gaji_owner.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gaji Owner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/static/style.css">
    <script>
        function calculateTotal() {
            const rows = document.querySelectorAll('.data-row');
            let totalHarga = 0;

            rows.forEach(row => {
                const inputData = parseFloat(row.querySelector('.input-data').value || 0);
                totalHarga += inputData;
            });

            document.getElementById('total').innerText = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        }

        function addRow() {
            const tableBody = document.getElementById('data-table-body');
            const newRow = document.createElement('tr');
            newRow.className = 'data-row';

            newRow.innerHTML = `
                <td><input type="text" class="nama form-control" placeholder="Nama"></td>
                <td><input type="text" class="keluhan form-control" placeholder="Keluhan"></td>
                <td><input type="number" class="harga form-control" placeholder="Harga" onchange="calculateTotal()"></td>
                <td><input type="number" class="input-data form-control" placeholder="Input Data" onchange="calculateTotal()"></td>
            `;
            tableBody.appendChild(newRow);
        }

        function confirmDelete() {
            return confirm("Apakah Anda yakin ingin menghapus semua data?");
        }
    </script>    
</head>
<body>
    <div class="container">
        <header>
            <h1>Menu Gaji Owner</h1>
        </header>

        <section>
            <h2 class="mt-4">Data Jasa Karyawan</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Keluhan</th>
                        <th>Harga</th>
                        <th>Input Data</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="data-row">
                            <td><input type="text" class="nama form-control" value="<?= htmlspecialchars($row['nama']); ?>" readonly></td>
                            <td><input type="text" class="keluhan form-control" value="<?= htmlspecialchars($row['keluhan']); ?>" readonly></td>
                            <td><input type="number" class="harga form-control" value="<?= htmlspecialchars($row['harga']); ?>" onchange="calculateTotal()"></td>
                            <td><input type="number" class="input-data form-control" placeholder="Input Data" onchange="calculateTotal()"></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" style="text-align: right;"><strong>Jumlah:</strong></td>
                        <td id="total"><strong>Rp 0</strong></td>
                    </tr>
                </tfoot>
            </table>
            <button class="btn btn-primary" onclick="addRow()">Tambah Baris</button>

            <!-- Tombol Hapus Semua -->
            <form method="POST" onsubmit="return confirmDelete()" class="d-inline">
                <button type="submit" name="hapus_semua" class="btn btn-danger">Hapus Semua</button>
            </form>
        </section>        

        <footer>
            <div class="fixed-bottom bg-light">
                <div class="d-flex justify-content-around py-2">
                    <a href="home_admin.php" class="btn btn-primary">HOME</a>
                </div>
            </div>
        </footer>
    </div>
</body>
</html>
