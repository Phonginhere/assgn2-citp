<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["user"]) && is_array($_SESSION["user"]) !== false){
    header("location: ./admin/manage.php");
    exit;
}
// $resultEmail = $_SESSION['email_err'];
$resultEmail = isset($_SESSION['email_err']) ? $_SESSION['email_err'] : "";
$resultPass = isset($_SESSION['password_err']) ? $_SESSION['password_err'] : "";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/login.css">
    <link rel="stylesheet" href="./styles/alert.css">
    <link rel="stylesheet"
    href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <title>Login page - l:on</title>
</head>

<body>
    <h1>Login page</h1>
    <form action="./processAuthorizing.php" method="post">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Sign in <a href="./index.php">Back to main page</a></h3>
            <p>Using your username/email and password</p>
        </div>

        <!-- Main container for all inputs feild -->
        <div class="mainContainer">
            <!-- Begin Username -->
            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email..." name="email">
            <!-- Display validation message for Email Address -->
            <?php if (!empty($resultEmail) && is_string($resultEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultEmail;
                    unset($_SESSION['email_err']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            <!-- End Email -->
            <br><br>

            <!-- Begin Password -->
            <label for="pword">Password</label>
            <input type="password" placeholder="Enter Password..." name="pword">
            <?php if (!empty($resultPass) && is_string($resultPass)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert2" />
                  <label class="close" title="close" for="alert2">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultPass;
                    unset($_SESSION['password_err']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            <!-- Ending Password -->

            <!-- Begin sub-container for the checkbox and the link -->
            <div class="subContainer">
                <p class="forgotpass"> <a href="./forget.php">Forgot Password</a></p>
            </div>
            <!-- Ending sub-container for the checkbox and the link -->

            <!-- Begin Submit login button -->
            <button type="submit">Login</button>
            <!-- End Submit login button -->

            

        </div>

    </form>

    <div class="listing margin-top-20 flex-flex center-center">
        <span><a href="#">© Stackfindover</a></span>
        <span><a href="#">Contact</a></span>
        <span><a href="#">Privacy & terms</a></span>
      </div>
</body>

</html>