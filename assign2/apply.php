<!-- apply.php -->
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once __DIR__ . '/settings.php';
global $pdo;

$stmt = $pdo->prepare("SELECT * FROM skill");
$stmt->execute();

// Fetch all the data.
$skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

session_start(); // Ensure that session is started at the beginning of the target PHP file

// Retrieve the values from the $_SESSION superglobal
$resultName = isset($_SESSION['resultName']) ? $_SESSION['resultName'] : "";
$resultEmail = isset($_SESSION['resultEmail']) ? $_SESSION['resultEmail'] : "";
$resultDob = isset($_SESSION['resultDob']) ? $_SESSION['resultDob'] : "";
$resultGender = isset($_SESSION['resultGender']) ? $_SESSION['resultGender'] : "";
$resultStreetSurtown = isset($_SESSION['resultStreetSurtown']) ? $_SESSION['resultStreetSurtown'] : "";
$resultState = isset($_SESSION['resultState']) ? $_SESSION['resultState'] : "";
$postcodeErr = isset($_SESSION['postcodeErr']) ? $_SESSION['postcodeErr'] : "";
$returnPhone = isset($_SESSION['returnPhone']) ? $_SESSION['returnPhone'] : "";
$returnSkills = isset($_SESSION['returnSkills']) ? $_SESSION['returnSkills'] : "";
$returnjobRef = isset($_SESSION['returnjobRef']) ? $_SESSION['returnjobRef'] : "";
// Now you can use these variables in your target form as needed

?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=divice-width, intial-scale=1">
    <?php
    require('./fragment/seo.php');
    require('./fragment/library.php');
    ?>
</head>

