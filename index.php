<?php include 'includes/koneksi-db.php'; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelompok 8</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <?php include 'includes/header.php'; ?>
    <div class="center">
        <div class="container">
            <div class="bungkus2">
                <?php include 'includes/bagian-kiri.php'; ?>
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="pages/add-article.php" class="button ">Tambah Artikel</a>
                <?php endif; ?>
            </div>
            <div class="bagian-kanan">
                <?php include 'includes/item.php'; ?>
            </div>
        </div>
    </div>
</body>

</html>