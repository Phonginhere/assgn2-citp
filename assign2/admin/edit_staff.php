<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Including authentication check
include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2, 3);
include './controller/authroleCheck.php';


include_once __DIR__ . '/../settings.php';
function getInfoStaff()
{
  if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'){
    global $pdo;

    try {
      $stmt = $pdo->query("SELECT * FROM `staff` WHERE `staffId` = " . $_GET['id']);
      $result = $stmt->fetch(PDO::FETCH_ASSOC);
      return $result;
    } catch (PDOException $e) {
      echo 'Error fetching data: ' . $e->getMessage();
      return [];
    }
  }
}
$getInfoStaff = getInfoStaff();


session_start();


$resultFirstname = isset($_SESSION['resultFirstname']) ? $_SESSION['resultFirstname'] : null;
$resultLastname = isset($_SESSION['resultLastname']) ? $_SESSION['resultLastname'] : null;
$resultNickname = isset($_SESSION['resultNickname']) ? $_SESSION['resultNickname'] : null;
$resultEmail = isset($_SESSION['resultEmail']) ? $_SESSION['resultEmail'] : null;
$resultdob = isset($_SESSION['resultdob']) ? $_SESSION['resultdob'] : null;

$resultPhonenum = isset($_SESSION['resultPhonenum']) ? $_SESSION['resultPhonenum'] : null;
$resultTelenum = isset($_SESSION['resultTelenum']) ? $_SESSION['resultTelenum'] : null;
$resultddRoles = isset($_SESSION['resultddRoles']) ? $_SESSION['resultddRoles'] : null;

