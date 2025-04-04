<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi sudah benar

if (!isset($_SESSION['role'])) {
    header("Location: index.php");
    exit;
}

// Jika ingin batasi khusus admin
if ($_SESSION['role'] !== 'admin') {
    echo "<script>alert('Akses ditolak!'); window.location.href='index.php';</script>";
    exit;
}

// Ambil jumlah keluhan masuk
$query_keluhan = "SELECT COUNT(*) as total_keluhan FROM jasa";
$result_keluhan = $conn->query($query_keluhan);
$total_keluhan = ($result_keluhan->num_rows > 0) ? $result_keluhan->fetch_assoc()['total_keluhan'] : 0;

// Ambil total harga jasa
$query_harga = "SELECT SUM(harga) as total_harga FROM jasa";
$result_harga = $conn->query($query_harga);
$total_harga = ($result_harga->num_rows > 0) ? $result_harga->fetch_assoc()['total_harga'] : 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - iZrenk Bengkel Hape</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-3">
        <!-- Header dengan Logout -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0">Home Admin</h1>
            <a href="logout.php" class="btn btn-outline-danger">Logout</a>
        </div>

        <div class="row mt-4">
            <!-- Kartu Jumlah Keluhan -->
            <div class="col-md-6">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body text-center">
                        <h3>Jumlah Keluhan</h3>
                        <h2><?= $total_keluhan; ?></h2>
                    </div>
                </div>
            </div>

            <!-- Kartu Total Harga -->
            <div class="col-md-6">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body text-center">
                        <h3>Total Harga</h3>
                        <h2>Rp <?= number_format($total_harga, 0, ',', '.'); ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tombol Navigasi -->
        <div class="text-center mt-4">
            <a href="jasa.php" class="btn btn-primary">Tambah Jasa</a>
            <a href="gaji.php" class="btn btn-danger">Tabel Jasa</a>
            <a href="tabel_cashbon.php" class="btn btn-danger">Tabel Cashbon</a>
            <a href="cashbon.php" class="btn btn-primary">Tambah Cashbon</a>
        </div>
    </div>
</body>
</html>
