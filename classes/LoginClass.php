<?php
require_once("MySqlDatabaseClass.php");
require_once("VoertuigClass.php");

class LoginClass
{
    //Fields
    private $idKlant;
    private $naam;
    private $email;
    private $password;
    private $userrole;
    private $geblokkeerd;
    private $activated;
    private $activationdate;
    private $adres;
    private $woonplaats;


    //Properties
    public function getIdKlant()
    {
        return $this->idKlant;
    }

    public function getNaam()
    {
        return $this->naam;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getUserrole()
    {
        return $this->userrole;
    }

    public function getGeblokkeerd()
    {
        return $this->geblokkeerd;
    }

    public function getActivated()
    {
        return $this->activated;
    }

    public function getActivationdate()
    {
        return $this->activationdate;
    }

    public function getAdres()
    {
        return $this->adres;
    }

    public function getWoonplaats()
    {
        return $this->woonplaats;
    }

    public function setIdKlant($value)
    {
        $this->idKlant = $value;
    }

    public function setNaam($value)
    {
        $this->naam = $value;
    }

    public function setEmail($value)
    {
        $this->email = $value;
    }

    public function setPassword($value)
    {
        $this->password = value;
    }

    public function setUserrole($value)
    {
        $this->userrole = $value;
    }

    public function setGeblokkeerd($value)
    {
        $this->geblokkeerd = $value;
    }

    public function setActivated($value)
    {
        $this->activated = $value;
    }

    public function setActivationdate($value)
    {
        $this->activationdate = value;
    }

    public function setAdres($value)
    {
        $this->adres = value;
    }

    public function setWoonplaats($value)
    {
        $this->woonplaats = value;
    }


    //Constructor
    public function __construct()
    {
    }

    //Methods
    /* Hier komen de methods die de informatie in/uit de database stoppen/halen
    */
    public static function find_by_sql($query)
    {
        // Maak het $database-object vindbaar binnen deze method
        global $database;

        // Vuur de query af op de database
        $result = $database->fire_query($query);

        // Maak een array aan waarin je LoginClass-objecten instopt
        $object_array = array();

        // Doorloop alle gevonden records uit de database
        while ($row = mysqli_fetch_array($result)) {
            // Een object aan van de LoginClass (De class waarin we ons bevinden)
            $object = new LoginClass();

            // Stop de gevonden recordwaarden uit de database in de fields van een LoginClass-object
            $object->idKlant = $row['idKlant'];
            $object->naam = $row['naam'];
            $object->email = $row['email'];
            $object->password = $row['password'];
            $object->userrole = $row['userrole'];
            $object->geblokkeerd = $row['geblokkeerd'];
            $object->activated = $row['activated'];
            $object->activatiedatum = $row['activatiedatum'];
            $object->adres = $row['adres'];
            $object->woonplaats = $row['woonplaats'];

            $object_array[] = $object;
        }
        return $object_array;
    }

    public static function find_login_by_email_password($email, $password)
    {
        $query = "SELECT *
					  FROM `login`
					  WHERE `email` 	= '" . $email . "'
					  AND	`password`	= '" . $password . "'";

        $loginClassObjectArray = self::find_by_sql($query);
        $loginClassObject = array_shift($loginClassObjectArray);
        return $loginClassObject;
    }


    public static function insert_into_database($post)
    {
        global $database;

        date_default_timezone_set("Europe/Amsterdam");

        $date = date('Y-m-d H:i:s');

        $password = MD5($post['email'] . date('Y-m-d H:i:s'));

        $query = "INSERT INTO `login` (`idKlant`,
									   `naam`,
									   `email`,
									   `password`,
									   `userrole`,
									   `activated`,
									   `activatiedatum`,
									   `adres`,
									   `woonplaats`)
				  VALUES			 (NULL,
				  					   '" . $post['naam'] . "',
									   '" . $post['email'] . "',
									   '" . $password . "',
									   'Klant',
									   '0',
									   '" . $date . "',
									   '" . $post['adres'] . "',
									   '" . $post['woonplaats'] . "')";
//         echo $query;
        $database->fire_query($query);

        $last_id = mysqli_insert_id($database->getDb_connection());

        self::send_email($last_id, $post, $password);
    }

    public static function check_if_email_exists($email)
    {
        global $database;

        $query = "SELECT `email`
					  FROM	 `login`
					  WHERE	 `email` = '" . $email . "'";

        $result = $database->fire_query($query);

        //ternary operator
        return (mysqli_num_rows($result) > 0) ? true : false;
    }


    public static function check_if_email_password_exists($email, $password, $activated)
    {
        global $database;

        $query = "SELECT `email`, `password`, `activated`
					  FROM	 `login`
					  WHERE	 `email` = '" . $email . "'
					  AND	 `password` = '" . $password . "'";

        $result = $database->fire_query($query);

        $record = mysqli_fetch_array($result);

        return (mysqli_num_rows($result) > 0 && $record['activated'] == $activated) ? true : false;
    }

