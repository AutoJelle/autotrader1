<?php
//session_start();
require_once("./classes/LoginClass.php");
require_once("./classes/SessionClass.php");

if (!isset($_SESSION['idKlant'])) {
//    var_dump($_SESSION);
//    header("refresh:5;url=index.php?content=inloggen_Registreren");
//    echo "<head><style>body{overflow-y: hidden;}</style></head><h3 style='text-align: center;' >U bent niet ingelogd en daarom niet bevoegd om deze pagina te bekijken. U wordt teruggestuurd naar de loginpagina.</h3>";
} else
    if (LoginClass::check_if_geblokkeerd($_SESSION['idKlant'])) {
        if (!isset($_SESSION['idKlant'])) {
            //var_dump($_SESSION);
//            header("refresh:5;url=index.php?content=inloggen_Registreren");
//            echo "<h3 style='text-align: center;' >U bent niet ingelogd en daarom niet bevoegd om deze pagina te bekijken. U wordt teruggestuurd naar de loginpagina.</h3>";
            exit();
        } else if (!(in_array($_SESSION['userrole'], $userrole))) {
            if(!isset($_SESSION['idKlant']) || $_SESSION['idKlant'] == 1){
                header("refresh:5;url=index.php?content=klantHomepage");
            } else{
                header("refresh:5;url=index.php?content=" . $_SESSION['userrole'] . "Homepage");
            }
            if($_SESSION['idKlant'] == 1) {
                echo "<h3 style='text-align: center;' >U bent niet ingelogd en kunt daarom niet deze pagina bekijken. U wordt teruggestuurd naar uw homepagina.</h3>";
            }else{
                echo "<h3 style='text-align: center;' >U heeft niet de rechten om deze pagina te bekijken. U wordt teruggestuurd naar uw homepagina.</h3>";
            }
            exit();
        } else {
        }
    } else {
        header("refresh:20;url=index.php?content=logout");
        echo "<h3 style='text-align: center;' >U bent geblokkeerd, neem contact op met: beheer@autotrader.nl om de blokkade op te heffen</h3>";

        exit();
    }
?>