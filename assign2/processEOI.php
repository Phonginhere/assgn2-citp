<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once __DIR__ . '/settings.php';
session_start();

function checkAndCreateTable($pdo, $tableName, $createQuery, $keysQuery, $autoIncrementQuery, $constraintsQuery)
{
    try {
        $pdo->query("SELECT 1 FROM $tableName LIMIT 1");
    } catch (Exception $e) {
        // If table doesn't exist, create it
        $pdo->exec($createQuery);
        $pdo->exec($keysQuery);
        $pdo->exec($autoIncrementQuery);
        $pdo->exec($constraintsQuery);

        // echo "Table $tableName created and configured successfully!";
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $jobId = "";
    $count = 0;

    $first_name = isset($_POST["givenname"]) ? $_POST["givenname"] : "";
    $middle_name = isset($_POST["middlename"]) ? $_POST["middlename"] : "";
    $last_name = isset($_POST["familyname"]) ? $_POST["familyname"] : "";

    $dob = isset($_POST["dateofbirth"]) ? $_POST["dateofbirth"] : "";

    $email = $_POST["email"];

    $gen = isset($_POST["gen"]);

    $jobref = isset($_GET["ref_num"]) ? $_GET["ref_num"] : "";

    $streetAddress = isset($_POST["street"]) ? $_POST["street"] : "";
    $suburbTown = isset($_POST["sub_t"]) ? $_POST["sub_t"] : "";

    $state = isset($_POST["state"]) ? $_POST["state"] : "";

    $postcode = $_POST["postcode"];

    $phone = $_POST["phonenum"];

    $skills = isset($_POST["skills"]) ? $_POST["skills"] : "";
    // print_r($skills);
    $jobRef = isset($_POST["ref_num"]) ? $_POST["ref_num"] : "";

    $otherText = isset($_POST['Other']) ? $_POST["Other"] : "";

    $resultName = validateName($first_name, $middle_name, $last_name);
    $resultEmail = validateEmail($email, $pdo);
    $resultDob = validateAge($dob);
    $resultGender = validateGender();
    $resultStreetSurtown = validatestreetandSurtown($streetAddress, $suburbTown);
    $resultState = validateState();
    $resultPostcode = validatePostcode($postcode);
    $returnPhone = validatePhone($phone);
    $returnSkills = validateSkills($skills);
    $returnjobRef = jobRef($jobref);

    if (is_array($resultName)) {
        $resultName = null;
    } else if ($resultName) {
        $count++;
    }

    if (is_array($resultEmail)) {
        $resultEmail = null;
    } else if ($resultEmail) {
        $count++;
    }

    if (is_array($resultDob)) {
        $resultDob = null;
    } else if ($resultDob) {
        $count++;
    }

    if (is_array($resultGender)) {
        $resultGender = null;
    } else if ($resultGender) {
        $count++;
    }

    if (is_array($resultStreetSurtown)) {
        $resultStreetSurtown = null;
    } else if ($resultStreetSurtown) {
        $count++;
    }

    if (is_array($resultState)) {
        $resultState = null;
    } else if ($resultState) {
        $count++;
    }

    if (is_array($resultPostcode)) {
        $resultPostcode = null;
    } else {
        $count++;
        // $postcodeErr = "wrong postcode or invalid postcode suitable for the state";
    }

    if (is_array($returnPhone)) {
        $returnPhone = null;
    } else if ($returnPhone) {
        $count++;
    }

    if (is_array($returnSkills)) {
        $returnSkills = null;
    } else if ($returnSkills) {
        $count++;
    }
    if (is_array($returnjobRef)) {
        $returnjobRef = null;
    } else if ($returnjobRef) {
        $count++;

    }


    if ($count > 0) {
        // Redirect back to the form with the result
        $_SESSION['resultName'] = $resultName;
        $_SESSION['resultEmail'] = $resultEmail;
        $_SESSION['resultDob'] = $resultDob;
        $_SESSION['resultGender'] = $resultGender;
        $_SESSION['resultStreetSurtown'] = $resultStreetSurtown;
        $_SESSION['resultState'] = $resultState;
        $_SESSION['postcodeErr'] = $resultPostcode;
        $_SESSION['returnPhone'] = $returnPhone;
        $_SESSION['returnSkills'] = $returnSkills;
        $_SESSION['returnjobRef'] = $returnjobRef;
        // echo $jobref;
        // $messageErr = "We found: " . "<br>" . $resultName . "<br>" . $resultEmail . "<br>" . $resultDob . "<br>" . $resultGender . "<br>" . $resultStreetSurtown . "<br>" . $resultState . "<br>" . $postcodeErr . "<br>" . $returnPhone. "<br>" .$returnSkills;
        header("Location: apply.php?jobref=$jobref");
    } else {
        $createQueryEOISkill = "
    CREATE TABLE `eoi_skill` (
        `eoi_skill_id` tinyint(11) NOT NULL,
        `EOInumber` tinyint(11) DEFAULT NULL,
        `skill_id` tinyint(11) DEFAULT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
";

        $keysQueryEOISkill = "
    ALTER TABLE `eoi_skill`
    ADD PRIMARY KEY (`eoi_skill_id`),
    ADD KEY `fk_ek_eoi` (`EOInumber`),
    ADD KEY `fk_ek_skill` (`skill_id`)
";

        $autoIncrementQueryEOISkill = "
    ALTER TABLE `eoi_skill`
    MODIFY `eoi_skill_id` tinyint(11) NOT NULL AUTO_INCREMENT
";

        $constraintsQueryEOISkill = "
    ALTER TABLE `eoi_skill`
    ADD CONSTRAINT `fk_ek_eoi` FOREIGN KEY (`EOInumber`) REFERENCES `eoi` (`EOInumber`) ON DELETE CASCADE ON UPDATE CASCADE,
    ADD CONSTRAINT `fk_ek_skill` FOREIGN KEY (`skill_id`) REFERENCES `skill` (`skill_id`) ON DELETE SET NULL ON UPDATE CASCADE
";

        // Queries for `eoi` table
        $createQueryEOI = "
CREATE TABLE `eoi` (
    `EOInumber` tinyint(11) NOT NULL,
    `jobDescId` tinyint(11) DEFAULT NULL,
    `firstName` varchar(40) NOT NULL,
    `middleName` varchar(40) DEFAULT NULL,
    `lastName` varchar(40) NOT NULL,
    `dob` date NOT NULL,
    `email` varchar(60) NOT NULL,
    `phoneNum` varchar(15) NOT NULL,
    `gender` tinyint(1) NOT NULL,
    `streetName` varchar(40) NOT NULL,
    `surburbOrtown` varchar(40) NOT NULL,
    `state` varchar(3) NOT NULL,
    `postcode` varchar(4) NOT NULL,
    `status` TINYINT(1) NOT NULL,
    `others` text DEFAULT NULL,
    `issued_date` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
";

        $keysQueryEOI = "
    ALTER TABLE `eoi`
    ADD PRIMARY KEY (`EOInumber`),
    ADD KEY `fk_eoi_jobdesc` (`jobDescId`)
";

        $autoIncrementQueryEOI = "
    ALTER TABLE `eoi`
    MODIFY `EOInumber` tinyint(11) NOT NULL AUTO_INCREMENT
";

        $constraintsQueryEOI = "
    ALTER TABLE `eoi`
    ADD CONSTRAINT `fk_eoi_jobdesc` FOREIGN KEY (`jobDescId`) REFERENCES `jobDesc` (`jobDescId`) ON DELETE SET NULL ON UPDATE CASCADE
";
        checkAndCreateTable($pdo, 'eoi', $createQueryEOI, $keysQueryEOI, $autoIncrementQueryEOI, $constraintsQueryEOI);

        checkAndCreateTable($pdo, 'eoi_skill', $createQueryEOISkill, $keysQueryEOISkill, $autoIncrementQueryEOISkill, $constraintsQueryEOISkill);

        try {
            // Prepare the SQL statement with placeholders
            $stmt = $pdo->prepare("
                INSERT INTO eoi (firstName, middleName, lastName, dob, email, phoneNum, gender, streetName, jobDescId, surburbOrtown, state, postcode, status, others)
                VALUES (:firstName, :middleName, :lastName, :dob, :email, :phoneNum, :gender, :streetName, :jobDescId, :surburbOrtown, :state, :postcode, 0, :others)
            ");

            // $date_input = strtotime($dob);
            $date_object = DateTime::createFromFormat('d/m/Y', $dob);
            $newformat = $date_object->format('Y-m-d');
            $status = 0;
            // Bind values to the placeholders
            $stmt->bindValue(':firstName', $first_name);
            $stmt->bindValue(':middleName', $middle_name);
            $stmt->bindValue(':lastName', $last_name);
            $stmt->bindValue(':dob', $newformat);
            //retrieve the job reference from the database to get idJob
            $sql = $pdo->prepare("SELECT jobDescId FROM jobDesc WHERE refNum=?");
            $sql->execute([$jobRef]);
            $jobId = $sql->fetchColumn();
            $stmt->bindValue(':jobDescId', $jobId);
            $stmt->bindValue(':email', $email);
            $stmt->bindValue(':streetName', $email);
            $stmt->bindValue(':phoneNum', $phone);
            $stmt->bindValue(':gender', $gen); // Assuming 1 is male, 0 is female
            $stmt->bindValue(':streetName', $streetAddress);
            $stmt->bindValue(':surburbOrtown', $suburbTown);
            $stmt->bindValue(':state', $state);
            $stmt->bindValue(':postcode', $postcode);
            $stmt->bindValue(':others', $otherText);

            // Execute the statement
            $stmt->execute();




            // Get the last inserted ID
            $lastId = $pdo->lastInsertId();

            $sql = "INSERT INTO eoi_skill (EOInumber, skill_id) VALUES (:EOInumber, :skill_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':EOInumber', $lastId, PDO::PARAM_INT);
            // print_r ($skills);
            foreach ($skills as $skill) {
                // echo '<br>'.$skill;
                $stmt->bindValue(':skill_id', $skill, PDO::PARAM_INT);
                $stmt->execute();
            }

            // echo "Data inserted successfully!";
            header("Location: jobs.php");

        } catch (PDOException $e) {
            echo "Error inserting data: " . $e->getMessage();
        }
    }
}

function validateName($first_name, $middle_name, $last_name)
{
    $result = "";
    $Fresult = "";
    $Mresult = "";
    $Lresult = "";
    $count = 0;
    $countNull = 0;

    $max_length = 20;

    if (empty($first_name) || empty($last_name)) {
        if (empty($first_name)) {
            $countNull++;
            $Fresult = "First Name -";
        } else {
            $countNull--;
        }
        if (empty($last_name)) {
            $countNull++;
            $Lresult = "Last Name -";
        } else {
            $countNull--;
        }
        if ($countNull == 2) {
            $result = "Please enter both First Name and Last Name. ";
        } else {
            $result = "$Fresult $Lresult should be entered. ";
        }

        return $result;
    } else if (strlen($first_name) > $max_length || strlen($last_name) > $max_length || strlen($middle_name)) {
        if (strlen($first_name) > $max_length) {
            $Fresult = "First Name -";
            $count++;
        } else {
            $count--;
        }
        if (strlen($middle_name) > $max_length) {
            $Mresult = "Middle Name -";
            $count++;
        } else {
            $count--;
        }
        if (strlen($last_name) > $max_length) {
            $Lresult = "Last Name -";
            $count++;
        } else {
            $count--;
        }
    }

    if ($count > 0) {
        $result = "$Fresult $Mresult $Lresult should be no more than $max_length characters long. ";
    } else {
        $result = array($first_name, $middle_name, $last_name);
    }

    return $result;
}

function validateAge($dob)
{

    $min_age = 15;
    $max_age = 80;
    $today = new DateTime(date("Y-m-d"));
    $result = "";



    if (empty($dob)) {
        $result = "Please enter a Date of Birth. ";
    } else {
        $dob_date = DateTime::createFromFormat('d/m/Y', $dob);
        if ($dob_date === false) {
            $result = "Invalid Date of Birth format. Use dd/mm/yyyy. ";
        } else {
            $interval = $today->diff($dob_date);
            $age = intval($interval->y);

            if ($age < $min_age || $age > $max_age) {
                $result = "Your age is not suitable for our company. ";
            } else {
                $result = array($dob);
            }
        }
    }

    return $result;
}

function validateEmail($email, $pdo)
{
    $notify = "";

    if (empty($email)) {
        $notify = "Email is required ";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $notify = "Invalid email address format ";
    } else {
        // Check if the email exists in the database
        try {
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM eoi WHERE email = :email");
            $stmt->execute(['email' => $email]);
            $emailCount = $stmt->fetchColumn();

            if ($emailCount > 0) {
                $notify = "Email address already exists in the system";
            } else {
                // Valid email address, and not found in the database
                $notify = array($email);
            }
        } catch (PDOException $e) {
            $notify = "Error accessing database: " . $e->getMessage();
        }
    }

    return $notify;
}


function validateGender()
{
    $error = "";
    $done = false;

    // Validate gender (radio button)
    if (!isset($_POST["gen"])) {
        $error .= "Please select your gender.";
    }

    // If no errors, set the "done" flag to true
    if (empty($error)) {
        $done = true;
    }

    return $done ? array($_POST["gen"]) : $error;
}

function validatestreetandSurtown($streetAddress, $suburbTown)
{
    $result = "";
    $count = 0;
    $errorFailtwo = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $max_length = 40;
        $errorFailtwo = "Street Address and Suburb/town should be no more than $max_length characters long.";

        if (empty($streetAddress) && empty($suburbTown)) {
            $result = "Please enter both Street Address and Suburb/town.";
        } elseif (strlen($streetAddress) > $max_length || strlen($suburbTown) > $max_length) {
            if (strlen($streetAddress) > $max_length && strlen($suburbTown) > $max_length) {
                $count++;
            } else if (strlen($streetAddress) > $max_length) {
                $result = "Street Address should be no more than $max_length characters long.";
                $count--;
            } else {
                $result = "Suburb/town should be no more than $max_length characters long.";
                $count--;
            }
        } else {
            $result = array($streetAddress, $suburbTown);
        }
    }

    if ($count > 0) {
        return $errorFailtwo;
    }
    return $result;
}

function validateState()
{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_REQUEST['state']) && $_REQUEST['state'] == '0') {
            return 'Please select a state.';
        } else {
            return array($_REQUEST['state']);
        }
    }

}

