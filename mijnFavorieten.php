<?php
$userrole = array("klant");
require_once("./security.php");

if (isset($_POST['removeItemCart'])) {
    header("refresh:4;url=index.php?content=mijnFavorieten");
    echo "<h3 style='text-align: center;' >Item is uit favorieten verwijderd.</h3>";
    require_once("./classes/VoertuigClass.php");
    VoertuigClass::remove_item_favorieten($_POST);

} else if (isset($_POST['addToCart'])) {
    header("refresh:4;url=index.php?content=klantHomepage");
    require_once("./classes/BuyClass.php");
    BuyClass::insert_winkelmanditem_database($_POST);
} else {
    ?>
    <style>
        td {
            min-width: 100px;
        }
    </style>
    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h2>Mijn Favorieten</h2></div>
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

                    $sql = "SELECT * FROM favoriete WHERE idKlant = " . $_SESSION['idKlant'] . " ";
                    $result = $conn->query($sql);
                    //                        echo $sql . "<br>";
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
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
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                <td> <img style='margin-top: 5px;' width='100px' src=\"images/voertuigen/" . $row2["fotopad"] . "\" class=\"img-responsive\"> </td>
                                                <td> " . $row3['merk'] . " </td>
                                                <td> " . $row2['model'] . " </td>                                            
                                                <td> " . $row4['type'] . " </td>
                                                <td> " . number_format($row2['prijs'], 0, ',', '.') . " </td>
                                                <td>
                                                    <a href='index.php?content=voertuigPagina&idVoertuig=" . $row2["idVoertuig"] . "' target=\"_blank\"> <button type='button' class=\"btn btn-info\" name=''>Bekijk Item</button></a>
                                                    <form role=\"form\" action='' method='post'>
                                                        <input type='submit' class=\"btn btn-danger\" name='removeItemCart' value='Verwijder Item'><br>
                                                        <input type='submit' class=\"btn btn-success\" name='addToCart' value='Toevoegen aan winkelmand'>
                                                        <input type='hidden' class=\"btn btn-info\" name='idVoertuig' value='" . $row2['idVoertuig'] . "'/>
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
                        echo "Geen resultaten in de favorieten.";
                    }
                    $conn->close();

                    ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>