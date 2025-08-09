<?php
include('../config/database.php');

$id = $_GET['id'];
$sql = "DELETE FROM pendaftaran WHERE id = $id";

if ($conn->query($sql)) {
    echo "<script>alert('Data berhasil dihapus!'); window.location.href = 'list.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>