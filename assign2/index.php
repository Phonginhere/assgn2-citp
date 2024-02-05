<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

   <?php 
      require('./fragment/bannerMainindex.php');
      require('./fragment/vidSectionindex.php');
      require('./fragment/sectionIndex.php');
      require('./fragment/photosSectionindex.php');
      require('./fragment/statisticSectionindex.php');
      require('./fragment/slideshowSectionindex.php');
   ?>

   <footer>
   <?php
      require('./fragment/footer.php');
      ?>
   </footer>
</body>

</html>