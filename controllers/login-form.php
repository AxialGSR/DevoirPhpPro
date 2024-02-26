<?php
session_start();
// Page inaccessible si la personne est connecté
$fichier = file_get_contents('template/login.tpl');
echo $fichier;
require_once('../inc/db.php');
if(isset($_POST['submit']))
{   //vérification du remplissage des champs
    if( !empty($_POST['username']) && !empty($_POST['password'])){
        if(($_POST['username'] == $_SESSION['email'] && password_verify($_POST['password'],$_SESSION['Hpassword']) )){
            echo 'vous êtes connecté';
        }else{
            echo 'inconnu';
        }

    }
}
?>