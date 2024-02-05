<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Initialize the session
session_start();

// Including database connections
include_once __DIR__ . '/settings.php';

// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["user"]) && $_SESSION["user"] === true) {
    header("location: ./admin/manage.php");
    exit;
}
// $resultEmail = $_SESSION['email_err'];
$resultEmail = isset($_SESSION['email_err']) ? $_SESSION['email_err'] : "";

//if user click submit button, check the input email
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;
    // Check if email is empty
    // echo $_POST["email"];
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Please enter email.";
        $count++;
    } else {
        $email = trim($_POST["email"]);
    }

    if ($count > 0) {

        $_SESSION["email_err"] = $email_err;
        header("location: forget.php");
    } else {
        checkEmail($email);
    }
}

//check if email exist in database pdo
function checkEmail($email)
{
    global $pdo;
    $sql = "SELECT staffId, email, staffStatus FROM staff WHERE email = :email";
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);
        // Set parameters
        $param_email = trim($email);
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if email exists, if yes then pass to input code
            if ($stmt->rowCount() == 1) {
                if ($row = $stmt->fetch()) {
                    $staffStatus = $row["staffStatus"];
                    if ($staffStatus == 0) {
                        $email_err = "Your account is not active. Please contact admin.";
                        $_SESSION["email_err"] = $email_err;
                        header("location: ./forget.php");
                    } else {
                        include('app_logic.php');
                    }
                }
                // header("location: ./app_logic.php");
            } else {
                $_SESSION['email_err'] = "Email not found!";
                header("location: ./forget.php");
                return false;
            }
        }
    }
}

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
    <title>Forget password - l:on</title>
</head>

<body>
    <h1>Forget Password page</h1>
    <form action="forget.php" method="post">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Forget Password <a href="./index.php">Back to main page</a></h3>
            <p>Using your email or user name</p>
        </div>

        <!-- Main container for all inputs feild -->
        <div class="mainContainer">
            <!-- Begin Email -->
            <label for="email">Email</label>
            <input type="text" placeholder="Enter Email..." name="email" required>
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

            <!-- Begin sub-container for the checkbox and the link -->
            <div class="subContainer">

                <p class="forgotpass"> <a href="./login.php">Back to Login Page</a></p>
            </div>
            <!-- Ending sub-container for the checkbox and the link -->

            <!-- Begin Submit find button -->
            <button name="reset-password" type="submit">Find!</button>
            <!-- End Submit find button -->



        </div>

    </form>

    <div class="listing margin-top-20 flex-flex center-center">
        <span><a href="#">© Stackfindover</a></span>
        <span><a href="#">Contact</a></span>
        <span><a href="#">Privacy & terms</a></span>
    </div>


</body>

</html>