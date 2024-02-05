<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Including authentication check
    include './controller/authCheck.php';
//Role check
$_GET['roles'] = array(1, 2, 3, 5);
include './controller/authroleCheck.php';

//get role user 
$user = $_SESSION['user'];
$staffroles = $user["staffroles"];

// Including database connections
include_once __DIR__ . '/../settings.php';
if(isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);       // Convert to integer (basic sanitation)
    $status = intval($_GET['status']); // Convert to integer (basic sanitation)

    // Prepare and execute the update statement
    $stmt = $pdo->prepare("UPDATE `eoi` SET `status`=:status WHERE `EOInumber`=:id");
    $stmt->bindParam(':status', $status, PDO::PARAM_INT);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    // Optionally: Redirect to avoid form re-submission on refresh
    header('Location: '.$_SERVER['PHP_SELF']);
    exit;
}
$results = [];
try{
    global $pdo;
    //Display only for applicant
        $sqlApp = "SELECT e.EOInumber as eoiN, jd.refNum as refN, 
        CONCAT(e.firstName, ' ', IFNULL(e.middleName, ''), ' ', e.lastName) as appFuName, 
        e.email as email,
        jd.name as jobName,
        e.issued_date as isDate, 
        e.status as status 
        FROM `eoi` as e 
        LEFT JOIN jobDesc as jd ON e.jobDescId = jd.jobDescId
        WHERE e.email = :email";
        $stmtApp = $pdo->prepare($sqlApp);
        $stmtApp->bindValue(':email', $_SESSION["email"]);
        $stmtApp->execute();
        $resultsApp = $stmtApp->fetchAll(PDO::FETCH_ASSOC);

    //display only job reference, but group by it
    $sqlRef = "SELECT jd.refNum as refN FROM `eoi` as e 
    LEFT JOIN jobDesc as jd ON e.jobDescId = jd.jobDescId
    GROUP BY jd.refNum";
    $stmtRef = $pdo->prepare($sqlRef);
    $stmtRef->execute();
    $resultsRef = $stmtRef->fetchAll(PDO::FETCH_ASSOC);


    
        
    //displaying all
    $sql = "SELECT e.EOInumber as eoiN, jd.refNum as refN, 
            CONCAT(e.firstName, ' ', IFNULL(e.middleName, ''), ' ', e.lastName) as appFuName, 
            e.email as email,
            jd.name as jobName,
            e.issued_date as isDate, 
            e.status as status 
            FROM `eoi` as e 
            LEFT JOIN jobDesc as jd ON e.jobDescId = jd.jobDescId";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        if (!empty($_POST['job_reference']) && !empty($_POST['action'])) {
            $jobReference = $_POST['job_reference'];
            $action = $_POST['action'];
            // echo $jobReference;
            
            if ($action == "display") {
                // Code to display details based on job reference
                //select the table eoi with search
            $sql .= " WHERE jd.refNum LIKE :search";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search', '%' . $jobReference . '%');
        $stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } elseif ($action == "remove") {
                // Code to remove details based on job reference
                $sql = "DELETE eoi FROM eoi
                JOIN jobDesc ON eoi.jobDescId = jobDesc.jobDescId
                WHERE jobDesc.refNum = :jobRef";
        
        $stmt = $pdo->query($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } else {
            //select the table eoi
$stmt = $pdo->query($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }else{
//select the table eoi
$stmt = $pdo->query($sql);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

  
}catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Manage Recruitment</title>
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
            $action_page = "";
            require('./fragment/pageheaderAdmin.php');
            ?>

            <div class="page-content">

            <?php if($staffroles != 5):?>
                <div class="records table-responsive">

                    <div class="record-header">
                    <?php if($staffroles != 1):?>
                        <div class="add">
                        
                            <span>Job reference</span>
                            <!-- select job reference using database and php -->
                            <form action="./manage.php" method="post">
                                <select name="job_reference" id="job_reference">
                            <option value="" selected>Select Job Reference</option>
                                 <?php foreach ($resultsRef as $row): ?>
                                <option value="<?php echo htmlspecialchars($row['refN']); ?>">
                                 <?php echo htmlspecialchars($row['refN']); ?>
                            </option>
                                 <?php endforeach; ?>
                             </select>
    
                            <select name="action" id="action">
                                <option value="" selected>Select Proceed</option>
                                <option value="display">Display</option>
                                <option value="remove">Remove</option>
                            </select>
    
                        <button type="submit">Implement</button>
</form>

                        </div>
                        <?php endif;?>
                        <div class="browse">
                            <input type="text" id="manageInput" placeholder="Search" class="record-search"
                                onkeyup="manageFunction()">
                            <select name="" id="filterBy">
                                <option value="default" selected>Default</option>
                                <option value="job_reference">Job reference</option>
                                <option value="applicant">Applicant</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <table id="myTableLog" width="100%">
                            <thead>
                                <tr>
                                    <th>Job Reference</th>
                                    <th> APPLICANT</th>
                                    <th> ROLES</th>
                                    <th> ISSUED DATE</th>
                                    <th> Status </th>
                                    <th> ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($results)): ?>
                            <?php foreach ($results as $result): ?>
                                <tr>
                                    
                                    <td><?= $result['refN'] ?></td>
                                    <td>
                                        <div class="client">
                                            <div class="client-img bg-img"
                                                style="background-image: url(../images/3.jpeg)">
                                            </div>
                                            <div class="client-info">
                                                <h4><?= $result['appFuName'] ?></h4>
                                                <small><?= $result['email'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <?= $result['jobName'] ?>
                                    </td>
                                    <td>
                                    <?= $result['isDate'] ?>
                                    </td>
                                    <td>
                                    <?php
                                            switch ($result['status']) {
                                                case 0:
                                                    //echo applied
                                                    echo '<span class="s_applicant">Applied</span>';
                                                    break;
                                                case 1:
                                                    //echo processing
                                                    echo ' <span class="s_processing">Processing</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="s_interview_post_available">Interview</span>';
                                                    break;
                                                case 3:
                                                    //echo accepted
                                                    echo '<span class="s_accecpted_draft_out">Accepted</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="s_rejected_discontinuted">Rejected</span>';
                                                    break;
                                                default:
                                                    echo "Unknown Role";
                                            }
                                            ?>
                                    </td>
                                    <td>
                                        <div class="actions">
                                            <a class="buttonAtag" href="./profileApp.php?id=<?=$result['eoiN']?>"><span
                                                    class="las la-info-circle"></span></a>
                                                    <?php 
                                                    
                                                    if($staffroles == 3){
                                                        if ($result['status'] != 1) {  // Assuming 1 is the status you're checking against
                                                            ?> <span class="las la-question-circle" onclick="window.location.href='manage.php?id=<?=$result['eoiN']?>&status=1'"></span><?php
                                                            }
                                                            if ($result['status'] != 2) { 
                                                                ?> <span class="las la-eye" onclick="window.location.href='manage.php?id=<?=$result['eoiN']?>&status=2'"></span><?php
                                                                }
                                                            if ($result['status'] != 4) {
                                                                ?> <span class="las la-eye-slash" onclick="window.location.href='manage.php?id=<?=$result['eoiN']?>&status=4'"></span><?php
                                                                }
                                                    }
                                                    if($staffroles == 2){
                                                        if ($result['status'] != 3) {
                                                            ?> <span class="las la-envelope" onclick="window.location.href='manage.php?id=<?=$result['eoiN']?>&status=3'"></span><?php
                                                            }
                                                        if ($result['status'] != 4) {
                                                            ?> <span class="las la-eye-slash" onclick="window.location.href='manage.php?id=<?=$result['eoiN']?>&status=4'"></span><?php
                                                            }
                                                    }
                                                   
                                                    
                                                    
                                                    ?>
                                            
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
    <p>No records found</p>
<?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
                <?php endif;?>
            </div>

            <!-- Display another similar table, but for applicant only-->
            <?php if($staffroles == 5):?>
                <div class="records table-responsive">

                    <div class="record-header">

                        <div class="browse">
                            <input type="text" id="manageInput" placeholder="Search" class="record-search"
                                onkeyup="manageFunction()">
                            <select name="" id="filterBy">
                                <option value="default" selected>Default</option>
                                <option value="job_reference">Job reference</option>
                                <option value="applicant">Applicant</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <table id="myTableLog" width="100%">
                            <thead>
                                <tr>
                                    <th>Job Reference</th>
                                    <th> APPLICANT</th>
                                    <th> ROLES</th>
                                    <th> ISSUED DATE</th>
                                    <th> Status </th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if (!empty($resultsApp)): ?>
                            <?php foreach ($resultsApp as $result): ?>
                                <tr>
                                    
                                    <td><?= $result['refN'] ?></td>
                                    <td>
                                        <div class="client">
                                            <div class="client-img bg-img"
                                                style="background-image: url(../images/3.jpeg)">
                                            </div>
                                            <div class="client-info">
                                                <h4><?= $result['appFuName'] ?></h4>
                                                <small><?= $result['email'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                    <?= $result['jobName'] ?>
                                    </td>
                                    <td>
                                    <?= $result['isDate'] ?>
                                    </td>
                                    <td>
                                    <?php
                                            switch ($result['status']) {
                                                case 0:
                                                    //echo applied
                                                    echo '<span class="s_applicant">Applied</span>';
                                                    break;
                                                case 1:
                                                    //echo processing
                                                    echo ' <span class="s_processing">Processing</span>';
                                                    break;
                                                case 2:
                                                    echo '<span class="s_interview_post_available">Interview</span>';
                                                    break;
                                                case 3:
                                                    //echo accepted
                                                    echo '<span class="s_accecpted_draft_out">Accepted</span>';
                                                    break;
                                                case 4:
                                                    echo '<span class="s_rejected_discontinuted">Rejected</span>';
                                                    break;
                                                default:
                                                    echo "Unknown Role";
                                            }
                                            ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
    <p>No records found</p>
<?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            <?php endif?>

        </main>

    </div>
</body>

</html>
