<?php

// Including authentication check
include './controller/authCheck.php';
$email = "";
if (isset($_SESSION["email"])) {
  $email = $_SESSION["email"];
  // echo $email;
}

include_once __DIR__ . '/../settings.php';

$stmt = $pdo->prepare("SELECT * FROM `staff` WHERE `email` = :email");
$stmt->execute([':email' => $email]);
$result = $stmt->fetch(PDO::FETCH_ASSOC);

$resultFirstname = isset($_SESSION['resultFirstname']) ? $_SESSION['resultFirstname'] : "";
$resultLastname = isset($_SESSION['resultLastname']) ? $_SESSION['resultLastname'] : "";
$resultNickname = isset($_SESSION['resultNickname']) ? $_SESSION['resultNickname'] : "";
$resultEmail = isset($_SESSION['resultEmail']) ? $_SESSION['resultEmail'] : "";

$resultdob = isset($_SESSION['resultdob']) ? $_SESSION['resultdob'] : "";
$resultPhonenum = isset($_SESSION['resultPhonenum']) ? $_SESSION['resultPhonenum'] : "";
$resultTelenum = isset($_SESSION['resultTelenum']) ? $_SESSION['resultTelenum'] : "";
$resultOpass = isset($_SESSION['resultOpass']) ? $_SESSION['resultOpass'] : "";
$resultNpass = isset($_SESSION['resultNpass']) ? $_SESSION['resultNpass'] : "";
$resultRpass = isset($_SESSION['resultRpass']) ? $_SESSION['resultRpass'] : "";



?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <title>Profile | Admin</title>
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
      $action_page = isset($_GET['actionPage']) ? $_GET['actionPage'] : '';
      require('./fragment/pageheaderAdmin.php');
      ?>

      <div class="page-content">

        <form action="./controller/profileController.php" method="post">
          <fieldset>

            <legend>
              Personal
            </legend>


<input type="hidden" name="idUser" value="<?= $result['staffId'] ?>">


            <div class="box">
              <label for="firstname">
                First name:
              </label>
              <input type="text" name="firstname" id="firstname" placeholder="Enter Your First name"
                value="<?= $result['staffFname'] ?>">
              <!-- Display validation message for Name -->
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
              <input type="text" name="lastname" id="lastname" placeholder="Enter Your Last name" value="<?= $result['staffLname'] ?>">
              <!-- Display validation message for Name -->
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
              <input type="text" name="nickname" id="nickname" placeholder="Enter Your Nick name" value="<?= $result['staffNname'] ?>">
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
              <input type="email" name="emailAdd" id="email" placeholder="xyz@gmail.com" value="<?= $result['email'] ?>">
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


            <div class="box">
              <label for="dob">
                Date of birth:
              </label>
              <input type="text" name="dob" id="dob" placeholder="dd/mm/yyyy" value="<?= $result['dob'] ?>">
              <!-- Display validation message for Name -->
              <?php if (!empty($resultdob) && is_string($resultdob)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert5" />
                  <label class="close" title="close" for="alert5">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultdob;
                    unset($_SESSION['resultdob']);
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
              <input type="text" name="phonenum" id="phonenum" placeholder="Type your phone number" value="<?= $result['phoneNum'] ?>">
              <!-- Display validation message for Name -->
              <?php if (!empty($resultPhonenum) && is_string($resultPhonenum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert6" />
                  <label class="close" title="close" for="alert6">
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
              <input type="text" name="telenum" id="telenum" placeholder="Type your telephone number" value="<?= $result['telephoneNum'] ?>">
              <!-- Display validation message for Name -->
              <?php if (!empty($resultTelenum) && is_string($resultTelenum)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert7" />
                  <label class="close" title="close" for="alert8">
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
              Security
            </legend>


            <div class="box">
              <label for="opass">
                Old Password:
              </label>

              <input type="password" name="opass" id="opass" placeholder="**********">
              <!-- Display validation message for Old pass -->
              <?php if (!empty($resultOpass) && is_string($resultOpass)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert8" />
                  <label class="close" title="close" for="alert8">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultOpass;
                    unset($_SESSION['resultOpass']);
                    ?>
                  </p>
                </div>
                <?php endif; ?>
            </div>


            <div class="box">
              <label for="npass">
                Password:
              </label>

              <input type="password" name="npass" id="npass" placeholder="**********">
              <!-- Display validation message for New Password -->
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
            </div>

            <!-- <input type="submit" value="Submit" id="btn"> -->

          </fieldset>

        </form>


      </div>

    </main>

  </div>
</body>

</html>