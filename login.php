<?php require_once("inc/session.php");
require_once("inc/functions.php");
include('inc/db_connection.php');
?>

<?php

$email = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$email = $_POST["email"];
	$password = $_POST["password"];

	$found_user = attempt_login($email, $password);

	if ($found_user) {
		//Success - set session variables
		$_SESSION["user_id"] = $found_user["id"];
		$_SESSION["username"] = $found_user["username"];
		$_SESSION["role"] = $found_user["role"];
		redirect_to("index.php");
	} else {
		//failure - show error message
		$_SESSION["message"] = "Email or Password not found!";
		redirect_to("login.php");
	}
} 

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Home Menu Login</title>
    <link rel="stylesheet" href="css/style.css"> 
     <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
</head>
<body>
 <header>
      <h1 class="center">Home Menu Login</h1>
 </header>
  <div class="login"> 
   <?php echo message(); ?>
   <form class="login" action="#" method="POST">
       <input type="text" name="email" placeholder="EMAIL">
       <input type="password" name="password" placeholder="PASSWORD">
       <input type="submit" name="login" value="Sign In">
   </form>
   <br>
   <br>
   <br>
   <div class="clear"></div>
    <a title="New User" href="register.php"><input type="submit" value="New User"></a></p>  
    
    <a title="Forgot Your Password?" href="forgot_password.php"><input type="submit" value="Forgot Password"></a></p>  
       
    </div>
</body>
</html>