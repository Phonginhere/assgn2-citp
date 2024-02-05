<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once __DIR__ . '/../../settings.php';
session_start();



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;

    $id = isset($_POST["id"]) ? $_POST["id"] : "";

    $firstname = isset($_POST["firstname"]) ? $_POST["firstname"] : "";
    $lastname = isset($_POST["lastname"]) ? $_POST["lastname"] : "";
    $nickname = isset($_POST["nickname"]) ? $_POST["nickname"] : "";
    $email = isset($_POST["emailAdd"]) ? $_POST["emailAdd"] : "";

    $phonenum = isset($_POST["phonenum"]) ? $_POST["phonenum"] : "";
    $telenum = isset($_POST["telenum"]) ? $_POST["telenum"] : "";

    $roles = isset($_REQUEST['roles']) ? $_REQUEST['roles'] : "";
    $status = isset($_REQUEST['status']) ? $_REQUEST['status'] : "";


    $npass = isset($_POST["npass"]) ? $_POST["npass"] : "";
    $retypepass = isset($_POST["retypepass"]) ? $_POST["retypepass"] : "";

    $currentFile = isset($_POST["currentFile"]) ? $_POST["currentFile"] : "";


    $resultFirstname = firstName_validate($firstname);
    $resultLastname = lastName_validate($lastname);
    $resultNickname = nickName_validate($nickname);
    $resultEmail = email_validate($email);

    $resultPhonenum = validatePhone($phonenum, $id);
    $resultTelenum = validate_telephone($telenum, $id);

    $resultddRoles = validatedropdownRoles($roles);
    $resultddStatus = validatedropdownStatus($status);

    $resultNpass = validate_newpassword($npass);
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


    if (is_array($resultPhonenum)) {
        $resultPhonenum = null;
    } else {
        $count++;
    }

    if (is_array($resultTelenum)) {
        $resultTelenum = null;
    } else {
        $count++;
        echo $resultTelenum;

    }

    if (is_array($resultddRoles)) {
        $resultddRoles = null;
    } else {
        $count++;
    }

    if (is_array($resultddStatus)) {
        $resultddStatus = null;
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


        $_SESSION['resultPhonenum'] = $resultPhonenum;
        $_SESSION['resultTelenum'] = $resultTelenum;

        $_SESSION['resultddRoles'] = $resultddRoles;
        $_SESSION['resultddStatus'] = $resultddStatus;

        $_SESSION['resultNpass'] = $resultNpass;
        $_SESSION['resultRpass'] = $resultRpass;

        // $messageErr = "We found: " . "<br>" . $resultName . "<br>" . $resultEmail . "<br>" . $resultDob . "<br>" . $resultGender . "<br>" . $resultStreetSurtown . "<br>" . $resultState . "<br>" . $postcodeErr . "<br>" . $returnPhone. "<br>" .$returnSkills;
        header("Location: ../" . $currentFile);
        echo "vvvvvvv";
    } else {
        $hashedPassword = md5($npass);
        if (strpos($currentFile, "Adding") !== false) {

            $sql = "INSERT INTO staff (staffFname, staffLname, staffNname, email, phoneNum, telephoneNum, password, staffRoles, staffStatus, addedDate) 
            VALUES (:staffFname, :staffLname, :staffNname, :email, :phonenum, :telephoneNum, :password, :staffRoles, :staffStatus, NOW())";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':staffFname', $firstname);
            $stmt->bindParam(':staffLname', $lastname);
            $stmt->bindParam(':staffNname', $nickname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phonenum', $phonenum);
            $stmt->bindParam(':telephoneNum', $telenum);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':staffRoles', $roles);
            $stmt->bindParam(':staffStatus', $status);


            $stmt->execute();
        } else {
            $sql = "UPDATE staff SET staffFname = :staffFname, staffLname = :staffLname, staffNname = :staffNname, email = :email, phoneNum = :phonenum, telephoneNum = :telephoneNum, password = :password, staffRoles = :staffRoles, staffStatus = :staffStatus WHERE staffID = :staffID";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':staffFname', $firstname);
            $stmt->bindParam(':staffLname', $lastname);
            $stmt->bindParam(':staffNname', $nickname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phonenum', $phonenum);
            $stmt->bindParam(':telephoneNum', $telenum);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':staffRoles', $roles);
            $stmt->bindParam(':staffStatus', $status);
            $stmt->bindParam(':staffID', $id);

            $stmt->execute();
        }

        header("Location: ../staffManager.php");
    }

}
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

