<?php
// Page inaccessible si la personne est connecté
$file = file_get_contents('template/register.tpl');
echo $file;
require_once('../inc/db.php');
if(isset($_POST['submit']))
{   //vérification du remplissage des champs
    if( !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['confirm-password'])){
        //vérification de l'égalité des mots de passes
        if($_POST['password'] === $_POST['confirm-password']){
            // si ok récupération des variables
            $email = $dbh->quote($_POST['email']);
            $password = $dbh->quote($_POST['password']);
            $Hpassword = password_hash($password,PASSWORD_ARGON2I);

            // contrôle si email exite
            $sql = $dbh->prepare("SELECT * FROM utilisateurs WHERE email = :email LIMIT 1");
                $sql->bindValue(':email',$email,PDO::PARAM_STR);

                $sql->execute();
                if($sql->rowCount()==0){
                    // si 0 mail identique  récréation d'un nouvelle ID et création d'une session
                    $_SESSION['email'] = $_POST['email'];
                    $_SESSION['Hpassword'] = $Hpassword;
                     
                 $Sql = $dbh->prepare("INSERT INTO utilisateurs SET
                            email = $email,
                            password = $Hpassword
                             ");
                if ( $Sql->execute() ) {
                    echo 'mémorisé';
                    //envoie du mail
                    include '../phpmailer.php';
                    require '../vendor/autoload.php';

                    //Create an instance; passing `true` enables exceptions
                    $mail = new PHPMailer(true);

                    try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output Montre le code a l'envoie
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'dwwm2324.fr';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'contact@dwwm2324.fr';                     //SMTP username
                    $mail->Password   = 'm%]E5p2%o]yc';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('from@example.com', 'gilles');
                    $mail->addAddress($_POST['email'],$_POST['nom']);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');

                    //Attachments
                    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    // $mail->addAttachment('drone-shot.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Mail de confirmation';
                    $mail->Body    = '<h2>Bonjour</h2>
                    <p>Pour valider votre inscription cliquer sur le lien ci-dessous :</p>
                    <p><a href="http://localhost/confirmation.php?cle=[CLE]">http://localhost/confirmation.php?cle=[CLE]</a></p>
                    <p>Merci de votre confiance</p>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                    } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    }

                }else{
                    echo 'email déja existant';
                }
    
        }else{
        echo 'mot passe différent';
        }
    }else{
        echo'remplir les champs';
    }
}
}
?>