<?php
// ob_start(); // Start output buffering

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once __DIR__ . '/settings.php';
session_start();
echo $_SERVER["REQUEST_METHOD"];
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "hâhhahahaha";
    $count = 0;
    // Check if email is empty
    $email = trim($_POST["email"]);
    if (empty($email)) {
        $email_err = "Please enter email.";
        $count++;
    } else {
        $email = trim($_POST["email"]);
    }

    // Check if password is empty
    $password = trim($_POST["pword"]);
    if (empty($password)) {
        $password_err = "Please enter your password.";
        $count++;
    } else {
        $password = trim($_POST["pword"]);
    }

    if ($count > 0) {

        $_SESSION["email_err"] = $email_err;
        $_SESSION["password_err"] = $password_err;
        header("location: login.php");
    } else {
        global $pdo;
        // Validate credentials
        // Prepare a select statement
        $sql = "SELECT staffId, email, staffRoles, concat(staffFname, ' ', staffLname) as fuName, staffStatus, password FROM staff WHERE email = :email";


        if ($stmt = $pdo->prepare($sql)) {
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if ($stmt->execute()) {
                // Check if email exists, if yes then verify password
                if ($stmt->rowCount() == 1) {
                    if ($row = $stmt->fetch()) {
                        $staffStatus = $row["staffStatus"];
                        if ($staffStatus === 0) {
                            $email_err = "Your account is not active. Please contact admin.";
                            $_SESSION["email_err"] = $email_err;
                            header("location: ./login.php");
                        }
                        $id = $row["staffId"];
                        $email = $row["email"];
                        $staffRoles = $row["staffRoles"];
                        $staffStatus = $row["staffStatus"];
                        $fuName = $row["fuName"];
                        $hashed_password = $row["password"];
                        $hashed_input_password = md5($password);
                        if ($hashed_input_password == $hashed_password) {
                            // Password is correct, so start a new session
                            // session_start();

                            // Store data in session variables
                            $_SESSION['user'] = [
                                'fullname' => $fuName,
                                'staffroles' => $staffRoles,
                                'staffstatus' => $staffStatus,
                                // any other user information you want to store
                            ];

                            $_SESSION["staffId"] = $id;
                            $_SESSION["email"] = $email;

                            // Redirect user to welcome page
                            header("location: ./admin/manage.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The password you entered was not valid.";
                            $_SESSION["password_err"] = $password_err;
                            header("location: login.php");
                        }
                    }
                } else {
                    // Display an error message if email doesn't exist
                    $email_err = "No account found with that email.";
                    $_SESSION["email_err"] = $email_err;
                    header("location: login.php");
                }
            } else {
                $password_err = "Oops! Something went wrong. Please try again later.";
                $_SESSION["password_err"] = $password_err;
                header("location: login.php");
            }
        }
        // echo "oh ... my .. god";
    }
}

// ob_end_flush(); // Flush the output buffer and turn off output buffering
?>