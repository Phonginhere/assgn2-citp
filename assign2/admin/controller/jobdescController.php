<?php
//begin brief job info feild
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
include_once __DIR__ . '/../../settings.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;

    $id = isset($_POST["id"]) ? $_POST["id"] : "";

    $jobDescName = isset($_POST["jobDescName"]) ? $_POST["jobDescName"] : "";
    $refNum = isset($_POST["refNum"]) ? $_POST["refNum"] : "";
    $posTitle = isset($_POST["posTitle"]) ? $_POST["posTitle"] : "";
    $keyResponse = isset($_POST["keyResponse"]) ? $_POST["keyResponse"] : "";

    $mimmumR = isset($_POST["mimmumR"]) ? $_POST["mimmumR"] : "";

    $maximumR = isset($_POST["maximumR"]) ? $_POST["maximumR"] : "";
    $bonusR = isset($_POST["bonusR"]) ? $_POST["bonusR"] : "";
    
    $noteSala = isset($_POST["noteSala"]) ? $_POST["noteSala"] : "";

    $nameReportedto = isset($_REQUEST["nameReportedto"]) ? $_REQUEST["nameReportedto"] : "";
    $noteReported_person = isset($_POST["noteReported_person"]) ? $_POST["noteReported_person"] : "";

    $skills = isset($_POST["skills"]) ? $_POST["skills"] : "";
    $jobDesctext = test_input(isset($_POST["jobDesctext"])) ? test_input($_POST["jobDesctext"]) : "";


    $currentFile = isset($_POST["currentFile"]) ? $_POST["currentFile"] : "";

    $resultjob_descName = namejobInfo($jobDescName);
    $resultrefNum = refNum($refNum);
    $resultposTitle = posTitle($posTitle);
    $resultkeyResponse = keyResponse($keyResponse);


    $resultminiMum = minimum(7000, $maximumR);
    $resultmaxiMum = maximum($maximumR);
    $result_noteSalary = note_salary($noteSala);

    $result_nameReportedto = namePerson_report($nameReportedto);
    $resultSkills = validateskillsAdmin($skills);
    $resultjobDesctext = brief_job_info($jobDesctext);


    if (is_array($resultjob_descName)) {
        $resultjob_descName = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultrefNum)) {
        $resultrefNum = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultposTitle)) {
        $resultposTitle = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultkeyResponse)) {
        $resultkeyResponse = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultminiMum)) {
        $resultminiMum = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultmaxiMum)) {
        $resultmaxiMum = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($result_noteSalary)) {
        $result_noteSalary = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($result_nameReportedto)) {
        $result_nameReportedto = null;
    } else {
        $count++;
        echo "ha";
    }

    if (is_array($resultSkills)) {
        $resultSkills = null;
    } else {
        $count++;
        echo $resultSkills;
    }
    if (is_array($resultjobDesctext)) {
        $resultjobDesctext = null;
    } else {
        $count++;
    }
    if ($count > 0) {
        // Redirect back to the form with the result
        $_SESSION['resultjob_descName'] = $resultjob_descName;
        $_SESSION['resultrefNum'] = $resultrefNum;
        $_SESSION['resultposTitle'] = $resultposTitle;

        $_SESSION['resultkeyResponse'] = $resultkeyResponse;
        $_SESSION['resultminiMum'] = $resultminiMum;
        $_SESSION['resultmaxiMum'] = $resultmaxiMum;
        $_SESSION['result_noteSalary'] = $result_noteSalary;

        $_SESSION['result_nameReportedto'] = $result_nameReportedto;
        $_SESSION['resultSkills'] = $resultSkills;
        $_SESSION['resultjobDesctext'] = $resultjobDesctext;

        // echo $nameReportedto;

        // $messageErr = "We found: " . "<br>" . $resultName . "<br>" . $resultEmail . "<br>" . $resultDob . "<br>" . $resultGender . "<br>" . $resultStreetSurtown . "<br>" . $resultState . "<br>" . $postcodeErr . "<br>" . $returnPhone. "<br>" .$returnSkills;
        header("Location: ../" . $currentFile);
    } else {
        if (str_contains($currentFile, "Adding")) {
            $sql = "INSERT INTO jobDesc (name, refNum, posTitle, keyResponse, minSala, maxSala, bonus, noteBonus, reportTo, note, briefJobDescription, status, staffId) 
            VALUES (:jobDescName, :refNum, :posTitle, :keyResponse, :minSala, :maxiMum, :bonus, :noteBonus, :reportTo, :noteReported_person, :jobDesctext, :status, :staffId)";
            $stmt = $pdo->prepare($sql);
            $status  = 0;
            $stmt->bindParam(':jobDescName', $jobDescName);
            $stmt->bindParam(':refNum', $refNum);
            $stmt->bindParam(':posTitle', $posTitle);
            $stmt->bindParam(':keyResponse', $keyResponse);
            $stmt->bindParam(':minSala', $mimmumR);
            $stmt->bindParam(':maxiMum', $maximumR);
            $stmt->bindParam(':bonus', $bonusR);
            $stmt->bindParam(':noteBonus', $noteSala);
            $stmt->bindParam(':reportTo', $nameReportedto);
            $stmt->bindParam(':noteReported_person', $noteReported_person);
            $stmt->bindParam(':jobDesctext', $jobDesctext);
            $stmt->bindParam(':status', $status);
            $stmt->bindParam(':staffId', $_SESSION["staffId"]);

            $stmt->execute();

            $last_id = $pdo->lastInsertId();
            $sql = "INSERT INTO jobDesc_skill (jobDescId, skill_id) VALUES (:jobDescId, :skill_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jobDescId', $last_id);
            foreach ($skills as $skill) {
                $stmt->bindParam(':skill_id', $skill);
                $stmt->execute();
            }
            

            header("Location: ../manage_list_job.php");

        } else {
            $sql = "UPDATE jobDesc SET name = :jobDescName, refNum = :refNum, posTitle = :posTitle, 
            keyResponse = :keyResponse, minSala = :miniMum, maxSala = :maxiMum, bonus = :bonus, 
            noteBonus = :noteSalary, reportTo = :nameReportedto, note = :noteReported_person, briefJobDescription = :jobDesctext 
            WHERE jobDescId = :jobDescId";
            $stmt = $pdo->prepare($sql);

            $stmt->bindParam(':jobDescName', $jobDescName);
            $stmt->bindParam(':refNum', $refNum);
            $stmt->bindParam(':posTitle', $posTitle);
            $stmt->bindParam(':keyResponse', $keyResponse);
            $stmt->bindParam(':miniMum', $mimmumR);
            $stmt->bindParam(':maxiMum', $maximumR);
            $stmt->bindParam(':bonus', $bonusR);
            $stmt->bindParam(':noteSalary', $noteSala);
            $stmt->bindParam(':nameReportedto', $nameReportedto);
            $stmt->bindParam(':noteReported_person', $noteReported_person);
            $stmt->bindParam(':jobDesctext', $jobDesctext);
            $stmt->bindParam(':jobDescId', $id);
            
            $stmt->execute();
            

            $sql = "DELETE FROM jobDesc_skill WHERE jobDescId = :jobDescId";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jobDescId', $id);
            $stmt->execute();
            
            $sql = "INSERT INTO jobDesc_skill (jobDescId, skill_id) VALUES (:jobDescId, :skill_id)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':jobDescId', $id);
            foreach ($skills as $skill) {
                $stmt->bindParam(':skill_id', $skill);
                $stmt->execute();
            }
            header("Location: ../" . $currentFile);
        }
    }

    // echo $currentFile . "hahahahah";

}
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
function namejobInfo($job_name)
{
    $result = "";

    $max_length = 40;
    $min_length = 2;

    if (empty($job_name)) {
        $result = "Job Name should be entered";
        return $result;
    } elseif (strlen($job_name) > $max_length && strlen($job_name) < $min_length) {
        $result = "Job Name should be no more than $max_length and less than $min_length characters long. ";
    } else {
        $result = array($job_name);
    }

    return $result;
}

