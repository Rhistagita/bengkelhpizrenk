<?php
include 'koneksi.php'; // Koneksi ke database

// Periksa apakah koneksi berhasil
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$query = "SELECT * FROM jasa ORDER BY tanggal_input DESC";
$result = mysqli_query($koneksi, $query);

// Periksa apakah query berhasil
if (!$result) {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Jasa</title>
</head>
<body>
    <h1>Daftar Jasa</h1>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Keluhan</th>
                <th>Harga</th>
                <th>Tanggal Input</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['nama']) ?></td>
                    <td><?= htmlspecialchars($row['keluhan']) ?></td>
                    <td><?= htmlspecialchars($row['harga']) ?></td>
                    <td><?= htmlspecialchars($row['tanggal_input']) ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>
</html>