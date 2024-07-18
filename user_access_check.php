<?php

// Check if the 'Username' session variable is set and not empty
if (!isset($_SESSION['Username']) || empty($_SESSION['Username'])) {
    // Redirect to the admin_login.php page if 'Username' session variable is not set or empty
    header("Location: admin_login.php");
    exit(); // Stop further execution
} else {
    // Redirect to the Product_list.php page if 'Username' session variable is set and not empty
    header("Location: Product_list.php");
    exit(); // Stop further execution
}
?>
