<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Including authentication check
include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2, 3, 4);
include './controller/authroleCheck.php';


include_once __DIR__ . '/../settings.php';
function getEOI_info()
{

    global $pdo;
    try {
        $stmt = $pdo->query("SELECT DISTINCT jd.name as jName, e.firstName as fname, e.middleName as mname, 
        e.lastName as lname, e.dob as dob, e.email as email, e.phoneNum as pNum, 
        e.gender as gend, e.streetName as sName, e.surburbOrtown as surTown, e.state as state, e.postcode as pcode,
         e.status as status, e.others as othertext, e.issued_date as isDate
        FROM eoi as e 
        LEFT JOIN eoi_skill as ek ON e.EOInumber = ek.EOInumber 
        LEFT JOIN jobDesc as jd ON jd.jobDescId = e.jobDescId 
        WHERE e.EOInumber = " . $_GET['id']);
        $resultJobdesc = $stmt->fetch(PDO::FETCH_ASSOC);
        return $resultJobdesc;
    } catch (PDOException $e) {
        echo 'Error fetching data: ' . $e->getMessage();
        return [];
    }
}
$get_eoi_info = getEOI_info();

// Get all skills
$sql = "SELECT * FROM `skill`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allSkills = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtAssociatedSkills = $pdo->prepare("SELECT skill_id FROM eoi_skill WHERE EOInumber = :EOInumber");
$stmtAssociatedSkills->bindParam(':EOInumber', $_GET['id'], PDO::PARAM_INT);
$stmtAssociatedSkills->execute();

$associatedSkillIds = $stmtAssociatedSkills->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Edit Staff</title>
    <?php
    require('./fragment/libraryInput.php');
    ?>
</head>

<body>
    <?php
    $name_file = basename($_SERVER['PHP_SELF']);
    require('./fragment/sidebarAdmin.php');
    ?>

    <div class="main-content">

        <?php
        require('./fragment/topbarAdmin.php');
        ?>


        <main>

            <?php
            $filename_without_ext = basename($name_file, '.php');
            $action_page = "View";
            require('./fragment/pageheaderAdmin.php');
            ?>

            <div class="page-content">

                <form action="./controller/jobdescController.php" method="post">
                    <fieldset>

                        <legend>
                            Personal info
                        </legend>

                        <div class="box">
                            <label for="fname">
                                First Name:
                            </label>
                            <input disabled type="text" id="fname" name="fname" value="<?= $get_eoi_info['fname'] ?>">
                        </div>


                        <div class="box">
                            <label for="mname">
                                Middle Name:
                            </label>
                            <input disabled type="text" id="mname" value="<?= $get_eoi_info['mname'] ?>">
                        </div>

                        <div class="box">
                            <label for="lname">
                                Last Name:
                            </label>
                            <input disabled type="text" id="lname" value="<?= $get_eoi_info['lname'] ?>">
                        </div>

                        <div class="box">
                            <label for="gend">
                                Gender:
                            </label>
                            <input disabled type="text" id="gend" value="<?php
                            switch ($get_eoi_info['gend']) {
                                case 1:
                                    //echo processing
                                    echo 'Male';
                                    break;
                                case 2:
                                    echo 'Female';
                                    break;
                                default:
                                    echo "Unknown Role";
                            }?>">
                        </div>


                        <div class="box">
                            <label for="dob">
                                D.O.B (Date of birth):
                            </label>
                            <input disabled type="text" id="dob" value="<?= $get_eoi_info['dob'] ?>">
                        </div>


                        <div class="box">
                            <label for="email">
                                Email:
                            </label>
                            <input disabled type="text" id="email" value="<?= $get_eoi_info['email'] ?>">
                        </div>


                        <div class="box">
                            <label for="pNum">
                                Phone Num:
                            </label>
                            <input disabled type="text" id="pNum" value="<?= $get_eoi_info['pNum'] ?>">
                        </div>


                    </fieldset>

                    <fieldset>

                        <legend>
                            Address info
                        </legend>


                        <div class="box">

                            <label for="strAdd">
                                Street Name:
                            </label>
                            <input disabled type="text" id="strAdd" value="<?= $get_eoi_info['sName'] ?>">
                        </div>

                        <div class="box">

                            <label for="surTown">
                                Surburb/Town name:
                            </label>
                            <input disabled type="text" name="surTown" id="surTown"
                                value="<?= $get_eoi_info['surTown'] ?>">
                        </div>


                        <div class="box">

                            <label for="surTown">
                                State:
                            </label>
                            <input disabled type="text" name="state" id="state" value="<?= $get_eoi_info['state'] ?>">
                        </div>


                        <div class="box">

                            <label for="noteSala">
                                Postcode
                            </label>
                            <input disabled type="text" name="pcode" id="pcode" value="<?= $get_eoi_info['pcode'] ?>">
                        </div>




                    </fieldset>

                    <fieldset>

                        <legend>
                            Job info
                        </legend>

                        <div class="box">

                            <label for="jName">
                                Job Name:
                            </label>
                            <input disabled type="text" id="jName" value="<?= $get_eoi_info['jName'] ?>">
                        </div>
                        <div class="box">

                            <label for="stus">
                                Status:
                            </label>
                            <input disabled type="text" id="stus" value="<?php
                            switch ($get_eoi_info['status']) {
                                case 0:
                                    //echo applied
                                    echo 'Applied';
                                    break;
                                case 1:
                                    //echo processing
                                    echo ' Processing';
                                    break;
                                case 2:
                                    echo 'Interview';
                                    break;
                                case 3:
                                    //echo accepted
                                    echo 'Accepted';
                                    break;
                                case 4:
                                    echo 'Discontinued';
                                    break;
                                default:
                                    echo "Unknown Role";
                            } ?>">
                        </div>

                        <div class="box">

                            <label for="stus">
                                Date issue:
                            </label>
                            <input disabled type="text" id="stus" value="<?= $get_eoi_info['isDate'] ?>">
                        </div>


                    </fieldset>


                    <fieldset>

                        <legend>
                            Skills
                        </legend>

                        <div class="browse">
                            <input type="search" id="manageInputSk" placeholder="Search" class="record-search"
                                onkeyup="managelSkillsAdminFunction()">
                            <!-- <input type="submit" id="" name="" value="Find"></input> -->
                        </div>

                        <div>
                            <table id="myTableskills" width="100%">
                                <thead>
                                    <tr>
                                        <th>SKILLS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allSkills as $skill): ?>
                                        <tr>
                                            <td>
                                                <?= in_array($skill['skill_id'], $associatedSkillIds) ? htmlspecialchars($skill['skillName']) : '' ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>


                        <!-- Display validation message for Skill -->
                        <?php if (!empty($resultSkills) && is_string($resultSkills)): ?>
                            <div class="alert error">
                                <input type="checkbox" id="alert1" />
                                <label class="close" title="close" for="alert1">
                                    <i class="las la-times"></i>
                                </label>
                                <p class="inner">
                                    <strong>Warning!</strong>
                                    <?php echo $resultSkills;
                                    unset($_SESSION['resultSkills']);
                                    ?>
                                </p>
                            </div>
                        <?php endif; ?>
                    </fieldset>

                    <fieldset>

                        <legend>
                            Brief job info
                        </legend>





                        <div class="box">
                            <label for="jobDesctext">
                                Enter_Job_Description_Below!
                            </label>
                            <textarea disabled type="text" id="jobDesctext" name="jobDesctext" rows="8" cols="100">
<?php

echo htmlspecialchars($get_eoi_info['othertext']);
?>
</textarea>
                        </div>

                    </fieldset>

                    <div id="inputsubContainer">
                        <a id="btnBack" href="./manage.php">Back</a>
                    </div>


                </form>


            </div>

        </main>

    </div>
</body>

</html>