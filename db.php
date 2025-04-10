<?php
$host = 'localhost';
<<<<<<< HEAD
$db = 'risti_db';
=======
$db = 'db_risti';
>>>>>>> b527b211405a4de6a1a89be4368e1d7172d29dd6
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
