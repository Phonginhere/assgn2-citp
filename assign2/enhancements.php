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
    <section class="enhanceBody">
 <!-- begin nav bar header-->
 <header>
        <?php
        require('./fragment/navbar.php');
        ?>
    </header>
   <!-- end nav bar header-->

    <!-- Begin side bar left -->

    <?php
        require('./fragment/navbarleftEnhance.php');
        require('./fragment/documentationEnhance.php');
        ?>

     <!-- End side bar left -->

    </section>
</body>

</html>