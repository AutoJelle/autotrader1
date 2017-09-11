<?php
$userrole = array("admin", "verkoopleidster");
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

?>

<?php
if (isset($_POST['submit'])) {
    echo "<h3 style='text-align: center;' >Actie is aangemaakt.</h3>";
    header("refresh:5;url=index.php?content=verkoopleidsterHomepage");
    require_once("./classes/ActieClass.php");
    ActieClass::start_actie($_POST);
} else {

    $date = date('Y-m-d');
    $endDate = date('Y-m-d', strtotime("+ 2 day"));

    $sql = "SELECT * FROM voertuig ORDER BY idVoertuig DESC";
    $result = $conn->query($sql);
    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Verkoopleidster Pagina</h2>
                </div>
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
            <row class="row">
                <div class="col-md-12">
                    <h4>Actie starten</h4>
                </div>
                <form role="form" action='' method='post'>
                    <div class="form-group"><label class="control-label" for="voertuigKiezen">Voor welk voertuig is de actie?</label>
                        <select name="voertuigKiezen" class='form-control' required>
                            <?php
                            while ($row = mysqli_fetch_array($result)) {
                                $sql2 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN `merk` AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                                $result2 = $conn->query($sql2);

                                $sqlCount = "SELECT * FROM actie WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                                $resultCount = $conn->query($sqlCount);
                                if ($resultCount->num_rows > 0) {
                                    while ($row2 = mysqli_fetch_array($result2)) {

                                    }
                                } else {
                                    while ($row2 = mysqli_fetch_array($result2)) {
                                        echo "<option value='" . $row['idVoertuig'] . "'>" . $row2['merk'] . " " . $row['model'] . " " . $row['bouwjaar'] . "</option>";
                                    }
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <?php

                    echo "
                    <div class='form-group'>
                        <label class='control-label' for='geselecteerdeBeginDatum'> Kies de gewenste datum waarop de actie moet beginnen: </label>
                        <input type='date' class='form-control' name='geselecteerdeBeginDatum' value='" . $date . "' min='" . $date . "' required>
                    </div>
                    <div class='form-group'>
                        <label class='control-label' for='geselecteerdeDatum'> Kies de gewenste datum waarop de actie moet eindigen: </label>
                        <input type='date' class='form-control' name='geselecteerdeDatum' value='" . $endDate . "' min='" . $endDate . "' required>
                    </div>
                    ";
                    ?>
                    <div class="form-group">
                        <label class="control-label" for="beschrijving">Beschrijving:</label>
                        <textarea class="form-control" id="beschrijving" placeholder="Voer de beschrijving in" type="text" name="beschrijving" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="procentKorting"> Hoeveel procent korting: </label>
                        <input type='number' min="0" max="100" class='form-control' name='procentKorting' required>
                    </div>
                    <div class="form-group">
                        <input type='submit' class='btn btn-info' name='submit' value='Actie Aanmaken'>
                    </div>
                </form>
            </row>
        </div>
    </div>
    <?php
}
?>
