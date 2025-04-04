<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Cek apakah user memiliki sesi login
if (!isset($_SESSION['role'])) {
    header('Location: index.php');
    exit;
}

// Tambah Cashbon
if (isset($_POST['tambah_cashbon'])) {
    $keterangan = trim($_POST['keterangan']);
    $tanggal = trim($_POST['tanggal']);
    $harga = trim($_POST['harga']);

    if (!empty($keterangan) && !empty($tanggal) && !empty($harga)) {
        $query = "INSERT INTO cashbon (keterangan, tanggal, harga) VALUES (?, ?, ?)";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ssi", $keterangan, $tanggal, $harga);
            if ($stmt->execute()) {
                echo "<script>alert('Cashbon berhasil ditambahkan!'); window.location.href='cashbon.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Harap isi semua kolom!'); window.location.href='cashbon.php';</script>";
    }
}

// Edit Cashbon
if (isset($_POST['edit_cashbon'])) {
    $keterangan = trim($_POST['keterangan']);
    $tanggal = trim($_POST['tanggal']);
    $harga = trim($_POST['harga']);

    if (!empty($keterangan) && !empty($tanggal) && !empty($harga)) {
        $query = "UPDATE cashbon SET tanggal=?, harga=? WHERE keterangan=?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("sis", $tanggal, $harga, $keterangan);
            if ($stmt->execute()) {
                echo "<script>alert('Cashbon berhasil diperbarui!'); window.location.href='cashbon.php';</script>";
            } else {
                echo "Error: " . $stmt->error;
            }
            $stmt->close();
        }
    } else {
        echo "<script>alert('Harap isi semua kolom!'); window.location.href='cashbon.php';</script>";
    }
}

// Hapus Cashbon
if (isset($_POST['hapus_cashbon'])) {
    $keterangan = trim($_POST['keterangan']);

    $query = "DELETE FROM cashbon WHERE keterangan=?";
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param("s", $keterangan);
        if ($stmt->execute()) {
            echo "<script>alert('Cashbon berhasil dihapus!'); window.location.href='cashbon.php';</script>";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

// Ambil data cashbon dari database
$query = "SELECT * FROM cashbon ORDER BY tanggal DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Cashbon</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container mt-4">
        <h1 class="mb-4">Menu Cashbon</h1>

        <!-- Tombol Kembali ke Home -->
        <?php if ($_SESSION['role'] === 'admin') : ?>
            <a href="home_admin.php" class="btn btn-secondary mb-3">← Kembali ke Home Admin</a>
        <?php elseif ($_SESSION['role'] === 'karyawan') : ?>
            <a href="home.karyawan.php" class="btn btn-secondary mb-3">← Kembali ke Home Karyawan</a>
        <?php endif; ?>

        <section>
            <h2>Daftar Cashbon</h2>
            <ul class="list-group">
                <?php while ($row = $result->fetch_assoc()) : ?>
                    <li class="list-group-item d-flex justify-content-between align-items-start">
                        <div>
                            <strong>Keterangan:</strong> <?php echo htmlspecialchars($row['keterangan']); ?><br>
                            <strong>Tanggal:</strong> <?php echo htmlspecialchars($row['tanggal']); ?><br>
                            <strong>Harga:</strong> Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?><br>
                        </div>
                        <div>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editModal<?php echo htmlspecialchars($row['keterangan']); ?>">Edit</button>
                            <form method="POST" action="cashbon.php" class="d-inline">
                                <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($row['keterangan']); ?>">
                                <button class="btn btn-danger btn-sm" name="hapus_cashbon" onclick="return confirm('Yakin ingin menghapus cashbon ini?');">Hapus</button>
                            </form>
                        </div>
                    </li>

                    <div class="modal fade" id="editModal<?php echo htmlspecialchars($row['keterangan']); ?>" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Cashbon</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="cashbon.php">
                                        <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars($row['keterangan']); ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Tanggal</label>
                                            <input type="date" class="form-control" name="tanggal" value="<?php echo htmlspecialchars($row['tanggal']); ?>" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Harga</label>
                                            <input type="number" class="form-control" name="harga" value="<?php echo $row['harga']; ?>" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-primary" name="edit_cashbon">Simpan Perubahan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </ul>
        </section>

        <div class="text-center my-4">
            <button class="btn btn-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#inputModal">+</button>
        </div>
    </div>

    <div class="modal fade" id="inputModal" tabindex="-1" aria-labelledby="inputModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Cashbon</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="cashbon.php">
                        <div class="mb-3">
                            <label class="form-label">Keterangan</label>
                            <input type="text" class="form-control" name="keterangan" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="date" class="form-control" name="tanggal" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Harga</label>
                            <input type="number" class="form-control" name="harga" required>
                        </div>
                        <button type="submit" class="btn btn-primary" name="tambah_cashbon">Tambah</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