function validatePhone($phone, $id)
{
    function validate_phone($phone)
    {
        // Remove spaces from the phone number
        $phone = str_replace(' ', '', $phone);


        // Check if the phone number consists of 8 to 12 digits
        return preg_match('/^[0-9]{8,12}$/', $phone);
    }

    $error = "";
    include_once __DIR__ . '/../../settings.php';
    global $pdo;
    // Check for duplicates in 'phoneNum' column
    $sql_phonenum = "SELECT * FROM staff where phoneNum ='$phone'";
    $stmt_phonenum = $pdo->prepare($sql_phonenum);
    $stmt_phonenum->execute();
    $duplicates_phonenum = $stmt_phonenum->fetchAll(PDO::FETCH_ASSOC);


    $sql_phoneuserRegister = "SELECT `phoneNum` FROM `staff` WHERE `staffId` = :staffId";
    $stmt_phoneuserRegister = $pdo->prepare($sql_phoneuserRegister);

    $stmt_phoneuserRegister->bindParam(':staffId', $id);
    $stmt_phoneuserRegister->execute();
    $phoneuserRegister = $stmt_phoneuserRegister->fetchAll(PDO::FETCH_ASSOC);

    // echo ;
    if (empty($phone)) {
        $error = "Phone number is required";
    } elseif (!validate_phone($phone)) {
        $error = "Invalid phone number format";
    } else if (count($duplicates_phonenum) > 0) {
        if(count($phoneuserRegister) > 0){
            return array($phone);
        }else{
            $error = "Duplicate phone number";
        }
    } else {
        // Valid phone number
        return array($phone);
    }

    return $error;
}

function validate_telephone($telephone, $id)
{
    function validate_telephone_limit($telephone)
    {
        // Remove spaces from the telephone number
        $phone = str_replace(' ', '', $telephone);

        // Check if the telephone number consists of 8 to 12 digits
        return preg_match('/^[0-9]{8,12}$/', $phone);
    }

    $error = "";
    // Check for duplicates in 'telephone' column
    include_once __DIR__ . '/../../settings.php';
    global $pdo;
    $sql_telephone = "SELECT * FROM staff where telephoneNum = '$telephone'";
    $stmt_telephone = $pdo->prepare($sql_telephone);
    $stmt_telephone->execute();
    $duplicates_telephone = $stmt_telephone->fetchAll(PDO::FETCH_ASSOC);


    $sql_telephoneuserRegister = "SELECT `telephoneNum` FROM `staff` WHERE `staffId` = :staffId";
    $stmt_telephoneuserRegister = $pdo->prepare($sql_telephoneuserRegister);
    $stmt_telephoneuserRegister->bindParam(':staffId', $id);
    $stmt_telephoneuserRegister->execute();
    $telephoneuserRegister = $stmt_telephoneuserRegister->fetch(PDO::FETCH_ASSOC);


    if (!validate_telephone_limit($telephone) && !(is_null($telephone) || empty($telephone))) {
        $error = "Invalid telephone format";
        // echo "hahaha";
    } else if (count($duplicates_telephone) > 0 && !(is_null($telephone) || empty($telephone))) {
        if(count($telephoneuserRegister) > 0){
            return array($phone);
        }else{
            $error = "Duplicate telephone number";
        }
    } else {
        // Valid telephone number
        // echo "4444";
        return array($telephone);
       
    }

   

    return "$error";
}

function validatedropdownRoles($roles)
{
    if (isset($roles) && $roles == 'n') {
        return 'Please select a role.';
    } else {
        return array($roles);
    }

}

function validatedropdownStatus($status)
{
    if (isset($status) && $status == 'n') {
        return 'Please select a status.';
    } else {
        return array($status);
    }
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
        $result = "Please input re-type password";
    } else
        if ($password != $retypepass) {
            $result = "Please make sure that retype password should similar to new password that you input";
        } else {
            $result = array($retypepass);
        }

    return $result;
}

?>