function refNum($refNum)
{
    function is_valid_refNum($refNum)
    {
        return preg_match('/^[a-zA-Z]{2}\d{3}$/', $refNum);
    }

    function is_alphanumeric($refNum)
    {
        return ctype_alnum($refNum);
    }

    function is_exact_length($refNum, $length)
    {
        return strlen($refNum) === $length;
    }

    $result = "";
    $exact_length = 5;

    if (empty($refNum)) {
        $result = "Please enter a value in the input field.";
    } elseif ($refNum === str_repeat($refNum[0], strlen($refNum))) {
        $result = "No, It's not allowed to have all the same characters.";
    } elseif (is_valid_refNum($refNum)) {
        $result = array($refNum);
    } else {
        $is_alphanumeric = is_alphanumeric($refNum);
        $is_exact_length = is_exact_length($refNum, $exact_length);

        if (!$is_alphanumeric) {
            $result = "No, It's not an alphanumeric string/text";
        } elseif (!$is_exact_length) {
            $result = "No, It's not exactly 5 characters";
        } else {
            $result = "Invalid format. It should be 2 letters followed by 3 digits.";
        }
    }
    return $result;
}

function posTitle($pos_title)
{
    $result = "";

    $max_length = 40;
    $min_length = 2;

    if (empty($pos_title)) {
        $result = "Position title should be entered";
        return $result;
    } elseif (strlen($pos_title) > $max_length && strlen($pos_title) < $min_length) {
        $result = "Position title should be no more than $max_length and less than $min_length characters long. ";
    } else {
        $result = array($pos_title);
    }

    return $result;
}

