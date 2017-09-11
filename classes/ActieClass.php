<?php
require_once('MySqlDatabaseClass.php');

class ActieClass
{
    public static function start_actie($post)
    {
        global $database;

        $query = "INSERT INTO `actie` (`idActie`,
									   `beschrijving`,
									   `idVoertuig`,
									   `datum`,
									   `beginDatum`,
									   `procentKorting`,
									   `actieVanDeDag`,
									   `aantalBesteld`)
				       VALUES		  (NULL,
									   '" . $post['beschrijving'] . "',
									    " . $post['voertuigKiezen'] . ",
									   '" . $post['geselecteerdeDatum'] . "',
									   '" . $post['geselecteerdeBeginDatum'] . "',
									   '" . $post['procentKorting'] . "',
									   '0',
									   '0')";

//        echo $query;
        $database->fire_query($query);

        $sql = "SELECT email FROM login WHERE `acties` = 1";
        $result = $database->fire_query($sql);

        $sql2 = "SELECT * FROM voertuig WHERE idVoertuig = " . $post['voertuigKiezen'] . " ";
        $result2 = $database->fire_query($sql2);

        $sql3 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN `merk` AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $post['voertuigKiezen'] . " ";
        $result3 = $database->fire_query($sql3);

        while ($row = mysqli_fetch_array($result)) {
            while ($row2 = mysqli_fetch_array($result2)) {
                while ($row3 = mysqli_fetch_array($result3)) {
                    self::send_email($post, $row['email'], $row2, $row3['merk']);
                }
            }
        }
    }

    private static function send_email($post, $email, $row2, $merk)
    {
        $to = $email;
        $subject = "Een nieuwe actie is gestart!";
        $message = "Geachte heer/mevrouw <br> ";

        $message .= "Er is een nieuwe actie gestart.<br>";
        $message .= "De actie betreft het voertuig: " . $merk . " " . $row2['model'] . " " . $row2['bouwjaar'] . ". <br>";
        $message .= "Het voertuig zal " . $post['procentKorting'] . "% korting hebben. <br><br>";
        $message .= "Een korte beschrijving van de actie: <br>" . $post['beschrijving'] . " <br><br>";
        $message .= "De actie zal beginnen op: " . $post['geselecteerdeBeginDatum'] . ". <br><br>";
        $message .= "De actie zal eindigen op: " . $post['geselecteerdeDatum'] . ". <br><br>";
        $message .= "Met vriendelijke groet," . "<br>";
        $message .= "Jelle van den Broek" . "<br>";

        $headers = 'From: no-reply@autotrader.nl' . "\r\n";
        $headers .= 'Reply-To: webmaster@autotrader.nl' . "\r\n";
        $headers .= 'Bcc: accountant@autotrader.nl' . "\r\n";

        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();


        mail($to, $subject, $message, $headers);
    }

    public static function start_actie_vd_dag($post)
    {
        global $database;
        $sql = "DELETE FROM `actie` WHERE `actieVanDeDag` = 1 ";

        $query = "INSERT INTO `actie` (`idActie`,
									   `beschrijving`,
									   `idVoertuig`,
									   `datum`,
									   `beginDatum`,
									   `procentKorting`,
									   `actieVanDeDag`,
									   `aantalBesteld`)
				       VALUES		  (NULL,
									   '" . $post['beschrijving'] . "',
									    " . $post['voertuigKiezen'] . ",
									   '" . $post['geselecteerdeDatum'] . "',
									   NULL,
									   '" . $post['procentKorting'] . "',
									   '1',
									   '0')";
//        echo $query;
        $database->fire_query($sql);
        $database->fire_query($query);

        $sql = "UPDATE `login` SET `aVDDGekocht` = 0";
        $database->fire_query($sql);

    }

    public static function kan_klant_artikel_van_de_dag_kopen($post)
    {
        global $database;
        $sql = "SELECT * FROM actie WHERE `idVoertuig` = " . $post['voertuigIDB'] . " ";
        $sql2 = "SELECT * FROM login WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
        $result = $database->fire_query($sql);
        $result2 = $database->fire_query($sql2);

        if ($result->num_rows > 0) {
            while ($row = mysqli_fetch_array($result)) {
                if($row['actieVanDeDag'] == 1) {
                    while ($row2 = mysqli_fetch_array($result2)) {
                        if ($row['aantalBesteld'] <= 49) {
                            if ($row2['aVDDGekocht'] == 0) {
                                return true;
                            } else {
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }
                } else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }

    public static function koop_artikel_van_de_dag($post)
    {
        global $database;

        $sql = "SELECT * FROM actie WHERE `idVoertuig` = " . $post['voertuigIDB'] . " ";
        $result = $database->fire_query($sql);

        while ($row = mysqli_fetch_array($result)) {
            $query  = "UPDATE `actie` SET `aantalBesteld` = (`aantalBesteld` + 1) WHERE `idActie` = " . $row['idActie'] . " ";
            $query2 = "UPDATE `actie` SET `procentKorting` = (" . $row['procentKorting'] . " - 1) WHERE `idActie` = " . $row['idActie'] . " ";
            $query3 = "UPDATE `login` SET `aVDDGekocht` = 1 WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
            $database->fire_query($query);
            if($row['actieVanDeDag'] == 1) {
                $database->fire_query($query2);
                $database->fire_query($query3);
            }
        }
    }

    public static function remove_actie($post)
    {
        global $database;

        $query = "DELETE FROM `actie` WHERE `idActie` = " . $post['idActie'] . " ";
        //echo $query;


        $database->fire_query($query);
    }
}


//
//
//
//INSERT INTO `bestelling` (`idBestelling`, `idVoertuig`, `idKlant`, `voertuigMerk`, `voertuigType`, `bestelDatum`, `bezorgenOfOphalen`, `geselecteerdeDatum`, `prijs`, `betaalMethode`, `opmerking`)
//VALUES (NULL, 9, 9, 'Harley Davidson', 'Motor', '2017-08-30 13:28:40', 'opgehaalt', '2017-08-30', '300000', 'iDeal', NULL)
//SELECT * FROM actie WHERE `idVoertuig` = 9
//SELECT * FROM login WHERE `idKlant` = 9
//UPDATE `actie` SET `aantalBesteld` = + 1, `procentKorting` = - 1 WHERE `idActie` = 17
//UPDATE `login` SET `aVVDGekocht` = 1 WHERE `idKlant` = 9
