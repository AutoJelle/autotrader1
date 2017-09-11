<?php
$userrole = array("klant", "anon");
require_once("./security.php");
require_once("classes/LoginClass.php");
require_once("classes/BuyClass.php");
require_once("classes/SessionClass.php");

$servername = "mysql.hostinger.nl";
$username = "u533697936_root";
$password = "npmwbftg";
$dbname = "u533697936_autot";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


date_default_timezone_set('Europe/Amsterdam');
$time = date('H:i:s');

function check_time($t1, $t2, $tn)
{
    $t1 = +str_replace(":", "", $t1);
    $t2 = +str_replace(":", "", $t2);
    $tn = +str_replace(":", "", $tn);
    if ($t2 >= $t1) {
        return $t1 <= $tn && $tn < $t2;
    } else {
        return !($t2 <= $tn && $tn < $t1);
    }
}

$t1 = "00:00:00";
$t2 = "23:59:59";
$t0 = $time;

$actieVDDagShow = false;

if (isset($_POST['removeItemCart'])) {
    header("refresh:4;url=index.php?content=klantHomepage");
    echo "<h3 style='text-align: center;' >Item is uit de winkelmand verwijderd.</h3>";
    require_once("./classes/BuyClass.php");
    BuyClass::remove_item_winkelmand($_POST);

} else {
    ?>

    <style>
        td {
            min-width: 100px;
        }

        .btn {
            float: right;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>Winkelmand</h2></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="index.php?content=klantHomepage">Winkelmand</a></li>
                    <li><a href="index.php?content=mijnBestellingen">Mijn bestellingen</a></li>
                    <li><a href="index.php?content=mijnFavorieten">Mijn favorieten</a></li>
                    <li><a href="index.php?content=mijnAccountGegevens">Mijn account</a></li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php

                $prijsMetKorting = NULL;

                //Haal alle voertuigen van de klant uit de winkelmand
                $sql = "SELECT * FROM winkelmand WHERE idKlant = " . $_SESSION['idKlant'] . " ";
                $result = $conn->query($sql);

                //Als er resultaten zijn
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        //per resultaat, doe het onderstaande

                        //Select alles van actie waar het voertuig id het voertuig id uit de row is.
                        $query = "SELECT * FROM actie WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                        $queryResult = $conn->query($query);
                        $queryResult2 = $conn->query($query);

                        //Selecteer alle gegevens uit de voertuig tabel
                        $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                        $result2 = $conn->query($sql2);

                        //Zoek het merk bij het voertuig
                        $sql3 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                        $result3 = $conn->query($sql3);

                        //Zoek het type bij het voertuig
                        $sql4 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                        $result4 = $conn->query($sql4);

                        while ($row2 = $result2->fetch_assoc()) {
                            //Als het voertuig niet beschikbaar is, haal het uit de winkelmand en stuur de klant terug.
                            if ($row2['beschikbaar'] < 1) {


                                $countQuery = "SELECT COUNT(*) FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
                                $resultCount = $conn->query($countQuery);

                                BuyClass::remove_unavailable_item_winkelmand($row);


                                while ($rowCount = $resultCount->fetch_assoc()) {

                                    //Als de winkelmand leeg is, stuur de klant terug naar winkelmandpagina
                                    if ($rowCount['COUNT(*)'] < 2) {
                                        echo "<h2>Voertuig is niet meer beschikbaar en is verwijderd uit het winkelmandje. U wordt terug gestuurd.</h2>";
                                        echo "<META HTTP-EQUIV=\"refresh\" content=\"3;URL='index.php?content=klantHomepage'\">";
                                        //Als de winkelmand niet leeg is, refresh de pagina.
                                    } else if ($rowCount['COUNT(*)'] > 1) {
                                        echo "<script>alert('Voertuig is niet meer beschikbaar en is verwijderd uit het winkelmandje.')</script>";
                                        echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL = 'index.php?content=klantHomepage'\">";

                                    }
                                }
                            }
                            while ($row3 = $result3->fetch_assoc()) {
                                while ($row4 = $result4->fetch_assoc()) {
                                    //Laat alle gegevens van het voertuig zien.
                                    echo "  
                                                    <table class=\"table table - responsive\">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    Afbeelding:
                                                                </th>
                                                                <th>
                                                                    Merk:
                                                                </th>
                                                                <th>
                                                                    Model:
                                                                </th>
                                                                <th>
                                                                    Type:
                                                                </th>
                                                                <th>
                                                                    Prijs:
                                                                </th>
                                                                ";
                                    while ($queryRow = $queryResult->fetch_assoc()) {
                                        if ($queryResult->num_rows > 0) {
                                            echo "
                                                            <th>";
                                            //Als de actie van de dag bij het voertuig gaande is, laat dat zien.
                                            if ($queryRow['actieVanDeDag'] == 1) {
                                                if (check_time($t1, $t2, $t0)) {
                                                    if ((strtotime($queryRow['datum']) == strtotime('today'))) {
                                                        $actieVDDagShow = true;
                                                    }
                                                }
                                            }
                                            if ($actieVDDagShow) {
                                                echo "Actie van de dag!<br>";
                                            }
                                            echo "
                                                                Nieuwe prijs <br>(" . $queryRow['procentKorting'] . "% korting):
                                                            </th>
                                                        ";
                                        }
                                    }

                                    echo "
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <tr>
                                                        <td> <img style='margin-top: 5px;' width='100px' src=\"images/voertuigen/" . $row2["fotopad"] . "\" class=\"img-responsive\"> </td>
                                                        <td> " . $row3['merk'] . " </td>
                                                        <td> " . $row2['model'] . " </td>                                            
                                                        <td> " . $row4['type'] . " </td>
                                                        <td> " . number_format($row2['prijs'], 0, ',', '.') . " </td>
                                                    ";
                                    //Als er actie is, laat dat zien.
                                    while ($queryRow = $queryResult2->fetch_assoc()) {
                                        if ($queryResult2->num_rows > 0) {
                                            $prijsMetKorting = ((100 - $queryRow['procentKorting']) / 100) * $row2['prijs'];
                                            echo "
                                                        <td> " . number_format($prijsMetKorting, 0, ',', '.') . " </td>
                                                    ";
                                        }
                                    }
                                    echo "
                                                        <td>
                                                        <!--Knoppen om item te bekijken of om te verwijderen-->
                                                            <a href='index.php?content=voertuigPagina&idVoertuig=" . $row2["idVoertuig"] . "' target=\"_blank\"> <button type='button' class=\"btn btn-info\" name=''>Bekijk Item</button></a>
                                                            <form role=\"form\" action='' method='post'>
                                                                <input type='submit' class=\"btn btn-danger\" name='removeItemCart' value='Verwijder Item'>
                                                                <input type='hidden' class=\"btn btn-info\" name='idWinkelmand' value='" . $row['idWinkelmand'] . "'/>
                                                            </form>
                                                        </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                ";
                                }
                            }
                        }
                    }
                    //Knop om door te gaan met bestellen.
                    echo "
                        <form role='form' action='index.php?content=betalen' method='post'>
                            <input type='submit' style='float: none;' class='btn btn-info' name='betalen' value='Bestellen'>
                        </form><br>";
                } else {
                    echo "Geen resultaten in de winkelmand.";
                }
                $conn->close();

                ?>
            </div>
        </div>

    </div>
    <?php
}
?>



