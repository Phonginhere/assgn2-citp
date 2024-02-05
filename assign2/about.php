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

    <!--begin first section body-->
    <!--begin banner-->
    <?php
    require('./fragment/bannerAbout.php');
    ?>
    <!-- end banner -->
    <!-- end first section body -->
    <hr>

    <!--second  body-->
    <!--Begin Our team-->

    <?php
    require('./fragment/teamDetail.php');
    ?>

    <!--End Our team-->
    <!--end our team section body-->

    <!-- footer -->
    <footer>
   <?php
      require('./fragment/footer.php');
      ?>
   </footer>
    <!-- end footer -->
</body>

</html>