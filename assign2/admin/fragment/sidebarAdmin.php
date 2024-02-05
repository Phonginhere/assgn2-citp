<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
} 
// else {
//     echo "You are not logged in!";
// }

global $pdo;
$query = "SELECT name FROM settings LIMIT 1";
$stmtNamecomp = $pdo->prepare($query);
$stmtNamecomp->execute();
$row = $stmtNamecomp->fetch();
if($row) {
    $value = $row['name'];

    // Split the string as required
    $firstLetter = substr($value, 0, 1);
    $rest = substr($value, 1);

    // Display it in the wanted format
?>
<link rel="stylesheet" href="../styles/popup.css">
<input type="checkbox" id="menu-toggle">
<div class="sidebar">
    <div class="side-header">
        <?php echo "<h3>{$firstLetter}<span>{$rest}</span></h3>";}?>
    </div>

    <div class="side-content">
        <div class="profile">
            <h4><?=$user['fullname']?></h4>
            <small><?php
            switch ($user['staffroles']) {
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
            ?></small>
        </div>
        <div class="side-menu">
            <ul>
                <li>
                    <a href="<?php
                    if ($name_file != 'manage.php')
                        echo './manage.php';
                    else
                        echo '#' ?>" <?php if ($name_file == 'manage.php')
                        echo 'class="active"'; ?>>
                        <span class="las la-home"></span>
                        <small>Dashboard</small>
                    </a>
                </li>

                <li>
                    <a href="<?php
                    if ($name_file != 'staffManager.php' && $name_file != 'edit_staff.php' && $name_file != 'profileStf.php')
                        echo './staffManager.php';
                    else
                        echo '#' ?>" <?php if ($name_file == 'staffManager.php' || $name_file == 'profileStf.php' || $name_file == 'edit_staff.php')
                        echo 'class="active"'; ?>>
                        <span class="las la-user-friends"></span>
                        <small>Staff Manager</small>
                    </a>
                </li>
                <li>
                    <a href="<?php
                    if ($name_file != 'profile.php')
                        echo './profile.php';
                    else
                        echo '#' ?>" <?php if ($name_file == 'profile.php')
                        echo 'class="active"'; ?>>
                        <span class="las la-user-alt"></span>
                        <small>Profile</small>
                    </a>
                </li>
                <li>
                    <a href="<?php
                    if ($name_file != 'manage_list_job.php' && $name_file != 'edit_skill.php' && $name_file != 'edit_job_description.php' && $name_file != 'profileJobdesc.php')
                        echo './manage_list_job.php';
                    else
                        echo '#' ?>" <?php if ($name_file == 'manage_list_job.php' || $name_file == 'edit_skill.php' || $name_file == 'edit_job_description.php' || $name_file == 'profileJobdesc.php')
                        echo 'class="active"'; ?>>
                        <span class="las la-clipboard-list"></span>
                        <small>Job Description</small>
                    </a>
                </li>
                <li>
                    <a href="<?php
                    if ($name_file != 'settingsAdmin.php')
                        echo './settingsAdmin.php';
                    else
                        echo '#' ?>" <?php if ($name_file == 'settingsAdmin.php')
                        echo 'class="active"'; ?>>
                        <span class="las la-cog"></span>
                        <small>Settings</small>
                    </a>
                </li>
                <li>
                    <a target="_blank" href="../../assign2">
                        <span class="las la-home"></span>
                        <small>Applicant View</small>
                    </a>
                </li>
            </ul>
            
        </div>
        
    </div>
</div>