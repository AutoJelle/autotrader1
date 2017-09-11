<?php
$userrole = array("admin", "verkoper");
require_once("./security.php");

?>
<?php

require_once("classes/VoertuigClass.php");
if (isset($_POST['removeVoertuig'])) {
    include('connect_db.php');

    VoertuigClass::delete_voertuig($_POST);

    header("refresh:4;url=index.php?content=" . $_SESSION['userrole'] . "Homepage");
    echo "<h3 style='text-align: center;' >Uw wijzigingen zijn verwerkt.</h3>";


} else {
    ?>
    <style>
        td {
            min-width: 100px;
        }

        .btn{
            float: right;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>Voertuig bekijken / verwijderen</h2></div>
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

        <row class="row">
            <div class="col-md-12">
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


    switch ($_SESSION['userrole']) {
        case 'admin':
                $sql = "SELECT * FROM voertuig";
            break;
        default:
                $sql = "SELECT * FROM voertuig WHERE idKlant = " . $_SESSION['idKlant'];
            break;
    }

    //                $sql = "SELECT * FROM voertuig";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                        $result2 = $conn->query($sql2);

                        $sql3 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                        $result3 = $conn->query($sql3);

                        $sql4 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                        $result4 = $conn->query($sql4);

                        while ($row2 = $result2->fetch_assoc()) {
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
                                                    <th>
                                                        Beschikbaar:
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <td> <img style='margin-top: 5px;' width='100px' src=\"images/voertuigen/" . $row2["fotopad"] . "\" class=\"img-responsive\"> </td>
                                            <td> " . $row3['merk'] . " </td>
                                            <td> " . $row2['model'] . " </td>                                            
                                            <td> " . $row4['type'] . " </td>
                                            <td> " . number_format($row2['prijs'], 0, ',', '.') . " </td>
                                            <td> ";
                                            if ($row2['beschikbaar'] == 1){
                                                echo "Ja";
                                            } else{
                                                echo "Nee";
                                            }
                                     echo " </td>
                                            <td>
                                                <form role=\"form\" action='' method='post'>
                                                    <a href='index.php?content=voertuigPagina&idVoertuig=" . $row["idVoertuig"] . "' target=\"_blank\"> <button type='button' style='float: right;' class=\"btn btn-info\" name=''>Bekijk voertuig</button></a><br>      
                                                    <input type='submit' class=\"btn btn-danger\" name='removeVoertuig' value='Verwijder Voertuig'>
                                                    <input type='hidden' class=\"btn btn-info\" name='idVoertuig' value='" . $row['idVoertuig'] . "'/>
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
                    echo "Geen resultaten.";
                }
                $conn->close();
                ?>

                <br><br>
            </div>
        </row>
    </div>
    <?php
}
?>