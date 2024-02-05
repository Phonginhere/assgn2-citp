<?php
session_start();
ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);

// Including authentication check
include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2);
include './controller/authroleCheck.php';



//session_start(); // Ensure that session is started at the beginning of the target PHP file
include_once './controller/settingsController.php';
// include_once   '../../assign2/settings.php';

$settings = getSettings();
// Retrieve the values from the $_SESSION superglobal
$resultName = isset($_SESSION['resultSitename']) ? $_SESSION['resultSitename'] : null;
$resultcityName = isset($_SESSION['resultcityName']) ? $_SESSION['resultcityName'] : null;
$resulturlDirection = isset($_SESSION['resulturlDirection']) ? $_SESSION['resulturlDirection'] : null;

$resultStreet = isset($_SESSION['resultStreet']) ? $_SESSION['resultStreet'] : null;
$resultSurtown = isset($_SESSION['resultSurtown']) ? $_SESSION['resultSurtown'] : null;
$resultState = isset($_SESSION['resultState']) ? $_SESSION['resultState'] : null;
$resultPostcode = isset($_SESSION['resultPostcode']) ? $_SESSION['resultPostcode'] : null;

$resultgeneralEmail = isset($_SESSION['resultgeneralEmail']) ? $_SESSION['resultgeneralEmail'] : null;
$resultfirstEmail = isset($_SESSION['resultfirstEmail']) ? $_SESSION['resultfirstEmail'] : null;
$resultsecondEmail = isset($_SESSION['resultsecondEmail']) ? $_SESSION['resultsecondEmail'] : null;
$resultthirdEmail = isset($_SESSION['resultthirdEmail']) ? $_SESSION['resultthirdEmail'] : null;

