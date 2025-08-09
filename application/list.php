<?php include('../config/database.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pendaftar Beasiswa</title>
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
        <h2>Data Pendaftar Beasiswa</h2>
        
        <?php
        $sql = "SELECT * FROM pendaftaran";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0): ?>
            <div style="overflow-x: auto;">
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Nomor HP</th>
                            <th>Semester</th>
                            <th>IPK</th>
                            <th>Jenis Beasiswa</th>
                            <th>Berkas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $row['id']; ?></td>
                                <td><?= htmlspecialchars($row['nama']); ?></td>
                                <td><?= htmlspecialchars($row['email']); ?></td>
                                <td><?= htmlspecialchars($row['nomor_hp']); ?></td>
                                <td><?= $row['semester']; ?></td>
                                <td><?= $row['ipk']; ?></td>
                                <td><?= htmlspecialchars($row['pilihan_beasiswa']); ?></td>
                                <td>
                                    <?php if (!empty($row['file_berkas'])): ?>
                                        <a href="../uploads/<?= htmlspecialchars($row['file_berkas']); ?>" target="_blank">Download</a>
                                    <?php else: ?>
                                        Tidak ada berkas
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['status_ajuan']; ?></td>
                                <td>
                                    <a href="edit.php?id=<?= $row['id']; ?>" class="btn">Edit</a>
                                    <a href="delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
                                    <a href="detail.php?id=<?= $row['id']; ?>" class="btn btn-secondary">Lihat</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>Tidak ada data pendaftar.</p>
        <?php endif; ?>

        <div class="text-center mt-3">
            <a href="register.php" class="btn">Pendaftaran Baru</a>
            <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>