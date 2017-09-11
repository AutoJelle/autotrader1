<?php
$userrole = array("klant");
require_once("./security.php");

?>
<style>
    td{
        min-width: 100px;
    }
</style>
<div class="section">
    <div class="container">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h2>Mijn Bestellingen</h2></div>
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
                $sql = "SELECT * FROM bestelling WHERE `idKlant` = " . $_SESSION['idKlant'] . " ORDER BY `idBestelling` DESC";
                $result = $conn->query($sql);

                //echo $sql . "<br>";


                if ($result->num_rows > 0) {

                    while ($row = $result->fetch_assoc()) {
                        $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                        $result2 = $conn->query($sql2);

                        //echo $sql2 . "<br>";

                        while ($row2 = $result2->fetch_assoc()) {
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
                                    <td> " . $row['voertuigMerk'] . " </td>
                                    <td> " . $row2['model'] . " </td>
                                    <td> " . $row['voertuigType'] . " </td>
                                    <td> " . number_format($row['prijs'], 0, ',', '.') . " </td>
                                    <td>
                                        <a href='index.php?content=voertuigPagina&idVoertuig=" . $row["idVoertuig"] . "' target=\"_blank\"> <button type='button' class=\"btn btn-info\" name=''>Bekijk Item</button></a>
                                    </td>
                                </tr>
                                </tbody>
                                </table>
                            ";
                        }
                    }
                } else {
                    echo "Geen resultaten in de winkelmand.";
                }
                $conn->close();
                ?>
            </div>
        </div>

    </div>
</div>