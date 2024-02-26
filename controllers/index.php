<?php
// Page accessible uniquement aux personnes connectées
require_once('autoload.php');
require_once('../inc/db.php;')
$fichier = file_get_contents('template/index.tpl');
echo $fichier;
?>