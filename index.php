<?php
if (empty($_SESSION['Username'])) {
	include('user_navbar.php');
	echo "Usermode";
	header("Location: Sale.php");
}else{
	echo "Admin mode";
include('Navbar.php');
header("Location: Navbar.php");
}
exit; 
?>
