<?php 
include('Config.php');
if (empty($_SESSION['Username'])) {
  include('user_navbar.php');
}
else{
   include('Navbar.php');
}
date_default_timezone_set("Asia/Yangon");

// Get the current date in 'Y-m-d' format
$current_date = date('Y-m-d');

// Query to select sales data from product_latkar table for the current date
$select_sale_latkar = "SELECT s.Sale_ID, p.Product_Name,p.Barcode, s.Total_Amount, s.Date, s.Time, s.Buy_Quantity 
                       FROM sale s
                       JOIN product_latkar p ON s.Product_ID = p.Barcode
                       WHERE s.Status = 1 AND s.Date = ?";
$sale_total_latkar = "SELECT SUM(s.Total_Amount) AS totalsum 
                      FROM Sale s
                      JOIN product_latkar pr ON s.Product_ID = pr.Barcode
                      WHERE s.Status = '1' AND Date = '$current_date'";
$result = mysqli_query($connection, $sale_total_latkar);
$row = mysqli_fetch_assoc($result);
$sum = $row['totalsum'];
// Query to select sales data from product table for the current date
$select_sale_product = "SELECT s.Sale_ID, p.Product_Name,p.Barcode, s.Total_Amount, s.Date, s.Time, s.Buy_Quantity 
                        FROM sale s
                        JOIN product p ON s.Product_ID = p.Barcode
                        WHERE s.Status = 1 AND s.Date = ?";
$sale_total_Product = "SELECT SUM(s.Total_Amount) AS totalsum 
                      FROM Sale s
                      JOIN Product pr ON s.Product_ID = pr.Barcode
                      WHERE s.Status = '1' AND Date = '$current_date'";
$result = mysqli_query($connection, $sale_total_Product);
$row = mysqli_fetch_assoc($result);
$sum1 = $row['totalsum'];
echo "<h1>Sale For ".$current_date."</h1>";
echo "total Amount:".number_format($sum + $sum1);
// Prepare and execute the first query for product_latkar
if ($stmt = $connection->prepare($select_sale_latkar)) {
    $stmt->bind_param("s", $current_date);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        echo "<h3>လက်ကား အရောင်းစာရင်း</h3>";
        echo "<table border='1' width='100%'>";
        echo "<tr>";
        echo "<th>Product Name</th>";
        echo "<th>Buy Quantity</th>";
        echo "<th>Total Amount</th>";
        echo "<th>Time</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Product_Name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['Buy_Quantity'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars(number_format($row['Total_Amount']), ENT_QUOTES, 'UTF-8') . "</td>";
            // echo "<td>" . htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['Time'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
         echo "<div>လက်ကား ရောင်းရငွေ:".number_format($sum)." Ks</div>";
    } else {
        echo "<br>No sales from Product Latkar on " . $current_date;
    }

    $stmt->close();
} else {
    die('Prepare failed: ' . htmlspecialchars($connection->error));
}

// Prepare and execute the second query for product
if ($stmt = $connection->prepare($select_sale_product)) {
    $stmt->bind_param("s", $current_date);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h3>လက်လီ အရောင်းစာရင်း</h3>";
        echo "<table border='1' width='100%'>";
        echo "<tr>";
        echo "<th>Product Name</th>";
        echo "<th>Buy Quantity</th>";
        echo "<th>Total Amount</th>";
        echo "<th>Time</th>";
        echo "</tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . htmlspecialchars($row['Product_Name'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['Buy_Quantity'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars(number_format($row['Total_Amount']), ENT_QUOTES, 'UTF-8') . "</td>";
            // echo "<td>" . htmlspecialchars($row['Date'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td>" . htmlspecialchars($row['Time'], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        echo "<div>လက်လီ ရောင်းရငွေ:".number_format($sum1)." Ks</div>";
    } else {
        echo "No sales from Product on " . $current_date;
    }

    $stmt->close();
} else {
    die('Prepare failed: ' . htmlspecialchars($connection->error));
}

$connection->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
</head>
<body>
    <link rel="stylesheet" type="text/css" href="Sale_list.css">
</body>
</html>