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

    global $pdo;

    try {
        $stmt = $pdo->query("SELECT * FROM `jobDesc` WHERE `jobDescId` = " . $_GET['id']);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (PDOException $e) {
        echo 'Error fetching data: ' . $e->getMessage();
        return [];
    }
}
$getInfoStaff = getInfoStaff();


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Info Staff</title>
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

                <fieldset>

                    <legend>
                        Personal
                    </legend>


                    <div class="box">
                        <label for="firstname">
                            First name:
                        </label>
                        <input type="text" name="firstname" id="firstname"
                            value="<?= $getInfoStaff['staffLname'] ?>" disabled>
                    </div>

                    <div class="box">
                        <label for="lastname">
                            Last name:
                        </label>
                        <input type="text" name="lastname" id="lastname"
                            value="<?= $getInfoStaff['staffLname'] ?>" disabled>

                    </div>


                    <div class="box">
                        <label for="nickname">
                            Nick name:
                        </label>
                        <input type="text" name="nickname" id="nickname"
                            value="<?= $getInfoStaff['staffNname'] ?>" disabled>

                    </div>

                    <div class="box">
                        <label for="email">
                            E-mail:
                        </label>
                        <input type="email" name="emailAdd" id="email"
                            value="<?= $getInfoStaff['email'] ?>" disabled>
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
                        <input type="text" name="phonenum" id="phonenum" 
                            value="<?= $getInfoStaff['phoneNum'] ?>" disabled>
                    </div>

                    <div class="box">

                        <label for="telenum">
                            Telephone Number:
                        </label>
                        <input type="text" name="telenum" id="telenum"
                            value="<?= $getInfoStaff['telephoneNum'] ?>" disabled>
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

                        <select name="roles" id="staffRoles" disabled>
                            <option value="n" <?= ($getInfoStaff['staffRoles'] == 'n' ? 'selected' : '') ?>>Please Select
                            </option>
                            <option value="1" <?= ($getInfoStaff['staffRoles'] == '1' ? 'selected' : '') ?>>Admin
                            </option>
                            <option value="2" <?= ($getInfoStaff['staffRoles'] == '2' ? 'selected' : '') ?>>Manager
                            </option>
                            <option value="3" <?= ($getInfoStaff['staffRoles'] == '3' ? 'selected' : '') ?>>HR</option>
                            <option value="4" <?= ($getInfoStaff['staffRoles'] == '4' ? 'selected' : '') ?>>Leader
                            <option value="5" <?= ($getInfoStaff['staffRoles'] == '5' ? 'selected' : '') ?>>Applicant
                            </option>
                        </select>
                    </div>

                    <div class="box">
                        <label for="website">
                            Status:
                        </label>



                        <select name="status" id="staffStatus" disabled>
                <option value="n" 
                
                <?= ($getInfoStaff['staffStatus'] == 'n' ? 'selected' : '') ?>
                
                >Choose it!</option>
                <option value="1" 
                
                <?= ($getInfoStaff['staffStatus'] == '1' ? 'selected' : '') ?>
                
                >Enabled</option>
                <option value="2" 
                
                <?= ($getInfoStaff['staffStatus'] == '2' ? 'selected' : '') ?>
                
                >Disabled</option>
              </select>

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