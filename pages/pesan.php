<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Messages</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <?php include '../includes/header.php'; ?>
    <div class="center">
        <div class="container">
            <?php include '../includes/bagian-kiri.php'; ?>
            <div class="bungkus">
                <div class="isi-item">
                    <div class="artikel">
                        <h1>Daftar Pesan</h1>
                        <?php
                        // Database connection details
                        $servername = "localhost";
                        $username = "root";
                        $password = "";
                        $dbname = "db_artikel";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $dbname);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Query to fetch contact messages
                        $sql = "SELECT nama, email, pesan, created_at FROM pesan ORDER BY created_at DESC";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            echo "<table>";
                            echo "<tr><th>Nama</th><th>Email</th><th>Pesan</th><th>Waktu</th></tr>";
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row["nama"] . "</td>";
                                echo "<td>" . $row["email"] . "</td>";
                                echo "<td>" . $row["pesan"] . "</td>";
                                echo "<td>" . $row["created_at"] . "</td>";
                                echo "</tr>";
                            }
                            echo "</table>";
                        } else {
                            echo "Belum ada pesan kontak.";
                        }

                        $conn->close();
                        ?>
                    </div>
                </div>
                <a href="contact.php" class="button">Kembali</a>
            </div>
        </div>
    </div>
</body>

</html>