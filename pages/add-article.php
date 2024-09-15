<?php
include '../includes/koneksi-db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judul = $_POST["judul"];
    $tanggal = $_POST["tanggal"];
    $author = $_POST["author"];
    $isiArtikel = $_POST["isiArtikel"];

    $target_dir = "../img/";
    $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Periksa apakah file gambar atau bukan
    $check = getimagesize($_FILES["gambar"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        echo "File bukan gambar.";
        $uploadOk = 0;
    }

    // Cek apakah file sudah ada
    if (file_exists($target_file)) {
        $gambar = $target_file;
    } else {
        // Batasi tipe file yang diizinkan
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Maaf, hanya file JPG, JPEG, & PNG yang diizinkan.";
            $uploadOk = 0;
        }
    }
    // Cek apakah $uploadOk bernilai 0 karena kesalahan
    if ($uploadOk == 0) {
        echo "File Anda tidak dapat diunggah.";
    } else {
        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $target_file)) {
            $sql = "INSERT INTO artikel (gambar, judul, tanggal, author, isiArtikel)
                    VALUES ('$target_file', '$judul', '$tanggal', '$author', '$isiArtikel')";

            if ($conn->query($sql) === TRUE) {
                header("Location: ../index.php");
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        } else {
            echo "Maaf, terjadi kesalahan saat mengunggah file.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="center">
        <div class="container">
            <?php include '../includes/bagian-kiri.php'; ?>
            <div class="bungkus">
                <div class="add-article">
                    <form action="add-article.php" method="post" class="form-artikel" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*" required>
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" id="judul" name="judul" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" name="author" required>
                        </div>
                        <div class="form-group panjang">
                            <label for="isiArtikel">Isi Artikel</label>
                            <textarea id="isiArtikel" name="isiArtikel" required></textarea>
                        </div>
                        <input type="submit" value="Tambah Artikel" class="button" formaction="add-article.php">
                    </form>
                </div>
                <a href="../index.php" class="button">Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>