<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: home.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Admin Login - NSTI Dispensary</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="login-container">
    <div class="heading">
    <h1>NSTI DISPENSARY</h1>
    <p>ADMIN LOGIN</p>

    </div>
    <form action="login.php" method="post">
    <div class="input-group">
        <label for="username">Username</label>
        <input type="text" id="username" name="username" required>
    </div>

    <div class="input-group">
        <label for="password">Password</label>
        <div class="password-wrapper">
            <input type="password" id="password" name="password" required>
            <span class="toggle-password" onclick="togglePasswordVisibility()">
                <i id="eye-icon" class="fa fa-eye"></i>
            </span>
        </div>
    </div>

    <button type="submit">Login</button>
</form>
    </div>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../includes/db_config.php';
    
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $_SESSION['admin_logged_in'] = true;
        header("Location: home.php");
        exit;
    } else {
        echo "<script>alert('Invalid username or password');</script>";
    }
}
?>