<body>
    <!-- begin nav bar header-->
    <header>
        <?php
        require('./fragment/navbar.php');
        ?>
    </header>
    <!-- end nav bar header-->
    <br>
    <br>
    <br>
    <br>
    <br>
    <br>
    <section class="H1">
        <h1 id="hh1">Apply Information</h1>
        <h2>Please enter the information below:</h2>
    </section>
    <br>
    <br>
    <!-- apply -->
    <form action="./processEOI.php?ref_num=<?=$_GET['jobref']?>" method="post">
        <fieldset>
            <!-- Personal Details -->
            <legend>Personal Details</legend>
            <p>Name</p>
            <p><label for="givenname"></label>
                <input type="text" name="givenname" id="givenname" placeholder="First" />
                <label for="middlename"></label>
                <input type="text" name="middlename" id="middlename" placeholder="Middle" />
                <label for="familyname"></label>
                <input type="text" name="familyname" id="familyname" placeholder="Last" />
            </p>

            <!-- Display validation message for Name -->

            <?php if (!empty($resultName) && is_string($resultName)): ?>
                <span class="error" id="errorMessage_Name" style="color: red;">
                    <?php echo $resultName;
                    unset($_SESSION['resultName']); ?>
                </span>
            <?php endif; ?>

            <p>Date of birth</p>
            <p><label for="dateofbirth"></label>
                <input type="text" name="dateofbirth" id="dateofbirth">
            </p>

            <!-- Display validation message for DOB -->
            <?php if (!empty($resultDob) && is_string($resultDob)): ?>
                <span class="error" id="errorMessage_DOB" style="color: red;">
                    <?php echo $resultDob;
                    unset($_SESSION['resultDob']); ?>
                </span>
            <?php endif; ?>

            <p>Email</p>
            <p><label for="email"></label>
                <input type="text" name="email" id="email" placeholder="example@">
            </p>

            <!-- Display validation message for Email -->
            <?php if (!empty($resultEmail) && is_string($resultEmail)): ?>
                <span class="error" id="errorMessage_Email" style="color: red;">
                    <?php echo $resultEmail;
                    unset($_SESSION['resultEmail']); ?>
                </span>
            <?php endif; ?>

            <p>Phone number</p>
            <p><label for="phonenum"></label>
                <input type="text" name="phonenum" id="phonenum">
            </p>

            <!-- Display validation message for Phone -->
            <?php if (!empty($returnPhone) && is_string($returnPhone)): ?>
                <span class="error" id="errorMessage_Phone" style="color: red;">
                    <?php echo $returnPhone;
                    unset($_SESSION['returnPhone']); ?>
                </span>
            <?php endif; ?>

            <fieldset>
                <legend>Sex</legend>
                <p><label for="male">Male</label>
                    <input type="radio" name="gen" value="Male">
                </p>
                <p><label for="female">Female</label>
                    <input type="radio" name="gen" value="Female">
                </p>

                <!-- Display validation message for Gender -->
                <?php if (!empty($resultGender) && is_string($resultGender)): ?>
                    <span class="error" id="errorMessage_Gender" style="color: red;">
                        <?php echo $resultGender;
                        unset($_SESSION['resultGender']); ?>
                    </span>
                <?php endif; ?>

                <!---End Personal Details--->
            </fieldset>
            <fieldset>
                <!---Address--->
                <legend>Address</legend>
                <p>Street</p>
                <p>
                    <input type="text" name="street" id="street">
                </p>
                <p>Suburb/town</p>
                <p>
                    <input type="text" name="sub_t" id="sub_t">
                </p>

                <!-- Display validation message for Street -->
                <?php if (!empty($resultStreetSurtown) && is_string($resultStreetSurtown)): ?>
                    <span class="error" id="errorMessage_StreetSurtown" style="color: red;">
                        <?php echo $resultStreetSurtown;
                        unset($_SESSION['resultStreetSurtown']); ?>
                    </span>
                <?php endif; ?>

                <p>State</p>
                <p>
                    <select name="state" id="state">
                        <option value="0">Please Select</option>
                        <option value="vic">VIC</option>
                        <option value="nsw">NSW</option>
                        <option value="qld">QLD</option>
                        <option value="nt">NT</option>
                        <option value="wa">WA</option>
                        <option value="sa">SA</option>
                        <option value="tas">TAS</option>
                        <option value="act">ACT</option>
                    </select>
                </p>

                <!-- Display validation message for State -->
                <?php if (!empty($resultState) && is_string($resultState)): ?>
                    <span class="error" id="errorMessage_State" style="color: red;">
                        <?php echo $resultState;
                        unset($_SESSION['resultState']); ?>
                    </span>
                <?php endif; ?>

                <p>Postcode</p>
                <p>
                    <input type="text" name="postcode" id="postcode">
                </p>

                <!-- Display validation message for Postcode -->
                <?php if (!empty($postcodeErr) && is_string($postcodeErr)): ?>
                    <span class="error" id="errorMessage_Postcode" style="color: red;">
                        <?php echo $postcodeErr;
                        unset($_SESSION['postcodeErr']); ?>
                    </span>
                <?php endif; ?>


                <!---End Address--->
            </fieldset>
        </fieldset>
        <fieldset>
            <!---Jobs detail--->
            <legend>Job apply details</legend>
            <p>Reference number</p>
            <?php if (!empty($_GET['jobref'])): ?>
            <input type="text" value="<?=$_GET['jobref']?>" name="ref_num" readonly="readonly">
            <?php endif;?>
            <!-- <select name="ref_num" id="refnum" required>
                <option value="temp">Select Reference Number</option>
                <option value="1">WD567 - Web Developer</option>
                <option value="2">PR132 - Programmer</option>
            </select> -->

            <!-- Display validation message for Job reference -->
            <?php if (!empty($returnjobRef) && is_string($returnjobRef)): ?>
                <span class="error" id="errorMessage_jobRef" style="color: red;">
                    <?php echo $returnjobRef;
                    unset($_SESSION['returnjobRef']); ?>
                </span>
            <?php endif; ?>

            <fieldset>
                <legend>Skill required list</legend>
                <div id="checkboxes2">
                    <div class="control">
                        <input class="input" type="text" placeholder="Search" id="search" />
                        <span class="icon is-small is-left">
                            <span class="searchIcon"></span>
                        </span>
                    </div>
                    <?php foreach ($skills as $skill): ?>
                        <p>
                            <label for="skill<?= $skill['skill_id'] ?>" class="select_label">
                                <input type="checkbox" value="<?= $skill['skill_id'] ?>" name="skills[]"
                                    id="skill<?= $skill['skill_id'] ?>" />
                                <?= $skill['skillName'] ?>
                                <span class="select_label-icon"></span>
                            </label>
                        </p>
                    <?php endforeach; ?>


                </div>


                <!-- Display validation message for Job reference -->
                <?php if (!empty($returnSkills) && is_string($returnSkills)): ?>
                    <span class="error" id="errorMessage_Skills" style="color: red;">
                        <?php echo $returnSkills;
                        unset($_SESSION['returnSkills']); ?>
                    </span>
                <?php endif; ?>
                <!--- end Jobs detail--->

            </fieldset>
            <fieldset>
                <!---Other--->
                <legend>Other(optional)</legend>
                <textarea name="Other" id="Other" cols="100" rows="10"></textarea>
                <!---End Other--->
            </fieldset>
            <br>
            <input type="submit" value="APPLY">
        </fieldset>
    </form>
    <!--End Apply-->
    <footer>
        <?php
        require('./fragment/footer.php');
        ?>
    </footer>
    <script>
        const search = document.getElementById("search");
        const labels = document.querySelectorAll("#checkboxes2 > p > label");

        search.addEventListener("input", () => Array.from(labels).forEach((element) => element.style.display = element.childNodes[1].id.toLowerCase().includes(search.value.toLowerCase()) ? "inline" : "none"))
    </script>
</body>