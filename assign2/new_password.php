<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Including database connections
include_once __DIR__ . '/settings.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["user"]) && $_SESSION["user"] === true){
	header("location: ./admin/manage.php");
	exit;
}




//if token is null, redirect back enter_email.php
// if (empty($_GET['token'])) {
// 	header('location: ../enter_email.php');
// }
// include('app_logic.php'); 
session_start();
$resultErr = isset($_SESSION['resultErr']) ? $_SESSION['resultErr'] : "";
$token = isset($_GET['token']) ? $_GET['token'] : "";
echo $resultErr;
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Password Reset PHP</title>
	<link rel="stylesheet" href="./styles/forgetpass.css">
	<link rel="stylesheet" href="./styles/alert.css">
    <link rel="stylesheet"
    href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
</head>
<body>
	<form class="login-form" action="./toikobiet.php" method="post">
		<h2 class="form-title">New password</h2>
		 <!-- Display validation message for First Name -->
              <?php if (!empty($resultErr) && is_string($resultErr)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultErr;
                    unset($_SESSION['resultErr']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
		<!-- form validation messages -->
		<input type="hidden" name="token" value="<?=$token?>">
		<div class="form-group">
			<label>New password</label>
			<input type="password" name="new_pass">
		</div>
		<div class="form-group">
			<label>Confirm new password</label>
			<input type="password" name="new_pass_c">
		</div>
		<div class="form-group">
			<button type="submit" name="new_password" class="login-btn">Submit</button>
		</div>
	</form>
</body>
</html>