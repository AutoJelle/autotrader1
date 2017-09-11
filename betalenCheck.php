<?php
$userrole = array("klant", "anon");
require_once("./security.php");

?>

<?php
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


?>

<?php
if (isset($_POST['clearCart'])) {

    header("refresh:5;url=index.php?content=klantHomepage");
    require_once("./classes/BuyClass.php");
    require_once("./classes/ActieClass.php");
    if (!ActieClass::kan_klant_artikel_van_de_dag_kopen($_POST)) {
        echo "<h3 style='text-align: center;' >De bestelling is niet uitgevoerd omdat er geen exemplaren meer zijn of u heeft er al een gekocht.</h3><br><br>";
    } else {
        echo "<h3 style='text-align: center;' >Uw gegevens zijn verwerkt. Bedankt voor uw bestelling</h3><br><br>";
        ActieClass::koop_artikel_van_de_dag($_POST);
        //Stop gegevens in de database
        BuyClass::insert_bestelling_database($_POST);
        //Leeg de winkelmand
        BuyClass::clear_winkelmand($_POST);
        //Zet de opmerking in de database.
        BuyClass::insert_opmerking_into_database($_POST);
    }
} else {

    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!--printknop-->
                <div style="float: right;" onclick="window.print();" class="printButton">
                    <a href="" target="_blank" class="btn btn-success btn-lg">
                        <span class="glyphicon glyphicon-print"></span> Print
                    </a>
                </div>
                <form role="form" action='' method='post'>
                    <!--overzicht-->
                    <h2>Overzicht van uw bestelling:</h2>
                    <?php
                    $totaalPrijs = 0;

                    $query = "SELECT * FROM login WHERE idKlant = " . $_SESSION['idKlant'] . " ";
                    $queryResultA = $conn->query($query);


                    $sql = "SELECT * FROM winkelmand WHERE idKlant = " . $_SESSION['idKlant'] . " ";
                    $result = $conn->query($sql);

                    //                echo $query . "<br>";

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {

                            $query = "SELECT * FROM actie WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                            $queryResult = $conn->query($query);
                            $queryResult2 = $conn->query($query);

                            $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                            $result2 = $conn->query($sql2);

                            $sql3 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                            $result3 = $conn->query($sql3);

                            $sql4 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                            $result4 = $conn->query($sql4);

                            while ($row2 = $result2->fetch_assoc()) {
                                if ($row2['beschikbaar'] < 1) {

                                    $countQuery = "SELECT COUNT(*) FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
                                    $resultCount = $conn->query($countQuery);

                                    BuyClass::remove_unavailable_item_winkelmand($row);


                                    while ($rowCount = $resultCount->fetch_assoc()) {

                                        if ($rowCount['COUNT(*)'] < 2) {
                                            echo "<h2>Voertuig is niet meer beschikbaar en is verwijderd uit het winkelmandje. U wordt terug gestuurd.</h2>";
                                            echo "<META HTTP-EQUIV=\"refresh\" content=\"3;URL='index.php?content=klantHomepage'\">";

                                        } else if ($rowCount['COUNT(*)'] > 1) {
                                            echo "<h2>Voertuig is niet meer beschikbaar en is verwijderd uit het winkelmandje. U wordt terug gestuurd.</h2>";
                                            echo "<META HTTP-EQUIV=\"refresh\" content=\"3;URL = 'index.php?content=klantHomepage'\">";
                                        }
                                    }
                                }
                                while ($row3 = $result3->fetch_assoc()) {
                                    while ($row4 = $result4->fetch_assoc()) {
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
                                            <td> " . number_format($row2['prijs'], 0, ',', '.') . " </td>";
                                        while ($queryRow = $queryResult2->fetch_assoc()) {
                                            if ($queryResult2->num_rows > 0) {
                                                $prijsMetKorting = ((100 - $queryRow['procentKorting']) / 100) * $row2['prijs'];
                                                echo "
                                                        <td> " . number_format($prijsMetKorting, 0, ',', '.') . " </td>
                                                    ";
                                            }
                                        }
                                        echo "
                                            <td> ";

                                        $totaalPrijs += $row2['prijs'];
                                        echo "  </td>
                                            <td>
                                                <a href='index.php?content=voertuigPagina&idVoertuig=" . $row2["idVoertuig"] . "' target=\"_blank\"> <button type='button' style='float: right;' class=\"btn btn-info\" name=''>Bekijk Item</button></a>                                                    
                                            </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        ";

                                        $voertuigID = $row2['idVoertuig'];
                                        $voertuigMerk = $row3['merk'];
                                        $voertuigType = $row4['type'];
                                    }
                                }
                            }
                        }
                    }

                    $betaalMethodeA = "";
                    while ($rowQuery = $queryResultA->fetch_assoc()) {
                        $betaalMethodeA = $rowQuery['betaalMethode'];
                    }

                    //Overzicht van gegevens.
                    echo "<br>Totaal prijs: &euro; " . number_format($_POST['prijs'], 0, ',', '.') . "<br>";
                    echo "geselecteerdeDatum: " . $_POST['geselecteerdeDatum'] . "<br>";
                    echo "Het voertuig wordt " . $_POST['bezorgenOfOphalen'] . ".<br>";
