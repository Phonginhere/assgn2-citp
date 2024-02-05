<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//connect settings.php
include_once __DIR__ . '/../../settings.php';



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;

    $idUser = isset($_POST["idUser"]) ? $_POST["idUser"] : "";
    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $nickname = isset($_POST["nickname"]) ? $_POST["nickname"] : "";
    $email = isset($_POST["emailAdd"]) ? $_POST["emailAdd"] : "";
    $dob = isset($_POST["dob"]) ? $_POST["dob"] : "";

    $phonenum = isset($_POST["phonenum"]) ? $_POST["phonenum"] : "";
    $telenum = isset($_POST["telenum"]) ? $_POST["telenum"] : "";

    $phonenum = isset($_POST["phonenum"]) ? $_POST["phonenum"] : "";
    $telenum = isset($_POST["telenum"]) ? $_POST["telenum"] : "";

    $opass = isset($_POST["opass"]) ? $_POST["opass"] : "";
    $npass = isset($_POST["npass"]) ? $_POST["npass"] : "";
    $retypepass = isset($_POST["retypepass"]) ? $_POST["retypepass"] : "";

    //retrieve value password using id
    $sql = "SELECT password FROM staff WHERE staffId = :staffId";
    $stmt_pass = $pdo->prepare($sql);
    
    $stmt_pass->bindParam(':staffId', $idUser);
    $stmt_pass->execute();

    $password = "";
    if ($stmt_pass->rowCount() > 0) {
        $rowpass = $stmt_pass->fetch(PDO::FETCH_ASSOC);
        $password = $rowpass['password'];
    } else {
        echo "No records found.";
    }

    $resultFirstname = firstName_validate($firstname);
    $resultLastname = lastName_validate($lastname);
    $resultNickname = nickName_validate($nickname);
    $resultEmail = email_validate($email);
    $resultdob = dob_validate($dob);

    $resultPhonenum = validatePhone($phonenum);
    $resultTelenum = validate_telephone($telenum);

    $resultOpass = validate_oldpassword($opass, $password);
    $resultNpass = validate_newpassword($npass, $password);
    $resultRpass = validate_retypePassword($npass, $retypepass);

    if (is_array($resultFirstname)) {
        $resultFirstname = null;
    } else {
        $count++;
    }

    if (is_array($resultLastname)) {
        $resultLastname = null;
    } else {
        $count++;
    }

    if (is_array($resultNickname)) {
        $resultNickname = null;
    } else {
        $count++;
    }

    if (is_array($resultEmail)) {
        $resultEmail = null;
    } else {
        $count++;
    }

    if (is_array($resultdob)) {
        $resultdob = null;
    } else {
        $count++;
    }

    if (is_array($resultPhonenum)) {
        $resultPhonenum = null;
    } else {
        $count++;
    }

    if (is_array($resultTelenum)) {
        $resultTelenum = null;
    } else {
        $count++;
    }

    if (is_array($resultOpass)) {
        $resultOpass = null;
    } else {
        $count++;
    }

    if (is_array($resultNpass)) {
        $resultNpass = null;
    } else {
        $count++;
    }

    if (is_array($resultRpass)) {
        $resultRpass = null;
    } else {
        $count++;
    }

    if ($count > 0) {
        // Redirect back to the form with the result
        $_SESSION['resultFirstname'] = $resultFirstname;
        $_SESSION['resultLastname'] = $resultLastname;
        $_SESSION['resultNickname'] = $resultNickname;
        $_SESSION['resultEmail'] = $resultEmail;

        $_SESSION['resultdob'] = $resultdob;
        $_SESSION['resultPhonenum'] = $resultPhonenum;
        $_SESSION['resultTelenum'] = $resultTelenum;
        $_SESSION['resultOpass'] = $resultOpass;
        $_SESSION['resultNpass'] = $resultNpass;
        $_SESSION['resultRpass'] = $resultRpass;
        // echo "chan luon";
        // $messageErr = "We found: " . "<br>" . $resultName . "<br>" . $resultEmail . "<br>" . $resultDob . "<br>" . $resultGender . "<br>" . $resultStreetSurtown . "<br>" . $resultState . "<br>" . $postcodeErr . "<br>" . $returnPhone. "<br>" .$returnSkills;
        header("Location: ../profile.php");
    } else {
        //debug here

        global $pdo;
        //update profile using pdo sql, I have include settings.php
        $sql = "UPDATE staff SET staffFname = :firstname, staffLname = :lastname, staffNname = :nickname, email = :email, dob = :dob, phoneNum = :phonenum,
         telephoneNum = :telenum, password = :password WHERE staffId = :staffId";
        $stmt = $pdo->prepare($sql);
        //assign password to hash password


        if (empty($npass)) { //if new password is empty, then update password with old password
            $stmt->bindParam(':password', $password);
        } else {
            $hashpass = md5($npass);
            $stmt->bindParam(':password', $hashpass);
        }
        //convert $dob to date standard for sql
        $dob = date('Y-m-d', strtotime(str_replace('/', '-', $dob)));
        $stmt->bindParam(':firstname', $firstname);
        $stmt->bindParam(':lastname', $lastname);
        $stmt->bindParam(':nickname', $nickname);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':dob', $dob);
        $stmt->bindParam(':phonenum', $phonenum);
        $stmt->bindParam(':telenum', $telenum);

        $stmt->bindParam(':staffId', $idUser);
        $stmt->execute();

    }
    header("Location: ../profile.php");
}

