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

          <fieldset>

            <legend>
              Personal
            </legend>


<input type="hidden" name="idUser" value="<?= $result['staffId'] ?>">


            <div class="box">
              <label for="firstname">
                First name:
              </label>
              <input disabled type="text" name="firstname" id="firstname" placeholder="Enter Your First name"
                value="<?= $result['staffFname'] ?>">
            </div>

            <div class="box">
              <label for="lastname">
                Last name:
              </label>
              <input disabled type="text" name="lastname" id="lastname" placeholder="Enter Your Last name" value="<?= $result['staffLname'] ?>">
            </div>


            <div class="box">
              <label for="nickname">
                Nick name:
              </label>
              <input disabled type="text" name="nickname" id="nickname" placeholder="Enter Your Nick name" value="<?= $result['staffNname'] ?>">
            </div>

            <div class="box">
              <label for="email">
                E-mail:
              </label>
              <input disabled type="email" name="emailAdd" id="email" placeholder="xyz@gmail.com" value="<?= $result['email'] ?>">
            </div>


            <div class="box">
              <label for="dob">
                Date of birth:
              </label>
              <input disabled type="text" name="dob" id="dob" placeholder="dd/mm/yyyy" value="<?= $result['dob'] ?>">
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
              <input disabled type="text" name="phonenum" id="phonenum" placeholder="Type your phone number" value="<?= $result['phoneNum'] ?>">
            </div>

            <div class="box">

              <label for="telenum">
                Telephone Number:
              </label>
              <input disabled type="text" name="telenum" id="telenum" placeholder="Type your telephone number" value="<?= $result['telephoneNum'] ?>">
            </div>



          </fieldset>

          <div id="inputsubContainer">
    <a id="btnBack" href="./staffManager.php">Back</a>
  </div>

        


      </div>

    </main>

  </div>
</body>

</html>