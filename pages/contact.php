<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php' ?>
    <div class="center">
        <div class="container">
            <?php include '../includes/bagian-kiri.php' ?>
            <div class="bungkus">
                <div class="isi-item">
                    <div class="artikel">
                        <h1>Get in touch </h1>
                        <p>Terima kasih atas kunjungan Anda ke website kami! Jika Anda memiliki pertanyaan, masukan, atau ingin berinteraksi lebih lanjut dengan kami, jangan ragu untuk menghubungi kami. Website ini merupakan bagian dari tugas mata kuliah Praktikum Pemrograman Web, dan kami sangat menghargai setiap tanggapan yang dapat membantu kami meningkatkan kualitas dan fungsi situs ini.</p>
                        <p>Kami menyadari bahwa keberhasilan website ini tidak hanya bergantung pada upaya kami dalam desain dan pengembangan, tetapi juga pada interaksi dan umpan balik dari pengunjung. Oleh karena itu, kami menyediakan beberapa saluran komunikasi untuk memudahkan Anda dalam memberikan masukan atau mengajukan pertanyaan.</p>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            // Retrieve form data
                            $nama = $_POST['nama'];
                            $email = $_POST['email'];
                            $pesan = $_POST['pesan'];

                            // Insert into database
                            try {
                                $pdo = new PDO('mysql:host=localhost;dbname=db_artikel', 'root', '');
                                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $stmt = $pdo->prepare("INSERT INTO pesan (nama, email, pesan) VALUES (:nama, :email, :pesan)");
                                $stmt->bindParam(':nama', $nama);
                                $stmt->bindParam(':email', $email);
                                $stmt->bindParam(':pesan', $pesan);
                                $stmt->execute();

                                echo "<p class='success-message'>Pesan Anda telah berhasil dikirim!</p>";
                            } catch (PDOException $e) {
                                echo "<p class='error-message'>Error: " . $e->getMessage() . "</p>";
                            }
                        }
                        ?>
                        <form class="form-artikel" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input type="text" id="nama" name="nama" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" id="email" name="email" required>
                            </div>
                            <div class="form-group panjang2">
                                <label for="pesan">Pesan</label>
                                <textarea id="pesan" name="pesan" required></textarea>
                            </div>
                            <input type="submit" value="Kirim" class="button">
                        </form>
                    </div>
                </div>
                <?php if (isset($_SESSION['username'])) : ?>
                    <a href="pesan.php" class="button">Lihat pesan</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>

</html>