<?php
// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// echo "Current directory: " . __DIR__;
// echo "PHPMailer directory: " . realpath(__DIR__ . '/path/to/phpmailer/');

// require './PHPMailer ';

require realpath(__DIR__ . '/PHPMailer/PHPMailerAutoload.php');
// require realpath(__DIR__ . '/PHPMailer/src/PHPMailer.php');
// require realpath(__DIR__ . '/PHPMailer/src/SMTP.php');

// require 'phpmailer/src/Exception.php';
// require 'phpmailer/src/PHPMailer.php';
// require 'phpmailer/src/SMTP.php';

session_start();
$errors = [];
$user_id = "";
// connect to database
$host = 'feenix-mariadb.swin.edu.au';
$dbname = 's104334842_db';
$user = 's104334842';
$pass = '@taoXincu17';
$db = mysqli_connect($host, $user, $pass, $dbname);

/*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])) {
  $email = mysqli_real_escape_string($db, $_POST['email']);
  // ensure that the user exists on our system
  $query = "SELECT email FROM staff WHERE email='$email'";
  $results = mysqli_query($db, $query);

  if (empty($email)) {
    array_push($errors, "Your email is required");
  } else if (mysqli_num_rows($results) <= 0) {
    array_push($errors, "Sorry, no user exists on our system with that email");
  }
  // generate a unique random token of length 100
  if (function_exists('random_bytes')) {
    $token = bin2hex(random_bytes(50));
  } elseif (function_exists('openssl_random_pseudo_bytes')) {
    $token = bin2hex(openssl_random_pseudo_bytes(50));
  } else {
    // Fallback to a less secure method if neither function is available
    $token = bin2hex(mt_rand());
  }

  if (count($errors) == 0) {
    // store token in the password-reset database table against the user's email
    $sql = "INSERT INTO password_resets(email, token) VALUES ('$email', '$token')";
    $results = mysqli_query($db, $sql);

    // Send email to user with the token in a link they can click on
    // Start with PHPMailer class

    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = 3; // Increase to 2 to get more detailed error messages
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = "projectsut23@gmail.com"; // Enter your email
    $mail->Password = "ityoagcunbrnvttd";
    $mail->SMTPSecure = 'tls';
    $mail->Port = 25;


    $mail->From = "projectsut23@gmail.com";
    $mail->FromName = "Reset password from Company";

    $mail->addAddress("$email", "Hello User");

    $mail->isHTML(true);

    $mail->Subject = 'Reset your password on our company';
    // Set HTML
    $domain = "mercury.swin.edu.au/cos10026/s104334842/assign2";
    $mail->isHTML(TRUE);
    $mail->Body = "Hi there, click on this <a href=\"http://" . $domain . "/inputPwd.php?token=$token\"\">link</a> to reset your password on our site";
    $mail->AltBody = 'Hi there, we are happy to confirm your booking. Please check the document in the attachment.';

    try {
      $_SESSION['token'] = $token;
      $mail->send();
      // $_POST['email'] = $email;
      header("location: pending.php?email=$email");

    } catch (Exception $e) {
      echo "Mailer Error: " . $mail->ErrorInfo;
    }
  }
}






?>