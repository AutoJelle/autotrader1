<?php
require_once('MySqlDatabaseClass.php');
require_once("LoginClass.php");
require_once("SessionClass.php");

class BuyClass
{
    //Fields
    private $idWinkelmand;
    private $klantid;
    private $prijs;
    //Properties
    //getters

    public function getId()
    {
        return $this->id;
    }

    public function getKlantId()
    {
        return $this->klantid;
    }

    //setters
    public function setKlantId($value)
    {
        $this->klantid = $value;
    }

    public function getPrijs()
    {
        return $this->prijs;
    }

    public function setPrijs($value)
    {
        $this->prijs = $value;
    }

    public function setId($value)
    {
        $this->id = $value;
    }

    public function __construct()
    {
    }

    //Methods
    public static function insert_winkelmanditem_database($post)
    {
        global $database;

        if (!isset($_SESSION['idKlant'])) {
            $_SESSION['idKlant'] = 1;
            $_SESSION['userrole'] = "anon";
        }

//        $sql = "SELECT * FROM actie WHERE actieVanDeDag = 1";
//        $result = $database->fire_query($sql);
////        HIJ SELECT NU UIT ACTIE ALLE AVDD'S. ZORG DAT IE DE RESULTATEN TEGEN DE WINKELMAND TABEL HOUD.
//        $sql2 = "nothin";
//        if ($result->num_rows > 0) {
//                while ($row = $result->fetch_assoc()) {
//                    $sql2 = "SELECT * FROM winkelmand WHERE idVoertuig = " . $row['idVoertuig'] . " ";
//
//                    if ($post['idVoertuig'] == $row['idVoertuig']) {
//                        echo "<h3 style='text-align: center;' >Item niet toegevoegd,jj  u heeft al een artikel van de dag in uw winkelmand.</h3>";
//                    } else {
//                        echo "ooooooooooooooo";
//                        $query = "INSERT INTO `winkelmand` (`idWinkelmand`, `idVoertuig`, `idKlant`)
//                                                    VALUES (NULL, " . $post['idVoertuig'] . ", " . $_SESSION['idKlant'] . ")";
//                        $database->fire_query($query);
//
//                        $last_id = mysqli_insert_id($database->getDb_connection());
//
//                        self::check_winkelmand_duplicates($post, $last_id);
//                    }
//
//                    $result2 = $database->fire_query($sql2);
//                    echo $sql2;
//                    echo "<h1>" . $result2->num_rows . "</h1>";
//                    if ($result2->num_rows > 0) {
//                        echo "<h3 style='text-align: center;' >Item niet toegevoegd, u heeft al een artikel van de dag in uw winkelmand.</h3>";
//                    } else if ($result2->num_rows < 1) {
//                        echo "klklklklklklklklkklklkllklklklklklkll";
//                        echo "iiiiiiiiiiiiiiiiiiiiiiiiiiiiii";
//                        $query = "INSERT INTO `winkelmand` (`idWinkelmand`, `idVoertuig`, `idKlant`)
//                                                    VALUES (NULL, " . $post['idVoertuig'] . ", " . $_SESSION['idKlant'] . ")";
//                        $database->fire_query($query);
//
//                        $last_id = mysqli_insert_id($database->getDb_connection());
//
//                        self::check_winkelmand_duplicates($post, $last_id);
//                    }
//                }
//        } else{
//            echo "uuuuuuuuuuuuuuuuuuuuuuuuuuu";
            $query = "INSERT INTO `winkelmand` (`idWinkelmand`, `idVoertuig`, `idKlant`) 
                                                    VALUES (NULL, " . $post['idVoertuig'] . ", " . $_SESSION['idKlant'] . ")";
            $database->fire_query($query);

            $last_id = mysqli_insert_id($database->getDb_connection());

            self::check_winkelmand_duplicates($post, $last_id);
//        }
    }

