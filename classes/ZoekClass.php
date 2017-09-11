<?php
require_once('MySqlDatabaseClass.php');

class ZoekClass
{
    public static function advanced_search()
    {
        global $database;

        $by_merk = $_POST['by_merk'];
        $by_type = $_POST['by_type'];
        $by_bouwjaar = $_POST['by_bouwjaar'];
        $by_brandstof = $_POST['by_brandstof'];
        $by_schakeling = $_POST['by_schakeling'];
        $by_model = $_POST['by_model'];
        $by_kilometerstand = $_POST['by_kilometerstand'];
        $by_kleur = $_POST['by_kleur'];
        $by_aantalZitplaatsen = $_POST['by_aantalZitplaatsen'];
        $by_versnellingen = $_POST['by_versnellingen'];
        $by_prijs = $_POST['by_prijs'];
//        $by_ = $_POST['by_'];

        //Do real escaping here

//        SELECT c.*, b.merk FROM voertuig as c INNER JOIN voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk AND a.idVoertuig = c.idVoertuig WHERE a.idVoertuig = 1
//        $queryA = "SELECT * FROM voertuig";
//        $queryA = "SELECT c.*, b.merk FROM voertuig as c INNER JOIN voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk AND a.idVoertuig = c.idVoertuig";
        $queryA = "SELECT c.*, b.merk, d.type FROM voertuig as c INNER JOIN voertuigmerk AS a INNER JOIN merk AS b INNER JOIN type AS d INNER JOIN voertuigtype AS e ON a.idMerk = b.idMerk AND a.idVoertuig = c.idVoertuig AND d.idType = e.idType AND e.idVoertuig = c.idVoertuig";
        $conditions = array();

        if ($by_merk != "") {
            $conditions[] = "merk='$by_merk'";
        }
        if ($by_type != "") {
            $conditions[] = "type='$by_type'";
        }
        if ($by_bouwjaar != "") {
            $conditions[] = "bouwjaar='$by_bouwjaar'";
        }
        if ($by_brandstof != "") {
            $conditions[] = "brandstof='$by_brandstof'";
        }
        if ($by_schakeling != "") {
            $conditions[] = "schakeling='$by_schakeling'";
        }
        if ($by_model != "") {
            $conditions[] = "model='$by_model'";
        }
        if ($by_kilometerstand != "") {
            $conditions[] = "kilometerstand='$by_kilometerstand'";
        }
        if ($by_kleur != "") {
            $conditions[] = "kleur='$by_kleur'";
        }
        if ($by_aantalZitplaatsen != "") {
            $conditions[] = "aantalZitplaatsen='$by_aantalZitplaatsen'";
        }
        if ($by_versnellingen != "") {
            $conditions[] = "versnellingen='$by_versnellingen'";
        }
        if ($by_prijs != "") {
            $conditions[] = "prijs='$by_prijs'";
        }
//        if($by_ !="") {
//            $conditions[] = "='$by_'";
//        }

        $sqlA = $queryA;
        if (count($conditions) > 0) {
            $sqlA .= " WHERE " . implode(' AND ', $conditions);
        }

        $resultA = $database->fire_query($sqlA);


//        $by_merk = $_POST['by_merk'];
//
//        $queryB = "SELECT * FROM merk";
//        $conditionsB = array();
//
//        if ($by_merk != "") {
//            $conditionsB[] = "merk='$by_merk'";
//        }
//
//        $sqlB = $queryB;
//        if (count($conditionsB) > 0) {
//            $sqlB .= " WHERE " . implode(' AND ', $conditionsB);
//        }
//
//        echo $sqlB;
//        $resultB = $database->fire_query($sqlB);
//
//        if ($resultB->num_rows > 0) {
//            while ($rowB = $resultB->fetch_assoc()) {
//                echo "<br>" . $rowB['merk'];
//            }
//        }

        echo "
            <h3>Resultaten</h3>
            <table id=\"myTable2\">
                <tr class=\"header\">
                    <th>Merk</th>
                    <th>Type</th>
                    <th>Model</th>
                    <th>Schakeling</th>
                    <th>Brandstof</th>
                    <th>Bouwjaar</th>
                    <th>Kilometerstand</th>
                    <th>Kleur</th>
                    <th>Aantal Zitplaatsen</th>
                    <th>Versnellingen</th>
                    <th>Prijs</th>
                </tr>
            ";

        if ($resultA->num_rows > 0) {
            while ($rowA = $resultA->fetch_assoc()) {

                $sql2 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $rowA['idVoertuig'] . " ";
                $result2 = $database->fire_query($sql2);

                $sql3 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $rowA['idVoertuig'] . " ";
                $result3 = $database->fire_query($sql3);

                while ($row2 = $result2->fetch_assoc()) {
                    while ($row3 = $result3->fetch_assoc()) {
                        echo "
                            <tr>
                                <td> " . $row2['merk'] . " </td>
                                <td> " . $row3['type'] . " </td>
                                <td> " . $rowA['model'] . " </td>
                                <td> " . $rowA['schakeling'] . " </td>
                                <td> " . $rowA['brandstof'] . " </td>
                                <td> " . $rowA['bouwjaar'] . " </td>
                                <td> " . $rowA['kilometerstand'] . " </td>
                                <td> " . $rowA['kleur'] . " </td>
                                <td> " . $rowA['aantalZitplaatsen'] . " </td>
                                <td> " . $rowA['versnellingen'] . " </td>
                                <td> &euro; " . number_format($rowA['prijs'], 0, ',', '.') . " <br>
                                    <a href='index.php?content=voertuigPagina&idVoertuig=" . $rowA["idVoertuig"] . "'>
                                        <button type=\"button\" style='padding: 0px; margin: 0; min-width: 100px; ' class=\"btn btn-primary\">Meer<br>Informatie</button>
                                    </a>
                                </td>    
                            </tr>
                        ";
                    }
                }

            }
        } else {
            echo "Geen resultaten gevonden.";
        }

        echo "</table>";


        return $resultA;
    }
}

?>


