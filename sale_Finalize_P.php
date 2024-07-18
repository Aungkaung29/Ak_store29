<?php
include('Config.php');

if (isset($_GET['PID'])) {
    $PID = $_GET['PID'];

    // Update sale status to '1' (finalized)
    $update_sale_query = "UPDATE Sale SET Status = '1' WHERE Sale_ID = ?";
    $stmt_update_sale = $connection->prepare($update_sale_query);

    if ($stmt_update_sale === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    $stmt_update_sale->bind_param("i", $PID);
    $stmt_update_sale->execute();

    if ($stmt_update_sale->affected_rows > 0) {
        // Retrieve product details related to the sale
        $select_product_query = "SELECT p.Product_ID,p.Barcode, s.Buy_Quantity 
                                 FROM product p
                                 JOIN Sale s ON p.Barcode = s.Product_ID
                                 WHERE s.Sale_ID = ?";
        $stmt_select_product = $connection->prepare($select_product_query);

        if ($stmt_select_product === false) {
            die('Prepare failed: ' . htmlspecialchars($connection->error));
        }

        $stmt_select_product->bind_param("i", $PID);
        $stmt_select_product->execute();
        $result = $stmt_select_product->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['Product_ID'];
            $buy_quantity = $row['Buy_Quantity'];

            // Update product quantity
            $update_product_query = "UPDATE product SET Quantity = Quantity - ? WHERE Product_ID = ?";
            $stmt_update_product = $connection->prepare($update_product_query);

            if ($stmt_update_product === false) {
                die('Prepare failed: ' . htmlspecialchars($connection->error));
            }

            $stmt_update_product->bind_param("ii", $buy_quantity, $product_id);
            $stmt_update_product->execute();

            if ($stmt_update_product->affected_rows > 0) {
                echo "<script>window.location='Sale.php';</script>";
            } else {
                echo "Error updating product quantity.";
            }

            $stmt_update_product->close();
        } else {
            echo "Product not found for the sale.";
        }

        $stmt_select_product->close();
    } else {
        echo "Error finalizing sale.";
    }

    $stmt_update_sale->close();
}

$connection->close();
?>