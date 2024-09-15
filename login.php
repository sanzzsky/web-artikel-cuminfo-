<?php
session_start();
include 'includes/koneksi-db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "Username and Password are required.";
        header("Location: login.php");
        exit;
    }

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            header("Location: index.php");
            exit;
        } else {
            $_SESSION['error'] = "Password salah";
            header("Location: login.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Username tidak terdaftar";
        header("Location: login.php");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>
    <div class="login-center">
        <div class="container">
            <div class="form-container">
                <h2>LOGIN</h2>
                <form action="" method="post" class="flex">
                    <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <input type="submit" value="Login" class="button">
                </form>
                <?php
                if (isset($_SESSION['error'])) {
                    echo "<p class='error-message'>" . $_SESSION['error'] . "</p>";
                    unset($_SESSION['error']);
                }
                ?>
                <p>Belum punya akun? <a href="register.php">Sign up</a></p>
            </div>
        </div>
    </div>
</body>

</html>