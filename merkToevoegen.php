<?php
$userrole = array("verkoper", "admin");
require_once("./security.php");
?>

<?php

require_once("./classes/MerkClass.php");
if (isset($_POST['submit-merk'])) {

    MerkClass::insert_merk_into_database($_POST['merk']);
    header("refresh:4;url=index.php?content=" . $_SESSION['userrole'] . "Homepage");
    echo "<h3 style='text-align: center;' >U heeft een nieuw merk toegevoegd.</h3>";
} else {
    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h2>Merk toevoegen</h2></div>
            </div>
            <?php

            switch ($_SESSION['userrole']) {
                case 'admin':
                    echo "
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <ul class=\"breadcrumb\">
        <!--                        <li><a href=\"index.php?content=adminHomepage\">Admin homepage</a></li>-->
                                <li><a href=\"index.php?content=voertuigToevoegen\">Voertuigen toevoegen</a></li>
        <!--                        <li><a href=\"index.php?content=voertuigenBeheren\">Voertuigen beheren</a></li>-->
                                <li><a href=\"index.php?content=verwijderVoertuig\">Voertuigen verwijderen</a></li>
                                <li><a href=\"index.php?content=rolWijzigen\">Gebruikerrol veranderen</a></li>
                                <li><a href=\"index.php?content=blokkeren\">Gebruiker blokkeren</a></li>
                                <li><a href=\"index.php?content=gebruikerVerwijderen\">Gebruiker verwijderen</a></li>
                                <li><a href=\"index.php?content=berichtenBekijken\">Berichten bekijken</a></li>
                                <li><a href=\"index.php?content=merkToevoegen\">Merk toevoegen</a></li>
                                <!--<li><a href=\"index.php?content=typeToevoegen\">Type toevoegen</a></li>-->
                            </ul>
                        </div>
                    </div>
                    ";
                    break;
                default:
                    echo "
                    <div class=\"row\">
                        <div class=\"col-md-12\">
                            <ul class=\"breadcrumb\">
                                <li><a href=\"index.php?content=voertuigToevoegen\">Voertuigen toevoegen</a></li>
        <!--                        <li><a href=\"index.php?content=voertuigenBeheren\">Voertuigen beheren</a></li>-->
                                <li><a href=\"index.php?content=verwijderVoertuig\">Voertuigen bekijken / verwijderen</a></li>
                                <li><a href=\"index.php?content=merkToevoegen\">Merk toevoegen</a></li>
                            </ul>
                        </div>
                    </div>
                    ";
                    break;

            }

            ?>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-12 text-left">
                            <form role="form" action="" method="post">
                                <div class="form-group"><input class="form-control" name="merk" placeholder="Merk" type="text"></div>

                                <button type="submit" class="btn btn-primary" name="submit-merk">Verzend</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>


    <?php
}
?>