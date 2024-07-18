<?php
include('Config.php');

// Include navbar based on session
if (empty($_SESSION['Username'])) {
    include('user_navbar.php');
} else {
    include('Navbar.php');
}

// Check if search results are available
$search_results = false;
if (isset($_GET['search_by']) && isset($_GET['txtsearch'])) {
    $search_by = $_GET['search_by'];
    $search_term = $_GET['txtsearch'];

    if ($search_by === 'product_name') {
        $search_query = "SELECT pl.Link_To_CTN, pl.Product_ID AS latkar_ID, p.Product_ID AS Parent_Product_ID, p.Product_Name AS Parent_Product_Name, pl.Product_Name, pl.Quantity, pl.Buy_Price, pl.Sell_Price 
                        FROM product pl 
                        LEFT JOIN product_latkar p ON p.Product_ID = pl.Link_To_CTN
                        WHERE pl.Product_Name LIKE '%$search_term%'";
    } elseif ($search_by === 'product_id') {
        $search_query = "SELECT pl.Link_To_CTN, pl.Product_ID AS latkar_ID, p.Product_ID AS Parent_Product_ID, p.Product_Name AS Parent_Product_Name, pl.Product_Name, pl.Quantity, pl.Buy_Price, pl.Sell_Price 
                        FROM product pl 
                        LEFT JOIN product_latkar p ON p.Product_ID = pl.Link_To_CTN
                        WHERE pl.Product_ID = '$search_term'";
    }

    $search_results = mysqli_query($connection, $search_query);

    if (!$search_results) {
        die('Query failed: ' . mysqli_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product List (Latkar)</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        a {
            text-decoration: none;
            color: blue;
        }
    </style>
</head>
<body>
    <h1>Product List <span style="color: blue">(လက်လီ)</span></h1>

    <!-- Search Form -->
    <form action="Product_List_latkar.php" method="GET">
        
    </form>

    <!-- Product Search Section -->
   
    <input type="text" id="search_term" style="padding:5px;font-size:18px" placeholder="Search by product name..." autofocus>

    <!-- Product Table -->
    <table id="product_table">
        <thead>
            <tr>
                <th>Product Name (CTN code)</th>
                <th>Quantity</th>
                <th>Buy Price</th>
                <th>Sell Price</th>
               
                <th>Link To Product</th>
                <th colspan="3">Commands</th>
            </tr>
        </thead>
        <tbody id="product_body">
            <?php
            // Display search results or all products
            if ($search_results) {
                while ($array = mysqli_fetch_assoc($search_results)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($array['Product_Name'], ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars($array['latkar_ID'], ENT_QUOTES, 'UTF-8') . ')</td>';
                    echo '<td>' . htmlspecialchars($array['Quantity'], ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . number_format(htmlspecialchars($array['Buy_Price'], ENT_QUOTES, 'UTF-8')) . '</td>';
                    echo '<td>' . number_format(htmlspecialchars($array['Sell_Price'], ENT_QUOTES, 'UTF-8')) . '</td>';
                    echo '<td>' . htmlspecialchars($array['Quantity_Per_Package'], ENT_QUOTES, 'UTF-8') . '</td>';
                    if (empty($array['Parent_Product_Name'])) {
                        echo '<td>Not connected to latli</td>';
                    } else {
                        echo '<td><a href="ExtractingPackage.php?PID=' . htmlspecialchars($array['Parent_Product_ID'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($array['Parent_Product_Name'], ENT_QUOTES, 'UTF-8') . '</a></td>';
                    }
                    echo '<td><a href="ExtractingPackage.php?PID=' . htmlspecialchars($array['Parent_Product_ID'], ENT_QUOTES, 'UTF-8') . '">Add to လက်လီ</a></td>';
                    echo '<td><a href="Product_Latkar_Restock.php?PID=' . htmlspecialchars($array['latkar_ID'], ENT_QUOTES, 'UTF-8') . '">Edit</a></td>';
                    echo '</tr>';
                }
            } else {
                // Display all products if no search results
                $select_latkar = "SELECT pl.Link_To_CTN, pl.Product_ID AS latkar_ID, p.Product_ID AS Parent_Product_ID, p.Product_Name AS Parent_Product_Name, pl.Product_Name, pl.Quantity, pl.Buy_Price, pl.Sell_Price 
                                  FROM product pl 
                                  LEFT JOIN product_latkar p ON p.Product_ID = pl.Link_To_CTN";
                $select_query = mysqli_query($connection, $select_latkar);

                if (!$select_query) {
                    die('Query failed: ' . mysqli_error($connection));
                }

                while ($array = mysqli_fetch_assoc($select_query)) {
                    echo '<tr>';
                    echo '<td>' . htmlspecialchars($array['Product_Name'], ENT_QUOTES, 'UTF-8') . ' (' . htmlspecialchars($array['latkar_ID'], ENT_QUOTES, 'UTF-8') . ')</td>';
                    echo '<td>' . htmlspecialchars($array['Quantity'], ENT_QUOTES, 'UTF-8') . '</td>';
                    echo '<td>' . number_format(htmlspecialchars($array['Buy_Price'], ENT_QUOTES, 'UTF-8')) . '</td>';
                    echo '<td>' . number_format(htmlspecialchars($array['Sell_Price'], ENT_QUOTES, 'UTF-8')) . '</td>';
                  
                    if (empty($array['Parent_Product_Name'])) {
                        echo '<td>Not connected to latkar</td>';
                    } else {
                        echo '<td><a href="Product_Latkar_Restock.php?PID=' . htmlspecialchars($array['Parent_Product_ID'], ENT_QUOTES, 'UTF-8') . '">' . htmlspecialchars($array['Parent_Product_Name'], ENT_QUOTES, 'UTF-8') . '</a></td>';
                    }
                    
                    echo '<td><a href="Product_Latli_Restock.php?PID=' . htmlspecialchars($array['latkar_ID'], ENT_QUOTES, 'UTF-8') . '">Edit</a></td>';
                    echo '</tr>';
                }
            }
            ?>
        </tbody>
    </table>

    <!-- JavaScript for AJAX Product Search -->
    <script>
        const searchInput = document.getElementById('search_term');
        const productTable = document.getElementById('product_table');
        const productBody = document.getElementById('product_body');

        searchInput.addEventListener('input', function() {
            const searchValue = this.value.trim().toLowerCase();

            // Loop through rows to show/hide based on search input
            Array.from(productBody.getElementsByTagName('tr')).forEach(function(row) {
                const productName = row.getElementsByTagName('td')[0]; // Assuming product name is first column
                if (productName) {
                    const textValue = productName.textContent.toLowerCase() || productName.innerText.toLowerCase();
                    row.style.display = textValue.indexOf(searchValue) > -1 ? '' : 'none';
                }
            });

            // Show/hide entire table if search input is empty
            productTable.style.display = searchValue.length > 0 ? 'table' : '';
        });
    </script>
</body>
</html>