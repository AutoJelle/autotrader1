<?php
$userrole = array("klant", "verkoper", "admin", "baliemedewerker", "eigenaar");
require_once("./security.php");
?>

<?php

require_once("./classes/TypeClass.php");
if (isset($_POST['submit-type'])) {

    TypeClass::insert_type_into_database($_POST['type']);
    header("refresh:4;url=index.php?content=adminHomepage");
    echo "<h3 style='text-align: center;' >U heeft een nieuw type toegevoegd.</h3>";

} else {
    ?>

    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>Voertuigen beheren</h2></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <!--                <li><a href="index.php?content=adminHomepage">Admin homepage</a></li>-->
                    <li><a href="index.php?content=voertuigToevoegen">Voertuigen toevoegen</a></li>
                    <!--                    <li><a href="index.php?content=voertuigenBeheren">Voertuigen beheren</a></li>-->
                    <li><a href="index.php?content=verwijderVoertuig">Voertuigen verwijderen</a></li>
                    <li><a href="index.php?content=rolWijzigen">Gebruikerrol veranderen</a></li>
                    <li><a href="index.php?content=blokkeren">Gebruiker blokkeren</a></li>
                    <li><a href="index.php?content=gebruikerVerwijderen">Gebruiker verwijderen</a></li>
                    <li><a href="index.php?content=berichtenBekijken">Berichten bekijken</a></li>
                    <li><a href="index.php?content=merkToevoegen">Merk toevoegen</a></li>
<!--                    <li><a href="index.php?content=typeToevoegen">Type toevoegen</a></li>-->
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 text-left">
                <form role="form" action="" method="post">
                    <div class="form-group"><input class="form-control" name="type" placeholder="Type" type="text"></div>

                    <button type="submit" class="btn btn-primary" name="submit-type">Verzend</button>

                </form>
            </div>
        </div>
    </div>


    <?php
}
?>