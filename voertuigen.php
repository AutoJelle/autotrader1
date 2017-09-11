<div class="container">
    <div class="row">
        <?php

        if (!isset($_SESSION['idKlant'])) {
            $_SESSION['idKlant'] = 1;
            $_SESSION['userrole'] = "anon";
        }

        require_once("classes/LoginClass.php");
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

        date_default_timezone_set('Europe/Amsterdam');
        $time = date('H:i:s');

        function check_time($t1, $t2, $tn)
        {
            $t1 = +str_replace(":", "", $t1);
            $t2 = +str_replace(":", "", $t2);
            $tn = +str_replace(":", "", $tn);
            if ($t2 >= $t1) {
                return $t1 <= $tn && $tn < $t2;
            } else {
                return !($t2 <= $tn && $tn < $t1);
            }
        }

        $t1 = "00:00:00";
        $t2 = "23:59:59";
        $t0 = $time;

        $actieVDDagShow = false;
        $actieShow = false;

        $sqlQuery = "SELECT b.idVoertuig FROM type AS a INNER JOIN voertuigtype AS b ON a.idType = b.idType WHERE a.type = '" . $_GET['typeVanVoertuig'] . "' ";
        $sqlQueryResult = $conn->query($sqlQuery);

        if ($sqlQueryResult->num_rows > 0) {
            echo "<div class=\"col-md-12\"><h2>Voertuigen</h2><br></div>";
            while ($sqlQueryRow = $sqlQueryResult->fetch_assoc()) {

                $prijsMetKorting = NULL;

                $sql = "SELECT * FROM voertuig AS a INNER JOIN voertuigtype AS b ON a.idVoertuig = b.idVoertuig WHERE b.idVoertuig = " . $sqlQueryRow['idVoertuig'] . " ORDER BY b.idVoertuig";
                $result = $conn->query($sql);

//            echo $sqlQuery;
//            echo $sql;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {

                        $query = "SELECT * FROM `actie` WHERE idVoertuig = " . $row['idVoertuig'] . " ";
                        $queryResult = $conn->query($query);

                        if ($row['beschikbaar'] != 0) {
                            $sql2 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                            $result2 = $conn->query($sql2);
                            echo "
                            <div class=\"col-md-12\" style=\"float: right;\">
                                <h3>
                        ";
                            while ($row2 = mysqli_fetch_array($result2)) {
                                echo $row2['merk'];
                            }
                            echo " " . $row["model"] . " - " . $row["bouwjaar"] . "</h3>
                            <div class=\"col-md-5\" style=\"float: left;\">
                                <img width='300px;' src=\"images/voertuigen/" . $row["fotopad"] . "\" style=\"margin-left: -15px;\" class=\"img-responsive\">
                            </div>
                            <div class=\"col-md-7\" style=\"float: right; background-color: lightgrey; \">
                                <div class=\"col-md-5\" style=\"float: right; background-color: white; margin-top: 5px; margin-right: -10px;\">
                        ";
                            if ($queryResult->num_rows > 0) {
                                while ($queryRow = $queryResult->fetch_assoc()) {
                                    $prijsMetKorting = ((100 - $queryRow['procentKorting']) / 100) * $row['prijs'];

                                    $sqlX = "SELECT * FROM login WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
                                    $resultX = $conn->query($sqlX);

                                    while ($rowX = $resultX->fetch_assoc()) {
                                        if (isset($_SESSION['idKlant'])) {
                                            if ($queryRow['actieVanDeDag'] == 1) {
                                                if ($queryRow['aantalBesteld'] <= 50) {
                                                    if (check_time($t1, $t2, $t0)) {
                                                        if ((strtotime($queryRow['datum']) == strtotime('today'))) {
                                                            if ($rowX['acties'] == 1) {
                                                                $actieVDDagShow = true;
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                            if ((strtotime($queryRow['datum']) >= strtotime('now')) && (strtotime($queryRow['beginDatum']) <= strtotime('now'))) {
                                                if ($rowX['acties'] == 1) {
                                                    $actieShow = true;
                                                }
                                            } else {
                                            }
                                        } else {
                                            echo "<h1>sssssssssss</h1>";
                                        }
                                    }

                                    if ($actieVDDagShow) {
                                        echo "
                                            <p>
                                                Dit is het artikel van de dag! Voertuig heeft " . $queryRow['procentKorting'] . "% korting tussen 11 en 1.<br>
                                                <b>Oude Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b><br>
                                                <b>Nieuwe Prijs: " . number_format($prijsMetKorting, 0, ',', '.') . "</b>
                                            </p>
                                        ";
                                    } else if ($actieShow) {
                                        echo "
                                                <p>
                                                    Dit voertuig heeft " . $queryRow['procentKorting'] . "% korting! <br>
                                                    <b>Oude Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b><br>
                                                    <b>Nieuwe Prijs: " . number_format($prijsMetKorting, 0, ',', '.') . "</b>
                                                </p>
                                            ";
                                    } else {
                                        echo "
                                            <p>
                                                <b>Prjs: " . number_format($row["prijs"], 0, ',', '.') . "</b>
                                            </p>
                                        ";
                                    }
                                }
                            } else {
                                echo "
                                <p>
                                    <b>Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b>
                                </p>
                            ";
                            }
                            echo "
                            </div>
                                    <p>
                                        <ul style='margin-left: -30px;'>
                                            <li>Eneergielabel: " . $row["milieu"] . "</li>
                                            <li>Km-stand: " . $row["kilometerstand"] . "</li>
                                            <li>Brandstof: " . $row["brandstof"] . "</li>
                                            <li>Schakeling: " . $row["schakeling"] . "</li>
                                        </ul>
                                    </p>
                                </div>
                            </div>
                            <div class=\"col-md-8\" style=\"float: right;\">
                                <div class=\"col-md-2\" style=\"float: right;\">
                        ";
                            if ($queryResult->num_rows > 0) {
                                if ($actieVDDagShow) {
                                    echo "
                                        <a href='index.php?content=actieVoertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                                            <button type=\"button\" style=\"margin-top: -50px; margin-left: -45px\" class=\"btn btn-primary\">Meer Informatie</button>
                                        </a>
                                    ";
                                } else if ($actieShow) {
                                    echo "
                                        <a href='index.php?content=actieVoertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                                            <button type=\"button\" style=\"margin-top: -50px; margin-left: -45px\" class=\"btn btn-primary\">Meer Informatie</button>
                                        </a>
                                    ";
                                } else {
                                    echo "
                                        <a href='index.php?content=voertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                                            <button type=\"button\" style=\"margin-top: -50px; margin-left: -45px\" class=\"btn btn-primary\">Meer Informatie</button>
                                        </a>
                                    ";
                                }
                            } else {
                                echo "
                                <a href='index.php?content=voertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                                    <button type=\"button\" style=\"margin-top: -50px; margin-left: -45px\" class=\"btn btn-primary\">Meer Informatie</button>
                                </a>
                            ";
                            }
                            echo "                                    
                                </div>
                            </div>
                         ";
                        }
                    }
                } else {
//                    echo "Geen resultatennn";
                }
            }
        } else {
            echo "Geen resultaten";
        }
        $conn->close();
        ?>
    </div>
</div>


<!--
if ($queryResult->num_rows > 0) {
while ($queryRow = $queryResult->fetch_assoc()) {
$prijsMetKorting = ((100 - $queryRow['procentKorting']) / 100) * $row['prijs'];

$sqlX = "SELECT * FROM login WHERE `idKlant` = " . $_SESSION['idKlant'] . " ";
$resultX = $conn->query($sqlX);

while ($rowX = $resultX->fetch_assoc()) {
if ($rowX['aVDDGekocht'] == 1) {
} else if ($rowX['aVDDGekocht'] == 0) {
if ($queryRow['actieVanDeDag'] == 1) {
if ($queryRow['aantalBesteld'] <= 50) {
if (check_time($t1, $t2, $t0)) {
if ((strtotime($queryRow['datum']) == strtotime('today'))) {
if ($rowX['acties'] == 1) {
$actieVDDagShow = true;
}
}
}
}
}
}
if ((strtotime($queryRow['datum']) >= strtotime('now')) && (strtotime($queryRow['beginDatum']) <= strtotime('now'))) {
if ($rowX['acties'] == 1) {
$actieShow = true;
}
} else {
}
}

if ($actieVDDagShow) {
echo "
<p>
    Dit is het artikel van de dag! Voertuig heeft " . $queryRow['procentKorting'] . "% korting tussen 11 en 1.<br>
    <b>Oude Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b><br>
    <b>Nieuwe Prijs: " . number_format($prijsMetKorting, 0, ',', '.') . "</b>
</p>
";
} else if ($actieShow) {
echo "
<p>
    Dit voertuig heeft " . $queryRow['procentKorting'] . "% korting! <br>
    <b>Oude Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b><br>
    <b>Nieuwe Prijs: " . number_format($prijsMetKorting, 0, ',', '.') . "</b>
</p>
";
} else {
echo "
<p>
    <b>Prjs: " . number_format($row["prijs"], 0, ',', '.') . "</b>
</p>
";
}
}
} else {
echo "
<p>
    <b>Prijs: " . number_format($row["prijs"], 0, ',', '.') . "</b>
</p>
";
}
-->