<?php
require_once('MySqlDatabaseClass.php');

class BerichtClass
{
    public static function insert_message_into_database($post)
    {
        global $database;
        $query = "INSERT INTO `berichten` (`idBericht`, `naam`, `telNummer`, `email`, `bericht`) 
                      VALUES (NULL, '" . $post['name'] . "', '" . $post['phone'] . "', '" . $post['email'] . "', '" . $post['message'] . "')";
        $database->fire_query($query);
    }
}

?>