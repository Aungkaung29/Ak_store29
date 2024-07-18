<?php
error_reporting(E_ALL);
ini_set('display_error',1);
session_start();
$alert_message='';
$valid_password = '1234';
if($_SERVER["REQUEST_METHOD"] == "POST"){
$password = $_POST["txtpassword"];
if($password === $valid_password){
	$valid_username="admin";
	$_SESSION['Username']= $valid_username;
	$alert_message = 'login success';
	header("Location:Today_Sale_List.php");
	exit();
	}else{
		$alert_message = "Invalid";
	}
}

?>



</script>
  <style>
        /* CSS styles for the binary text and main content */
        body {
            background: black;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Prevent scrolling */
            font-family: Arial, sans-serif;
            color: white;
        }

        .binary-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -1;
            font-family: Courier, monospace;
            font-size: 20px;
            color: #14452f;
            overflow: hidden;
        }

        .container {
            position: relative;
            background-color:  #1d2e28;
            width: 250px;
            
            text-align: center;
            border: 1px solid #ccc;
        }

        .inputtext {
            padding: 10px;
            font-size: 16px;
            width: calc(100% - 20px); /* Adjusted to accommodate padding */
            box-sizing: border-box;
            margin-bottom: 10px;
        }

        .button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #14452f;
            color:  black;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background-color: #45a049;
        }

        h2 {
            padding:0px;
            font-size: 30px;
          color: #14452f;
            background-color: transparent;
             text-shadow: 4px 4px 10px rgba(0, 0, 0, 0.5);
           
        }
    </style>

<form action = "login.php" method="POST">
<?php echo $alert_message; ?>
 <div class="container">
        <h2>Login</h2>

        <form action="login.php" method="POST">
            <input type="password" name="txtpassword" class="inputtext" placeholder="Password" autofocus required>
            <button type="submit" class="button">Login</button><button class="button" onclick="window.history.back();">Back</button>
            <p class="message" id="alert_message"></p>
        </form>
    </div>
</form>
