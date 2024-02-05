<?php
// Database settings
$host = 'feenix-mariadb.swin.edu.au';
$dbname = 's104334842_db';
$user = 's104334842';
$pass = '@taoXincu17';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}
?>