$resultddStatus = isset($_SESSION['resultddStatus']) ? $_SESSION['resultddStatus'] : null;
$resultNpass = isset($_SESSION['resultNpass']) ? $_SESSION['resultNpass'] : null;
$resultRpass = isset($_SESSION['resultRpass']) ? $_SESSION['resultRpass'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;
//continue 


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
      $action_page = $_GET['actionPage'];
      require('./fragment/pageheaderAdmin.php');
      ?>

      <div class="page-content">

        <form action="./controller/staffController.php" method="post">
          <fieldset>

            <legend>
              Personal
              <?php if ($_GET['actionPage'] == "Adding") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage']);
              } else if ($_GET['actionPage'] == "Editing") {
                $currentFile = basename($_SERVER['PHP_SELF'] . "?actionPage=" . $actionPage = $_GET['actionPage'] . "&id=" . $id = $_GET['id']);
              } ?>
            </legend>

            <input type="hidden" name="id" value="<?=$id?>">
            <input type="hidden" name="currentFile" value="<?php echo $currentFile ?>">


            <div class="box">
              <label for="firstname">
                First name:
              </label>
              <input type="text" name="firstname" id="firstname" placeholder="Enter Your First name"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['staffFname'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for First Name -->
              <?php if (!empty($resultFirstname) && is_string($resultFirstname)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultFirstname;
                    unset($_SESSION['resultFirstname']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">
              <label for="lastname">
                Last name:
              </label>
              <input type="text" name="lastname" id="lastname" placeholder="Enter Your Last name"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['staffLname'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for Last Name -->
              <?php if (!empty($resultLastname) && is_string($resultLastname)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert2" />
                  <label class="close" title="close" for="alert2">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultLastname;
                    unset($_SESSION['resultLastname']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="nickname">
                Nick name:
              </label>
              <input type="text" name="nickname" id="nickname" placeholder="Enter Your Nick name"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['staffNname'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for Name -->
              <?php if (!empty($resultNickname) && is_string($resultNickname)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert3" />
                  <label class="close" title="close" for="alert3">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultNickname;
                    unset($_SESSION['resultNickname']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">
              <label for="email">
                E-mail:
              </label>
              <input type="email" name="emailAdd" id="email" placeholder="xyz@gmail.com"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['email'] ?>"
                <?php endif; ?>>
              <!-- Display validation message for Name -->
              <?php if (!empty($resultEmail) && is_string($resultEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert4" />
                  <label class="close" title="close" for="alert4">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultEmail;
                    unset($_SESSION['resultEmail']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


          </fieldset>

          <fieldset>

            <legend>
              Phone
            </legend>


            <div class="box">

              <label for="phonenum">
                Phone Number:
              </label>
              <input type="text" name="phonenum" id="phonenum" placeholder="Type your phone number"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['phoneNum'] ?>"
              <?php endif; ?>>
              <?php if (!empty($resultPhonenum) && is_string($resultPhonenum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert5" />
                  <label class="close" title="close" for="alert5">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultPhonenum;
                    unset($_SESSION['resultPhonenum']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">

              <label for="telenum">
                Telephone Number:
              </label>
              <input type="text" name="telenum" id="telenum" placeholder="Type your telephone number"
              <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                value="<?= $getInfoStaff['telephoneNum'] ?>"
                <?php endif; ?>>
              <?php if (!empty($resultTelenum) && is_string($resultTelenum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert6" />
                  <label class="close" title="close" for="alert6">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultTelenum;
                    unset($_SESSION['resultTelenum']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>



          </fieldset>

          <fieldset>

            <legend>
              Privileges
            </legend>
            <div class="box">
              <label for="website">
                Roles:
              </label>

              <select name="roles" id="staffRoles" class="classic">
                <option value="n" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffRoles'] == 'n' ? 'selected' : '') ?>
                <?php endif; ?>
                >Please Select</option>
                <option value="2" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffRoles'] == '2' ? 'selected' : '') ?>
                <?php endif; ?>
                >Manager</option>
                <option value="3" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffRoles'] == '3' ? 'selected' : '') ?>
                <?php endif; ?>
                >HR</option>
                <option value="4" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffRoles'] == '4' ? 'selected' : '') ?>
                <?php endif; ?>
                >Leader</option>
                <option value="5" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffRoles'] == '5' ? 'selected' : '') ?>
                <?php endif; ?>
                >Applicant</option>
              </select>



              <?php if (!empty($resultddRoles) && is_string($resultddRoles)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert7" />
                  <label class="close" title="close" for="alert7">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultddRoles;
                    unset($_SESSION['resultddRoles']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">
              <label for="website">
                Status:
              </label>

              

              <select name="status" id="staffStatus" class="classic">
                <option value="n" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffStatus'] == 'n' ? 'selected' : '') ?>
                <?php endif; ?>
                >Choose it!</option>
                <option value="1" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffStatus'] == '1' ? 'selected' : '') ?>
                <?php endif; ?>
                >Enabled</option>
                <option value="2" 
                <?php if (isset($_GET['actionPage']) && $_GET['actionPage'] !== 'Adding'): ?>
                <?= ($getInfoStaff['staffStatus'] == '2' ? 'selected' : '') ?>
                <?php endif; ?>
                >Disabled</option>
              </select>

             


              
              <?php if (!empty($resultddStatus) && is_string($resultddStatus)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert8" />
                  <label class="close" title="close" for="alert8">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultddStatus;
                    unset($_SESSION['resultddStatus']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>



          </fieldset>


          <fieldset>

            <legend>
              Security
            </legend>


            <div class="box">
              <label for="pass">
                Password:
              </label>

              <input type="password" name="npass" id="pass" placeholder="**********">
              <!-- Display validation message for New password -->
              <?php if (!empty($resultNpass) && is_string($resultNpass)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert9" />
                  <label class="close" title="close" for="alert9">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultNpass;
                    unset($_SESSION['resultNpass']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="retypepass">
                Retype Password:
              </label>

              <input type="password" name="retypepass" id="retypepass" placeholder="**********">
              <?php if (!empty($resultRpass) && is_string($resultRpass)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert10" />
                  <label class="close" title="close" for="alert10">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultRpass;
                    unset($_SESSION['resultRpass']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div id="inputsubContainer">
              <input type="reset" value="Reset" id="btnInput">
              <input type="submit" value="Submit" id="btnInput">
              <a id="btnBack" href="./staffManager.php">Back</a>
            </div>

            <!-- <input type="submit" value="Submit" id="btn"> -->

          </fieldset>

        </form>


      </div>

    </main>

  </div>
</body>

</html>