<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Starting session
session_start();

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    //check if user is disabled in terms of status
    $staffStatus = $user["staffstatus"];
    if ($staffStatus === 0) {
        $email_err = "Your account is not active. Please contact admin.";
        unset($_SESSION['user']);
        $_SESSION["email_err"] = $email_err;
        header("location: ../login.php");
    }
    // echo "Hello, " . htmlspecialchars($user['username']);
} else {
    header("location: ../index.php");
}
?>