function keyResponse($keyResponse)
{
    $result = "";

    $max_length = 200;
    $min_length = 2;

    if (empty($keyResponse)) {
        $result = "Key responsibilies should be entered";
        return $result;
    } elseif (strlen($keyResponse) > $max_length && strlen($keyResponse) < $min_length) {
        $result = "Key responsibilies should be no more than $max_length and less than $min_length characters long. ";
    } else {
        $result = array($keyResponse);
    }

    return $result;
}


//ending brief job info feild

//begin salary range
// case 1: minimum = -2, maximum = 0 -> Minimum must more than 0$
// case 2: mimimum = 1, maxmimum = 0 -> Mimimum must less than Maximum
function minimum($minimumSala, $maximumSala)
{
    $result = "";
    if (empty($minimumSala)) {
        $result = "Minimum salary must be entered";
    } else if (!is_numeric($minimumSala)) {
        $result = "Minimum salary must be numeric";
    } else if ($minimumSala < 0) {
        $result = "Minimum must more than 0$";
    } else if ($minimumSala > $maximumSala) {
        $result = "Mimimum salary must lower than Maximum salary";
    } else {
        $result = array($minimumSala);
    }
    return $result;
}

function maximum($maximumSala)
{
    $result = "";
    if (empty($maximumSala)) {
        $result = "Minimum salary must be entered";
    } else if (!is_numeric($maximumSala)) {
        $result = "Maximum salary must be numeric";
    } else {
        return array($maximumSala);
    }
    return $result;
}

function note_salary($noteSalary)
{
    $result = "";

    $max_length = 600;

    if (strlen($noteSalary) > $max_length) {
        $result = "Note Salary should be no more than $max_length characters long. ";
    } else {
        $result = array($noteSalary);
    }

    return $result;
}

// end salary range

//begining the person to report to
function namePerson_report($nameReportedto)
{
    $msg = "";
    if (isset($nameReportedto) && $nameReportedto == 'n') {
        $msg = 'Please select a leader.';
    } else {
        $msg = array($nameReportedto);
    }
    return $msg;
}

//ending the person to report to

//beginning skills required


function validateskillsAdmin($skills)
{
    $msg = "";

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Check if any skills checkbox is checked
        if (isset($_POST['skills'])) {
            $skills = $_POST['skills'];
            return array($skills);
            // $checkedSkillsText = [];

            // foreach ($skills as $skill) {
            //     if ($skill == "8" && !empty($_POST['other_skill_text'])) {
            //         $checkedSkillsText[] = $_POST['other_skill_text'];
            //     } elseif ($skill != "8") {
            //         $checkedSkillsText[] = $skill;
            //     }
            // }

            // if (!empty($checkedSkillsText)) {
            //     $msg = array($checkedSkillsText);
            // } else {
            //     $msg = 'Other skills checkbox is checked, but no input text beside that is inputed';
            // }
        } else {
            $msg = 'No skills checkbox is checked';
        }
    }
    return $msg;
}
//end skills required

//begin brief job info
function brief_job_info($job_name)
{
    $result = "";

    $max_length = 500;
    $min_length = 2;

    if (empty($job_name)) {
        $result = "Brief Job info should be entered";
        return $result;
    } elseif (strlen($job_name) > $max_length && strlen($job_name) < $min_length) {
        $result = "Brief Job info should be no more than $max_length and less than $min_length characters long. ";
    } else {
        $result = array($job_name);
    }

    return $result;
}
//end brief job info
