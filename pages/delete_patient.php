<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: login.php");
    exit;
}
include '../includes/db_config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM patients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: all_patients.php");
        exit;
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.location.href='all_patients.php';</script>";
    }
} else {
    header("Location: all_patients.php");
    exit;
}
?>
