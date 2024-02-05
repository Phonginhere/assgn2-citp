<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Including database connections
include_once __DIR__ . '/../settings.php';

// Including authentication check
    include './controller/authCheck.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Admin | Unauthorized Access</title>
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

                <div class="card">
                    <h3>Unauthorized Access</h3>
                    <p>You are not authorized to access this page.</p>
                    <p>Please contact the administrator for more information.</p>

            </div>

        </main>

    </div>
</body>

</html>
