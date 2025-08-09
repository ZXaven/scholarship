<?php
include('../config/database.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama = $conn->real_escape_string($_POST['nama']);
    $email = $conn->real_escape_string($_POST['email']);
    $nomor_hp = $conn->real_escape_string($_POST['nomor_hp']);
    $semester = (int)$_POST['semester'];
    $pilihan_beasiswa = $conn->real_escape_string($_POST['beasiswa'] ?? null);
    $status_ajuan = "Belum diverifikasi";
    $ipk = (float)$_POST['ipk'];

    if ($ipk < 3) {
        echo "<script>alert('IPK Anda kurang dari 3. Tidak dapat melanjutkan pendaftaran.'); window.history.back();</script>";
        exit;
    }

    $file_berkas = null;
    if (isset($_FILES['berkas']['tmp_name']) && !empty($_FILES['berkas']['name'])) {
        $upload_dir = "../uploads/";
        $file_berkas = basename($_FILES['berkas']['name']);
        $file_path = $upload_dir . $file_berkas;
        
        if (!move_uploaded_file($_FILES['berkas']['tmp_name'], $file_path)) {
            echo "<script>alert('Upload berkas gagal.'); window.history.back();</script>";
            exit;
        }
    }

    $sql = "INSERT INTO pendaftaran (nama, email, nomor_hp, semester, ipk, pilihan_beasiswa, file_berkas, status_ajuan)
            VALUES ('$nama', '$email', '$nomor_hp', $semester, $ipk, '$pilihan_beasiswa', '$file_berkas', '$status_ajuan')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Pendaftaran berhasil!'); window.location.href = 'result.php';</script>";
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
    <title>Form Pendaftaran Beasiswa</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script>
        function validateIPK() {
            const ipkField = document.getElementById('ipk');
            const beasiswaField = document.getElementById('beasiswa');
            const berkasField = document.getElementById('berkas');
            const submitButton = document.getElementById('submit');

            const ipk = parseFloat(ipkField.value);

            if (ipk < 3) {
                beasiswaField.disabled = true;
                berkasField.disabled = true;
                submitButton.disabled = true;
            } else {
                beasiswaField.disabled = false;
                berkasField.disabled = false;
                submitButton.disabled = false;
            }
        }

        function moveToBeasiswa() {
            const ipkField = document.getElementById('ipk');
            const beasiswaField = document.getElementById('beasiswa');
            const ipk = parseFloat(ipkField.value);

            if (ipk >= 3) {
                beasiswaField.focus();
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            validateIPK();
        });
    </script>
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
        <h2>Form Pendaftaran Beasiswa</h2>
        <form action="register.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama">Nama:</label>
                <input type="text" id="nama" name="nama" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>

            <div class="form-group">
                <label for="nomor_hp">Nomor HP:</label>
                <input type="number" id="nomor_hp" name="nomor_hp" required>
            </div>

            <div class="form-group">
                <label for="semester">Semester Saat Ini:</label>
                <select id="semester" name="semester" required>
                    <option value="" disabled selected>Pilih Semester</option>
                    <?php for ($i = 1; $i <= 8; $i++): ?>
                        <option value="<?= $i; ?>">Semester <?= $i; ?></option>
                    <?php endfor; ?>
                </select>
            </div>

            <div class="form-group">
                <label for="ipk">IPK:</label>
                <input type="number" step="0.01" id="ipk" name="ipk" min="0" max="4" placeholder="IPK (0.00 - 4.00)" value="3.4" required onblur="moveToBeasiswa(); validateIPK()">
            </div>

            <div class="form-group">
                <label for="beasiswa">Jenis Beasiswa:</label>
                <select id="beasiswa" name="beasiswa" required disabled>
                    <option value="" disabled selected>Pilih Jenis Beasiswa</option>
                    <option value="Beasiswa Akademik">Beasiswa Akademik</option>
                    <option value="Beasiswa Non-Akademik">Beasiswa Non-Akademik</option>
                </select>
            </div>

            <div class="form-group">
                <label for="berkas">Upload Berkas Syarat:</label>
                <input type="file" id="berkas" name="berkas" required disabled>
            </div>

            <button type="submit" id="submit" disabled>Daftar</button>
        </form>

        <div class="text-center mt-3">
            <a href="../index.php" class="btn btn-secondary">Kembali ke Beranda</a>
        </div>
    </div>
</body>
</html>