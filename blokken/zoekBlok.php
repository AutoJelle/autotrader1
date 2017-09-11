<style>
    .pageDivZoekBlok {
        background-color: #ECECEC;
    }

    #actieVanDeDagDiv {
        background-color: gold;
        -webkit-transform: rotate(-20deg);
        -moz-transform: rotate(20deg);
        border: 10px dashed black;
        border-radius: 10px;
        float: left;
        margin-top: 50px;
        padding: 10px;
        padding-bottom: 25px;
        padding-top: -5px;
    }

    #zoekenKnopDiv{
        background-color: forestgreen;
        border: 1px solid black;
        border-radius: 10px;
        float: none;
        width: 350px;
        padding: 10px;
        padding-bottom: 5px;
        padding-top: 5px;
        margin-top: -60px;

    }

    a, a:hover {
        color: black;
        text-decoration: none;
    }
</style>
<div class="container-fluid pageDiv pageDivZoekBlok">
    <div class="pageDivContent">
        <div class="zoekBlokClass row">
            <div class="col-md-5">
                <?php

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

                $sql = "SELECT * FROM `actie` WHERE `actieVanDeDag` = 1 AND `datum` = CURRENT_DATE()";

                if (isset($_SESSION['idKlant'])) {
                    $sql2 = "SELECT * FROM `login` WHERE idKlant = " . $_SESSION['idKlant'] . " ";
                    $result2 = $conn->query($sql2);


                    $result = $conn->query($sql);

                    while ($row = $result->fetch_assoc()) {
                        while ($row2 = $result2->fetch_assoc()) {
                            if ($row['actieVanDeDag'] == 1) {
                                if ($row['aantalBesteld'] <= 50) {
                                    if (check_time($t1, $t2, $t0)) {
                                        if ((strtotime($row['datum']) == strtotime('today'))) {
                                            if ($row2['acties'] == 1) {
                                                $actieVDDagShow = true;
                                            }
                                        }
                                    }
                                }

                                /*
                                    if ($queryRow['actieVanDeDag'] == 1) {
                                    if ($queryRow['aantalBesteld'] <= 50) {
                                    if (check_time($t1, $t2, $t0)) {
                                    if ((strtotime($queryRow['datum']) == strtotime('today'))) {

                                */
                            } else if ((strtotime($queryRow['datum']) >= strtotime('now')) && (strtotime($queryRow['beginDatum']) <= strtotime('now'))) {
                                if ($rowX['acties'] == 1) {
                                    $actieShow = true;
                                }
                            } else {
                            }

                            if ($actieVDDagShow) {
                                echo "
                    <a href='index.php?content=actieVoertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                        <div id='actieVanDeDagDiv'>
                            <h3 style='text-align: center; font-family: Algerian;'><small style='color: black;'>Klik hier voor</small><br>Artikel van de dag!</h3>
                        </div>
                    </a>
                    ";
                            }
                        }
                    }
                }
                ?>

            </div>
        </div>
        <a href='index.php?content=zoeken'>
            <div id='zoekenKnopDiv'>
                <h4 style='text-align: center; color: white;'>Klik hier om te zoeken</h4>
            </div>
        </a>
    </div>
</div>

