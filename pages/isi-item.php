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
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $row["judul"]; ?></title>
    <link rel="stylesheet" href="../css/style.css" />
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="center">
        <div class="container">
            <?php include '../includes/bagian-kiri.php'; ?>

            <div class="bungkus">
                <div class="isi-item">
                    <img src="<?php echo $row["gambar"]; ?>">
                    <div class="artikel">
                        <div class="judul-konten">
                            <h1><?php echo $row["judul"]; ?></h1>
                        </div>
                        <div class="date-author">
                            <p><?php echo date("F j, Y", strtotime($row["tanggal"])); ?><span>ㅤ|ㅤ</span><?php echo $row["author"]; ?></p>
                        </div>
                        <div class="garis"></div>
                        <div class="isi-artikel">
                            <?php echo nl2br($row["isiArtikel"]); ?>
                        </div>
                    </div>
                    <?php if(isset($_SESSION['username'])): ?>
                        <div class="tombol-mod">
                            <a href="edit-article.php?id=<?php echo $row["id"]; ?>" class="button">Edit</a><br>
                            <a href="delete-article.php?id=<?php echo $row["id"]; ?>" class="buttonred" onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')">Hapus</a>
                        </div>
                    <?php endif; ?>
                </div>
                <div>
                    <a href="../index.php" class="button">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>