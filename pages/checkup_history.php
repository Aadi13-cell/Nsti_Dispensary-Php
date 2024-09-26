<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_config.php';

// Get the patient ID from the URL
if (isset($_GET['id'])) {
    $patient_id = $_GET['id']; // Make sure 'id' is passed through the URL
} else {
    echo "No patient ID provided.";
    exit;
}

// Fetch checkup history including medicine details
$sql = "SELECT * FROM check_table WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

// Fetch patient information for display
$sql_patient = "SELECT name FROM patients WHERE id = ?";
$stmt_patient = $conn->prepare($sql_patient);
$stmt_patient->bind_param("i", $patient_id);
$stmt_patient->execute();
$patient_result = $stmt_patient->get_result();
$patient = $patient_result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkup History - NSTI Dispensary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
        <button class="custom-btn" onclick="window.location.href='all_patients.php'">
            <i class="fa-solid fa-backward back-icon"></i> Back
        </button>
    </div>
</div>

<div class="checkup-container">
    <h2>Checkup History for <?php echo htmlspecialchars($patient['name']); ?></h2>

    <?php if ($result->num_rows > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Date of Checkup</th>
                    <th>Problem</th>
                    <th>Medicine Given</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['date_of_checkup']; ?></td>
                    <td><?php echo $row['problem']; ?></td>
                    <td><?php echo $row['medicine_name']; ?></td> <!-- Medicine details -->
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>No checkup history found for this patient.</p>
    <?php endif; ?>
</div>

</body>
</html>
