<!DOCTYPE html>
<html>

<head>
    <meta charset="uft-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php
      require('./fragment/seo.php');
      require('./fragment/library.php');
    ?>    
<title>ERROR 404</title>
</head>
<body>
    <!-- begin nav bar header-->
    <header>
        <?php
        require('./fragment/navbar.php');
        ?>
    </header>
    <!-- end nav bar header-->
    <br><br><br><br>
    <!-- Info-->
    <section class="EH1">
        <h1 id="eh1">Uh!!!!!!!!</h1>
        <h2 id="go_back">Your not suppose to be here.</h2>
        <h2 id="go_back">Now lets take u back to the home page.</h2>
        <h2 id="go_back">Click the logo on the top left corner to go back to the home page.</a></h2>
        <h2 id="go_back">or this button below</h2>
        <a href="./index.php" class="button2">HOME</a>
        <br>
        <br>
        
    </section>
    <section id="container">
        <section class="steam" id="steam1"> </section>
        <section class="steam" id="steam2"> </section>
        <section class="steam" id="steam3"> </section>
        <section class="steam" id="steam4"> </section>
    
        <section id="cup">
            <section id="cup-body">
                <section id="cup-shade"></section>
            </section>
            <section id="cup-handle"></section>
        </section>
    
        <section id="saucer"></section>
    
        <section id="shadow"></section>
	<p>HERE'S A CUP OF TEA FOR THE TROUBLE.</p>
    </section>
    
    <!-- End Info-->
    <!-- footer -->
      <section class="footer">
        
      <?php include('./fragment/ackCountry.php')?>
      <?php include('./fragment/footerFourcolumns.php')?>
        
         <section class="clearfix"></section>
      </section>
    <!-- end footer -->
</body>