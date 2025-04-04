<?php
session_start();

// Jika form admin disubmit
if (isset($_POST['admin_login'])) {
    $admin_password = $_POST['admin_password'];

    if ($admin_password === 'adminizrenk') {
        $_SESSION['role'] = 'admin';
        header("Location: home_admin.php");
        exit();
    } else {
        $error = "Sandi admin salah!";
    }
}

// Jika tombol karyawan ditekan
if (isset($_POST['karyawan_login'])) {
    $_SESSION['role'] = 'karyawan';
    header("Location: home.karyawan.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang - iZrenk Bengkel Hape</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h1 class="mb-4">iZrenk Bengkel Hape</h1>

        <!-- Tampilkan error jika sandi admin salah -->
        <?php if (!empty($error)) : ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <!-- Tombol Pilih Admin -->
        <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#adminModal">Masuk sebagai Admin</button>

        <!-- Tombol Pilih Karyawan -->
        <form method="POST" style="display: inline;">
            <button type="submit" name="karyawan_login" class="btn btn-success">Masuk sebagai Karyawan</button>
        </form>
    </div>

    <!-- Modal Admin untuk input sandi -->
    <div class="modal fade" id="adminModal" tabindex="-1" aria-labelledby="adminModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="adminModalLabel">Masukkan Sandi Admin</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="password" name="admin_password" class="form-control" placeholder="Sandi Admin" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="admin_login" class="btn btn-primary">Masuk</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
