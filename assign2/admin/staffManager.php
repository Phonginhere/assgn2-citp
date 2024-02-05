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
if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);       // Convert to integer (basic sanitation)
    $status = intval($_GET['status']); // Convert to integer (basic sanitation)

    // Prepare and execute the update statement for status at staff table
    global $pdo;
    $stmt = $pdo->prepare("UPDATE `staff` SET `staffStatus`=:status WHERE `staffId`=:id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Optionally: Redirect to avoid form re-submission on refresh
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}

try {
    // Prepare the SQL statement.

    global $pdo;

    $stmt = $pdo->prepare("SELECT staffId, staffFname, staffLname, email, staffRoles, staffStatus, addedDate FROM staff");
    $stmt->execute();

    // Fetch all the data.
    $staffs = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Manage Staff page</title>
    <?php
    require('./fragment/libraryDisplay.php');
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

                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            <button><a href="./edit_staff.php?actionPage=Adding">Add record</a></button>
                        </div>



                        <div class="browse">
                            <input type="text" id="manageInput" placeholder="Search" class="record-search"
                                onkeyup="managestaffFunction()">
                            <select name="" id="filterStaff">
                                <option value="default" selected>Default</option>
                                <option value="name">Name</option>
                                <option value="roles">Roles</option>
                                <option value="status">Status</option>
                                <option value="added_date">Added Date</option>
                            </select>
                            <!-- <input type="submit" id="" name="" value="Find"></input> -->
                        </div>
                    </div>

                    <div>
                        <table id="myTable" width="100%">
                            <thead>
                                <tr>

                                    <th> Name</th>
                                    <th> ROLES</th>
                                    <th> STATUS</th>
                                    <th> ADDED DATE</th>
                                    <th> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($staffs as $staff): ?>
                                    <tr>

                                        <td>
                                            <div class="client">
                                                <div class="client-img bg-img"
                                                    style="background-image: url(../images/3.jpeg)"></div>
                                                <div class="client-info">
                                                    <h4>
                                                        <?= $staff['staffFname'] . ' ' . $staff['staffLname'] ?>
                                                    </h4>
                                                    <small>
                                                        <?= $staff['email'] ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($staff['staffRoles']) {
                                                case 1:
                                                    echo "Admin";
                                                    break;
                                                case 2:
                                                    echo "Manager";
                                                    break;
                                                case 3:
                                                    echo "HR";
                                                    break;
                                                case 4:
                                                    echo "Leader";
                                                    break;
                                                case 5:
                                                    echo "Applicant";
                                                    break;
                                                default:
                                                    echo "Unknown Role";
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($staff['staffStatus'] == 1) {
                                                echo '<span class="s_interview_post_available">Enable</span>';
                                            } else {
                                                echo '<span class="s_rejected_discontinuted">Disabled</span>';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?= $staff['addedDate'] ?>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a class="buttonAtag"
                                                    href="./profileStf.php?id=<?= $staff['staffId'] ?>"><span
                                                        class="las la-info-circle"></span></a>

                                                <?php
                                                if ($staff['staffId'] != 1) {
                                                    ?>
                                                    <a href="./edit_staff.php?actionPage=Editing&id=<?= $staff['staffId'] ?>"><span
                                                            class="las la-tools"></span></a>
                                                            <?php 
                                                    if ($staff['staffStatus'] != 1) {  // Assuming 1 is the status you're checking against
                                                    ?> <span class="las la-user-check" onclick="window.location.href='staffManager.php?id=<?=$staff['staffId']?>&status=1'"></span><?php
                                                    }
                                                    if ($staff['staffStatus'] != 0) { 
                                                    ?> <span class="las la-user-slash" onclick="window.location.href='staffManager.php?id=<?=$staff['staffId']?>&status=0'"></span><?php
                                                    }
                                                    ?>
                                                <?php } ?>

                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                </div>


            </div>

        </main>

    </div>
</body>

</html>