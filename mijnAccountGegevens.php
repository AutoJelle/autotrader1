<?php
$userrole = array("klant");
require_once("./security.php");

require_once("classes/LoginClass.php");
if (isset($_POST['submit'])) {
    include('connect_db.php');

    $sql = "UPDATE	`login` 
			                 SET 		`naam`		=	'" . $_POST['naam'] . "',
						                `adres`	= 	'" . $_POST['adres'] . "',
						                `woonplaats`	= 	'" . $_POST['woonplaats'] . "'
			                 WHERE	`idKlant`			=	'" . $_SESSION['idKlant'] . "';";

    //echo $sql;
    $database->fire_query($sql);
    //$result = mysqli_query($connection, $sql);

    header("refresh:4;url=index.php?content=mijnAccountGegevens");
    echo "<h3 style='text-align: center;' >Uw wijzigingen zijn verwerkt.</h3>";
    LoginClass::insert_actie_keuze($_SESSION['idKlant'], $_POST['actieKeuzeKiezen']);



} else {
    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h1>Wijzig gegevens</h1></div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <ul class="breadcrumb">
                        <li><a href="index.php?content=mijnAccountGegevens">Gegevens Aanpassen</a></li>
                        <li><a href="index.php?content=wijzig_wachtwoord">Wachtwoord Veranderen</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
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
                    $sql2 = "SELECT `naam`, `adres`, `woonplaats` FROM `login` WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
                    $result = $conn->query($sql2);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<form role=\"form\" action=\"index.php?content=mijnAccountGegevens\" method=\"post\">
                                    <div class=\"form-group\"><label class=\"control-label\" for=\"naam\">Naam<br></label>
                                        <input class=\"form-control\" id=\"naam\" placeholder=\"Naam\" type=\"text\" name=\"naam\" value='" . $row['naam'] . "' required></div>
                                    <div class=\"form-group\"><label class=\"control-label\" for=\"adres\">Adres<br></label>
                                        <input class=\"form-control\" id=\"adres\" placeholder=\"Adres\" type=\"text\" name=\"adres\" value='" . $row['adres'] . "' required></div>
                                    <div class=\"form-group\"><label class=\"control-label\" for=\"woonplaats\">Woonplaats</label>
                                        <input class=\"form-control\" id=\"woonplaats\" placeholder=\"Woonplaats\" type=\"text\" name=\"woonplaats\" value='" . $row['woonplaats'] . "' required></div>    
                                    <div class=\"form-group\"><label class=\"control-label\" for=\"actieKeuzeKiezen\">Wilt u meedoen aan speciale acties?</label>
                                        <br><input type=\"radio\" name=\"actieKeuzeKiezen\" value=\"1\"> Ja
                                        <br><input type=\"radio\" name=\"actieKeuzeKiezen\" value=\"0\"> Nee
                                    </div>
                    <button type=\"submit\" class=\"btn btn-default\" name=\"submit\">Verzend</button>
                </form>";
                        }
                    } else {
                        echo "Geen resultaten";
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