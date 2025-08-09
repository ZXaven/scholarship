<?php
include('../config/database.php');

$id = (int)$_GET['id'];
$sql = "SELECT * FROM pendaftaran WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows !== 1) {
    echo "Data tidak ditemukan.";
    exit;
}

$row = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $nomor_hp = $conn->real_escape_string($_POST['nomor_hp']);
    $semester = (int)$_POST['semester'];
    $pilihan_beasiswa = $conn->real_escape_string($_POST['beasiswa']);
    $status_ajuan = $conn->real_escape_string($_POST['status_ajuan']);
    $ipk = (float)$_POST['ipk'];
    $file_berkas = $_FILES['berkas']['name'] ?? null;
    $file_path = $row['file_berkas'];

    if ($file_berkas) {
        $upload_dir = "../uploads/";
        $file_path = $upload_dir . basename($file_berkas);
        if (!move_uploaded_file($_FILES['berkas']['tmp_name'], $file_path)) {
            echo "<script>alert('Upload berkas gagal!'); window.history.back();</script>";
            exit;
        }
    }

    $sql = "UPDATE pendaftaran SET 
            nama = '$nama', 
            email = '$email', 
            nomor_hp = '$nomor_hp', 
            semester = $semester, 
            pilihan_beasiswa = '$pilihan_beasiswa', 
            status_ajuan = '$status_ajuan', 
            ipk = $ipk, 
            file_berkas = '$file_path'
            WHERE id = $id";

    if ($conn->query($sql)) {
        echo "<script>alert('Data berhasil diperbarui!'); window.location.href = 'list.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pendaftaran</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="../index.php" class="nav-logo">Beasiswa</a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="../index.php" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="register.php" class="nav-link">Daftar</a></li>
                <li class="nav-item"><a href="list.php" class="nav-link">Data Pendaftar</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2>Edit Data Pendaftaran</h2>
        
        <form action="edit.php?id=<?= $id; ?>" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" value="<?= $row['nama']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?= $row['email']; ?>" required>
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP:</label>
                <input type="number" id="nomor_hp" name="nomor_hp" value="<?= $row['nomor_hp']; ?>" required>
            </div>

            <div class="form-group">
                <label for="semester">Semester:</label>
                <select id="semester" name="semester" required>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i; ?>" <?= $i == $row['semester'] ? 'selected' : ''; ?>>Semester <?= $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ipk">IPK:</label>
                <input type="number" step="0.01" id="ipk" name="ipk" value="<?= $row['ipk']; ?>" min="0" max="4" required>
            </div>

            <div class="form-group">
                <label for="beasiswa">Jenis Beasiswa:</label>
                <select id="beasiswa" name="beasiswa" required>
                    <option value="Beasiswa Akademik" <?= $row['pilihan_beasiswa'] === 'Beasiswa Akademik' ? 'selected' : ''; ?>>Beasiswa Akademik</option>
                    <option value="Beasiswa Non-Akademik" <?= $row['pilihan_beasiswa'] === 'Beasiswa Non-Akademik' ? 'selected' : ''; ?>>Beasiswa Non-Akademik</option>
                </select>
            </div>

            <div class="form-group">
                <label for="status_ajuan">Status Ajuan:</label>
                <select id="status_ajuan" name="status_ajuan" required>
                    <option value="Belum diverifikasi" <?= $row['status_ajuan'] === 'Belum diverifikasi' ? 'selected' : ''; ?>>Belum diverifikasi</option>
                    <option value="Diterima" <?= $row['status_ajuan'] === 'Diterima' ? 'selected' : ''; ?>>Diterima</option>
                    <option value="Ditolak" <?= $row['status_ajuan'] === 'Ditolak' ? 'selected' : ''; ?>>Ditolak</option>
                </select>
            </div>

            <div class="form-group">
                <label for="berkas">Upload Berkas Baru (opsional):</label>
                <input type="file" id="berkas" name="berkas">
            </div>

            <?php if (!empty($row['file_berkas'])): ?>
                <div class="form-group">
                    <label>Berkas Saat Ini:</label>
                    <p><a href="../uploads/<?= $row['file_berkas']; ?>" target="_blank">Lihat Berkas</a></p>
                </div>
            <?php endif; ?>

            <button type="submit" class="btn">Simpan Perubahan</button>
        </form>

        <div class="text-center mt-3">
            <a href="list.php" class="btn btn-secondary">Kembali ke Daftar</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>