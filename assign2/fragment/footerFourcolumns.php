<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
global $pdo;
$query = "SELECT * FROM settings";
$stmtsettings = $pdo->prepare($query);
$stmtsettings->execute();
$row = $stmtsettings->fetch();
$thirdEmail = $row['thirdEmail'];
$secondEmail = $row['secondEmail'];
$firstEmail = $row['firstEmail'];

$fbUsername = $row['fbUsername'];
$twUsername = $row['twUsername'];
$lkUsername = $row['lkUsername'];
$ytUsername = $row['ytUsername'];
$insUsername = $row['insUsername'];
?>
<section class="footerContentWrapper">
    <section class="footer-col large-w-25 small-w-50 tiny-w-100 tt-l flt">
        <h3>
            <?= $row['name'] ?>
        </h3>
        <h4>
            <?= $row['cityName'] ?>
        </h4>
        <p>
            <?= $row['streetAddress'] ?>,
            <?= $row['subOrtown'] ?>,
            <?= $row['state'] ?>,
            <?= $row['postcode'] ?>
        </p>
        <a target="_blank" href="<?= $row['urlDirection'] ?>">Click for Direction</a>
    </section>
    <section class="footer-col large-w-25 small-w-50 tiny-w-100 tt-l flt">
        <h3>Pages</h3>
        <a href="./about.php">About Us</a>
        <a href="./jobs.php">Job</a>
        <a href="./enhancement.php">Enhancement</a>
    </section>
    <section class="footer-col large-w-25 small-w-50 tiny-w-100 tt-l flt" id="contact_info">
        <h3>Contact</h3>
        <a href="mailto:<?= $row['generalEmail'] ?>"> <i class="far fa-envelope-open"></i>Company email</a>
        <h4>Other email</h4>
        <?php if ($firstEmail != null): ?>
            <a href="mailto:<?= $row['firstEmail'] ?>"> <i class="far fa-envelope-open"></i>General
                email</a>
        <?php endif; ?>
        <?php if ($secondEmail != null): ?>
            <a href="mailto:<?= $row['secondEmail'] ?>"> <i class="far fa-envelope-open"></i>Second email</a>
        <?php endif; ?>
        <?php if ($thirdEmail != null): ?>
            <a href="mailto:<?= $row['thirdEmail'] ?>"> <i class="far fa-envelope-open"></i>Third email</a>
        <?php endif; ?>




    </section>
    <section class="footer-col large-w-25 small-w-50 tiny-w-100 tt-l flt">
        <h3>Social Media</h3>
        <section class="roundedSocialBtns">
        <?php if ($fbUsername != null): ?>
            <a class="socialBtn facebook" href="https://www.facebook.com/<?= $row['fbUsername'] ?>/"
                target="_blank"><i class="fab fa-facebook-f"></i></a>
            <?php endif; ?>
            <?php if ($twUsername != null): ?>
            <a class="socialBtn twitter" href="https://twitter.com/<?= $row['twUsername'] ?>" target="_blank"><i
                    class="fab fa-twitter"></i></a>
            <?php endif; ?>
            <?php if ($lkUsername != null): ?>
            <a class="socialBtn linkedin" href="https://www.linkedin.com/<?= $row['lkUsername'] ?>" target="_blank"><i
                    class="fab fa-linkedin"></i></a>
            <?php endif; ?>
            <?php if ($ytUsername != null): ?>
            <a class="socialBtn youtube" href="https://www.youtube.com/<?= $row['ytUsername'] ?>" target="_blank"><i
                    class="fab fa-youtube"></i></a>
            <?php endif; ?>
            <?php if ($insUsername != null): ?>
            <a class="socialBtn instagram" href="https://www.instagram.com/<?= $row['insUsername'] ?>"
                target="_blank"><i class="fab fa-instagram"></i></a>
            <?php endif; ?>
        </section>
    </section>
</section>