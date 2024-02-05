<?php
include_once __DIR__ . '/settings.php';
session_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Check if the user is already logged in, if yes then redirect him to welcome page
if (isset($_SESSION["user"]) && $_SESSION["user"] === true) {
    header("location: ./admin/manage.php");
    exit;
}

//begin check new password
function validate_newpassword($password)
{
    $result = "";

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $password);
    $lowercase = preg_match('@[a-z]@', $password);
    $number = preg_match('@[0-9]@', $password);
    $specialChars = preg_match('@[^\w]@', $password);
    if (empty($password)) {
        $result = "Please input new password";
    } else if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
        $result = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
    } else {
        $result = array($password);
    }
    return $result;
}
//end check new password

// ENTER A NEW PASSWORD
//if form submit
if (isset($_POST['new_password'])) {
    $token = $_POST['token'];
    $newpwd = $_POST['newpwd'];
    $confmNewpwd = $_POST['confmNewpwd'];
    $count = 0;
    //check new password
    $result = validate_newpassword($newpwd);
    if (is_array($result)) {
        $newpwd = $result[0];
    } else {
        $newpwd_err = $result;
        $count++;
    }
    //check confirm new password
    if (empty($confmNewpwd)) {
        $confmNewpwd_err = "Please confirm new password";
        $count++;
    } else {
        if ($newpwd != $confmNewpwd) {
            $confmNewpwd_err = "Confirm password not match";
            $count++;
        }
    }
    //check if the token is similar in database
    global $pdo;
    $email = "";
    $sql = "SELECT token, email FROM password_resets WHERE token = :token";
    if ($stmt = $pdo->prepare($sql)) {
        // Bind variables to the prepared statement as parameters
        $stmt->bindParam(":token", $param_token, PDO::PARAM_STR);
        // Set parameters
        $param_token = trim($token);
        // Attempt to execute the prepared statement
        if ($stmt->execute()) {
            // Check if email exists, if yes then pass to input code
            if ($stmt->rowCount() == 1) {
                //assign email variable to use in update password
                if ($row = $stmt->fetch()) {
                    $email = $row["email"];
                } 
                // if ($row = $stmt->fetch()) {
                //     $id = $row["staffId"];
                //     $email = $row["email"];
                //     return true;
                // }
                // header("location: ./app_logic.php");
                // include('app_logic.php');
            } else {
                $newpwd_err = "No token exist";
                $count++;
            }
        }
    }

    //if no error, update new password
    if ($count == 0) {
        $sql = "UPDATE staff SET password = :password WHERE email = :email";
        if ($stmt = $pdo->prepare($sql)) {
            // Set parameters
            $param_password = md5($newpwd);
            
            $param_token = $token;

            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":email", $email, PDO::PARAM_STR);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Password updated successfully. Destroy the token
                $sql = "DELETE FROM password_resets WHERE token = :token";
                if ($stmt = $pdo->prepare($sql)) {
                    // Bind variables to the prepared statement as parameters
                    $stmt->bindParam(":token", $param_token, PDO::PARAM_STR);
                    $stmt->execute();
                    // Password updated successfully. Destroy the session, and redirect to login page
                    session_destroy();
                    header("location: ./login.php");
                    exit();
                } else {
                    echo "Oops! Something went wrong. Please try again later.";
                }

            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
    } else {
        $_SESSION['newpwd_err'] = $newpwd_err;
        $_SESSION['confmNewpwd_err'] = $confmNewpwd_err;
        header("location: ./inputPwd.php?token=$token");
        exit();
    }
}
$newpwd_err = isset($_SESSION['newpwd_err']) ? $_SESSION['newpwd_err'] : "";
$confmNewpwd_err = isset($_SESSION['confmNewpwd_err']) ? $_SESSION['confmNewpwd_err'] : "";

// if (isset($_POST['new_password'])) {
//     $token = $_POST['token'];
//     echo $token;
//     $_SESSION['resultErr'] = 'No token exist';
//     // header('Location: ./inputPwd.php?token='.$token);
// }

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
    <title>New password Recovery</title>
</head>

<body>
    <h1>New password Recovery</h1>
    <form action="inputPwd.php" method="post">
        <!-- Headings for the form -->
        <div class="headingsContainer">
            <h3>Please type new password</h3>
        </div>

        <!-- Main container for all inputs feild -->
        <div class="mainContainer">
            <!-- Begin code -->
            <input type="hidden" name="token" value="<?= $_GET['token'] ?>">
            <input type="password" placeholder="Enter New Password..." name="newpwd">
            <!-- Display validation message for New Password -->
            <?php if (!empty($newpwd_err) && is_string($newpwd_err)): ?>
                <div class="alert error">
                    <input type="checkbox" id="alert1" />
                    <label class="close" title="close" for="alert1">
                        <i class="las la-times"></i>
                    </label>
                    <p class="inner">
                        <strong>Warning!</strong>
                        <?php echo $newpwd_err;
                        unset($_SESSION['newpwd_err']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <!-- End New Password -->

            <input type="password" placeholder="Enter New Password Again..." name="confmNewpwd">
            <!-- Display validation message for New Password -->
            <?php if (!empty($confmNewpwd_err) && is_string($confmNewpwd_err)): ?>
                <div class="alert error">
                    <input type="checkbox" id="alert2" />
                    <label class="close" title="close" for="alert2">
                        <i class="las la-times"></i>
                    </label>
                    <p class="inner">
                        <strong>Warning!</strong>
                        <?php echo $confmNewpwd_err;
                        unset($_SESSION['confmNewpwd_err']);
                        ?>
                    </p>
                </div>
            <?php endif; ?>
            <!-- End New Password -->
            <br><br>

            <!-- Begin sub-container for the checkbox and the link -->
            <div class="subContainer">

                <p class="forgotpass"> <a href="./login.php">Back to Login Page</a></p>
            </div>
            <!-- Ending sub-container for the checkbox and the link -->

            <!-- Begin Submit button -->
            <button type="submit" name="new_password">Submit</button>
            <!-- End Submit button -->



        </div>

    </form>

    <div class="listing margin-top-20 flex-flex center-center">
        <span><a href="#">© Stackfindover</a></span>
        <span><a href="#">Contact</a></span>
        <span><a href="#">Privacy & terms</a></span>
    </div>
</body>

</html>