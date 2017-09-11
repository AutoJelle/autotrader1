<?php
require_once('MySqlDatabaseClass.php');
require_once("LoginClass.php");
require_once("SessionClass.php");

class TypeClass
{
    //Fields
    private $idType;
    private $type;

    public function getIdType()
    {
        return $this->idType;
    }

    public function getType()
    {
        return $this->type;
    }


    //setters
    public function setIdType($value)
    {
        $this->idType = $value;
    }

    public function setType($value)
    {
        $this->type = $value;
    }

    public function __construct()
    {
    }

    //Methods


    public static function insert_type_into_database($type)
    {
        global $database;

        $sql = "SELECT idType FROM type ORDER BY idType DESC LIMIT 1";
        $result = $database->fire_query($sql);
        while ($row = $result->fetch_assoc()) {
            $lastTypeID = ($row['idType'] + 1);
        }
    
        $query = "INSERT INTO `type` (`idType`, `type`) 
                      VALUES ($lastTypeID, '" . $type . "')";
        //echo $query;

        $database->fire_query($query);
        $last_id = mysqli_insert_id($database->getDb_connection());
    }

}

?>