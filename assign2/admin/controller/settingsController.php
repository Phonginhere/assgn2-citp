<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once __DIR__ . '/../../settings.php';

function getSettings()
{

    global $pdo;

    try {
        $stmt = $pdo->query("SELECT * FROM `settings` WHERE `settingsId` = 1");
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo 'Error fetching data: ' . $e->getMessage();
        return [];
    }
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $count = 0;

    $name_site = isset($_POST["nameWeb"]) ? $_POST["nameWeb"] : "";
    $name_city = isset($_POST["cityName"]) ? $_POST["cityName"] : "";
    $url_map_link = isset($_POST["urlDirect"]) ? $_POST["urlDirect"] : "";

    $street = isset($_POST["street"]) ? $_POST["street"] : "";
    $sub_t = isset($_POST["sub_t"]) ? $_POST["sub_t"] : "";
    $state = isset($_POST["state"]) ? $_POST["state"] : "";
    $postcode = isset($_POST["postcode"]) ? $_POST["postcode"] : "";

    $general_email = isset($_POST["generalEmail"]) ? $_POST["generalEmail"] : "";
    $first_email = isset($_POST["firstEmail"]) ? $_POST["firstEmail"] : "";
    $second_email = isset($_POST["secondEmail"]) ? $_POST["secondEmail"] : "";
    $third_email = isset($_POST["thirdEmail"]) ? $_POST["thirdEmail"] : "";


    $faceWeb = isset($_POST["faceWeb"]) ? $_POST["faceWeb"] : "";
    $twittWeb = isset($_POST["twittWeb"]) ? $_POST["twittWeb"] : "";
    $linkeWeb = isset($_POST["linkeWeb"]) ? $_POST["linkeWeb"] : "";
    $YouWeb = isset($_POST["YouWeb"]) ? $_POST["YouWeb"] : "";
    $instagramWeb = isset($_POST["instagramWeb"]) ? $_POST["instagramWeb"] : "";

    $resultNamesite = nameSite($name_site);
    $resultUrlmaplink = linkUrl_map($url_map_link);
    $resultcityName = cityName($name_city);

    $resultStreet = validateStreet($street);
    $resultSurtown = validateSurtown($sub_t);
    $resultState = validateState();
    $resultPostcode = validatePostcode($postcode);

    $resultgEmail = email_validate($general_email);
    $resultfEmail = fEmail_validate($first_email);
    $resultsEmail = sEmail_validate($second_email);
    $result_tEmail = tEmail_validate($third_email);

    $resultfb_smedia = fb_socialMedia_validation($faceWeb);
    $result_twit_smedia = twit_socialMedia_validation($twittWeb);
    $result_linke_smedia = linke_socialMedia_validation($linkeWeb);
    $result_ytbs_smedia = youtube_socialMedia_validation($YouWeb);
    $result_ins_smedia = ins_socialMedia_validation($instagramWeb);

    // echo $YouWeb;

    if (is_array($resultNamesite)) {
        $resultNamesite = null;
    } else {
        $count++;
    }

    if (is_array($resultUrlmaplink)) {
        $resultUrlmaplink = null;
    } else {
        $count++;
    }

    if (is_array($resultcityName)) {
        $resultcityName = null;
    } else {
        $count++;
    }

    if (is_array($resultStreet)) {
        $resultStreet = null;
    } else if ($resultStreet) {
        $count++;
    }

    if (is_array($resultSurtown)) {
        $resultSurtown = null;
    } else if ($resultSurtown) {
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

    if (is_array($resultgEmail)) {
        $resultgEmail = null;
    } else {
        $count++;
    }

    if (is_array($resultfEmail)) {
        $resultfEmail = null;
    } else {
        $count++;
    }

    if (is_array($resultsEmail)) {
        $resultsEmail = null;
    } else {
        $count++;
    }

    if (is_array($result_tEmail)) {
        $result_tEmail = null;
    } else {
        $count++;
        // echo "toi ko";
    }

    if (is_array($resultfb_smedia)) {
        $resultfb_smedia = null;
    } else {
        $count++;
        // $postcodeErr = "wrong postcode or invalid postcode suitable for the state";
    }

    if (is_array($result_twit_smedia)) {
        $result_twit_smedia = null;
    } else {
        $count++;
    }

    if (is_array($result_ytbs_smedia)) {
        $returnSkills = null;
    } else {
        $count++;
    }
    if (is_array($result_linke_smedia)) {
        $result_linke_smedia = null;
    } else {
        $count++;
    }

    if (is_array($result_ins_smedia)) {
        $result_ins_smedia = null;
    } else {
        $count++;
    }


    if ($count > 0) {
        // Redirect back to the form with the result
        $_SESSION['resultSitename'] = $resultNamesite;
        $_SESSION['resulturlDirection'] = $resultUrlmaplink;
        $_SESSION['resultcityName'] = $resultcityName;


        $_SESSION['resultStreet'] = $resultStreet;
        $_SESSION['resultSurtown'] = $resultSurtown;
        $_SESSION['resultState'] = $resultState;
        $_SESSION['resultPostcode'] = $resultPostcode;

        $_SESSION['resultgeneralEmail'] = $resultgEmail;
        $_SESSION['resultfirstEmail'] = $resultfEmail;
        $_SESSION['resultsecondEmail'] = $resultsEmail;
        $_SESSION['resultthirdEmail'] = $result_tEmail;

        $_SESSION['resultfbSmedia'] = $resultfb_smedia;
        $_SESSION['result_twitSmedia'] = $result_twit_smedia;
        $_SESSION['result_youtSmedia'] = $result_ytbs_smedia;
        $_SESSION['result_linkeSmedia'] = $result_linke_smedia;
        $_SESSION['result_insSmedia'] = $result_ins_smedia;
        // echo $resultNamesite;
        // echo $resultUrlmaplink;
        // echo $resultcityName;
        // echo $resultStreet;
        // echo $resultSurtown;

        // echo $resultPostcode;
        echo $resultgEmail;
        echo $resultfEmail;
        echo $resultsEmail;
        echo $result_tEmail;
        // echo $resultfb_smedia;
        // echo $result_twit_smedia;
        // echo $result_ytbs_smedia;
        // echo $result_linke_smedia;
        // echo $result_ins_smedia;
        // echo $resultStreet;

        // $messageErr = "We found: " . "<br>" . $resultName . "<br>" . $resultEmail . "<br>" . $resultDob . "<br>" . $resultGender . "<br>" . $resultStreetSurtown . "<br>" . $resultState . "<br>" . $postcodeErr . "<br>" . $returnPhone. "<br>" .$returnSkills;
        header("Location: ../settingsAdmin.php");
    } else {
        try {
            $updatedPostcode = str_pad($postcode, 4, '0', STR_PAD_LEFT);
            // Assuming you have a PDO connection object $conn
            $sql = "UPDATE settings SET 
            name = :name,
            cityName = :cityName,
                    urlDirection = :urlDirection, 
                    streetAddress = :streetAddress,
                    subOrtown = :subOrtown,
                    state = :state,
                    postcode = :postcode,
                    generalEmail = :generalEmail,
                    firstEmail = :firstEmail,
                    secondEmail = :secondEmail,
                    thirdEmail = :thirdEmail,
                    fbUsername = :fbUsername,
                    twUsername = :twUsername,
                    lkUsername = :lkUsername,
                    ytUsername = :ytUsername,
                    insUsername = :insUsername
                    WHERE settingsId = :id";

            $stmt = $pdo->prepare($sql);

            // Bind parameters
            $stmt->bindParam(':name', $name_site);
            $stmt->bindParam(':cityName', $name_city);
            $stmt->bindParam(':urlDirection', $url_map_link);
            $stmt->bindParam(':streetAddress', $street);
            $stmt->bindParam(':subOrtown', $sub_t);

            $stmt->bindParam(':state', $state);
            $stmt->bindParam(':postcode', $updatedPostcode);
            $stmt->bindParam(':generalEmail', $general_email);
            $stmt->bindParam(':firstEmail', $first_email);
            $stmt->bindParam(':secondEmail', $second_email);
            $stmt->bindParam(':thirdEmail', $third_email);
            $stmt->bindParam(':fbUsername', $faceWeb);
            $stmt->bindParam(':twUsername', $twittWeb);
            $stmt->bindParam(':lkUsername', $linkeWeb);
            $stmt->bindParam(':ytUsername', $YouWeb);
            $stmt->bindParam(':insUsername', $instagramWeb);

            echo "co ko " . $third_email . " kco ko";

            $id = 1;

            // ... similarly bind other parameters

            // Assuming you know the ID of the record to update
            $stmt->bindParam(':id', $id);

            $stmt->execute();

            // Maybe redirect or output a success message
            header("Location: ../settingsAdmin.php?status=updated");

        } catch (PDOException $e) {
            echo "Errore: " . $pdo->errorInfo();
            echo "Error: " . $e->getMessage();
        }
    }
}

function nameSite($name_site)
{
    $result = "";


    $max_length = 60;

    if (empty($name_site)) {
        $result = "Please enter Site Name.";
    } elseif (strlen($name_site) > $max_length) {

        $result = "Site Name should be no more than $max_length characters long.";
    } else {
        $result = array($name_site);
    }
    return $result;
}
function linkUrl_map($url_map_link)
{
    function validate_urlmapLink($url_map_link)
    {
        // Remove spaces from the url map
        $url_map_link = str_replace(' ', '', $url_map_link);

        // Check if the url map consists of 8 to 12 digits
        return preg_match('#^https:\/\/.*#', $url_map_link);
    }
    $result = "";

    if (empty($url_map_link)) {
        $result = "url map is required";
    } elseif (!validate_urlmapLink($url_map_link)) {
        $result = "Invalid url map format";
    } else {
        // Valid url map
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}

function cityName($name_city)
{
    $result = "";

    $max_length = 60;

    if (empty($name_city)) {
        $result = "Please enter City Name.";
    } elseif (strlen($name_city) > $max_length) {
        if (strlen($name_city) > $max_length) {
            $result = "City Name should be no more than $max_length characters long.";
        }
    } else {
        $result = array($name_city);
    }
    return $result;
}

function validateStreet($streetAddress)
{
    $result = "";

    $max_length = 40;

    if (empty($streetAddress)) {
        $result = "Please enter Street Address.";
    } elseif (strlen($streetAddress) > $max_length) {
        $result = "Street Address should be no more than $max_length characters long.";
    } else {
        $result = array($streetAddress);
    }
    return $result;
}

function validateSurtown($suburbTown)
{
    $result = "";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $max_length = 40;

        if (empty($suburbTown)) {
            $result = "Please enter Suburb/town.";
        } elseif (strlen($suburbTown) > $max_length) {
            $result = "Suburb/town should be no more than $max_length characters long.";
        } else {
            $result = array($suburbTown);
        }
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

function email_validate($general_email)
{
    $msg = "";

    if (empty($general_email)) {
        $msg = "Email is required";
    } elseif (!filter_var($general_email, FILTER_VALIDATE_EMAIL)) {
        $msg = "Invalid email address format";
    } else {
        // Valid email address
        $msg = array($general_email);
    }

    return $msg;
}

function fEmail_validate($first_email)
{
    $msg = "";
    //check if first_email is empty
    if (empty($first_email)) {
        $msg = array($first_email);
    } else if (!filter_var($first_email, FILTER_VALIDATE_EMAIL)) {
        if (!empty($first_email)) {
            $msg = "Invalid email address format";
        }
    } else {
        // Valid email address
        $msg = array($first_email);
    }

    return $msg;
}

function sEmail_validate($second_email)
{
    $msg = "";
    //check if second email is empty
    if (empty($second_email)) {
        $msg = array($second_email);
    } else
        if (!filter_var($second_email, FILTER_VALIDATE_EMAIL)) {
            if (!empty($second_email)) {
                $msg = "Invalid email address format";
            }
        } else {
            // Valid email address
            $msg = array($second_email);
        }
    return $msg;
}

function tEmail_validate($third_email)
{
    $msg = "";
    //check if third email is empty
    if (empty($third_email)) {
        $msg = array($third_email);
    } else
        if (!filter_var($third_email, FILTER_VALIDATE_EMAIL)) {
            if (!empty($third_email)) {
                $msg = "Invalid email address format";
            }
        } else {
            // Valid email address
            $msg = array($third_email);
        }
    return $msg;
}

function fb_socialMedia_validation($username_fb)
{
    function validate_fbUsername($username_fb)
    {
        // Remove spaces from the url map
        $username_fb = str_replace(' ', '', $username_fb);

        // Check if the url map consists of 8 to 12 digits
        return preg_match('#^(?:(?:https?://)?(?:www\.)?facebook\.com/)?(?:@)?([\w.]{1,})(?:/\S*)?$#', $username_fb);
    }
    $result = "";

    //check if username facebook blank
    if (empty($username_fb)) {
        $result = array($username_fb);
    } else
    if (!validate_fbUsername($username_fb)) {
        if (!empty($username_fb)) {
            $result = "Invalid username Facebook format";
        }
    } else {
        // Valid url map
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}

function twit_socialMedia_validation($username_tw)
{
    function validate_twUsername($username_tw)
    {
        // Remove spaces from the url map
        $username_tw = str_replace(' ', '', $username_tw);

        // Check if the url map consists of 8 to 12 digits
        return preg_match('#^(?:(?:https?://)?(?:www\.)?twitter\.com/)?(?:@)?([\w.]{1,})(?:/\S*)?$#', $username_tw);
    }
    $result = "";
    if (empty($username_tw)) {
        $result = array($username_tw);
    } else
    if (!validate_twUsername($username_tw)) {
        if (!empty($username_tw)) {
            $result = "Invalid username Twitter format";
        }
    } else {
        // Valid url map
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}

function youtube_socialMedia_validation($username_yt)
{
    function validate_ytUsername($username_yt)
    {
        // Remove spaces from the url map
        $username_yt = str_replace(' ', '', $username_yt);

        // Check if the url map consists of 8 to 12 digits
        return preg_match('#^(?:(?:https?://)?(?:www\.)?youtube\.com/)?(?:@)?([\w.]{1,})(?:/\S*)?$#', $username_yt);
    }
    $result = "";

    if (empty($username_yt)) {
        $result = array($username_yt);
    } else
    if (!validate_ytUsername($username_yt)) {
        if (!empty($username_yt)) {
            $result = "Invalid username Youtube format";
        }
    } else {
        // Valid Youtube
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}

function linke_socialMedia_validation($username_lk)
{
    function validate_lkUsername($username_lk)
    {
        // Remove spaces from the Linkedin
        $username_lk = str_replace(' ', '', $username_lk);

        // Check if the Linkedin consists of 8 to 12 digits
        return preg_match('#^(?:(?:https?://)?(?:www\.)?linkedin\.com/)?(?:@)?([\w.]{1,})(?:/\S*)?$#', $username_lk);
    }
    $result = "";

    if (empty($username_lk)) {
        $result = array($username_lk);
    } else
    if (!validate_lkUsername($username_lk)) {
        if (!empty($username_lk)) {
            $result = "Invalid username Linkedin format";
        }
    } else {
        // Valid Linkedin
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}

function ins_socialMedia_validation($username_ins)
{
    function validate_insUsername($username_ins)
    {
        // Remove spaces from the Instagram
        $username_ins = str_replace(' ', '', $username_ins);

        // Check if the Instagram consists of 8 to 12 digits
        return preg_match('#^(?:(?:https?://)?(?:www\.)?instagram\.com/)?(?:@)?([\w.]{1,})(?:/\S*)?$#', $username_ins);
    }
    $result = "";

    if (empty($username_ins)) {
        $result = array($username_ins);
    } else
    if (!validate_insUsername($username_ins)) {
        if (!empty($username_ins)) {
            $result = "Invalid username Instagram format";
        }
    } else {
        // Valid Instagram
        return array($result);
        // You can perform further actions here.
    }
    return $result;
}
?>