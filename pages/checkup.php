
<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_config.php';

$patient_id = $_GET['patient_id'];

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $date_of_checkup = $_POST['date_of_checkup'];
//     $problem = $_POST['problem'];

//     // Insert checkup details into check_table
//     $sql = "INSERT INTO check_table (patient_id, date_of_checkup, problem) VALUES (?, ?, ?)";
//     $stmt = $conn->prepare($sql);
//     $stmt->bind_param("iss", $patient_id, $date_of_checkup, $problem);

//     if ($stmt->execute()) {

//         echo "<script>alert('Checkup data saved successfully!');</script>";
//     } else {
        
//         echo "<script>alert('Error saving checkup data. Please try again.');</script>";
//     }
// }


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $date_of_checkup = $_POST['date_of_checkup'];
    $problem = $_POST['problem'];
    $medicine_names = $_POST['medicine_name']; // This will be an array of medicines

    // Convert the array of medicines to a comma-separated string
    $medicine_names_str = implode(', ', $medicine_names);

    // Insert checkup details along with medicines into check_table
    $sql = "INSERT INTO check_table (patient_id, date_of_checkup, problem, medicine_name) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $patient_id, $date_of_checkup, $problem, $medicine_names_str);

    if ($stmt->execute()) {
        echo "<script>alert('Checkup data and medicines saved successfully!');</script>";
    } else {
        echo "<script>alert('Error saving checkup data. Please try again.');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <title>Checkup Form</title>
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
        <button class="custom-btn" onclick="window.location.href='home.php'">
           <i class="fa-solid fa-backward back-icon"></i> Back
        </button>

    </div>
    
</a>
</div>

<h2>Patient Checkup </h2>
<!-- <form method="POST" action="checkup.php?patient_id=<?php echo $patient_id; ?>">
    <label for="date_of_checkup">Date of Checkup:</label>
    <input type="date" id="date_of_checkup" name="date_of_checkup" required><br>

    <label for="problem">Problem:</label>
    <textarea id="problem" name="problem" rows="4" cols="50" required></textarea><br>

    <button type="submit">Submit</button>
</form> -->
<form method="POST" action="checkup.php?patient_id=<?php echo $patient_id; ?>">
    <label for="date_of_checkup">Date of Checkup:</label>
    <input type="date" id="date_of_checkup" name="date_of_checkup" required><br>

    <label for="problem">Problem:</label>
    <textarea id="problem" name="problem" rows="4" cols="50" required></textarea><br>

    <!-- Medicine Section -->
    <h3>Medicines</h3>
    <table id="medicine_table">
        <thead>
            <tr>
                <th>Serial No.</th>
                <th>Medicine Name</th>
                <th><button type="button" onclick="addRow()">Add Medicine</button></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td><input type="text" name="medicine_name[]" required></td>
                <td><button type="button" onclick="removeRow(this)">Remove</button></td>
            </tr>
        </tbody>
    </table>
    
    <button type="submit">Submit</button>
</form>


<script>
    function addRow() {
        const table = document.getElementById('medicine_table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const row = table.insertRow(rowCount);
        row.innerHTML = `<td>${rowCount + 1}</td>
                         <td><input type="text" name="medicine_name[]" required></td>
                         <td><button type="button" onclick="removeRow(this)">Remove</button></td>`;
    }

    function removeRow(button) {
        const row = button.closest('tr');
        row.parentNode.removeChild(row);
        updateRowNumbers(); // Update serial numbers after row deletion
    }

    function updateRowNumbers() {
        const table = document.getElementById('medicine_table').getElementsByTagName('tbody')[0];
        for (let i = 0; i < table.rows.length; i++) {
            table.rows[i].cells[0].innerText = i + 1; // Update serial number
        }
    }
</script>


</body>
</html>
