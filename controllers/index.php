<?php
// Page accessible uniquement aux personnes connectées
include  "includes.php";
require_once('autoload.php');
require_once('./inc/db.php');
$fichier = file_get_contents('template/index.tpl');
$login = file_get_contents('template/login.tpl');

echo $login;
echo $fichier;

?>