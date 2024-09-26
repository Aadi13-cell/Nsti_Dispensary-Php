<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_config.php';

$search_query = "";

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];

    $sql = "SELECT * FROM patients WHERE name LIKE ? OR registration_number LIKE ? OR mobile LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_query . "%";
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM patients";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Patients - NSTI Dispensary</title>
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
    </div>
</div>

<div class="patients-container">
    <h2>All Patients</h2>

<!-- Search Form -->
<form action="all_patients.php" method="post" class="search-bar">
    <input type="text" name="search_query" placeholder="Search by Name, Reg. No. or Mobile" value="<?php echo htmlspecialchars($search_query); ?>" required>
    <button type="submit" name="search">
        <i class="fa-solid fa-magnifying-glass"></i> Search
    </button>
</form>

<?php if (isset($_POST['search']) && $result->num_rows === 0): ?>
    <!-- Only show the Cancel button when no results are found -->
    <button type="button" class="cancel-btn" onclick="window.location.href='all_patients.php'" style="background-color: #d32f2f;">Cancel</button>
<?php endif; ?>

<?php if ($result->num_rows > 0): ?>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Trade</th>
                    <th>Registration Number</th>
                    <th>Gender</th>
                    <th>Mobile</th>
                    <th>Hostel</th>
                    <th>Date of Registration</th>
                    <th>Actions</th>
                    <th>Checkup History</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['trade']; ?></td>
                    <td><?php echo $row['registration_number']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $row['mobile']; ?></td>
                    <td><?php echo $row['hostel']; ?></td>
                    <td><?php echo $row['date_of_registration']; ?></td>
                    <td>
                        <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="edit-btn"><i class="fa-solid fa-pencil"></i></i></a>
                        <a href="#" class="delete-btn" onclick="showConfirmationBox('<?php echo $row['id']; ?>', '<?php echo $row['name']; ?>', '<?php echo $row['registration_number']; ?>')">
                            <i class="fa-solid fa-trash"></i>
                        </a>
                    </td>
                    <td>
                        <a href="checkup_history.php?id=<?php echo $row['id']; ?>" class="edit-btn">Check</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <p style="color: red; font-size:20px;">No patients found.</p>
<?php endif; ?>

<!-- Confirmation Box -->
<div id="confirmationBox" class="confirmation-box">
    <div class="confirmation-content">
        <h2>Delete Patient</h2>
        <p>Are you sure you want to delete <span id="patientName"></span> (Reg. No.: <span id="patientRegNo"></span>)?</p>
        <div class="buttons">
            <button id="confirmDeleteBtn" class="confirm-btn">Delete</button>
            <button onclick="closeConfirmationBox()" class="cancel-btn">Cancel</button>
        </div>
    </div>
</div>

<script>
    function showConfirmationBox(patientId, name, registrationNumber) {
        document.getElementById('patientName').textContent = name;
        document.getElementById('patientRegNo').textContent = registrationNumber;
        document.getElementById('confirmationBox').style.display = 'flex';

        document.getElementById('confirmDeleteBtn').onclick = function() {
            window.location.href = 'delete_patient.php?id=' + patientId;
        };
    }

    function closeConfirmationBox() {
        document.getElementById('confirmationBox').style.display = 'none';
    }
</script>

</div>
</body>
</html>
