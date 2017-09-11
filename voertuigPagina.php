<?php
//    if (!isset($_SESSION['idKlant'])) {
//        header("refresh:5;url=index.php?content=inloggen_Registreren");
//        echo "<h3 style='text-align: center;' >U bent niet ingelogd. U wordt doorgestuurd naar de loginpagina.</h3>";
//    }
//    else{
        $userrole = array("klant", "admin", "verkoopleidster", "verkoper", "anon");
        require_once("./security.php");
        ?>


        <?php
        if (isset($_POST['submit'])) {
            header("refresh:4;url=index.php?content=klantHomepage");
            require_once("./classes/BuyClass.php");
            if (BuyClass::insert_winkelmanditem_database($_POST)){

            }
        } else if (isset($_POST['addFav'])) {
            echo "<h3 style='text-align: center;' >Item toegevoegd aan favorieten.</h3>";
            header("refresh:4;url=index.php?content=mijnFavorieten");
            require_once("./classes/VoertuigClass.php");
            VoertuigClass::voeg_favoriet_toe($_POST);
        } else {
            ?>

            <div class="container">
                <div class="row">
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

                    $voertuigMerk = NULL;

                    $idVoertuig = $_GET['idVoertuig'];
                    $sql = "SELECT * FROM `voertuig` WHERE `idVoertuig` = '" . $idVoertuig . "'";
                    $sql2 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN `merk` AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $idVoertuig . " ";
                    $sql3 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $idVoertuig . " ";

                    $result = $conn->query($sql);
                    $result2 = $conn->query($sql2);
                    $result3 = $conn->query($sql3);

                    while ($row2 = mysqli_fetch_array($result2)) {
                        $voertuigMerk = $row2['merk'];
                    }

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "
                        <div class=\"container\">
                            <h3>$voertuigMerk " . $row["model"] . " - " . $row['bouwjaar'] . "</h3>
                            <div>
                                <ul class=\"nav nav-tabs\"><!--
                                    <li class=\"active\"><a data-toggle=\"tab\" href=\"#home1\">Home</a></li>
                                    <li class=\"\"><a data-toggle=\"tab\" href=\"#specificaties\">Specificaties</a></li>
                                    <li class=\"\"><a data-toggle=\"tab\" href=\"#kosten\">Kosten</a></li>
                                    <li class=\"\"><a data-toggle=\"tab\" href=\"#historieEnReviews\">Historie & Reviews</a></li>-->
                                </ul>
                                <div class=\"tab-content\">
                                    <div id=\"home1\" class=\"tab-pane fade in active\">
                                            <div class=\"row\">
                                                <div class=\"col-md-8\">
                                                    <img style='margin-top: 5px;' src=\"images/voertuigen/" . $row["fotopad"] . "\" class=\"img-responsive\">
                                                </div>
                                                <div class=\"col-md-4\">
                                                <h4><b>Prijs: </b> &euro; " . number_format($row["prijs"], 0, ',', '.') . " </h4>
                                                    <b>Kilometerstand: </b>" . $row["kilometerstand"] . " <br> 
                                                    <b>Brandstof: </b>" . $row["brandstof"] . " <br> 
                                                    <b>Schakeling: </b>" . $row["schakeling"] . " <br> 
                                                    <b>Kleur: </b>" . $row["kleur"] . " <br> 
                                                    <b>Kenteken: </b>" . $row["kenteken"] . " <br> 
                                                    <b>Aantal Deuren: </b>" . $row["aantalDeuren"] . " <br> 
                                                    <b>Aantal zitplaatsen: </b>" . $row["aantalZitplaatsen"] . " <br> 
                                                    <b>Milieu label: </b>" . $row["milieu"] . " <br> 
                                                    <b>Veiligheids Klasse: </b>" . $row["veiligheidsklasse"] . " <br> 
                                                    <b>Lengte: </b>" . $row["lengte"] . " <br> 
                                                    <b>Breedte: </b>" . $row["breedte"] . " <br> 
                                                    <b>Hoogte: </b>" . $row["hoogte"] . " <br> 
                                                    <b>Gewicht: </b>" . $row["gewicht"] . " <br> 
                                                    <b>Versnellingen: </b>" . $row["versnellingen"] . " <br> 
                                                    <br>
                                                    <form role = \"form\" action='' method='post'>
                                                        <input type='hidden' name='idVoertuig' value='" . $row['idVoertuig'] . "'/>
                                                        <input type='hidden' name='merk' value='" . $voertuigMerk . "'/>
                                                        <input type='hidden' name='prijs' value='" . $row['prijs'] . "'/>
                                                        ";
                            if ($row['beschikbaar'] != 0) {
                                echo "<button type='submit' name='submit' class='btn btn-info'>Toevoegen aan winkelmand</button><br><br>";
                            } else {
                                echo "<b>Dit voertuig is al verkocht.</b>";
                            }
                            echo "<button type='submit' name='addFav' class='btn btn-info'>Toevoegen aan favorieten</button><br>";
                            echo "
                                                    </form>
                                                </div>
                                            </div>
                                    </div>
                                    <div id=\"specificaties\" class=\"tab-pane fade\">
                                    </div>
                                    <div id=\"kosten\" class=\"tab-pane fade\">
                                    </div>
                                    <div id=\"historieEnReviews\" class=\"tab-pane fade\">
                                    </div>
                                </div>
                        </div>
                    ";
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