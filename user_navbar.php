<?php 
include('Config.php');
// function is_active($page) {
//     // Get the current URL path
//     $currentURL = basename($_SERVER['PHP_SELF']);

//     // Check if the current URL matches the page argument
//     if ($currentURL === $page) {
//         return 'active';
//     } else {
//         return '';
//     }
// }
 ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Navigation Example</title>
    <style>
        /* Your CSS styles */
        body {
            font-family: Arial, sans-serif;
        }
        .Navbar {
            display: flex;
            background-color: #f0f0f0;
            padding: 10px;
        }
        .Navbar div {
            display: flex;
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
</head>
<body>
    
            <nav id="userNav">
                <?php if (empty($_SESSION['Username'])) : ?>
                    <input type="submit" value="User" onclick="window.location.href='login.php';">
                <?php else : ?>
                    Admin
                <?php endif; ?>
            </nav>
        </div>
    </div>
</body>
</html>