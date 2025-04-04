<?php
include 'koneksi.php'; // Pastikan koneksi ke database sudah benar

// Ambil data cashbon dari database
$query = "SELECT keterangan, tanggal, harga FROM cashbon ORDER BY tanggal DESC"; 
$result = $conn->query($query);

if (isset($_POST['hapus_semua'])) {
    $conn->query("DELETE FROM tabel_cashbon");
    echo "<script>alert('Semua data jasa telah dihapus!'); window.location.href='cashbon.php';</script>";
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabel Cashbon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function calculateTotal() {
            const rows = document.querySelectorAll('.data-row');
            let totalHarga = 0;

            rows.forEach(row => {
                const harga = parseFloat(row.querySelector('.harga').value || 0);
                totalHarga += harga;
            });

            document.getElementById('total').innerText = `Rp ${totalHarga.toLocaleString('id-ID')}`;
        }

        function addRow() {
            const tableBody = document.getElementById('data-table-body');
            const newRow = document.createElement('tr');
            newRow.className = 'data-row';

            newRow.innerHTML = `
                <td><input type="text" class="keterangan form-control" placeholder="Keterangan"></td>
                <td><input type="date" class="tanggal form-control"></td>
                <td><input type="number" class="harga form-control" placeholder="Harga" onchange="calculateTotal()"></td>
            `;
            tableBody.appendChild(newRow);
        }
    </script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center">Tabel Cashbon</h1>

        <section>
            <h2 class="mt-4">Data Cashbon</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Keterangan</th>
                        <th>Tanggal</th>
                        <th>Harga</th>
                    </tr>
                </thead>
                <tbody id="data-table-body">
                    <?php while ($row = $result->fetch_assoc()) { ?>
                        <tr class="data-row">
                            <td><input type="text" class="keterangan form-control" value="<?= htmlspecialchars($row['keterangan']); ?>" readonly></td>
                            <td><input type="date" class="tanggal form-control" value="<?= htmlspecialchars($row['tanggal']); ?>" readonly></td>
                            <td><input type="number" class="harga form-control" value="<?= htmlspecialchars($row['harga']); ?>" onchange="calculateTotal()"></td>
                        </tr>
                    <?php } ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" style="text-align: right;"><strong>Total:</strong></td>
                        <td id="total"><strong>Rp 0</strong></td>
                    </tr>
                </tfoot>
            </table>
            <button class="btn btn-primary" onclick="addRow()">Tambah Baris</button>
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
