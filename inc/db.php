<?php
// code de connexion à la DB
$dsn = 'mysql:dbname=minicloud;host=localhost';
$user ='root';
$password ='';
$dbh = new PDO($dsn, $user, $password);
?>