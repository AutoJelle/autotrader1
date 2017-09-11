<?php
require_once('MySqlDatabaseClass.php');
require_once("LoginClass.php");
require_once("SessionClass.php");

class MerkClass
{
    //Fields
    private $idMerk;
    private $merk;

    public function getIdMerk()
    {
        return $this->idMerk;
    }

    public function getMerk()
    {
        return $this->merk;
    }


    //setters
    public function setIdMerk($value)
    {
        $this->idMerk = $value;
    }

    public function setMerk($value)
    {
        $this->merk = $value;
    }

    public function __construct()
    {
    }

    //Methods


    public static function insert_merk_into_database($merk)
    {
        global $database;

        $sql = "SELECT idMerk FROM merk ORDER BY idMerk DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastMerkID = ($row['idMerk'] + 1);
        }
    
        $query = "INSERT INTO `merk` (`idMerk`, `merk`) 
                      VALUES ($lastMerkID, '" . $merk . "')";
        //echo $query;

        //echo "<br>";
        $database->fire_query($query);
        $last_id = mysqli_insert_id($database->getDb_connection());
    }

}

?>