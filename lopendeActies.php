<?php
$userrole = array("verkoopleidster");
require_once("./security.php");

if (isset($_POST['removeItemCart'])) {
    header("refresh:4;url=index.php?content=lopendeActies");
    echo "<h3 style='text-align: center;' >Item is uit acties verwijderd.</h3>";
    require_once("./classes/ActieClass.php");
    ActieClass::remove_actie($_POST);

} else {
    ?>
    <style>
        td {
            min-width: 100px;
            max-width: 450px;
        }
    </style>
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h2>Lopende Acties</h2></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php?content=verkoopleidsterHomepage">Actie Starten</a></li>
                        <li><a href="index.php?content=lopendeActies">Lopende Acties</a></li>
                        <!--Wijzigingsopdracht Begin-->
                        <li><a href="index.php?content=actieVanDeDag">Start actie van de dag</a></li>
                        <!--Wijzigingsopdracht Eind-->
                    </ul>
                </div>
            </div>
            <div class="row">

                <div class="col-md-12">
                    <?php
                    require_once("classes/LoginClass.php");
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

                    $date = date('Y-m-d');

                    $sqlA = "SELECT * FROM actie";
                    $sql = "SELECT * FROM actie WHERE (datum >= CURDATE() AND beginDatum <= CURDATE()) OR actieVanDeDag = 1";
//                    echo $sql;
                    $resultA = $conn->query($sqlA);
                    $result = $conn->query($sql);

                    $prijsMetKorting = NULL;


                    //                        echo $sql . "<br>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            while ($rowA = $resultA->fetch_assoc()) {
                                if (strtotime($rowA['datum']) < strtotime('yesterday')) {
                                    $queryA = "DELETE FROM `actie` WHERE `idActie` = " . $rowA['idActie'] . " ";
                                    $conn->query($queryA);
//                                echo $query;
                                }
                            }

                            $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                            $result2 = $conn->query($sql2);
//                                echo $sql2;

                            $sql3 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                            $result3 = $conn->query($sql3);


                            $sql4 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                            $result4 = $conn->query($sql4);

                            while ($row2 = $result2->fetch_assoc()) {
                                while ($row3 = $result3->fetch_assoc()) {
                                    while ($row4 = $result4->fetch_assoc()) {

                                        $prijsMetKorting = ((100 - $row['procentKorting']) / 100) * $row2['prijs'];
                                        echo "  
                                            <table class=\"table table - responsive\">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            Afbeelding:
                                                        </th>
                                                        <th>
                                                            Voertuig:
                                                        </th>
                                                        <th>
                                                            Begindatum:
                                                        </th>
                                                        <th>
                                                            Einddatum:
                                                        </th>
                                                        <th>
                                                            Oude prijs:
                                                        </th>
                                                        <th>";
                                                        if($row['actieVanDeDag'] == 1){
                                                        echo "Actie van de dag!<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br>";
                                                        }
                                                            echo"
                                                            Nieuwe prijs <br>(" . $row['procentKorting'] . "% korting):
                                                        </th>
                                                        <th>
                                                            Beschrijving:
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody> 
                                                <tr>
                                                <td> <img style='margin-top: 5px;' width='100px' src=\"images/voertuigen/" . $row2["fotopad"] . "\" class=\"img-responsive\"> </td>
                                                <td> " . $row3['merk'] . " " . $row2['model'] . " " . $row2['bouwjaar'] . " </td>
                                        ";
                                        if($row['actieVanDeDag'] == 1){
                                            echo "<td>Niet van toepassing</td>";
                                        }else{
                                            echo "<td> " . $row['beginDatum'] . " </td>";
                                        }
                                        echo "
                                                <td> " . $row['datum'] . " </td>
                                                <td> " . number_format($row2['prijs'], 0, ',', '.') . " </td>
                                                <td> " . number_format($prijsMetKorting, 0, ',', '.') . " </td>
                                                <td> " . $row['beschrijving'] . " </td>
                                                <td>
                                                    <a href='index.php?content=actieVoertuigPagina&idVoertuig=" . $row2["idVoertuig"] . "' target=\"_blank\"> <button type='button' class=\"btn btn-info\" name=''>Bekijk Item</button></a>
                                                    <form role=\"form\" action='' method='post'>
                                                        <input type='submit' class=\"btn btn-danger\" name='removeItemCart' value='Verwijder Item'><br>
                                                        <input type='hidden' class=\"btn btn-info\" name='idVoertuig' value='" . $row2['idVoertuig'] . "'/>
                                                        <input type='hidden' class=\"btn btn-info\" name='idActie' value='" . $row['idActie'] . "'/>
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
                    } else {
                        echo "Geen lopende acties.";
                    }
                    $conn->close();

                    ?>
                </div>
            </div>
        </div>
    <?php
}
?>