//begin personal details
function email_validate($email)
{
    $msg = "";

    if (empty($email)) {
        $msg = "Email is required";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email address format";
    } else {
        // Valid email address
        $msg = array($email);
    }

    return $msg;
}

function firstName_validate($first_name)
{
    $result = "";

    $max_length = 20;

    if (empty($first_name)) {
        $result = "Please enter First Name.";
    } elseif (strlen($first_name) > $max_length) {
        if (strlen($first_name) > $max_length) {
            $result = "First Name should be no more than $max_length characters long.";
        }
    } else {
        $result = array($first_name);
    }
    return $result;
}

function lastName_validate($last_name)
{
    $result = "";

    $max_length = 20;

    if (empty($last_name)) {
        $result = "Please enter Last Name.";
    } elseif (strlen($last_name) > $max_length) {
        if (strlen($last_name) > $max_length) {
            $result = "Last Name should be no more than $max_length characters long.";
        }
    } else {
        $result = array($last_name);
    }
    return $result;
}

function nickName_validate($nick_name)
{
    $result = "";

    $max_length = 20;

    if (strlen($nick_name) > $max_length) {
        if (strlen($nick_name) > $max_length) {
            $result = "Nick Name should be no more than $max_length characters long.";
        }
    } else {
        $result = array($nick_name);
    }
    return $result;
}

function dob_validate($dob)
{
    $result = "";

    if (!empty($dob)) {
        $dob_date = DateTime::createFromFormat('d/m/Y', $dob);
        if ($dob_date === false) {
            $result = "Invalid Date of Birth format. Use dd/mm/yyyy.";
        } else {
            $result = array($dob);
        }
    } else {
        $result = array($dob);
    }
    return $result;
}
//end personal details

function validatePhone($phone)
{
    function validate_phone($phone)
    {
        // Remove spaces from the phone number
        $phone = str_replace(' ', '', $phone);

        // Check if the phone number consists of 8 to 12 digits
        return preg_match('/^[0-9]{8,12}$/', $phone);
    }

    $error = "";


    if (empty($phone)) {
        $error = "Phone number is required";
    } elseif (!validate_phone($phone)) {
        $error = "Invalid phone number format";
    } else {
        // Valid phone number
        return array($phone);
        // You can perform further actions here.
    }

    return $error;
}

function validate_telephone($telephone)
{
    function validate_telephone_limit($telephone)
    {
        // Remove spaces from the telephone number
        $phone = str_replace(' ', '', $telephone);

        // Check if the telephone number consists of 8 to 12 digits
        return preg_match('/^[0-9]{8,12}$/', $phone);
    }

    $error = "";


    if (empty($telephone)) {
        $error = "Telephone number is required";
    } elseif (!validate_telephone_limit($telephone)) {
        $error = "Invalid telephone number format";
    } else {
        // Valid telephone number
        return array($telephone);
        // You can perform further actions here.
    }

    return $error;
}

//check old password from database table staff
function validate_oldpassword($opass, $password)
{
    $result = "";

    //compare password with hash $password
    if (!empty($opass)) {
        if (md5($password) != $opass) {
            $result = "Old Password is not correct";
        } else {
            $result = array($opass);
        }
    } else {
        $result = array($opass);
    }
    return $result;
}

//begin check new password
function validate_newpassword($npass, $password)
{
    $result = "";

    // Validate password strength
    $uppercase = preg_match('@[A-Z]@', $npass);
    $lowercase = preg_match('@[a-z]@', $npass);
    $number = preg_match('@[0-9]@', $npass);
    $specialChars = preg_match('@[^\w]@', $npass);
    if (!empty($npass)) {
        if (!$uppercase || !$lowercase || !$number || !$specialChars || strlen($npass) < 8) {
            $result = 'Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.';
        } else if ($npass != $password) {
            $result = "Please make sure that old password should not similar to password that you input";
        } else {
            $result = array($password);
        }
    } else {
        $result = array($password);
    }
    return $result;
}
//end check new password

function validate_retypePassword($password, $retypepass)
{
    $result = "";
    if (!empty($password) && empty($retypepass)) {
        $result = "Please input retype password";
    } else
        if ($password != $retypepass) {
            $result = "Please make sure that retype password should similar to new password that you input";
        } else {
            $result = array($retypepass);
        }

    return $result;
}

?>