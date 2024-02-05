<?php
session_start(); // Start the session

if (!isset($_SESSION['user'])) {
    // If the user is not logged in, redirect to login page
    header("Location: login.php");
    exit;
} 

// If the user is logged in, unset only the 'user' session variable
if (isset($_SESSION['user'])) {
    unset($_SESSION['user']);
}

// Redirect back to the login page or main page after logging out
header("Location: login.php");
exit;
?>
