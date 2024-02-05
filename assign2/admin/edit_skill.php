<?php
// Including authentication check
include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2, 3);
include './controller/authroleCheck.php';

include_once __DIR__ . '/../settings.php';
function getInfoSkill()
{
  if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'){
    global $pdo;

    try {
      $stmt = $pdo->query("SELECT * FROM `skill` WHERE `skill_id` = " . $_GET['id']);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'Error fetching data: ' . $e->getMessage();
      return [];
    }
  }
}
$getInfoSkil = getInfoSkill();


session_start();
$resultSkill = isset($_SESSION['resultSkill']) ? $_SESSION['resultSkill'] : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <title>Admin | Edit Skills</title>
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
      $action_page = $_GET['actionPage'];
      require('./fragment/pageheaderAdmin.php');
      ?>

      <div class="page-content">

        <form action="./controller/skillsController.php" method="post">
          <fieldset>

            <legend>
              Skills
              <?php if ($_GET['actionPage'] == "Adding") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage']);
              } else if ($_GET['actionPage'] == "Editing") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage'] . "&id=" . $id = $_GET['id']);
              } ?>
            </legend>
            

            <input type="hidden" name="idSkill" value="<?php echo $id ?>">
            <input type="hidden" name="currentFile" value="<?php echo $currentFile ?>">

            <div class="box">
              <label for="skillsname">
                Skills name:
              </label>
              <input type="text" name="skillsname" id="skillsname" placeholder="Enter Skills name"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoSkil['skillName'] ?>"
              <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultSkill) && is_string($resultSkill)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultSkill;
                    unset($_SESSION['resultSkill']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div id="inputsubContainer">
              <input type="reset" value="Reset" id="btnInput">
              <input type="submit" value="Submit" id="btnInput">
              <a id="btnBack" href="./manage_list_job.php">Back</a>
            </div>

          </fieldset>


        </form>


      </div>

    </main>

  </div>
</body>

</html>