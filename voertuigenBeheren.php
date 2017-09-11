<?php
$userrole = array("admin", "verkoper");
require_once("./security.php");

?>

<?php

require_once("classes/LoginClass.php");
require_once("classes/VoertuigClass.php");
if (isset($_POST['submit'])) {

    VoertuigClass::wijzig_gegevens_voertuig($_POST);

    header("refresh:4;url=index.php?content=adminHomepage");
    echo "<h3 style='text-align: center;' >Uw wijzigingen zijn verwerkt.</h3>";


} else {
    ?>

<div class="section">
    <div class="container">
    <div class="row">
        <div class="col-md-12"><h2>Voertuigen beheren</h2></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
                <li><a href="index.php?content=adminHomepage">Admin homepage</a></li>
                <li><a href="index.php?content=voertuigToevoegen">Voertuigen toevoegen</a></li>
<!--                <li><a href="index.php?content=voertuigenBeheren">Voertuigen beheren</a></li>-->
                <li><a href="index.php?content=verwijderVoertuig">Voertuigen verwijderen</a></li>
                <li><a href="index.php?content=rolWijzigen">Gebruikerrol veranderen</a></li>
                <li><a href="index.php?content=blokkeren">Gebruiker blokkeren</a></li>
                <li><a href="index.php?content=gebruikerVerwijderen">Gebruiker verwijderen</a></li>
                <li><a href="index.php?content=berichtenBekijken">Berichten bekijken</a></li>
            </ul>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <?php
            require_once("classes/LoginClass.php");
//            require_once("classes/BuyClass.php");
            require_once("classes/SessionClass.php");

$servername = "mysql.hostinger.nl";
                $username = "u533697936_root";
                $password = "npmwbftg";
                $dbname = "u533697936_autot";

            // Create connection
            $conn = new mysqli($servername, $username, $password, $dbname);
            $conn2 = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if ($conn2->connect_error) {
                die("Connection failed: " . $conn2->connect_error);
            }
            $sql = "SELECT * FROM voertuig WHERE idVoertuig = " . $_GET['idVoertuig'] . " ";
            echo $sql;
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <form role=\"form\" action=\"\" method=\"post\">
                        <div class=\"form-group\"><label class=\"control-label\" for=\"titel\">Titel<br></label>
                            <input class=\"form-control\" id=\"titel\" placeholder=\"Titel\" type=\"text\" name=\"titel\" value='" . $row['titel'] . "' required></div>
                        <div class=\"form-group\"><label class=\"control-label\" for=\"beschrijving\">Beschrijving<br></label>
                            <input class=\"form-control\" id=\"beschrijving\" placeholder=\"Beschrijving\" type=\"text\" name=\"beschrijving\" value='" . $row['beschrijving'] . "' required></div>
                        <div class=\"form-group\"><label class=\"control-label\" for=\"fotopad\">Fotopad<br></label>
                            <input class=\"form-control\" id=\"fotopad\" placeholder=\"Fotopad\" type=\"text\" name=\"fotopad\" value='" . $row['fotopad'] . "' required></div>
                        <div class=\"form-group\"><label class=\"control-label\" for=\"prijs\">Prijs<br></label>
                            <input class=\"form-control\" id=\"prijs\" placeholder=\"Prijs\" type=\"text\" name=\"prijs\" value='" . $row['prijs'] . "' required></div>
                        <div class=\"form-group\"><label class=\"control-label\" for=\"aantalBeschikbaar\">Aantal Beschikbaar</label>
                            <input class=\"form-control\" id=\"aantalBeschikbaar\" placeholder=\"Aantal Beschikbaar\" type=\"text\" name=\"aantalBeschikbaar\" value='" . $row['aantalBeschikbaar'] . "' required></div>
                        <input type='hidden' name='idvanvid' value='" . $row['idVideo'] . "'/>
                        <button type=\"submit\" class=\"btn btn-default\" name=\"submit\">Verzend</button>
                    </form><br><hr>";

                }

            } else {
                echo "Geen resultaten";
            }
            $conn->close();
            ?>
        </div>
    </div>
    <?php
}
?>