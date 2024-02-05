<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
// Including authentication check
include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2, 3);
include './controller/authroleCheck.php';


// Fetch users where staffRoles = 4 from the jobDesc table
include_once $_SERVER['DOCUMENT_ROOT'] . '/assign2/settings.php';

function getInfoJobDesc()
{
  if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'){
    global $pdo;

    try {
      $stmtJobDesc = $pdo->query("SELECT * FROM `jobDesc` WHERE `jobDescId` = " . $_GET['id']);
      $resultJobDesc = $stmtJobDesc->fetch(PDO::FETCH_ASSOC);
      return $resultJobDesc;
    } catch (PDOException $e) {
      echo 'Error fetching data: ' . $e->getMessage();
      return [];
    }
  }
}
$getInfoJobDesc = getInfoJobDesc();


$sql = "SELECT `staffId`, `staffFname`, `staffLname`FROM `staff` WHERE `staffRoles` = 4";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

try {
  // Prepare the SQL statement.

  global $pdo;

  $stmtAssociatedSkills = $pdo->prepare("SELECT skill_id FROM jobDesc_skill WHERE jobDescId = :jobDescId");
$stmtAssociatedSkills->bindParam(':jobDescId', $_GET['id'], PDO::PARAM_INT);
$stmtAssociatedSkills->execute();

$associatedSkillIds = $stmtAssociatedSkills->fetchAll(PDO::FETCH_COLUMN);

$stmtAllSkills = $pdo->prepare("SELECT * FROM skill");
$stmtAllSkills->execute();

$allSkills = $stmtAllSkills->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  echo "Error: " . $e->getMessage();
}