function validatePostcode($postcode)
{

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $state = $_REQUEST['state'];
        $valid = "";



        if (!isset($postcode) || trim($postcode) == '') {
            $valid = "Please input postcode";
            return $valid;
        } else {

            // Remove leading zeros from the user input
            $postcode = ltrim($postcode, '0');

            if ($state === "nsw") {
                if (
                    (1000 <= $postcode && $postcode <= 1999) ||
                    (2000 <= $postcode && $postcode <= 2599) ||
                    (2619 <= $postcode && $postcode <= 2899) ||
                    (2921 <= $postcode && $postcode <= 2999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "act") {
                if (
                    (200 <= $postcode && $postcode <= 299) ||
                    (2600 <= $postcode && $postcode <= 2618) ||
                    (2900 <= $postcode && $postcode <= 2920)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "vic") {
                if (
                    (3000 <= $postcode && $postcode <= 3999) ||
                    (8000 <= $postcode && $postcode <= 8999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "qld") {
                if (
                    (4000 <= $postcode && $postcode <= 4999) ||
                    (9000 <= $postcode && $postcode <= 9999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "sa") {
                if (
                    (5000 <= $postcode && $postcode <= 5799) ||
                    (5800 <= $postcode && $postcode <= 5999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "wa") {
                if (
                    (6000 <= $postcode && $postcode <= 6797) ||
                    (6800 <= $postcode && $postcode <= 6999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "tas") {
                if (
                    (7000 <= $postcode && $postcode <= 7799) ||
                    (7800 <= $postcode && $postcode <= 7999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            } elseif ($state === "nt") {
                if (
                    (800 <= $postcode && $postcode <= 899) ||
                    (900 <= $postcode && $postcode <= 999)
                ) {
                    $valid = array($valid);
                    return $valid;
                }
            }

            if (!$valid) {
                $valid = "Invalid postcode for the state";
                return $valid;
            }
        }
    }

    return $valid;
}



function jobRef($jobref)
{
    //use the function displayJobRef to compare $jobref and the jobref in the database
    global $pdo;
    $sql = "SELECT refNum, status FROM jobDesc";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $jobRefdbs = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //using loop to display all the job reference in the database


    // echo $jobRefdb['refNum'];
    if (empty($jobref)) {
        return 'Please select a job reference.';
    } else {
        // Flag to indicate if the case is found
$found = false;

// Loop through each associative array in the list
foreach ($jobRefdbs as $jobRefdb) {
    // Check if the 'refNum' value matches the case to check
    if ($jobRefdb['refNum'] === $jobref) {
        $found = true;
        break;
    }
}

// Display result
if (!$found) {
    return 'There is no job reference at our company.';
} else {
    foreach ($jobRefdbs as $jobRefdb) {
        // return $jobref;
        if (strcmp($jobref, $jobRefdb['refNum']) !== 0) {
            
        } else {
            if ($jobRefdb['status'] == 0) {
                return 'This job reference is not available.';
            } else {
                return array($_REQUEST['ref_num']);
            }
        }
    }
}
        

    }
}



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



function validateSkills($skills)
{
    $msg = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if any skills checkbox is checked
        if (isset($_POST['skills'])) {
            $skills = $_POST['skills'];
            $checkedSkillsText = [];

            foreach ($skills as $skill) {
                if ($skill == "8" && !empty($_POST['other_skill_text'])) {
                    $checkedSkillsText[] = $_POST['other_skill_text'];
                } elseif ($skill != "8") {
                    $checkedSkillsText[] = $skill;
                }
            }

            if (!empty($checkedSkillsText)) {
                $msg = array($checkedSkillsText);
            } else {
                $msg = 'Other skills checkbox is checked, but no input text beside that is inputed';
            }
        } else {
            $msg = 'No skills checkbox is checked';
        }
    }
    return $msg;
}