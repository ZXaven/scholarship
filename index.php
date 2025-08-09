<?php include('config/database.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portal Beasiswa</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <a href="index.php" class="nav-logo">Beasiswa</a>
            <ul class="nav-menu">
                <li class="nav-item"><a href="index.php" class="nav-link">Beranda</a></li>
                <li class="nav-item"><a href="application/register.php" class="nav-link">Daftar</a></li>
                <li class="nav-item"><a href="application/list.php" class="nav-link">Data Pendaftar</a></li>
            </ul>
        </div>
    </nav>

    <div class="container">
        <h2 class="text-center">Selamat Datang di Portal Beasiswa</h2>
        <p class="text-center">Segera Daftar Karena Kuota Terbatas</p>
        <div class="text-center mt-3">
            <img src="assets/images/1.jpg" alt="Beasiswa" style="max-width: 300px;">
        </div>
        <div class="text-center mt-3">
            <a href="application/register.php" class="btn">Daftar Beasiswa</a>
            <a href="application/list.php" class="btn btn-secondary">Lihat Data Pendaftaran</a>
        </div>
    </div>
</body>
</html>
<?php $conn->close(); ?>