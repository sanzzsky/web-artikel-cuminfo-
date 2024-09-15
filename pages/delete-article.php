<?php
include '../includes/koneksi-db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM artikel WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo "Artikel berhasil dihapus.";
        header("Location: ../index.php");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ID tidak diset";
    exit;
}
?>