    public static function check_winkelmand_duplicates($post, $id)
    {
        global $database;
        $query = "  SELECT
                        idVoertuig, idKlant, COUNT(*)
                    FROM
                        winkelmand
                    GROUP BY
                        idVoertuig, idKlant
                    HAVING 
                        COUNT(*) > 1";

        $result = $database->fire_query($query);


        $sqlX = "SELECT * FROM login WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
        $resultX = $database->fire_query($sqlX);

        while ($rowX = $resultX->fetch_assoc()) {
            if ($result->num_rows > 0) {
                $sql = "DELETE FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . "
                                                    AND `idVoertuig` = " . $post['idVoertuig'] . " 
                                                    AND `idWinkelmand` = " . $id . " ";

                $database->fire_query($sql);

            echo "<h3 style='text-align: center;' >Item niet toegevoegd, bestaat al in winkelmand.</h3>";
            } else if ($rowX['aVDDGekocht'] == 1) {
//                echo "<h3 style='text-align: center;' >Item niet toegevoegd, u heeft al een artikel van de dag gekocht.</h3>";
//                $sql = "DELETE FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . "
//                                                    AND `idVoertuig` = " . $post['idVoertuig'] . "
//                                                    AND `idWinkelmand` = " . $id . " ";
//
//                $database->fire_query($sql);
                echo "<h3 style='text-align: center;' >Item toegevoegd aan winkelmand.</h3>";

            } else if ($rowX['aVDDGekocht'] == 0) {
                echo "<h3 style='text-align: center;' >Item toegevoegd aan winkelmand.</h3>";
            } else {
                echo "<h3 style='text-align: center;' >Item toegevoegd aan winkelmand.</h3>";
            }
        }
//            echo $query;
    }

    public static function clear_winkelmand()
    {
        global $database;
        $query = "DELETE FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
//            echo $query;
        $database->fire_query($query);
    }

    public static function remove_item_winkelmand($post)
    {
        global $database;
        $query = "DELETE FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . "
                                                    AND `idWinkelmand` = " . $post["idWinkelmand"] . " ";
        // echo $query;
        $database->fire_query($query);
    }

