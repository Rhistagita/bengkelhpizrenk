<?php
session_start();
include 'koneksi.php'; // Pastikan koneksi sudah benar

// Cek role
if (!isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

// Tambah Jasa
if (isset($_POST['tambah_jasa'])) {
    $nama = trim($_POST['nama']);
    $keluhan = trim($_POST['keluhan']);
    $harga = trim($_POST['harga']);

    if (!empty($nama) && !empty($keluhan) && !empty($harga)) {
        $query = "INSERT INTO jasa (nama, keluhan, harga) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssi", $nama, $keluhan, $harga);
            if ($stmt->execute()) {
                echo "<script>alert('Jasa berhasil ditambahkan!'); window.location.href='jasa.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Harap isi semua kolom!'); window.location.href='jasa.php';</script>";
    }
}

// Edit Jasa
if (isset($_POST['edit_jasa'])) {
    $id = $_POST['id'];
    $nama = trim($_POST['nama']);
    $keluhan = trim($_POST['keluhan']);
    $harga = trim($_POST['harga']);

    if (!empty($nama) && !empty($keluhan) && !empty($harga)) {
        $query = "UPDATE jasa SET nama=?, keluhan=?, harga=? WHERE id=?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssii", $nama, $keluhan, $harga, $id);
            if ($stmt->execute()) {
                echo "<script>alert('Jasa berhasil diperbarui!'); window.location.href='jasa.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Harap isi semua kolom!'); window.location.href='jasa.php';</script>";
    }
}

// Hapus Jasa
if (isset($_POST['hapus_jasa'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM jasa WHERE id=?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('Jasa berhasil dihapus!'); window.location.href='home_admin.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Ambil data jasa dari database
$query = "SELECT * FROM jasa ORDER BY id DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Jasa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <header>
            <h1 class="text-center">Menu Jasa</h1>
        </header>

        <!-- Tombol Kembali dan Logout -->
        <div class="d-flex justify-content-between mb-4">
            <?php if ($_SESSION['role'] === 'admin') : ?>
                <a href="home_admin.php" class="btn btn-secondary">← Kembali ke Home Admin</a>
            <?php elseif ($_SESSION['role'] === 'karyawan') : ?>
                <a href="home.karyawan.php" class="btn btn-secondary">← Kembali ke Home Karyawan</a>
            <?php endif; ?>
            <a href="logout.php" class="btn btn-danger ms-auto">Logout</a>
        </div>

        <section id="serviceList" class="mt-4">
            <h2>Daftar Jasa</h2>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Nama Jasa:</strong> <?= htmlspecialchars($row['nama']); ?><br>
                            <strong>Keluhan:</strong> <?= htmlspecialchars($row['keluhan']); ?><br>
                            <strong>Harga:</strong> Rp <?= number_format($row['harga'], 0, ',', '.'); ?><br>
                        </div>
                        <div>
                            <!-- Tombol Edit -->
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id']; ?>">Edit</button>
                            <!-- Tombol Hapus -->
                            <form method="POST" action="jasa.php" class="d-inline">
                                <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                <button class="btn btn-danger btn-sm" name="hapus_jasa" onclick="return confirm('Yakin ingin menghapus jasa ini?');">Hapus</button>
                            </form>
                        </div>
                    </li>

                    <!-- Modal Edit -->
                    <div class="modal fade" id="editModal<?= $row['id']; ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Jasa</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="jasa.php">
                                        <input type="hidden" name="id" value="<?= $row['id']; ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Nama</label>
                                            <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Keluhan</label>
                                            <textarea class="form-control" name="keluhan" rows="3" required><?= htmlspecialchars($row['keluhan']); ?></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Harga</label>
                                            <input type="number" class="form-control" name="harga" value="<?= $row['harga']; ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" name="edit_jasa">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </ul>
        </section>

        <!-- Tombol Tambah Jasa -->
        <div class="text-center my-4">
            <button class="btn btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#inputModal">+</button>
        </div>
    </div>

    <!-- Modal Tambah Jasa -->
    <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Jasa</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="jasa.php">
                        <div class="mb-3">
                            <label class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Keluhan</label>
                            <textarea class="form-control" name="keluhan" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="tambah_jasa">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
