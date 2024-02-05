<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// check if the role is specific in the specific page
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    $staffroles = $user["staffroles"];
  
    
    //make the loop to compare
    foreach($_GET['roles'] as $value) {
  
        if ($value != $staffroles) {
            $hasMismatch = true; // found a mismatch
        }else{
            $hasMismatch = false;
            break; // no need to check further
        }
    }
  
    if ($hasMismatch) {
        // header("location: ./controller/authroleCheck.php");
        header("location: ./unauthorization.php");
         exit; // terminate the script after redirecting
    }
  
  }

?>