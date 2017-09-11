<?php
require_once("classes/LoginClass.php");
require_once("classes/SessionClass.php");

if (!empty($_POST['email']) && !empty($_POST['password'])) {
    // Als email/password combi bestaat en geactiveerd....
    if (LoginClass::check_if_email_password_exists($_POST['email'],
        MD5($_POST['password']),
        '1')
    ) {
echo "vardump 1: " . var_dump($_SESSION);
//        if($_SESSION['idKlant'] = 1){
//            $session->logout();
//        }

        $session->login(LoginClass::find_login_by_email_password($_POST['email'],
            MD5($_POST['password'])));

        switch ($_SESSION['userrole']) {
            case 'klant':
                header("location:index.php?content=klantHomepage");
                break;
            case 'verkoper':
                header("location:index.php?content=verkoperHomepage");
                break;
            case 'geblokkeerd':
                header("location:index.php?content=geblokkeerdHomepage");
                break;
            case 'admin':
                header("location:index.php?content=adminHomepage");
                break;
            case 'verkoopleidster':
                header("location:index.php?content=verkoopleidsterHomepage");
                break;
            default :
                header("location:index.php?content=autos");
        }
    } else {
        header("refresh:5;url=index.php?content=inloggen_Registreren");
        echo "<h3 style='text-align: center;' >Uw email/password combi bestaat niet of uw account is niet geactiveerd.</h3>";
    }
} else {
    header("refresh:5;url=index.php?content=inloggen_Registreren");
    echo "<h3 style='text-align: center;' >U heeft een van beide velden niet ingevuld, u wordt doorgestuurd naar de inlogpagina.</h3>";
}
?>