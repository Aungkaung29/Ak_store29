<?php
include('Config.php');
    $stmt = $connection->prepare("DELETE FROM Sale WHERE Status = 0");
    
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    

    if ($stmt->execute()) {
        echo "<script>window.location='Sale.php';</script>";
    } else {
        echo "Error deleting record: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
    $connection->close();

?>
