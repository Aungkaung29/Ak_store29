<?php
include('Config.php');

if (isset($_GET['PID'])) {
    $PID = $_GET['PID'];
    $stmt = $connection->prepare("DELETE FROM Sale WHERE Sale_ID = ?");
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    $stmt->bind_param("i", $PID);

    if ($stmt->execute()) {
        echo "<script>window.location='Sale.php';</script>";
    } else {
        echo "Error deleting record: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $connection->close();
}
?>
