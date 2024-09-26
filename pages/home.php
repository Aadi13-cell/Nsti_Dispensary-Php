<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}

include '../includes/db_config.php';

$search_query = "";
$patient_found = false;
$patient_id = "";

if (isset($_POST['search'])) {
    $search_query = $_POST['search_query'];

    $sql = "SELECT * FROM patients WHERE name LIKE ? OR registration_number LIKE ? OR mobile LIKE ?";
    $stmt = $conn->prepare($sql);
    $search_term = "%" . $search_query . "%"; // Wildcard search for partial match
    $stmt->bind_param("sss", $search_term, $search_term, $search_term);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $patient_found = true;
        $patient = $result->fetch_assoc(); 
        $patient_id = $patient['id']; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - NSTI Dispensary</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <style>
    /* Flex container to align image and glass-container */
    .flex-container {
        display: flex;
        justify-content: center;
        align-items: center;
        /* height: 100vh; */
    }

    /* Style for the image */
    .flex-container img {
        width: 300px; 
        height: auto; 
        margin-right: 20px; 
    }

    /* Glass container styling */
    /* .glass-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 60%; 
        padding: 10px;
        background: rgba(255, 255, 255, 0.2); 
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(10px); 
    }

    .glass-effect h1 {
        font-size: 2.5em;
        text-align: center;
    }

    .glass-effect p {
        font-size: 1.2em;
        text-align: center;
        margin-top: 10px;
    } */

</style>

</head>
<body>

<div class="header-container">
    <h1>NSTI KANPUR DISPENSARY</h1>
    <nav class="navbar">
        <div class="navbar">
            <a href="home.php">Home</a>
            <a href="register_patient.php">Patient Registration</a>
            <a href="all_patients.php">All Patient Details</a>
            <a href="logout.php">Logout</a>
        </div>
    </nav>

    <form action="home.php" method="post" class="search-bar">
        <input type="text" name="search_query" placeholder="Search by Name, Reg. No. or Mobile" value="<?php echo htmlspecialchars($search_query); ?>" required>
        <button type="submit" class="search-btn" name="search">
            <i class="fa-solid fa-magnifying-glass"></i>  <span class="search-text">Search</span>
        </button>
    </form>
</div>

<!-- Search Result Section -->
<div class="search-result <?php echo $patient_found ? 'show' : ''; ?>">
    <?php if ($patient_found): ?>
        <h2 class="alert2">Patient Found: <?php echo $patient['name']; ?></h2>
        <div class="check_buttons">
            <a href="checkup.php?patient_id=<?php echo $patient_id; ?>" class="checkup-btn">New Checkup</a>
            <a href="checkup_history.php?id=<?php echo $patient['id']; ?>" class="history_btn">Checkup History</a>
        </div>
    <?php else: ?>
        <?php if (isset($_POST['search'])): ?>
            <h2 class="alert">No patient found.</h2>
            <div class="check_buttons">
                <a href="register_patient.php" class="history_btn">Register Patient</a>
            </div>
        <?php endif; ?>
    <?php endif; ?>
</div>
<div class="flex-container">
    <img src="../img/checkUp.png" alt="Checkup Image">
    <div class="glass-container">
        <div class="glass-effect">
            <h1>Welcome to NSTI Dispensary</h1>
            <p>We provide high-quality medical care for all our students. Our services include consultation, treatment, and dispensing of medicines. Our dedicated team is here to ensure the well-being of everyone on campus.</p>
        </div>
    </div>
</div>

<div id="footer"></div>

<script src="../js/footer.js"></script>

</body>
</html>
