<?php 
session_start();
include_once __DIR__ . '/settings.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["user"]) && $_SESSION["user"] === true){
	header("location: ./admin/manage.php");
	exit;
}

include('app_logic.php'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="./styles/forgetpass.css">
</head>
<body>
	<form class="login-form" action="enter_email.php" method="post">
		<h2 class="form-title">Reset password</h2>
		<!-- form validation messages -->
		<?php include('messages.php'); ?>
		<div class="form-group">
			<label>Your email address</label>
			<input type="email" name="email">
		</div>
		<div class="form-group">
			<button type="submit" name="reset-password" class="login-btn">Submit</button>
			<p style="margin-top: 20px;">Go back to <a href="login.php"> login page</a>.</p>
		</div>
	</form>
</body>
</html>