<?php 

include('Config.php');

if (empty($_SESSION['Username'])) {
  include('user_navbar.php');
}
else{
   include('Navbar.php');
}
date_default_timezone_set("Asia/Yangon");

$error_message = ""; // Initialize error message variable

if (isset($_POST['btnsubmit'])) {
    $barcode = $_POST['txtbarcode'];
    $quantity = $_POST['txtquantity'];
    $date = date('Y-m-d');
    $time = date("H:i:s");
    
    // Using prepared statements to prevent SQL injection
    $stmt = $connection->prepare("SELECT * FROM product_latkar WHERE Barcode = ?");
    
    // Check if prepare() failed
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }

    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $array = $result->fetch_assoc();
        $barcode = $array['Barcode'];
        $price = $array['Sell_Price'];
        $stock_quantity = $array['Quantity']; // Retrieve stock quantity

        // Check if the requested buy quantity exceeds the stock quantity
        if ($quantity > $stock_quantity) {
            $error_message = "Error: Buy quantity cannot exceed stock quantity.";
        } else {
            $stmt_insert = $connection->prepare("INSERT INTO Sale (Product_ID, Buy_Quantity, Total_Amount, Date, Time, Status) VALUES (?, ?, ?, ?, ?, '0')");
            $total_amount = $price * $quantity;
            $stmt_insert->bind_param("iidss", $barcode, $quantity, $total_amount, $date, $time);
            $stmt_insert->execute();
            $stmt_insert->close();
        }
    } else {
        // Handle case where no product with the specified barcode is found
        $error_message = "Error: Product with barcode " . htmlspecialchars($barcode) . " not found.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sale</title>
    <link rel="stylesheet" type="text/css" href="Sale.css">
</head>
<body>
   <div class="Navbar">
        <div class="Sale" id="categorySale">
            <nav class="navigation1 active"><a href="Sale_LatKar.php">Sale Latkar</a></nav>
            <nav class="navigation1"><a href="sale.php">Sale Latli</a></nav>
        </div>
   </div>
    <form action="Sale_Latkar.php" method="POST">
        <h2 style="color: red;">လက်ကား အရောင်း</h2>
        <div class="sale-div">
            <div><input type="text" name="txtbarcode" placeholder="Barcode" autofocus required></div>
            <div><input type="number" name="txtquantity" placeholder="Quantity" required></div>
            <div><input type="submit" name="btnsubmit"></div>
            <div><input class="inputbox" type="number" id="pay" name="pay" placeholder="Payment" oninput="CheckTheChanges()"></div>
            Changes = <span style="font-size: 30px;" id="Changes"></span> Ks
        </div>
        <?php if (!empty($error_message)) : ?>
            <div style="color: red;"><?php echo $error_message; ?></div>
        <?php endif; ?>
    </form>

    <div class="ongoing-sale">
        <?php    
        $select = "SELECT s.*, p.Product_Name, p.Sell_Price FROM Sale s JOIN product_latkar p ON s.Product_ID = p.Barcode WHERE s.Status = '0'";
        $select_query = mysqli_query($connection, $select);

        if ($select_query) {
            $count = mysqli_num_rows($select_query);
            $select_price = "SELECT SUM(Total_Amount) AS totalsum FROM Sale WHERE Status = '0'";
            $result = mysqli_query($connection, $select_price);
            $row = mysqli_fetch_assoc($result);
            $sum = $row['totalsum'];

        ?>
            <table>
                <tr class="header">
                    <td>Product Name</td>
                    <td style="padding-right: 20px; padding-left: 20px;">အရေအတွက် x ရောင်းစျေး</td>
                    <td>Total Amount</td>
                </tr>
                <?php
                while ($array = mysqli_fetch_assoc($select_query)) {
                    $purchaseid = $array['Sale_ID'];
                    $productname = htmlspecialchars($array['Product_Name'], ENT_QUOTES, 'UTF-8');
                    $quantity = $array['Buy_Quantity'];
                    $total_amount = $array['Total_Amount'];
                    $sellprice = $array['Sell_Price'];
                ?>
                    <tr class="item">
                        <td><?php echo $productname ?></td>
                        <td style="padding-right: 20px; padding-left: 20px;"><?php echo $quantity ?> x <?php echo number_format($sellprice) ?> </td>
                        <td><?php echo number_format($total_amount) ?> Ks</td>
                        <td><a class="cancel" href="Sale_Cancel_L.php?PID=<?php echo $purchaseid ?>">Cancel</a></td>
                    </tr>
                <?php 
                }
                ?>
            </table>
            <div>
                <a class="link" accesskey="C" href="Sale_Finalize_L.php?PID=<?php echo $purchaseid ?>">Confirm</a>
                <a class="link" href="Sale_Cancel_All.php">Cancel All</a>
            </div>
            <div>Total: <span id="total_sum" style="color: orange; font-weight: bolder; font-size: 18px;"><?php echo number_format($sum) ?></span> Ks</div>
        <?php
        } else {
            echo "Error retrieving sales data.";
        }
        ?>
    </div>

    <script type="text/javascript">
        function CheckTheChanges() {
            var pay = document.getElementById('pay').value;
            var sum = <?php echo $sum ?>; // Fetch PHP variable $sum for total amount

            if (!isNaN(pay)) { // Check if pay is a number
                var changes = pay - sum;
                var formattedChanges = changes.toLocaleString('en-US'); // Format changes with commas
                document.getElementById('Changes').innerHTML = formattedChanges;
            }
        }
    </script>
<style type="text/css">
  
</style>
</body>
</html>

<?php
$connection->close();
?>
