<?php
session_start();
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header("Location: pages/home.php");
    exit;
} else {
    header("Location: pages/login.php");
    exit;
}
?>
