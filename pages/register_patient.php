<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Patient - NSTI Dispensary</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="heading">
    <h1>NSTI DISPENSARY</h1>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="register_patient.php">Patient Registration</a>
        <a href="all_patients.php">All Patient Details</a>
        <a href="logout.php">Logout</a>
    </div>
</div>

<div class="form-container">
    <h2>Patient Registration</h2>
    <form action="register_patient.php" method="post">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required>

        <label for="trade">Trade</label>
        <input type="text" id="trade" name="trade" required>

        <label for="registration_number">Registration Number</label>
        <input type="text" id="registration_number" name="registration_number" required>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="" disabled selected>Select Gender</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
            <option value="Other">Other</option>
        </select>

        <label for="mobile">Mobile Number</label>
        <input type="tel" id="mobile" name="mobile" required>


        <label for="hostel">Hostel</label>
        <select id="hostel" name="hostel" required>
            <option value="" disabled selected>Do you live in a hostel?</option>
            <option value="Yes">Yes</option>
            <option value="No">No</option>
        </select>

        <button type="submit">Register</button>
    </form>
</div>

<script src="../js/script.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../includes/db_config.php';

    $name = $_POST['name'];
    $trade = $_POST['trade'];
    $registration_number = $_POST['registration_number'];
    $gender = $_POST['gender'];
    $mobile = $_POST['mobile'];
    $hostel = $_POST['hostel']; 

    $sql = "INSERT INTO patients (name, trade, registration_number, gender, mobile, hostel) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $name, $trade, $registration_number, $gender, $mobile, $hostel);

    if ($stmt->execute()) {
        echo "<script>alert('Patient registered successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "');</script>";
    }
}
?>


