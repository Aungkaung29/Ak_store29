<?php 
include('Config.php');
if (empty($_SESSION['Username'])) {
  include('user_navbar.php');
}
else{
   include('Navbar.php');
}
date_default_timezone_set("Asia/Yangon");

$select_history = "SELECT * FROM history ORDER BY Date DESC";
$query = mysqli_query($connection,$select_history);

$count = mysqli_num_rows($query);
echo "<table style='width:100%'>";
for ($i=0; $i < $count; $i++) { 
	$array = mysqli_fetch_array($query);
	echo "<tr>";
	echo "<td>".$array['Product_Name']."</td>";
	echo "<td>".$array['Quantity']."</td>";
	echo "<td>".$array['Date']."</td>";
	echo "</tr>";
}
echo "</table>";
 ?>

