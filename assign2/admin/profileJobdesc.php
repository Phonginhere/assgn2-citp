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
function getInfojobDesc()
{

  global $pdo;
  try {
    $stmt = $pdo->query("SELECT jd.name as name, 
        jd.jobDescId as jobDescId,
        jd.refNum as rNum, 
        jd.posTitle as posTle, 
        jd.keyResponse as keyres, 
        jd.minSala as minsala, 
        jd.maxSala as maxsala, 
        jd.bonus as bonus, 
        jd.noteBonus as nBonus,
        jd.reportTo as reportTo, 
        concat(m.staffFname,' ' ,m.staffLname) as leader, 
        jd.note as note, jd.briefJobDescription as briefJobdesc
         
        FROM jobDesc jd 
        LEFT JOIN staff s 
        ON jd.staffId = s.staffId 
        LEFT JOIN staff m 
        ON jd.reportTo = m.staffId 
        where jd.jobDescId = " . $_GET['id']);
    $resultJobdesc = $stmt->fetch(PDO::FETCH_ASSOC);
    return $resultJobdesc;
  } catch (PDOException $e) {
    echo 'Error fetching data: ' . $e->getMessage();
    return [];
  }
}
$getInfoJobDesc = getInfojobDesc();

$sql = "SELECT `staffId`, `staffFname`, `staffLname`FROM `staff` WHERE `staffRoles` = 4";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get all skills
$sql = "SELECT * FROM `skill`";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$allSkills = $stmt->fetchAll(PDO::FETCH_ASSOC);

$stmtAssociatedSkills = $pdo->prepare("SELECT skill_id FROM jobDesc_skill WHERE jobDescId = :jobDescId");
$stmtAssociatedSkills->bindParam(':jobDescId', $_GET['id'], PDO::PARAM_INT);
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
              Brief job info
            </legend>

            <div class="box">
              <label for="jobDescName_in">
                Name:
              </label>
              <input disabled type="text" id="jobDescName_in" name="jobDescName"
                placeholder="Enter Job Description Name" value="<?= $getInfoJobDesc['name'] ?>">
            </div>


            <div class="box">
              <label for="refNum">
                Reference number:
              </label>
              <input disabled type="text" id="refNum" name="refNum" placeholder="Enter Reference Number"
                value="<?= $getInfoJobDesc['rNum'] ?>">
            </div>

            <div class="box">
              <label for="posTitle">
                Position Title:
              </label>
              <input disabled type="text" id="posTitle" name="posTitle" placeholder="Enter Position Title"
                value="<?= $getInfoJobDesc['posTle'] ?>">
            </div>


            <div class="box">
              <label for="keyResponse">
                Key responsibilites:
              </label>
              <input disabled type="text" id="keyResponse" name="keyResponse" placeholder="Enter Key responsibilites"
                value="<?= $getInfoJobDesc['keyres'] ?>">
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
              <input disabled type="text" name="mimmumR" id="mimmumR" placeholder="Enter Minimum Salary"
                value="<?= $getInfoJobDesc['minsala'] ?>">
            </div>

            <div class="box">

              <label for="maximumR">
                Maximum:
              </label>
              <input disabled type="text" name="maximumR" id="maximumR" placeholder="Enter Maximum Salary"
                value="<?= $getInfoJobDesc['maxsala'] ?>">
            </div>


            <div class="box">

              <label for="bonus">
                Bonus:
              </label>
              <input id='bonusHidden' type='hidden' value='No' name='bonusR'>
              <input disabled type="checkbox" name="bonusR" id="bonus" value="yes"
                value="<?= $getInfoJobDesc['bonus'] ?>" checked>
            </div>


            <div class="box">

              <label for="noteSala">
                Note (optional):
              </label>
              <input disabled type="text" name="noteSala" id="noteSala" placeholder="Enter Note (optional)"
                value="<?= $getInfoJobDesc['nBonus'] ?>">
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
              <select disabled name="nameReportedto" class="classic">

                <?php
                foreach ($users as $user) {
                  if ($getInfoJobDesc['jobDescId'] == $_GET['id'] && $getInfoJobDesc['reportTo'] == $user['staffId']) {
                    echo "<option selected  value='{$user['staffId']}' selected>{$user['staffFname']} {$user['staffLname']}</option>";
                  }

                }
                ?>
              </select>

            </div>

            <div class="box">
              <label for="website">
                Note:
              </label>
              <input type='hidden' name='noteReported_person' id='noteHidden' value='No'>
              <input type="checkbox" name="noteReported_person" id="noteSala" <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding' && $getInfoJobDesc['note'] == "Yes"): ?>
                  value="<?= $getInfoJobDesc['note'] ?>" checked <?php endif; ?>>
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

echo htmlspecialchars($getInfoJobDesc['briefJobdesc']);
?>
</textarea>
            </div>


          </fieldset>

          <div id="inputsubContainer">
            <a id="btnBack" href="./manage_list_job.php">Back</a>
          </div>


        </form>


      </div>

    </main>

  </div>
</body>

</html>