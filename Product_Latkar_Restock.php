<?php
include('Config.php');

if (isset($_GET['PID'])) {
    $PID = $_GET['PID'];

    $select = "SELECT * FROM product_latkar WHERE Product_ID = $PID";
    $select_query = mysqli_query($connection, $select);
    $array = mysqli_fetch_array($select_query);

    if (!$select_query) {
        die('Query failed: ' . mysqli_error($connection));
    }

    $productname = $array['Product_Name'];
    $quantity = $array['Quantity'];
    $barcode = $array['Barcode'];
    $buyprice = $array['Buy_Price'];
    $sellprice = $array['Sell_Price'];
  
}

if (isset($_POST['btnsubmit'])) {
    $productid = $_POST['txtid'];
    $productname = $_POST['txtproductname'];
    $quantity = $_POST['txtquantity'];
    $barcode = $_POST['txtbarcode'];
    $buyprice = $_POST['txtbuyprice'];
    $sellprice = $_POST['txtsellprice'];

    $restock = $_POST['txtrestock'];

echo $update = "UPDATE product_latkar 
           SET Product_Name = '$productname', 
               Quantity = Quantity + $restock,
               Barcode = '$barcode', 
               Buy_Price = '$buyprice', 
               Sell_Price = '$sellprice' 
           WHERE Product_ID = '$productid'";

    $update_query = mysqli_query($connection,$update);
    if ($update_query === false) {
        die('Prepare failed: ' . htmlspecialchars($connection->error));
    }
    else{
        echo "<script>alert('Product Updated')</script>";
        echo "<script>window.location='Product_List_latkar.php';</script>";
    }

    
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Details</title>
    <style>
        .form-group {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .form-group p {
            margin: 0 10px 0 0;
            width: 150px;
        }
        .form-group input {
            flex: 1;
            padding: 5px;
        }
        .buttons {
            
            
        }
        .buttons input[type="submit"] {
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: green;
            border: none;
            border-radius: 5px;
        }
        .buttons a{
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            color: white;
            background-color: blue;
            border: none;
            border-radius: 5px;
        }
        .buttons a {
            display: inline-block;
        }
    </style>
</head>
<body>
    <form action="Product_Latkar_Restock.php?PID=<?php echo htmlspecialchars($PID); ?>" method="post">
        <div class="form-group">
            <p>Product ID</p>
            <input type="number" name="txtid" value="<?php echo htmlspecialchars($PID); ?>" readonly>
        </div>
        <div class="form-group">
            <p>Product Name</p>
            <input type="text" name="txtproductname" value="<?php echo htmlspecialchars($productname); ?>">
        </div>
        <div class="form-group">
            <p>Barcode</p>
            <input type="text" name="txtbarcode" value="<?php echo htmlspecialchars($barcode); ?>">
        </div>
        <div class="form-group">
            <p>Quantity</p>
            <input type="number" name="txtquantity" value="<?php echo htmlspecialchars($quantity); ?>" readonly>
        </div>
        <div class="form-group">
            <p>Restock Quantity</p>
            <input type="number" name="txtrestock" value="0" autofocus>
        </div>
       
        <div class="form-group">
            <p>Buy Price</p>
            <input type="number" step="0.01" name="txtbuyprice" value="<?php echo htmlspecialchars($buyprice); ?>">
        </div>
        <div class="form-group">
            <p>Sell Price</p>
            <input type="number" step="0.01" name="txtsellprice" value="<?php echo htmlspecialchars($sellprice); ?>">
        </div>
        <div class="buttons">
            <a href="Product_List_latkar.php">Back to list</a>
            <input type="submit" name="btnsubmit" value="Submit">
        </div>
    </form>
</body>
</html>
