<?php
$dsn = 'mysql:dbname=**DATABASE**;host=localhost';
$user = '**USER**';
$password = '**PASSWORD**';

try {
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

?>
