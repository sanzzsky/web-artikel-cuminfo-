<?php
include '../includes/koneksi-db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM artikel WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Artikel tidak ditemukan";
        exit;
    }
} else {
    echo "ID tidak diset";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $judul = $_POST['judul'];
    $tanggal = $_POST['tanggal'];
    $author = $_POST['author'];
    $isiArtikel = $_POST['isiArtikel'];
    $uploadOk = 1;

    if (!empty($_FILES['gambar']['name'])) {
        $target_dir = "../img/";
        $target_file = $target_dir . basename($_FILES["gambar"]["name"]);
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
                $gambar = $target_file;
            } else {
                echo "Maaf, terjadi kesalahan saat mengunggah file.";
                $uploadOk = 0;
            }
        }
    } else {
        $gambar = $row['gambar']; // Gunakan gambar yang ada jika tidak ada gambar baru diunggah
    }

    if ($uploadOk == 1) {
        $sql_update = "UPDATE artikel SET gambar='$gambar', judul='$judul', tanggal='$tanggal', author='$author', isiArtikel='$isiArtikel' WHERE id=$id";

        if ($conn->query($sql_update) === TRUE) {
            header("Location: isi-item.php?id=$id");
            exit;
        } else {
            echo "Error: " . $sql_update . "<br>" . $conn->error;
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
    <title>Edit Artikel</title>
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="center">
        <div class="container">
            <?php include '../includes/bagian-kiri.php'; ?>
            <div class="bungkus">
                <div class="add-article">
                    <form action="edit-article.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data" class="form-artikel">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input type="file" id="gambar" name="gambar" accept="image/*">
                            <input type="hidden" name="gambar" value="<?php echo $row['gambar']; ?>">
                        </div>
                        <div class="form-group">
                            <label for="judul">Judul</label>
                            <input type="text" id="judul" name="judul" value="<?php echo $row['judul']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" id="tanggal" name="tanggal" value="<?php echo $row['tanggal']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" id="author" name="author" value="<?php echo $row['author']; ?>" required>
                        </div>
                        <div class="form-group panjang">
                            <label for="isiArtikel">Isi Artikel</label>
                            <textarea id="isiArtikel" name="isiArtikel" required><?php echo $row['isiArtikel']; ?></textarea>
                        </div>
                        <input type="submit" value="Simpan" class="button">
                    </form>
                </div>
                <a href="isi-item.php?id=<?php echo $id; ?>" class="button">Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>