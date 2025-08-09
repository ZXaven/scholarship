<?php
include('../config/database.php');

$sql = "SELECT * FROM pendaftaran ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    echo "Data tidak ditemukan.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pendaftaran</title>
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
        <h2>Hasil Pendaftaran</h2>
        
        <div class="form-group">
            <label>Nama:</label>
            <p><?= htmlspecialchars($data['nama']); ?></p>
        </div>
        
        <div class="form-group">
            <label>Email:</label>
            <p><?= htmlspecialchars($data['email']); ?></p>
        </div>
        
        <div class="form-group">
            <label>Nomor HP:</label>
            <p><?= htmlspecialchars($data['nomor_hp']); ?></p>
        </div>
        
        <div class="form-group">
            <label>Semester:</label>
            <p><?= $data['semester']; ?></p>
        </div>
        
        <div class="form-group">
            <label>IPK:</label>
            <p><?= $data['ipk']; ?></p>
        </div>
        
        <div class="form-group">
            <label>Jenis Beasiswa:</label>
            <p><?= htmlspecialchars($data['pilihan_beasiswa']); ?></p>
        </div>
        
        <div class="form-group">
            <label>Status Ajuan:</label>
            <p><?= $data['status_ajuan']; ?></p>
        </div>
        
        <div class="form-group">
            <label>Berkas:</label>
            <p>
                <?php if (!empty($data['file_berkas'])): ?>
                    <a href="../uploads/<?= htmlspecialchars($data['file_berkas']); ?>" target="_blank">Download Berkas</a>
                <?php else: ?>
                    Tidak ada berkas
                <?php endif; ?>
            </p>
        </div>

        <div class="text-center mt-3">
            <a href="../index.php" class="btn">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>