<?php 
include('config.php');
if (empty($_SESSION['Username'])) {
    include('user_navbar.php');
} else {
    include('Navbar.php');
}
include('Sale_Nav.php');
$select = "SELECT year(Date) AS sltyear, month(Date) AS sltdate, sum(Total_Amount) AS totalprisum, sum(Buy_Quantity) AS totalitem
           FROM sale 
           WHERE Status = '1'
           GROUP BY year(Date), month(Date)
           ORDER BY year(Date), month(Date)";
$select_query = mysqli_query($connection, $select);
$count = mysqli_num_rows($select_query);

// Start outputting the table
echo "<div class='Navbar1'>      
        <nav class='navigation2'><a href='Sale_List_L.php'>All Sale</a></nav>
        <nav class='navigation2'><a href='#' class='active'>Monthly</a></nav>   
        <nav class='navigation2'><a href='daily.php'>Daily</a></nav>
    </div>";
echo "<table style='width: 100%; border-collapse: collapse; margin-top: 20px;'>";
echo "<thead>";
echo "<tr>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Year - Month</th>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Total Amount</th>";
echo "<th style='border: 1px solid #ddd; padding: 8px; text-align: left;'>Total Item Sold</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

for ($i = 0; $i < $count; $i++) { 
    $row = mysqli_fetch_array($select_query);
    $year = $row['sltyear'];
    $mth = $row['sltdate'];
    $total_price = $row['totalprisum'];
    $total_item = $row['totalitem'];

    // Convert numeric month to abbreviated name
    $month_names = [
        1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 
        5 => "May", 6 => "Jun", 7 => "Jul", 8 => "Aug", 
        9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec"
    ];
    $mth_name = $month_names[$mth];

    echo "<tr>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".$year." - ".$mth_name."</td>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".number_format($total_price)." Ks</td>";
    echo "<td style='border: 1px solid #ddd; padding: 8px;'>".number_format($total_item)."</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";
?>