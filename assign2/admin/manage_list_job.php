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
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']); // Convert to integer (basic sanitation)
    $status = intval($_GET['status']); // Convert to integer (basic sanitation)

    // Prepare and execute the update statement
    $stmt = $pdo->prepare("UPDATE `jobDesc` SET `status`=:status WHERE `jobDescId`=:id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Optionally: Redirect to avoid form re-submission on refresh
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}
try {
    // Prepare the SQL statement.

    global $pdo;

    $stmt = $pdo->prepare("SELECT * FROM skill");
    $stmt->execute();

    // Fetch all the data.
    $skills = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $stmtJobDesc = $pdo->prepare("SELECT jobDescId, concat(s.staffFname, ' ', s.staffLname) AS staffName, s.email as sEmail, name, refNum, 
    concat(minSala, '-', maxSala) as rangeSala, 
    concat(m.staffFname, ' ',  m.staffLname) AS leaderName, status FROM jobDesc jd
    LEFT JOIN staff s ON jd.staffId = s.staffId 
    LEFT JOIN staff m ON jd.reportTo = m.staffId");
    $stmtJobDesc->execute();

    // Fetch all the data.
    $jobDescs = $stmtJobDesc->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Manage List Job Description</title>
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
                            <button><a href="./edit_job_description.php?actionPage=Adding">Add record</a></button>

                        </div>



                        <div class="browse">
                            <input type="search" id="manageInput" placeholder="Search" class="record-search"
                                onkeyup="manageljobFunction()">
                            <select name="" id="filterlJob">
                                <option value="default" selected>Default</option>
                                <option value="jobRef">Job reference</option>
                                <option value="staff">Staff</option>
                                <option value="roles">Roles</option>
                                <option value="issuedDate">Issued Date</option>
                                <option value="status">Status</option>
                            </select>
                            <!-- <input type="submit" id="" name="" value="Find"></input> -->
                        </div>
                    </div>

                    <div>
                        <table id="myTableljob" width="100%">
                            <thead>
                                <tr>

                                    <th> JOB REFERENCE</th>
                                    <th> CREATED BY</th>
                                    <th>JOB NAME </th>
                                    <th> Min and Max Salary ($)</th>
                                    <th> Leader</th>
                                    <th> STATUS </th>
                                    <th> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($jobDescs as $jobDesc): ?>
                                    <tr>

                                        <td>
                                            <?= $jobDesc['refNum'] ?>
                                        </td>
                                        <td>
                                            <div class="client">

                                                <div class="client-info">
                                                    <h4>
                                                        <?= htmlspecialchars(isset($jobDesc['staffName']) ? $jobDesc['staffName'] : '', ENT_QUOTES, 'UTF-8');?>
                                                    </h4>
                                                    <small>
                                                        <?= htmlspecialchars($jobDesc['sEmail'] ? $jobDesc['sEmail'] : '', ENT_QUOTES, 'UTF-8') ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($jobDesc['name']) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($jobDesc['rangeSala']) ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($jobDesc['leaderName']) ?>
                                        </td>
                                        <td>
                                            <?php
                                            switch ($jobDesc['status']) {
                                                case 0:
                                                    echo ' <span class="s_rejected_discontinuted">Discontinued</span>';
                                                    break;
                                                case 1:
                                                    echo '<span class="s_interview_post_available">Available</span>';
                                                    break;
                                                // case 2:
                                                //     echo ' <span class="s_processing">Out</span>';
                                                //     break;
                                                default:
                                                    echo "Unknown Role";
                                            }
                                            ?>

                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a class="buttonAtag"
                                                    href="./profileJobdesc.php?id=<?= $jobDesc['jobDescId'] ?>"><span
                                                        class="las la-info-circle"></span></a>
                                                <a
                                                    href="./edit_job_description.php?actionPage=Editing&id=<?= $jobDesc['jobDescId'] ?>"><span
                                                        class="las la-edit"></span></a>
                                                <?php
                                                if ($jobDesc['status'] != 0) { // Assuming 1 is the status you're checking against
                                                    ?> <span class="las la-trash"
                                                        onclick="window.location.href='manage_list_job.php?id=<?= $jobDesc['jobDescId'] ?>&status=0'"></span>
                                                    <?php
                                                }
                                                if ($jobDesc['status'] != 1) {
                                                    ?> <span class="las la-eye"
                                                        onclick="window.location.href='manage_list_job.php?id=<?= $jobDesc['jobDescId'] ?>&status=1'"></span>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            </tbody>
                        </table>
                    </div>

                </div>




            </div>

            <div class="page-header">
                <h1>Skills</h1>
                <small>Display table</small>
            </div>
            <div class="page-content">

                <div class="records table-responsive">

                    <div class="record-header">
                        <div class="add">
                            <button><a href="./edit_skill.php?actionPage=Adding">Add record</a></button>
                        </div>



                        <div class="browse">
                            <input type="search" id="manageInputSk" placeholder="Search" class="record-search"
                                onkeyup="managelSkillsFunction()">
                            <select name="" id="filterSkills">
                                <option value="default" selected>Default</option>
                                <option value="skills">Skills</option>
                            </select>
                            <!-- <input type="submit" id="" name="" value="Find"></input> -->
                        </div>
                    </div>

                    <div>
                        <table id="myTableskills" width="100%">
                            <thead>
                                <tr>

                                    <th>SKILLS</th>
                                    <th>ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($skills as $skill): ?>
                                    <tr>

                                        <td>
                                            <?= $skill['skillName'] ?>
                                        </td>
                                        <td>
                                            <div class="actions">
                                                <a href="./edit_skill.php?actionPage=Editing&id=<?= $skill['skill_id'] ?>"><span
                                                        class="las la-tools"></span></a>
                                                <a href="./controller/delete_record.php?actionPage=skills&id=<?= $skill['skill_id'] ?>"><span
                                                        class="las la-trash-alt"></span></a>
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