$resultfbSmedia = isset($_SESSION['resultfbSmedia']) ? $_SESSION['resultfbSmedia'] : null;
$result_twitSmedia = isset($_SESSION['result_twitSmedia']) ? $_SESSION['result_twitSmedia'] : null;
$result_linkeSmedia = isset($_SESSION['result_linkeSmedia']) ? $_SESSION['result_linkeSmedia'] : null;
$result_youtSmedia = isset($_SESSION['result_youtSmedia']) ? $_SESSION['result_youtSmedia'] : null;
$result_insSmedia = isset($_SESSION['result_insSmedia']) ? $_SESSION['result_insSmedia'] : null;

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
  <title>Admin | Settings </title>
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

        <form action="./controller/settingsController.php" method="post">
          <fieldset>

            <legend>
              General
            </legend>

            <div class="box">
              <label for="nameWeb_input">
                Name website:
              </label>
              <input type="text" id="nameWeb_input" name="nameWeb" placeholder="Enter Your Name website"
                value="<?= $settings['name'] ?>">
              <!-- Display validation message for Name -->
              <?php if (!empty($resultName) && is_string($resultName)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert1" />
                  <label class="close" title="close" for="alert1">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultName;
                    unset($_SESSION['resultSitename']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>

            </div>




            <div class="box">
              <label for="cityName_input">
                City name:
              </label>
              <input type="text" id="cityName_input" name="cityName" placeholder="Enter Your City name"
              value="<?= $settings['cityName'] ?>">
              <!-- Display validation message for City Name -->
              <?php if (!empty($resultcityName) && is_string($resultcityName)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert2" />
                  <label class="close" title="close" for="alert2">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultcityName;
                    unset($_SESSION['resultcityName']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>



            <div class="box">
              <label for="urlDirection_input">
                Url direction:
              </label>
              <input type="text" id="urlDirection_input" name="urlDirect" placeholder="Enter your company url direction"
              value="<?= $settings['urlDirection'] ?>">
              <!-- Display validation message for Url direction -->
              <?php if (!empty($resulturlDirection) && is_string($resulturlDirection)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert3" />
                  <label class="close" title="close" for="alert3">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resulturlDirection;
                    unset($_SESSION['resulturlDirection']);
                    ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

          </fieldset>

          <fieldset>
            <legend>
              Address
            </legend>

            <div class="box">

              <label for="street">
                Street Address:
              </label>
              <input type="text" id="street" name="street" placeholder="Type Street Address" value="<?= $settings['streetAddress'] ?>">
              <!-- Display validation message for Street Address -->
              <?php if (!empty($resultStreet) && is_string($resultStreet)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert4" />
                  <label class="close" title="close" for="alert4">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultStreet;
                    unset($_SESSION['resultStreet']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">

              <label for="sub_t">
                Surburb or Town:
              </label>
              <input type="text" id="sub_t" name="sub_t" placeholder="Type Surburb or Town"
              value="<?= $settings['subOrtown'] ?>">
              <!-- Display validation message for Surburb or Town -->
              <?php if (!empty($resultSurtown) && is_string($resultSurtown)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert5" />
                  <label class="close" title="close" for="alert5">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultSurtown;
                    unset($_SESSION['resultSurtown']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">

              <label for="gEmail_input">
                State:
              </label>
              <select name="state" id="state" class="classic">
    <option value="0" <?= ($settings['state'] == '0' ? 'selected' : '') ?>>Please Select</option>
    <option value="vic" <?= ($settings['state'] == 'vic' ? 'selected' : '') ?>>VIC</option>
    <option value="nsw" <?= ($settings['state'] == 'nsw' ? 'selected' : '') ?>>NSW</option>
    <option value="qld" <?= ($settings['state'] == 'qld' ? 'selected' : '') ?>>QLD</option>
    <option value="nt" <?= ($settings['state'] == 'nt' ? 'selected' : '') ?>>NT</option>
    <option value="wa" <?= ($settings['state'] == 'wa' ? 'selected' : '') ?>>WA</option>
    <option value="sa" <?= ($settings['state'] == 'sa' ? 'selected' : '') ?>>SA</option>
    <option value="tas" <?= ($settings['state'] == 'tas' ? 'selected' : '') ?>>TAS</option>
    <option value="act" <?= ($settings['state'] == 'act' ? 'selected' : '') ?>>ACT</option>
</select>
              <!-- Display validation message for State -->
              <?php if (!empty($resultState) && is_string($resultState)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert6" />
                  <label class="close" title="close" for="alert6">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultState;
                    unset($_SESSION['resultState']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <div class="box">

              <label for="postcode">
              Postcode:
              </label>
              <input type="text" id="postcode" name="postcode" placeholder="Type Postcode" value="<?= $settings['postcode'] ?>">
              <!-- Display validation message for Postcode -->
              <?php if (!empty($resultPostcode) && is_string($resultPostcode)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert7" />
                  <label class="close" title="close" for="alert7">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultPostcode;
                    unset($_SESSION['resultPostcode']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

          </fieldset>

          <fieldset>

            <legend>
              Email
            </legend>


            <div class="box">

              <label for="gEmail_input">
                General Email:
              </label>
              <input type="text" id="gEmail_input" name="generalEmail" placeholder="Type General Email"
              value="<?= $settings['generalEmail'] ?>">
              <!-- Display validation message for General Email -->
              <?php if (!empty($resultgeneralEmail) && is_string($resultgeneralEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert8" />
                  <label class="close" title="close" for="alert8">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultgeneralEmail;
                    unset($_SESSION['resultgeneralEmail']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">

              <label for="fEmail_input">
                First Email:
              </label>
              <input type="text" id="fEmail_input" name="firstEmail" placeholder="Type First Email"
              value="<?= $settings['firstEmail'] ?>">
              <!-- Display validation message for First Email -->
              <?php if (!empty($resultfirstEmail) && is_string($resultfirstEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert9" />
                  <label class="close" title="close" for="alert9">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultfirstEmail;
                    unset($_SESSION['resultfirstEmail']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">

              <label for="sEmail_input">
                Second Email:
              </label>
              <input type="text" id="sEmail_input" name="secondEmail" placeholder="Type Second Email"
              value="<?= $settings['secondEmail'] ?>">
              <!-- Display validation message for Second Email -->
              <?php if (!empty($resultsecondEmail) && is_string($resultsecondEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert10" />
                  <label class="close" title="close" for="alert10">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultsecondEmail;
                    unset($_SESSION['resultsecondEmail']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>




            <div class="box">

              <label for="tEmail_input">
                Third Email:
              </label>
              <input type="text" id="tEmail_input" name="thirdEmail" placeholder="Type Third Email"
              value="<?= $settings['thirdEmail'] ?>">
              <!-- Display validation message for Third Email -->
              <?php if (!empty($resultthirdEmail) && is_string($resultthirdEmail)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert11" />
                  <label class="close" title="close" for="alert11">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultthirdEmail;
                    unset($_SESSION['resultthirdEmail']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>




          </fieldset>

          <fieldset>

            <legend>
              Social Media
            </legend>

            <div class="box">
              <label for="fbSc_input">
                Facebook:
              </label>

              <input type="text" id="fbSc_input" name="faceWeb" placeholder="Only type Facebook username"
              value="<?= $settings['fbUsername'] ?>">
              <!-- Display validation message for Facebook -->
              <?php if (!empty($resultfbSmedia) && is_string($resultfbSmedia)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert12" />
                  <label class="close" title="close" for="alert12">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $resultfbSmedia;
                    unset($_SESSION['resultfbSmedia']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="twSc_input">
                Twitter:
              </label>

              <input type="text" id="twSc_input" name="twittWeb" placeholder="Only type Twitter username"
              value="<?= $settings['twUsername'] ?>">
              <!-- Display validation message for Twitter -->
              <?php if (!empty($result_twitSmedia) && is_string($result_twitSmedia)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert13" />
                  <label class="close" title="close" for="alert13">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_twitSmedia;
                    unset($_SESSION['result_twitSmedia']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="lnSc_input">
                Linkedin:
              </label>

              <input type="text" id="lnSc_input" name="linkeWeb" placeholder="Only type Linkedin username"
              value="<?= $settings['lkUsername'] ?>">
              <!-- Display validation message for Linkedin -->
              <?php if (!empty($result_linkeSmedia) && is_string($result_linkeSmedia)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert14" />
                  <label class="close" title="close" for="alert14">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_linkeSmedia;
                    unset($_SESSION['result_linkeSmedia']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="ytSc_input">
                Youtube:
              </label>

              <input type="text" id="ytSc_input" name="YouWeb" placeholder="Only type Youtube username"
              value="<?= $settings['ytUsername'] ?>">
              <!-- Display validation message for Youtube -->
              <?php if (!empty($result_youtSmedia) && is_string($result_youtSmedia)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert15" />
                  <label class="close" title="close" for="alert15">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_youtSmedia;
                    unset($_SESSION['result_youtSmedia']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>


            <div class="box">
              <label for="inSc_input">
                Instagram:
              </label>

              <input type="text" id="inSc_input" name="instagramWeb" placeholder="Only type Instagram username"
              value="<?= $settings['insUsername'] ?>">
              <!-- Display validation message for Instagram -->
              <?php if (!empty($result_insSmedia) && is_string($result_insSmedia)): ?>
                <div class="alert error">
                  <input type="checkbox" id="alert16" />
                  <label class="close" title="close" for="alert16">
                    <i class="las la-times"></i>
                  </label>
                  <p class="inner">
                    <strong>Warning!</strong>
                    <?php echo $result_insSmedia;
                    unset($_SESSION['result_insSmedia']); ?>
                  </p>
                </div>
              <?php endif; ?>
            </div>

            <!-- <input type="submit" value="Submit" id="btn"> -->

          </fieldset>


          <div id="inputsubContainer">
            <input type="reset" value="Reset" onclick="resetComment();" id="btnInput">
            <input type="submit" value="Submit" id="btnInput">
          </div>
        </form>


      </div>

    </main>

  </div>
</body>
<!-- <script>
  // Restore the comment when the page is loaded
  document.getElementById("nameWeb_input").value = localStorage.getItem("nameWeb");
  document.getElementById("cityName_input").value = localStorage.getItem("cityName");
  document.getElementById("urlDirection_input").value = localStorage.getItem("urlDirection");

  document.getElementById("gEmail_input").value = localStorage.getItem("gEmail");
  document.getElementById("fEmail_input").value = localStorage.getItem("fEmail");
  document.getElementById("sEmail_input").value = localStorage.getItem("sEmail");
  document.getElementById("tEmail_input").value = localStorage.getItem("tEmail");

  document.getElementById("fbSc_input").value = localStorage.getItem("fbSc");
  document.getElementById("twSc_input").value = localStorage.getItem("twSc");
  document.getElementById("lnSc_input").value = localStorage.getItem("lnSc");
  document.getElementById("ytSc_input").value = localStorage.getItem("ytSc");
  document.getElementById("inSc_input").value = localStorage.getItem("inSc");

  function saveInput() {
    var nameWeb = document.getElementById("nameWeb_input").value;
    var cityName = document.getElementById("cityName_input").value;
    var urlDirection = document.getElementById("urlDirection_input").value;

    var gEmail = document.getElementById("gEmail_input").value;
    var fEmail = document.getElementById("fEmail_input").value;
    var sEmail = document.getElementById("sEmail_input").value;
    var tEmail = document.getElementById("tEmail_input").value;

    var fbSc = document.getElementById("fbSc_input").value;
    var twSc = document.getElementById("twSc_input").value;
    var lnSc = document.getElementById("lnSc_input").value;
    var ytSc = document.getElementById("ytSc_input").value;
    var inSc = document.getElementById("inSc_input").value;

    localStorage.setItem("nameWeb", nameWeb);
    localStorage.setItem("cityName", cityName);
    localStorage.setItem("urlDirection", urlDirection);

    localStorage.setItem("gEmail", gEmail);
    localStorage.setItem("fEmail", fEmail);
    localStorage.setItem("sEmail", sEmail);
    localStorage.setItem("tEmail", tEmail);

    localStorage.setItem("fbSc", fbSc);
    localStorage.setItem("twSc", twSc);
    localStorage.setItem("lnSc", lnSc);
    localStorage.setItem("ytSc", ytSc);
    localStorage.setItem("inSc", inSc);
  }
  function resetComment() {
    localStorage.removeItem("nameWeb");
    localStorage.removeItem("cityName");
    localStorage.removeItem("urlDirection");

    localStorage.removeItem("gEmail");
    localStorage.removeItem("fEmail");
    localStorage.removeItem("sEmail");
    localStorage.removeItem("tEmail");

    localStorage.removeItem("fbSc");
    localStorage.removeItem("twSc");
    localStorage.removeItem("lnSc");
    localStorage.removeItem("ytSc");
    localStorage.removeItem("inSc");


    document.getElementById("nameWeb_input").value = ""; // Clear the input field
    document.getElementById("cityName_input").value = ""; // Clear the input field
    document.getElementById("urlDirection_input").value = ""; // Clear the input field

    document.getElementById("gEmail_input").value = ""; // Clear the input field
    document.getElementById("fEmail_input").value = ""; // Clear the input field
    document.getElementById("sEmail_input").value = ""; // Clear the input field
    document.getElementById("tEmail_input").value = ""; // Clear the input field

    document.getElementById("fbSc_input").value = ""; // Clear the input field
    document.getElementById("twSc_input").value = ""; // Clear the input field
    document.getElementById("lnSc_input").value = ""; // Clear the input field
    document.getElementById("ytSc_input").value = ""; // Clear the input field
    document.getElementById("inSc_input").value = ""; // Clear the input field
  }
</script> -->

</html>