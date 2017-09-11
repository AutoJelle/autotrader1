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
    ActieClass::start_actie_vd_dag($_POST);
} else {

    date_default_timezone_set('Europe/Amsterdam');

    $date = date('Y-m-d');
    $actieDate = date('Y-m-d');

    $sql = "SELECT * FROM voertuig ORDER BY idVoertuig DESC";
    $result = $conn->query($sql);
    ?>

        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h2>Actie van de dag</h2>
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
                    <hr>
                    <h4>Wat is de actie van de dag?</h4>
                    <p> De actie van de dag is tussen 11 en 1 uur ’s middags goedkoper. De eerste koper krijgt 50%, de tweede koper 49%, etc.<br>
                        De koper krijgt te zien hoeveel korting hij/zij krijgt. Na 1 uur en voor 11 uur gelden de oude prijzen.<br>
                        De vorige actie van de dag wordt verwijderd bij het maken van een nieuwe actie van de dag.
                    </p>
                    <hr>
                    <h4>Actie van de dag starten</h4>
                </div>
                <form role="form" action='' method='post'>
                    <div class="form-group"><label class="control-label" for="voertuigKiezen">Voor welk voertuig is de actie van de dag?</label>
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
                        <label class='control-label' for='geselecteerdeDatum'> Kies de gewenste datum waarop de actie moet plaatsvinden: </label>
                        <input type='date' class='form-control' name='geselecteerdeDatum' value='" . $actieDate . "' min='" . $actieDate . "' required>
                    </div>
                    ";
                    ?>
                    <div class="form-group">
                        <label class="control-label" for="procentKorting"> Hoeveel procent korting: </label>
                        <input type='number' min="50" max="50" class='form-control' name='procentKorting' value="50" readonly required>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="beschrijving">Beschrijving:</label>
                        <textarea class="form-control" id="beschrijving" placeholder="Voer de beschrijving in" type="text" name="beschrijving" rows="3"></textarea>
                    </div>
                    <div class="form-group">
                        <input type='submit' class='btn btn-info' name='submit' value='Actie Aanmaken'>
                    </div>
                </form>
            </row>
        </div>
    <?php
}
?>



<!--TO DO MAAK DAT JE VOERTUIGEN VAKER DAN 1 KEER KAN BESTELLEN, DOE AANTALBESCHIKBAAR OMHOOG EN DOE BIJ DIE FUNCTIE DAT IE T OP 0 ZET, DAT IE MIN 1 DOET-->

<!--TO DO MOET DATUM SELECTEREN WEG?-->

<!--TO DO MAAK VELD OF TABEL ACTIE VAN DE DAG IN DATABASE, WAAR? VELD IS NU IN ACTIE, MISSCHIEN VELD IN VOERTUIG OF APARTE TABEL?-->

<!--TO DO TUSSEN 11 EN 13 UUR GELD DE KORTING-->
<!--TO DO KLANT KAN ACTIE VAN DE DAG MAAR 1 KEER BESTELLEN, SLA KLANTID OP NA BESTELLING EN CHECK BIJ BESTELLEN OF ID AL BESTAAT-->
<!--TO DO NA HET BESTELLEN ZORG DAT KORTING NIET MEER TE ZIEN IS-->
<!--TO DO EERSTE KLANT HEEFT 50% KORTING, VOLGENDE 49. SLA PROCENT KORTING OP IN TABEL EN HOEVAAK BESTELD EN DOE 1 PROCENT ERAF NA BESTELLING-->
<!--TO DO GEEF AANTAL KORTING WEER VOOR KLANT-->

<!--TO DO MAAK ZICHTBAAR VANAF VOORPAGINA-->

<!--TO DO BIJ MAKEN ACTIE DOE DAN KIJKEN SELECT ALLES UIT ACTIE ALS ID VOERTUIG ER IN ZIT, KAN NIET ACTIE MAKEN-->

<!--TO DO TOTAALPRIJS ONDER BETALEN (EN MISSCHIEN BETALENCHECK) ALS ER KORTING IS, DOE KORTING-->
<!--TO DO ANON GEBRUIKER KAN ACTIE VAN DE DAG OP VOORPAGINA ZIEN. MAG NIET-->

<!--TO DO MAKEN DAT JE MAAR EEN ARTIKEL VAN DE DAG KAN HEBBEN. ZORG DAT ALS JE EEN ACTIE MAAKT DAT IE DAN CHECKT OF ER AL EEN BESTAAT.-->
<!--https://nlmboutrecht-my.sharepoint.com/personal/hsok_mboutrecht_nl/Documents/E-mailbijlagen%201/Wijzigingsopdracht%20programmeren%202.pdf-->

<!--TODO MEERDERE EXEMPLAREN VAN EEN VOERTUIG MAKEN EN DAN ALS JE ER EEN KOOPT IPV OP 0 ZETTEN, MIN 1-->

<!--TODO MOMENTEEL GEEFT IN WINKELWAGEN PAGINA DE PRIJS ALS VOERTUIG KORTING HEEFT DAT HET AVDD IS. ZORG DAT ALLEEN AVDD ARTIKELEN DIT WEERGEVEN EN NIET ALLE VOERTUIGEN IN DE ACTIE TABEL-->

<!--TODO MAAK VOERTUIGEN BEWERKEN VOOR ADMIN (NET ALS KLANTGEGEVENS AANPASSEN)-->

<!--TODO SITE ONLINE ZETTEN-->

<!--TODO BIJ HET ANONIEM BESTELLEN ECHO MELDING DAT HET BETER IS ALS JE INLOGD MAYBE MAAR ALS JE INLOGD GAAN AL JE GEGEVENS WEG-->