session_start();
$resultjob_descName = isset($_SESSION['resultjob_descName']) ? $_SESSION['resultjob_descName'] : "";
$resultrefNum = isset($_SESSION['resultrefNum']) ? $_SESSION['resultrefNum'] : "";
$resultposTitle = isset($_SESSION['resultposTitle']) ? $_SESSION['resultposTitle'] : "";
$resultkeyResponse = isset($_SESSION['resultkeyResponse']) ? $_SESSION['resultkeyResponse'] : "";
$resultminiMum = isset($_SESSION['resultminiMum']) ? $_SESSION['resultminiMum'] : "";
$resultmaxiMum = isset($_SESSION['resultmaxiMum']) ? $_SESSION['resultmaxiMum'] : "";
$result_noteSalary = isset($_SESSION['result_noteSalary']) ? $_SESSION['result_noteSalary'] : "";
$result_nameReportedto = isset($_SESSION['result_nameReportedto']) ? $_SESSION['result_nameReportedto'] : "";
$resultSkills = isset($_SESSION['resultSkills']) ? $_SESSION['resultSkills'] : "";
$resultjobDesctext = isset($_SESSION['resultjobDesctext']) ? $_SESSION['resultjobDesctext'] : "";
$resultBenefit = isset($_SESSION['resultBenefit']) ? $_SESSION['resultBenefit'] : "";
$resultDrawback = isset($_SESSION['resultDrawback']) ? $_SESSION['resultDrawback'] : "";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <title>Admin | Edit Job Description</title>
  <?php
  require('./fragment/libraryInput.php');
  ?>
  <script>
    form.addEventListener('submit', () => {
    if(document.getElementById("noteSala").checked) {
        document.getElementById('noteHidden').disabled = true;
    }
    if(document.getElementById("bonus").checked) {
        document.getElementById('bonusHidden').disabled = true;
    }
});
  </script>
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
      $action_page = $_GET['actionPage'];
      require('./fragment/pageheaderAdmin.php');
      ?>

      <div class="page-content">

        <form action="./controller/jobdescController.php" method="post">
          <fieldset>

            <legend>
              Brief job info
              <?php if ($_GET['actionPage'] == "Adding") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage']);
              } else if ($_GET['actionPage'] == "Editing") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage'] . "&id=" . $id = $_GET['id']);
              } ?> 
            </legend>
              <input type="hidden" name="id" value="<?php echo $id ?>">
            <input type="hidden" name="currentFile" value="<?php echo $currentFile ?>">

            <div class="box">
              <label for="jobDescName_in">
                Name:
              </label>
              <input type="text" id="jobDescName_in" name="jobDescName" placeholder="Enter Job Description Name"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['name'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultjob_descName) && is_string($resultjob_descName)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultjob_descName;
                    unset($_SESSION['resultjob_descName']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="refNum">
                Reference number:
              </label>
              <input type="text" id="refNum" name="refNum" placeholder="Enter Reference Number"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['refNum'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultrefNum) && is_string($resultrefNum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert2" />
                  <label class="close" title="close" for="alert2">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultrefNum;
                    unset($_SESSION['resultrefNum']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">
              <label for="posTitle">
                Position Title:
              </label>
              <input type="text" id="posTitle" name="posTitle" placeholder="Enter Position Title"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['posTitle'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultposTitle) && is_string($resultposTitle)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert3" />
                  <label class="close" title="close" for="alert3">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultposTitle;
                    unset($_SESSION['resultposTitle']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="keyResponse">
                Key responsibilites:
              </label>
              <input type="text" id="keyResponse" name="keyResponse" placeholder="Enter Key responsibilites"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['keyResponse'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultkeyResponse) && is_string($resultkeyResponse)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert4" />
                  <label class="close" title="close" for="alert4">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultkeyResponse;
                    unset($_SESSION['resultkeyResponse']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>



          </fieldset>

          <fieldset>

            <legend>
              Salary Range
            </legend>


            <div class="box">

              <label for="mimmumR">
                Minimum:
              </label>
              <input type="text" name="mimmumR" id="mimmumR" placeholder="Enter Minimum Salary"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['minSala'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultminiMum) && is_string($resultminiMum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert5" />
                  <label class="close" title="close" for="alert5">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultminiMum;
                    unset($_SESSION['resultminiMum']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">

              <label for="maximumR">
                Maximum:
              </label>
              <input type="text" name="maximumR" id="maximumR" placeholder="Enter Maximum Salary"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['maxSala'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultmaxiMum) && is_string($resultmaxiMum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert6" />
                  <label class="close" title="close" for="alert6">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultmaxiMum;
                    unset($_SESSION['resultmaxiMum']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">

              <label for="bonus">
                Bonus:
              </label>
              <input id='bonusHidden' type='hidden' value='No' name='bonusR'>
              <input type="checkbox" name="bonusR" id="bonus" value="Yes"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding' && $getInfoJobDesc['bonus'] == "Yes"): ?>
                value="<?= $getInfoJobDesc['bonus'] ?>" checked
                <?php endif; ?>>
            </div>


            <div class="box">

              <label for="noteSala">
                Note (optional):
              </label>
              <input type="text" name="noteSala" id="noteSala" placeholder="Enter Note (optional)"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoJobDesc['noteBonus'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($result_noteSalary) && is_string($result_noteSalary)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert7" />
                  <label class="close" title="close" for="alert7">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_noteSalary;
                    unset($_SESSION['result_noteSalary']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>




          </fieldset>

          <fieldset>

            <legend>
              The person to report to
            </legend>
            <div class="box">
              <label for="responsiblePerson">
                Name:
              </label>

              <!-- Create the HTML select dropdown -->
              <select name="nameReportedto" class="classic">
              <option value="n" selected>Choose responsible person it!</option>
                <?php
                foreach ($users as $user) {
                    echo "<option value='{$user['staffId']}'>{$user['staffFname']} {$user['staffLname']}</option>";

                }
                ?>
              </select>


              <?php if (!empty($result_nameReportedto) && is_string($result_nameReportedto)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert8" />
                  <label class="close" title="close" for="alert8">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_nameReportedto;
                    unset($_SESSION['result_nameReportedto']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">
              <label for="website">
                Note:
              </label>
              <input  type='hidden' name='noteReported_person' id='noteHidden' value='No'>
              <input type="checkbox" name="noteReported_person" id="noteSala" value="Yes"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding' && $getInfoJobDesc['note'] == "Yes"): ?>
                checked
                <?php endif; ?>>
            </div>


          </fieldset>


          <fieldset>

            <legend>
              Skills
            </legend>

            <div class="browse">
              <input type="search" id="manageInputSk" placeholder="Search" class="record-search"
                onkeyup="managelSkillsAdminFunction()">
              <select name="" id="filterSkills">
                <option value="default" selected>Default</option>
                <option value="skills">Name</option>
              </select>
              <!-- <input type="submit" id="" name="" value="Find"></input> -->
            </div>

            <div>
            <table id="myTableskills" width="100%">
        <thead>
            <tr>
                <th>SKILLS</th>
                <th>CHOOSE</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($allSkills as $skill): ?>
                <tr>
                    <td><?= htmlspecialchars($skill['skillName']) ?></td>
                    <td>
                        <input type="checkbox" name="skills[]" value="<?= $skill['skill_id'] ?>"
                        <?= in_array($skill['skill_id'], $associatedSkillIds) ? 'checked' : '' ?>>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
            </div>


            <!-- Display validation message for Skill -->
            <?php if (!empty($resultSkills) && is_string($resultSkills)): ?>
              <div class="alert error">
                <input type="checkbox" id="alert9" />
                <label class="close" title="close" for="alert9">
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
              <textarea type="text" id="jobDesctext" name="jobDesctext" rows="8" cols="100">
<?php 
    if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding' && isset($getInfoJobDesc['briefJobDescription'])): 
        echo htmlspecialchars($getInfoJobDesc['briefJobDescription']);
    endif; 
?>
</textarea>

              <!-- Display validation message for First Name -->
              <?php if (!empty($resultjobDesctext) && is_string($resultjobDesctext)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert10" />
                  <label class="close" title="close" for="alert10">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultjobDesctext;
                    unset($_SESSION['resultjobDesctext']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


          </fieldset>

          <div id="inputsubContainer">
            <input type="reset" value="Reset" id="btnInput">
            <input type="submit" value="Submit" id="btnInput">
            <a id="btnBack" href="./manage_list_job.php">Back</a>
          </div>


        </form>


      </div>

    </main>

  </div>
</body>

</html>