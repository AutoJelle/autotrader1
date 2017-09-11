<?php
$userrole = array("admin", "verkoper");
require_once("./security.php");

?>

<?php
require_once("classes/LoginClass.php");
//require_once("classes/BuyClass.php");
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
if (isset($_POST['create'])) {
    echo "<h3 style='text-align: center;' >Voertuig is toegevoegd aan database.</h3>";
    header("refresh:4;url=index.php?content=" . $_SESSION['userrole'] . "Homepage");

    require_once("./classes/VoertuigClass.php");
    VoertuigClass::insert_voertuig_database($_POST);

    $OptionMerk = $_POST['merkSelect'];
    $OptionType = $_POST['typeSelect'];
    VoertuigClass::insert_merk_voertuig($_POST);
    VoertuigClass::insert_type_voertuig($_POST);

//    if (!($OptionMerk == "")) {
//        $_POST['merkSelect'] = $_POST['merkSelect'];
//        VoertuigClass::insert_merk_voertuig($_POST);
//    }
//
//
//    if (!($OptionType == "")) {
//        $_POST['typeSelect'] = $_POST['typeSelect'];
//        VoertuigClass::insert_type_voertuig($_POST);
//    }

} else {

    ?>

    <div class="section">
        <div class="container">
            <div class="row">
                <div class="col-md-12"><h2>Voertuig toevoegen</h2></div>
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

            <form role='form' action='' method='post'>
                <div class='form-group'>
                    <label for='typeSelect'>Type voertuig:</label><br>
                    <select name='typeSelect' class='form-control' required>
                        <option value=""></option>
                        <?php

                        $sql = "SELECT DISTINCT `idType`, `type` FROM `type` ORDER BY `type` ASC";
                        $result = $conn->query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['idType'] . "'>" . $row['type'] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='merkSelect'>Merk:</label><br>
                    <select name='merkSelect' class='form-control' required>
                        <option value=""></option>
                        <?php

                        $sql = "SELECT DISTINCT idMerk, merk FROM merk ORDER BY merk ASC";
                        $result = $conn->query($sql);
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<option value='" . $row['idMerk'] . "'>" . $row['merk'] . "</option>";
                        }

                        ?>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='model'>Model:</label>
                    <input type='text' class='form-control' name='model' placeholder='Voer model in.' required>
                </div>
                <div class='form-group'>
                    <label for='fotopad'>Fotopad:</label>
<!--                    <input type='text' class='form-control' name='fotopad' placeholder='Voer fotopad in. (Bijvoorbeeld "volkswagenGolf.jpg")' required>-->
                    <input type="file" class='form-control' name='fotopad' name="image" required>
                </div>
                <div class='form-group'>
                    <label for='prijs'>Prijs:</label>
                    <input type='text' class='form-control' name='prijs' placeholder='Voer prijs in.' required>
                </div>
                <div class='form-group'>
                    <label for='bouwjaar'>Bouwjaar:</label>
                    <input type='text' maxlength="4" class='form-control' name='bouwjaar' placeholder='Voer bouwjaar in.' required>
                </div>
                <div class='form-group'>
                    <label for='kilometerstand'>Kilometerstand:</label>
                    <input type='text' class='form-control' name='kilometerstand' placeholder='Voer kilometerstand in (volledig).' required>
                </div>
                <div class='form-group'>
                    <label for='brandstof'>Brandstof:</label>
<!--                    <input type='text' class='form-control' name='brandstof' placeholder='Voer brandstof in.' required>-->
                    <select name='brandstof' class='form-control' required>
                        <option value="Diesel">Diesel</option>
                        <option value="Benzine">Benzine</option>
                        <option value="LPG">LPG</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='schakeling'>Schakeling:</label>
                    <!--                    <input type='text' class='form-control' name='schakeling' placeholder='Voer schakeling in.' required>-->
                    <select name='schakeling' class='form-control' required>
                        <option value="Handmatig">Handmatig</option>
                        <option value="Automatisch">Automatisch</option>
                    </select>
                </div>
                <div class='form-group'>
                    <label for='kleur'>Kleur:</label>
                    <input type='text' class='form-control' name='kleur' placeholder='Voer kleur in.' required>
                </div>
                <div class='form-group'>
                    <label for='kenteken'>Kenteken:</label>
                    <input type='text' class='form-control' name='kenteken' placeholder='Voer kenteken in (bijvoorbeeld "AB-12-CD" of "ABC-12-D").' required>
                </div>
                <div class='form-group'>
                    <label for='aantalDeuren'>Aantal deuren:</label>
                    <input type='number' class='form-control' name='aantalDeuren' placeholder='Voer aantal deuren in.' required>
                </div>
                <div class='form-group'>
                    <label for='aantalZitplaatsen'>Aantal zitplaatsen:</label>
                    <input type='number' class='form-control' name='aantalZitplaatsen' placeholder='Voer aantal zitplaatsen in.' required>
                </div>
                <div class='form-group'>
                    <label for='milieu'>Milieu Label (A-F):</label>
                    <input type='text' class='form-control' name='milieu' placeholder='Voer milieu in.' required>
                </div>
                <div class='form-group'>
                    <label for='veiligheidsklasse'>Veiligheidsklasse (1-10):</label>
                    <input type='text' class='form-control' name='veiligheidsklasse' placeholder='Voer veiligheidsklasse in.' required>
                </div>
                <div class='form-group'>
                    <label for='lengte'>Lengte (Meter):</label>
                    <input type='text' class='form-control' name='lengte' placeholder='Voer lengte in.' required>
                </div>
                <div class='form-group'>
                    <label for='breedte'>Breedte (Meter):</label>
                    <input type='text' class='form-control' name='breedte' placeholder='Voer breedte in.' required>
                </div>
                <div class='form-group'>
                    <label for='hoogte'>Hoogte (Meter):</label>
                    <input type='text' class='form-control' name='hoogte' placeholder='Voer hoogte in.' required>
                </div>
                <div class='form-group'>
                    <label for='gewicht'>Gewicht (Kilogram):</label>
                    <input type='text' class='form-control' name='gewicht' placeholder='Voer gewicht in.' required>
                </div>
                <div class='form-group'>
                    <label for='versnellingen'>Versnellingen:</label>
                    <input type='text' class='form-control' name='versnellingen' placeholder='Voer versnellingen in.' required>
                </div>
                <button type='submit' name='create' class='btn btn-default'>Submit</button>

            </form>
        </div>
    </div>
    <?php
}
?>

