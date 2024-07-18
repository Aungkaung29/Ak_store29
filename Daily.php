<?php 
include('config.php');
if (empty($_SESSION['Username'])) {
    include('user_navbar.php');
} else {
    include('Navbar.php');
}include('Sale_Nav.php');

$select = "SELECT Date AS sale_date, sum(Total_Amount) AS totalprisum, sum(Buy_Quantity) AS totalitem
           FROM sale 
           WHERE Status = '1'
           GROUP BY Date
           ORDER BY Date";
$select_query = mysqli_query($connection, $select);
$count = mysqli_num_rows($select_query);
echo "<div class='Navbar1'>      
        <nav class='navigation2'><a href='Sale_List_L.php'>All Sale</a></nav>
        <nav class='navigation2'><a href='Monthly.php'>Monthly</a></nav>   
        <nav class='navigation2'><a href='#' class='active'>Daily</a></nav>
    </div>";
// Start outputting the table
echo "<table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>";
echo "<thead>";
echo "<tr>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Date</th>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Total Amount</th>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Total Item Sold</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = mysqli_fetch_array($select_query)) { 
    $sale_date = $row['sale_date'];
    $total_price = $row['totalprisum'];
    $total_item = $row['totalitem'];

    echo "<tr>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".$sale_date."</td>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".number_format($total_price)." Ks</td>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".number_format($total_item)."</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
?>