//                    echo "asdadadadasdasdasdasdasdasd: " . $_SESSION['idKlant'];
                    if ($_SESSION['idKlant'] == 1) {
                        echo "Uw naam: " . $_POST['naam'] . "<br>";
                        echo "Uw adres: " . $_POST['adres'] . "<br>";
                        echo "Uw woonplaats: " . $_POST['woonplaats'] . "<br>";
                        echo "Uw email: " . $_POST['email'] . "<br>";
                        echo "Betaalmethode: Overschrijven<br>";
                        $betaalMethodeA = $_POST['betaalMethodeKiezen'];
                    }
                    if ($_SESSION['idKlant'] != 1) {
                        echo "Betaalmethode: " . $betaalMethodeA . "<br>";
                    }
                    echo "Opmerkingen: <br>" . $_POST['comment'] . "<br><br>";

                    //Stop gegevens in variabelen
                    $totaleprijsA = $_POST['prijs'];
                    $geselecteerdeDatumA = $_POST['geselecteerdeDatum'];
                    $bezorgenOfOphalenA = $_POST['bezorgenOfOphalen'];
                    $opmerkingenA = $_POST['comment'];

                    if ($_SESSION['idKlant'] == 1) {
                        $naamA = $_POST['naam'];
                        $adresA = $_POST['adres'];
                        $woonplaatsA = $_POST['woonplaats'];
                        $emailA = $_POST['email'];
                        echo "<input type='hidden' name='naam' value='" . $_POST['naam'] . "'/>";
                        echo "<input type='hidden' name='adres' value='" . $_POST['adres'] . "'/>";
                        echo "<input type='hidden' name='woonplaats' value='" . $_POST['woonplaats'] . "'/>";
                        echo "<input type='hidden' name='email' value='" . $_POST['email'] . "'/>";
//                        echo $_POST['email'];
                    }

                    echo "<input type='hidden' name='totalePrijsB' value='" . $totaleprijsA . "'/>";
                    echo "<input type='hidden' name='geselecteerdeDatumB' value='" . $geselecteerdeDatumA . "'/>";
                    echo "<input type='hidden' name='bezorgenOfOphalenB' value='" . $bezorgenOfOphalenA . "'/>";
                    echo "<input type='hidden' name='betaalMethodeB' value='" . $betaalMethodeA . "'/>";
                    echo "<input type='hidden' name='opmerkingenB' value='" . $opmerkingenA . "'/>";
                    echo "<input type='hidden' name='voertuigIDB' value='" . $voertuigID . "'/>";
                    echo "<input type='hidden' name='voertuigMerkB' value='" . $voertuigMerk . "'/>";
                    echo "<input type='hidden' name='voertuigTypeB' value='" . $voertuigType . "'/>";

                    if ($_SESSION['idKlant'] == 1) {
                        echo "<input type='hidden' name='naamB' value='" . $naamA . "'/>";
                        echo "<input type='hidden' name='adresB' value='" . $adresA . "'/>";
                        echo "<input type='hidden' name='woonplaatsB' value='" . $woonplaatsA . "'/>";
                        echo "<input type='hidden' name='emailB' value='" . $emailA . "'/>";
                    }
                    //Verstuur gegevens naar class
                    echo "<input type='submit' class='btn btn-info' name='clearCart' value='Betalen'>";
                    echo "<a href='index.php?content=klantHomepage'><button type='button' class='btn btn-danger'>Annuleren</button></a>";

                    ?>
                </form>
            </div>
        </div>
    </div>
    <?php
}
?>