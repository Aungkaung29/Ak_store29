<?php
include('Config.php');
function is_active($page) {
    // Get the current URL path
    $currentURL = basename($_SERVER['PHP_SELF']);

    // Check if the current URL matches the page argument
    if ($currentURL === $page) {
        return 'active';
    } else {
        return '';
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navigation Example</title>
    <style>
        /* Your CSS styles */
    </style>
</head>
<body>
    <div class="Navbar">
        <div class="Entry" id="categoryEntry">
            <nav class="navigation1 <?php echo is_active('Product_Entry_Latkar.php'); ?>"><a href="Product_Entry_Latkar.php">Latkar Entry</a></nav>
            <nav class="navigation1 <?php echo is_active('Product_Entry.php'); ?>"><a href="Product_Entry.php">Latli Entry</a></nav>
        </div>
        <div class="ProductList" id="categoryProductList">
            <nav class="navigation1 <?php echo is_active('Product_List_latkar.php'); ?>"><a href="Product_List_latkar.php">Latkar List</a></nav>
            <nav class="navigation1 <?php echo is_active('Product_List.php'); ?>"><a href="Product_List.php">LatLi List</a></nav>
        </div>
        <div class="salelist" id="categorySaleList">
            <nav class="navigation1 <?php echo is_active('sale_List_L.php'); ?>"><a href="sale_List_L.php">Sale List</a></nav>
            <nav class="navigation1 <?php echo is_active('Today_Sale_List.php'); ?>"><a href="Today_Sale_List.php">Today List</a></nav>
        </div>
        <div>
             <nav id="userNav">   
           <?php 
        if (empty($_SESSION['Username'])) {
           echo "<input type='submit' value='User' onclick=\"window.location.href='login.php';\">";
        }else{
             echo "<input type='submit' value='Admin' onclick=\"window.location.href='logout.php';\">";
           }  
         ?></nav>
        </div>
    </div>

   
    <script>
        // JavaScript to handle active state based on the current URL
        document.addEventListener('DOMContentLoaded', function() {
            var currentUrl = window.location.href;
            var navLinks = document.querySelectorAll('.navigation1 a');
            
            navLinks.forEach(function(link) {
                if (link.href === currentUrl) {
                    link.parentNode.classList.add('active');
                }
            });
        });
    </script>
    <style type="text/css">
        * {
    margin: 0;
    font-family: arial;
    padding: 0;
    box-sizing: border-box;
}
        .Navbar {
            display: flex;
            background-color: #f0f0f0;
            padding: 10px;
        }
        .Navbar div {
            display: flex;
            border:1px dotted grey;
        }
        .navigation1 {
            cursor: pointer;
            padding: 10px 5px;
        }
        .navigation1 a {
            background-color: lightgray; /* Default background color */
            text-decoration: none;
            color: blue;
            padding: 10px 15px;
            transition: background-color 0.3s;
            display: inline-block; /* Ensure the link occupies the entire padding area */
        }
        .navigation1 a:hover {
            background-color: #e0e0e0; /* Background color on hover */
        }
        .navigation1.active a {
            background-color: yellow !important; /* Background color for active link */
            font-weight: bold;
        }
        #userNav {
            position: fixed; /* Fixed positioning to stay in place */
            top: 10px; /* Adjust as per your design */
            right: 10px; /* Adjust as per your design */
            background-color: #f0f0f0; /* Example background color */
            padding: 10px 20px; /* Example padding for better visibility */
            border: 1px solid #ccc; /* Example border */
            border-radius: 5px; /* Example border radius */
            z-index: 1000; /* Ensure it appears above other content if necessary */
        }
    </style>
</body>
</html>