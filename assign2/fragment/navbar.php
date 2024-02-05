<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $pdo;
$query = "SELECT name FROM settings LIMIT 1";
$stmtNamecomp = $pdo->prepare($query);
$stmtNamecomp->execute();
$row = $stmtNamecomp->fetch();
?>
<!-- begin nav bar header-->
      <nav id="menu">
         <label for="tm" id="toggleMenu">Links Navigation <i class="fa fa-arrow-down" aria-hidden="true"></i></label>
         <input type="checkbox" id="tm">
         <ul class="mainMenu">
            <li>
               <h1 class="logo"><a href="./index.php"><?php echo $row['name'];?></a></h1>
            </li>
            <li><a href="./about.php">About</a></li>
            <li><a href="./jobs.php">Jobs</a></li>
            <?php if(!isset($_SESSION["user"]) || is_array($_SESSION["user"]) !== true) {?>
               <li><a href="./login.php">Login </a></li>
               <?php }else{?>
               <li><a href="./admin/manage.php">Manage</a></li>
               <?php }?>
            <li><a target="_blank" href="https://www.youtube.com/watch?v=VUbh9uMxzNA">Video</a></li>
            <li><a target="_blank" href="https://www.youtube.com/watch?v=YOBc6YKYlRQ">Video 2</a></li>
            <li><a href="#" class="aTagblock">More
                  <i class="fa fa-arrow-down" aria-hidden="true"></i></a>
               <label title="Toggling Drop-Down" class="dropIcon" for="sub-m1"><i class="fa fa-arrow-down"
                     aria-hidden="true"></i></label>

               <input type="checkbox" id="sub-m1">
               <!--the name in id tag from input needs to link the label with the same name in for-->
               <ul class="subMenu">
                  <li><a href="#contact_info">Contact</a></li>
                  <li><a href="./enhancements.php">Enhancement</a></li>
                  <li><a href="./enhancements2.php">Enhancement2</a></li>
               </ul>
            </li>
         </ul>
      </nav>
   <!-- end nav bar header-->