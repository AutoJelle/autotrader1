<?php
$userrole = array("klant", "anon");
require_once("./security.php");

?>

<style>
    td {
        min-width: 100px;
    }
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">

            <h2>Uw bestelling</h2>
            <form role="form" action='index.php?content=betalenCheck' method='post'>
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


                $prijsMetKorting = NULL;
                $totaalPrijs = 0;

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
                                        echo "<META HTTP-EQUIV=\"refresh\" content=\"0;URL = 'index.php?content=betalen'\">";

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
                                            $totaalPrijs = $prijsMetKorting;
                                        }
                                    }
                                    echo "
                                            <td> ";
                                    if ($queryResult2->num_rows < 1) {
                                        $totaalPrijs += $row2['prijs'];
                                    }
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
                } else {
                    echo "Geen resultaten";
                }

                $date = date('Y-m-d');

                echo "<br>
                        <table class=\"table table - responsive\">
                         <thead>
                                <!--Kies tussen bezorgen of ophalen.-->
                         <tr>
                             <td>
                                    Kies tussen bezorgen of ophalen.
                                    <br>
                                    <br>
                             </td>
                             <td>
                                     <input type=\"radio\" name=\"bezorgenOfOphalen\" value=\"bezorgd\" required> Bezorgen<br>
                                     <input type=\"radio\" name=\"bezorgenOfOphalen\" value=\"opgehaalt\"> Ophalen<br>
                             </td>
                         </tr>
                         <tr><!--Datum kiezen-->
                             <td>
                                     Kies de gewenste datum waarop u uw bestelling wilt ontvangen of ophaalt(dd-mm-yyyy):
                             </td>
                             <td>
                                     <input type='date' class='form-control' name='geselecteerdeDatum' value='" . $date . "' min='" . date('Y-m-d') . "' max='" . date('Y-m-d', strtotime($date . ' + 2 months')) . "' required>
                                     
                             </td>
                         </tr>
                         ";
                //                Dit is voor de anonieme klant om zijn gegevens in te voeren
                if ($_SESSION['idKlant'] == 1) {
                    echo "
                                  <tr>
                                     <td>Betaalmethode:</td>
                                     <td>                            
                                     <div class=\"form-group\"><label class=\"control-label\" for=\"betaalMethodeKiezen\">Betaalmethode:</label>
                                            <select name=\"betaalMethodeKiezen\" class='form-control' required>
                                                <option value=\"iDeal\">Overschrijven</option>
                                            </select>
                                        </div>
                                    </td>
                                 </tr>
                                  <tr>
                                     <td>Volledige naam:</td>
                                     <td><div class=\"form-group\"><input class=\"form-control\" id=\"InputNaam\" name=\"naam\" placeholder=\"Volledige naam\" type=\"text\" required></div>                                     
                                 </tr>
                                  <tr>
                                     <td>Adres:</td>
                                     <td><div class=\"form-group\"><input class=\"form-control\" id=\"InputAdres\" name=\"adres\" placeholder=\"Adres\" type=\"text\" required></div></td>
                                 </tr>
                                  <tr>
                                     <td>Woonplaats:</td>
                                     <td><div class=\"form-group\"><input class=\"form-control\" id=\"InputWoonplaats\" name=\"woonplaats\" placeholder=\"Woonplaats\" type=\"text\" required></div></td>
                                  </tr>
                                  <tr>
                                     <td>E-mail adres:</td>
                                     <td><div class=\"form-group\"><input class=\"form-control\" id=\"InputEmail\" name=\"email\" placeholder=\"E-mail adres\" type=\"email\" required></div></td>
                                  </tr>
                             ";
                }
                echo "
                         </thead>
                     </table>
                     <!--Opmerkingen veld-->
                    <div class=\"form-group\"><label class=\"control-label\" for=\"comment\">Opmerkingen:</label>
                        <textarea class=\"form-control\" id=\"opmerking\" placeholder=\"Voer eventuele opmerkingen in.\" type=\"text\" name=\"comment\" rows=\"3\"></textarea>
                    </div>
                    
                     <input type='hidden' name='prijs' value='" . $totaalPrijs . "'/>
                     <input type='hidden' name='voertuigID' value='" . $voertuigID . "'/>
                     <input type='hidden' name='voertuigMerk' value='" . $voertuigMerk . "'/>
                     <input type='hidden' name='voertuigType' value='" . $voertuigType . "'/>
                     ";

                echo "<b>Totaalprijs: </b> &euro; " . number_format($totaalPrijs, 0, ',', '.') . "<br>";
                echo "<br><br>";
                echo " <input type='submit' class='btn btn-info' value='Volgende'>";
                echo "<a href='index.php?content=klantHomepage'><button type='button' class='btn btn-danger'>Annuleren</button></a>";
                $conn->close();
                ?>

            </form>
        </div>
    </div>
</div>