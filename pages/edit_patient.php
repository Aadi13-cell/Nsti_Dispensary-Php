<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_config.php';

// Check if the 'id' parameter is present in the URL (for GET requests)
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        $sql = "SELECT * FROM patients WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $patient = $result->fetch_assoc();
        } else {
            echo "<script>alert('Patient not found!'); window.location.href='all_patients.php';</script>";
            exit;
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href='all_patients.php';</script>";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $id = $_POST['id']; // Get the patient ID from the form
        $name = $_POST['name'];
        $trade = $_POST['trade'];
        $registration_number = $_POST['registration_number'];
        $gender = $_POST['gender'];
        $mobile = $_POST['mobile'];

       
        $sql = "UPDATE patients SET name = ?, trade = ?, registration_number = ?, gender = ?, mobile = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssi", $name, $trade, $registration_number, $gender, $mobile, $id);

        if ($stmt->execute()) {
            echo "<script>alert('Patient updated successfully'); window.location.href='all_patients.php';</script>";
        } else {
            echo "<script>alert('Error updating patient: " . $stmt->error . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid request.'); window.location.href='all_patients.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient - NSTI Dispensary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="heading">
   <h1>NSTI KANPUR DISPENSARY</h1>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="register_patient.php">Patient Registration</a>
        <a href="all_patients.php">All Patient Details</a>
        <a href="logout.php">Logout</a>
        <button onclick="window.history.back()" class="custom-btn">
            <i class="fa-solid fa-backward back-icon"></i> Back
        </button>
    </div>
</div>

<div class="form-container">
    <h1>Edit Patient Details</h1>

    <form action="edit_patient.php" method="post">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($patient['id']); ?>"> <!-- Hidden field for patient ID -->

        <div class="input-group">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($patient['name']); ?>" required>
        </div>

        <div class="input-group">
            <label for="trade">Trade</label>
            <input type="text" id="trade" name="trade" value="<?php echo htmlspecialchars($patient['trade']); ?>" required>
        </div>

        <div class="input-group">
            <label for="registration_number">Registration Number</label>
            <input type="text" id="registration_number" name="registration_number" value="<?php echo htmlspecialchars($patient['registration_number']); ?>" required>
        </div>

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>     
            <option value="Male" <?php if ($patient['gender'] == 'Male') echo 'selected'; ?>>Male</option>
            <option value="Female" <?php if ($patient['gender'] == 'Female') echo 'selected'; ?>>Female</option>
            <option value="Other" <?php if ($patient['gender'] == 'Other') echo 'selected'; ?>>Other</option>
        </select>

        <div class="input-group">
            <label for="mobile">Mobile</label>
            <input type="text" id="mobile" name="mobile" value="<?php echo htmlspecialchars($patient['mobile']); ?>" required>
        </div>

        <button type="submit">Update</button>
    </form>
</div>
</body>
</html>
