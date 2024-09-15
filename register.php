<?php
include 'includes/koneksi-db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $email = $_POST['email'];

    // Check if username or email already exists
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Username or email already exists
        $row = $result->fetch_assoc();
        if ($row['username'] == $username) {
            $error_message = "Username sudah dipakai.";
        } elseif ($row['email'] == $email) {
            $error_message = "Email sudah dipakai.";
        }
    } else {
        // Insert new user data
        $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $password, $email);

        if ($stmt->execute() === TRUE) {
            header("Location: login.php");
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='register.php';</script>";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css" />
</head>
<body>
    <div class="login-center">
        <div class="container">
            <div class="form-container">
                <h2>REGISTER</h2>
                <form action="register.php" method="post" class="flex">
                    <div class="form-group">
                        <input type="text" id="username" name="username" placeholder="Username" required>
                    </div>
                    <div class="form-group">
                        <input type="password" id="password" name="password" placeholder="Password" required>
                    </div>
                    <div class="form-group">
                        <input type="email" id="email" name="email" placeholder="Email" required>
                    </div>
                    <input type="submit" value="Register" class="button">
                </form>
                <?php if (isset($error_message)): ?>
                    <p class="error-message"><?php echo $error_message; ?></p>
                <?php endif; ?>
                <p>Sudah punya akun? <a href="login.php">Login</a></p>
            </div>
        </div>
    </div>
</body>
</html>