    public static function check_if_activated($email, $password)
    {
        global $database;

        $query = "SELECT `activated`
					  FROM	 `login`
					  WHERE	 `email` = '" . $email . "'
					  AND	 `password` = '" . $password . "'";

        $result = $database->fire_query($query);
        $record = mysqli_fetch_array($result);

        return ($record['activated'] == '0') ? true : false;
    }

    public static function check_if_geblokkeerd($idKlant)
    {
        global $database;

        $query = "SELECT `geblokkeerd`
					  FROM	 `login`
					  WHERE	 `idKlant` = '" . $idKlant . "'";

        $result = $database->fire_query($query);
        $record = mysqli_fetch_array($result);
        return $geblokt = ($record['geblokkeerd'] == '0') ? true : false;

    }

    private static function send_email($idKlant, $post, $password)
    {

        $to = $post['email'];
        $subject = "Activatiemail Autotrader";
        $message = "Geachte heer/mevrouw " . $post['naam'] . "<br>";

        $message .= "Hartelijk dank voor het registreren bij Autotrader.nl" . "<br>";
        $message .= "U kunt de registratie voltooien door op de onderstaande activatielink te klikken:" . "<br>";

        $message .= "Klik <a href='" . MAIL_PATH . "index.php?content=activate&idKlant=" . $idKlant . "&email=" . $post['email'] . "&password=" . $password . "'>hier</a> om uw account te activeren" . "<br>";

        $message .= "U kunt dan vervolgens een nieuw wachtwoord instellen." . "<br>";
        $message .= "Met vriendelijke groet," . "<br>";
        $message .= "Jelle van den Broek" . "<br>";

        $headers  = 'From: no-reply@autotrader.nl' . "\r\n";
        $headers .= 'Reply-To: webmaster@autotrader.nl' . "\r\n";
        $headers .= 'Bcc: accountant@autotrader.nl' . "\r\n";

        $headers .= "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'X-Mailer: PHP/' . phpversion();


        mail($to, $subject, $message, $headers);
    }

    public static function activate_account_by_id($idKlant)
    {
        global $database;
        $query = "UPDATE `login`
					  SET `activated` = '1'
					  WHERE `idKlant` = '" . $idKlant . "'";

        $database->fire_query($query);

    }

    public static function update_password($idKlant, $password)
    {
        global $database;
        $query = "UPDATE `login` 
					  SET	 `password` =	'" . MD5($password) . "'
					  WHERE	 `idKlant`		=	'" . $idKlant . "'";
        $database->fire_query($query);

    }

    public static function check_old_password($old_password)
    {
        $query = "SELECT *
					  FROM	 `login`
					  WHERE	 `idKlant`	=	'" . $_SESSION['idKlant'] . "'";
        $arrayLoginClassObjecten = self::find_by_sql($query);
        $loginClassObject = array_shift($arrayLoginClassObjecten);
        //var_dump($loginClassObject);
        //echo $loginClassObject->getPassword()."<br>";
        //echo MD5($old_password);
        if (!strcmp(MD5($old_password), $loginClassObject->getPassword())) {
            return true;
        } else {
            return false;
        }
    }

/*TODOp IDK WAAR DEZE FUNCTIE VOOR GEBRUIKT WORDT | KIJK OF ERGENS ACCOUNT VERANDEREN IS*/
////    public static function update_database($post)
////    {
////        global $database;
////        $query = "UPDATE `users` SET `firstname`='" . $post['voornaam'] . "', `infix`='" . $post['tussenvoegsel'] . "',`lastname`='" . $post['achternaam'] . "' where `idKlant`='" . $_SESSION['idKlant'] . "'";
////        //echo"users update";
////        $database->fire_query($query);
////    }

    public static function find_info_by_id($idKlant)
    {
        $query = "SELECT 	*
					  FROM 		`login`
					  WHERE		`idKlant`	=	" . $idKlant;
        $object_array = self::find_by_sql($query);
        $usersclassObject = array_shift($object_array);
        //var_dump($usersclassObject); exit();
        return $usersclassObject;
    }

    public static function insert_betaal_methode($idKlant, $betaalMethodeKiezen)
    {
        global $database;
        $query = "UPDATE `login` SET `betaalMethode` = ('" . $betaalMethodeKiezen . "') WHERE idKlant = " . $idKlant . " ";
//        echo $query;
        $database->fire_query($query);
    }

    public static function insert_actie_keuze($idKlant, $actieKeuzeKiezen)
    {
        global $database;
        $query = "UPDATE `login` SET `acties` = ('" . $actieKeuzeKiezen . "') WHERE idKlant = " . $idKlant . " ";
//        echo $query;
        $database->fire_query($query);
    }

}

?>