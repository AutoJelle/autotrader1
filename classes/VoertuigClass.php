<?php
require_once('MySqlDatabaseClass.php');


class VoertuigClass
{
    //Fields
    private $idVoertuig;
    private $idKlant;
    private $type;
    private $merk;
    private $model;
    private $prijs;
    private $bouwjaar;
    private $kilometerstand;
    private $brandstof;
    private $schakeling;
    private $kleur;
    private $kenteken;
    private $aantalDeuren;
    private $aantalZitplaatsen;
    private $milieu;
    private $veiligheidsklasse;
    private $lengte;
    private $breedte;
    private $hoogte;
    private $gewicht;
    private $versnellingen;

    //Properties
    //getters
    public function getIdVoertuig()
    {
        return $this->idVoertuig;
    }

    public function getIdKlant()
    {
        return $this->idKlant;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getMerk()
    {
        return $this->merk;
    }

    public function getModel()
    {
        return $this->model;
    }

    public function getPrijs()
    {
        return $this->prijs;
    }

    public function getBouwjaar()
    {
        return $this->bouwjaar;
    }

    public function getKilometerstand()
    {
        return $this->kilometerstand;
    }

    public function getBrandstof()
    {
        return $this->brandstof;
    }

    public function getSchakeling()
    {
        return $this->schakeling;
    }

    public function getKleur()
    {
        return $this->kleur;
    }

    public function getKenteken()
    {
        return $this->kenteken;
    }

    public function getAantalDeuren()
    {
        return $this->aantalDeuren;
    }

    public function getAantalZitplaatsen()
    {
        return $this->aantalZitplaatsen;
    }

    public function getMilieu()
    {
        return $this->milieu;
    }

    public function getVeiligheidsklasse()
    {
        return $this->veiligheidsklasse;
    }

    public function getLengte()
    {
        return $this->lengte;
    }

    public function getBreedte()
    {
        return $this->breedte;
    }

    public function getHoogte()
    {
        return $this->hoogte;
    }

    public function getGewicht()
    {
        return $this->gewicht;
    }

    public function getVersnellingen()
    {
        return $this->versnellingen;
    }


    //setters
    public function setIdVoertuig($value)
    {
        $this->idVoertuig = $value;
    }

    public function setIdKlant($value)
    {
        $this->idKlant = $value;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function setMerk($value)
    {
        $this->merk = $value;
    }

    public function setModel($value)
    {
        $this->model = $value;
    }

    public function setPrijs($value)
    {
        $this->prijs = $value;
    }

    public function setBouwjaar($value)
    {
        $this->bouwjaar = $value;
    }

    public function setKilometerstand($value)
    {
        $this->kilometerstand = $value;
    }

    public function setBrandstof($value)
    {
        $this->brandstof = $value;
    }

    public function setSchakeling($value)
    {
        $this->schakeling = $value;
    }

    public function setKleur($value)
    {
        $this->kleur = $value;
    }

    public function setKenteken($value)
    {
        $this->kenteken = $value;
    }

    public function setAantalDeuren($value)
    {
        $this->aantalDeuren = $value;
    }

    public function setAantalZitplaatsen($value)
    {
        $this->aantalZitplaatsen = $value;
    }

    public function setMilieu($value)
    {
        $this->milieu = $value;
    }

    public function setVeiligheidsklasse($value)
    {
        $this->veiligheidsklasse = $value;
    }

    public function setLengte($value)
    {
        $this->lengte = $value;
    }

    public function setBreedte($value)
    {
        $this->breedte = $value;
    }

    public function setHoogte($value)
    {
        $this->hoogte = $value;
    }

    public function setGewicht($value)
    {
        $this->titel = $value;
    }

    public function setVersnellingen($value)
    {
        $this->titel = $value;
    }


    //Constuctor
    public function __construct()
    {
    }

    //Methods
    public static function find_by_sql($query)
    {
        // Maak het $database-object vindbaar binnen deze method
        global $database;

        // Vuur de query af op de database
        $result = $database->fire_query($query);
        // Maak een array aan waarin je VoertuigClass-objecten instopt
        $object_array = array();

        // Doorloop alle gevonden records uit de database
        while ($row = mysqli_fetch_array($result)) {
            // Een object aan van de VoertuigClass (De class waarin we ons bevinden)
            $object = new VoertuigClass();

            // Stop de gevonden recordwaarden uit de database in de fields van een VoertuigClass-object
            $object->id = $row['idVoertuig'];
            $object->idKlant = $row['idKlant'];
            $object->type = $row['type'];
            $object->merk = $row['merk'];
            $object->model = $row['model'];
            $object->prijs = $row['prijs'];
            $object->bouwjaar = $row['bouwjaar'];
            $object->kilometerstand = $row['kilometerstand'];
            $object->brandstof = $row['brandstof'];
            $object->schakeling = $row['schakeling'];
            $object->kleur = $row['kleur'];
            $object->kenteken = $row['kenteken'];
            $object->aantalDeuren = $row['aantalDeuren'];
            $object->aantalZitplaatsen = $row['aantalZitplaatsen'];
            $object->milieu = $row['milieu'];
            $object->veiligheidsklasse = $row['veiligheidsklasse'];
            $object->lengte = $row['lengte'];
            $object->breedte = $row['breedte'];
            $object->hoogte = $row['hoogte'];
            $object->gewicht = $row['gewicht'];
            $object->versnellingen = $row['versnellingen'];

            $object_array[] = $object;
        }
        return $object_array;
    }

    public static function find_info_by_id($idVoertuig)
    {
        $query = "SELECT 	*
					  FROM 		`voertuig`
					  WHERE		`idVoertuig`	=	" . $idVoertuig;
        $object_array = self::find_by_sql($query);
        $voertuigclassObject = array_shift($object_array);

        return $voertuigclassObject;
    }

    public static function insert_voertuig_database($post)
    {
        global $database;

        $sql = "SELECT idVoertuig FROM voertuig ORDER BY idVoertuig DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastVoertuigID = ($row['idVoertuig'] + 1);
        }

        $date = date('Y-m-d');

        $query = "INSERT INTO `voertuig` ( `idVoertuig`,
										   `idKlant`,
										   `fotopad`,
										   `model`,
										   `prijs`,
										   `bouwjaar`,
										   `kilometerstand`,
										   `brandstof`,
										   `schakeling`,
										   `kleur`,
										   `kenteken`,
										   `aantalDeuren`,
										   `aantalZitplaatsen`,
										   `milieu`,
										   `veiligheidsklasse`,
                                           `lengte`,
                                           `breedte`,
                                           `hoogte`,
                                           `gewicht`,
                                           `versnellingen`,
                                           `datumToegevoegd`,
                                           `beschikbaar`)
					  VALUES			  ( " . $lastVoertuigID . ",
										   '" . $_SESSION['idKlant'] . "',
										   '" . $post['fotopad'] . "',
										   '" . $post['model'] . "',
										   '" . $post['prijs'] . "',
										   '" . $post['bouwjaar'] . "',
										   '" . $post['kilometerstand'] . "',
										   '" . $post['brandstof'] . "',
										   '" . $post['schakeling'] . "',
										   '" . $post['kleur'] . "',
										   '" . $post['kenteken'] . "',
										   '" . $post['aantalDeuren'] . "',
										   '" . $post['aantalZitplaatsen'] . "',
										   '" . $post['milieu'] . "',
										   '" . $post['veiligheidsklasse'] . "',
										   '" . $post['lengte'] . "',
										   '" . $post['breedte'] . "',
										   '" . $post['hoogte'] . "',
										   '" . $post['gewicht'] . "',
										   '" . $post['versnellingen'] . "',
										   '" . $date . "',
                                           " . 1 . ")";

//        echo $query . "<br>";
        $database->fire_query($query);
        $last_id = mysqli_insert_id($database->getDb_connection());
    }

