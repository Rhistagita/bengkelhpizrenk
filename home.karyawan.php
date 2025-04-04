<?php
session_start();

// Cek apakah user sudah login sebagai karyawan
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'karyawan') {
    header('Location: index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand">Home Karyawan</a>
            <a href="logout.php" class="btn btn-dark">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <header class="text-center">
            <h2>Selamat Datang, </h2>
            <p>Pilih menu di bawah untuk mengelola data:</p>
        </header>

        <!-- Tombol Navigasi -->
        <div class="text-center mt-4">
            <a href="jasa.php" class="btn btn-primary btn-lg mx-3">Kelola Jasa</a>
            <a href="cashbon.php" class="btn btn-danger btn-lg mx-3">Kelola Cashbon</a>
        </div>
    </div>
</body>
</html>