    public static function insert_bestelling_database($post)
    {
        global $database;

        date_default_timezone_set("Europe/Amsterdam");

        $date = date('Y-m-d H:i:s');

        $geselecteerdeDatum = $post['geselecteerdeDatumB'];


        //Als gebruiker anoniem is, gebruik deze query
        if($_SESSION['idKlant'] == 1) {
            $query = "INSERT INTO `bestelling` (`idBestelling`,
                                            `idVoertuig`,
                                            `idKlant`,
                                            `voertuigMerk`,
                                            `voertuigType`,
                                            `bestelDatum`,
                                            `bezorgenOfOphalen`,
                                            `geselecteerdeDatum`,
                                            `prijs`,
                                            `betaalMethode`,
                                            `opmerking`,
                                            `anonNaam`,
                                            `anonAdres`,
                                            `anonWoonplaats`,
                                            `anonEmail`)
                  VALUES                    (NULL, 
                                              " . $post['voertuigIDB'] . ", 
                                              " . $_SESSION['idKlant'] . ", 
                                             '" . $post['voertuigMerkB'] . "', 
                                             '" . $post['voertuigTypeB'] . "', 
                                             '" . $date . "',
                                             '" . $post['bezorgenOfOphalenB'] . "', 
                                             '" . $geselecteerdeDatum . "',
                                             '" . $post['totalePrijsB'] . "', 
                                             '" . $post['betaalMethodeB'] . "', 
                                             NULL,
                                             '" . $post['naamB'] . "', 
                                             '" . $post['adresB'] . "', 
                                             '" . $post['woonplaatsB'] . "', 
                                             '" . $post['emailB'] . "')";
        } else{
            //Anders, gebruik deze query.
            $query = "INSERT INTO `bestelling` (`idBestelling`,
                                            `idVoertuig`,
                                            `idKlant`,
                                            `voertuigMerk`,
                                            `voertuigType`,
                                            `bestelDatum`,
                                            `bezorgenOfOphalen`,
                                            `geselecteerdeDatum`,
                                            `prijs`,
                                            `betaalMethode`,
                                            `opmerking`)
                  VALUES                    (NULL, 
                                              " . $post['voertuigIDB'] . ", 
                                              " . $_SESSION['idKlant'] . ", 
                                             '" . $post['voertuigMerkB'] . "', 
                                             '" . $post['voertuigTypeB'] . "', 
                                             '" . $date . "',
                                             '" . $post['bezorgenOfOphalenB'] . "', 
                                             '" . $geselecteerdeDatum . "',
                                             '" . $post['totalePrijsB'] . "', 
                                             '" . $post['betaalMethodeB'] . "', 
                                             NULL)";
        }

        $database->fire_query($query);
        $last_id = mysqli_insert_id($database->getDb_connection());
        //Zet aantal beschikbaar naar beneden
        self::update_beschikbaar($post);
    }

    private static function send_email($post, $idBestelling, $geselecteerdeDatum)
    {

        if($_SESSION['idKlant'] == 1) {
            $_SESSION['email'] = $post['emailB'];
        }
        $to = $_SESSION['email'];
        $subject = "Bevestigingsmail Bestelling Autotrader";
        $message = "Geachte heer/mevrouw<br>";

        $message .= "Hartelijk dank voor het bestellen bij Autotrader" . "<br>";

        if($_SESSION['idKlant'] == 1) {
            $message .= "Hieronder het betaaloverzicht: <br>";
            $message .= "Uw bestellingsnummer is: " . $idBestelling . "<br>";
            $message .= "Totaal prijs: &euro; " . number_format($post['totalePrijsB'], 0, ',', '.') . "<br>";
            $message .= "U heeft betaald met: " . $post['betaalMethodeB'] . "<br>";
            $message .= "U heeft gekozen dat uw bestelling wordt " . $post['bezorgenOfOphalenB'] . " op: " . $geselecteerdeDatum . "<br><br>";
            $message .= "Uw naam: " . $post['naamB'] . "<br>";
            $message .= "Uw adres " . $post['adresB'] . "<br>";
            $message .= "Uw woonplaats: " . $post['woonplaatsB'] . "<br>";
            $message .= "Uw email: " . $post['emailB'] . "<br>";

            $message .= "Opmerkingen: <br>" . $post['opmerkingenB'] . "<br><br>";
            $message .= "Met vriendelijke groet," . "<br>";
            $message .= "Jelle van den Broek" . "<br>";
        } else{
            $message .= "Hieronder het betaaloverzicht: <br>";
            $message .= "Uw bestellingsnummer is: " . $idBestelling . "<br>";
            $message .= "Totaal prijs: &euro; " . number_format($post['totalePrijsB'], 0, ',', '.') . "<br>";
            $message .= "U heeft betaald met: " . $post['betaalMethodeB'] . "<br>";
            $message .= "U heeft gekozen dat uw bestelling wordt " . $post['bezorgenOfOphalenB'] . " op: " . $geselecteerdeDatum . "<br><br>";
            $message .= "Opmerkingen: <br>" . $post['opmerkingenB'] . "<br><br>";
            $message .= "Met vriendelijke groet," . "<br>";
            $message .= "Jelle van den Broek" . "<br>";
        }

        $headers = 'From: no-reply@autotrader.nl' . "\r\n";
        $headers .= 'Reply-To: webmaster@autotrader.nl' . "\r\n";
        $headers .= 'Bcc: accountant@autotrader.nl' . "\r\n";

        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);
    }

    public static function check_if_date_exists($geselecteerdeDatum)
    {
        global $database;

        $query = "SELECT `geselecteerdeDatum`
					  FROM	 `bestelling`
					  WHERE	 `geselecteerdeDatum` = '" . $geselecteerdeDatum . "'";

        $result = $database->fire_query($query);
        //echo $query;
        return (mysqli_num_rows($result) > 3) ? true : false;
    }

    public static function update_beschikbaar($post)
    {
        global $database;

        $query = "UPDATE `voertuig` SET `beschikbaar`= (`beschikbaar` - 1) WHERE `idVoertuig` = " . $_POST['voertuigIDB'] . " ";
//        echo $query;

        $database->fire_query($query);
    }

    public static function insert_opmerking_into_database($post)
    {
        global $database;

        $sql = "SELECT idBestelling FROM bestelling ORDER BY idBestelling DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastBestellingID = $row['idBestelling'];
        }

        $query = "UPDATE `bestelling` SET `opmerking` = '" . $post['opmerkingenB'] . "' WHERE idBestelling = " . $lastBestellingID . " ";
//        echo $opmerking;
//         echo $query;
        $database->fire_query($query);

        //Stuur de email met de gegevens
        self::send_email($post, $lastBestellingID, $post['geselecteerdeDatumB']);
    }

    public static function remove_unavailable_item_winkelmand($row)
    {
        global $database;
        $query = "DELETE FROM `winkelmand` WHERE `idKlant` = " . $_SESSION['idKlant'] . "
                                                    AND `idWinkelmand` = " . $row["idWinkelmand"] . " ";
//         echo $query;
        $database->fire_query($query);
    }

}
?>