    public static function insert_merk_voertuig($post)
    {
        global $database;

        $sql = "SELECT idVoertuig FROM voertuig ORDER BY idVoertuig DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastVoertuigID = $row['idVoertuig'];
        }

        $query = "INSERT INTO `voertuigmerk`    (`idVoertuigMerk`, 
												 `idVoertuig`, 
												 `idMerk`) 
				   VALUES 						(NULL,
				   								 " . $lastVoertuigID . ",
				   								 " . $post['merkSelect'] . ")";

        $database->fire_query($query);
    }

    public static function insert_type_voertuig($post)
    {
        global $database;

        $sql = "SELECT idVoertuig FROM voertuig ORDER BY idVoertuig DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastVoertuigID = $row['idVoertuig'];
        }

        $query = "INSERT INTO `voertuigtype`    (`idVoertuigType`, 
												 `idVoertuig`, 
												 `idType`) 
				   VALUES 						(NULL,
				   								 " . $lastVoertuigID . ",
				   								 " . $post['typeSelect'] . ")";

        $database->fire_query($query);
    }

    public static function delete_voertuig($post)
    {
        global $database;

        $sql =  "DELETE FROM `voertuig`     WHERE `idVoertuig` = " . $_POST['idVoertuig'] . " ";
        $sql2 = "DELETE FROM `voertuigmerk` WHERE `idVoertuig` = " . $_POST['idVoertuig'] . " ";
        $sql3 = "DELETE FROM `voertuigtype` WHERE `idVoertuig` = " . $_POST['idVoertuig'] . " ";

        $database->fire_query($sql2);
        $database->fire_query($sql3);
        $database->fire_query($sql);
        $last_id = mysqli_insert_id($database->getDb_connection());
    }

    public static function wijzig_gegevens_voertuig($post)
    {
        global $database;

        $sql = "UPDATE	`voertuig`  SET 	`model`		            =	'" . $_POST['model'] . "',
											`prijs`	                = 	'" . $_POST['prijs'] . "',
											`bouwjaar`	            = 	'" . $_POST['bouwjaar'] . "',
											`kilometerstand`	    = 	'" . $_POST['kilometerstand'] . "',
											`brandstof`	            = 	'" . $_POST['brandstof'] . "',
											`schakeling`	        = 	'" . $_POST['schakeling'] . "',
											`kleur`	                = 	'" . $_POST['kleur'] . "',
											`kenteken`	            = 	'" . $_POST['kenteken'] . "',
											`aantalDeuren`	        = 	'" . $_POST['aantalDeuren'] . "',
											`aantalZitplaatsen`	    = 	'" . $_POST['aantalZitplaatsen'] . "',
											`milieu`	            = 	'" . $_POST['milieu'] . "',
											`veiligheidsklasse`	    = 	'" . $_POST['veiligheidsklasse'] . "',
											`lengte`	            = 	'" . $_POST['lengte'] . "',
											`breedte`	            = 	'" . $_POST['breedte'] . "',
											`hoogte`	            = 	'" . $_POST['hoogte'] . "',
											`gewicht`	            = 	'" . $_POST['gewicht'] . "',
											`versnellingen`	        = 	'" . $_POST['versnellingen'] . "'
									WHERE	`idVoertuig`			=	'" . $_POST['idvanvoertuig'] . "'";

//			echo $sql;

        $database->fire_query($sql);
        $last_id = mysqli_insert_id($database->getDb_connection());

    }

    //$database->fire_query($sql);
    //$result = mysqli_query($connection, $sql);

    public static function voeg_favoriet_toe($post){
        global $database;

    $sql = "INSERT INTO	`favoriete`   (`idFavoriete`, 
                                       `idVoertuig`, 
                                       `idKlant`) 
                            VALUES    (NULL,
                                       " . $post['idVoertuig'] . ",
                                       " . $_SESSION['idKlant'] . ")";

//			echo $sql;

        $database->fire_query($sql);
    }

    public static function remove_item_favorieten($post)
    {
        global $database;
        $query = "DELETE FROM `favoriete` WHERE `idKlant` = " . $_SESSION['idKlant'] . "
                                           AND `idVoertuig` = " . $post["idVoertuig"] . " ";
//         echo $query;
        $database->fire_query($query);
    }
}

?>