<?php
require_once("classes/LoginClass.php");
require_once("classes/BuyClass.php");
require_once("classes/ZoekClass.php");
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

?>

<style>
    * {
        box-sizing: border-box;
    }

    .button {
        padding: 10px;
        margin: 10px;
    }

    #search {
        background-position: 10px 10px;
        background-repeat: no-repeat;
        width: 100%;
        font-size: 16px;
        padding: 12px 20px 12px 40px;
        border: 1px solid black;
        margin-bottom: 12px;
    }

    #myTable, #myTable1, #myTable2 {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
        font-size: 16px;
    }

    #myTable th, #myTable td, #myTable1 th, #myTable1 td, #myTable2 th, #myTable2 td {
        text-align: left;
        padding: 5px;
        /*min-width: 140px;*/
    }


    #myTable, #myTable1{
        border-bottom: 1px solid #ddd;
        width: 120%;
        margin-left: -100px;
    }

    #myTable tr, #myTable1 tr {
        border-bottom: 1px solid #ddd;
        width: 150%;
    }

    #myTable2 tr{
        border-bottom: 1px solid #ddd;
    }

    #myTable2 th{
        padding: 10px;
        padding-left: 5px;
    }

    #myTable td, #myTable1 tr th {
        border-bottom: 1px solid #ddd;
        width: 9.09%;
        /*border: 2px solid red;*/
    }

    #myTable tr.header, #myTable1 tr.header, #myTable2 tr.header, #myTable tr:hover {
        background-color: #f1f1f1;
    }

    #tableSearchFields td {
        display: block;
        margin-bottom: 10px;
    }

</style>
<div class="container">
    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs navTabs">
                <li class="active navTabsTab"><a data-toggle="tab" href="#geavanceerdZoeken">Geavanceerd Zoeken</a></li>
                <li class="navTabsTab"><a data-toggle="tab" href="#zoeken">Zoeken</a></li>
            </ul>
            <div class="tab-content">
                <div id="geavanceerdZoeken" class="tab-pane fade in active">
                    <h3>Geavanceerd Zoeken</h3>

                    <form action="" method="post" style="width: 50%;">
                        <table width="100%" border="0" style="border:none;" id="tableSearchFields">
                            <tr>
                                <td>
                                    <label>Merk:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_merk"/>
                                </td>
                                <td>
                                    <label>Type:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_type"/>
                                </td>
                                <td>
                                    <label>Model:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_model"/>
                                </td>
                                <td>
                                    <label>Schakeling:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_schakeling"/>
                                </td>
                                <td>
                                    <label>Brandstof:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_brandstof"/>
                                </td>
                                <td>
                                    <label>Bouwjaar:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_bouwjaar"/>
                                </td>
                                <td>
                                    <label>Kilometerstand:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_kilometerstand"/>
                                </td>
                                <td>
                                    <label>Kleur:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_kleur"/>
                                </td>
                                <td>
                                    <label>Aantal Zitplaatsen:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_aantalZitplaatsen"/>
                                </td>
                                <td>
                                    <label>Versnellingen:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_versnellingen"/>
                                </td>
                                <td>
                                    <label>Prijs:&nbsp;</label>
                                    <input class="form-control" type="text" name="by_prijs"/>
                                </td>
                                <!--                                <td><label>:&nbsp;</label><input type="text" name="by_" /></td>-->
                                <td>
                                    <input class="btn btn-success button" type="submit" name="submit1" value="Search"/>
                                </td>
                            </tr>
                        </table>
                    </form>

                    <?php
                    if (isset($_POST['submit1'])) {
                        ZoekClass::advanced_search();
                        echo "
                        <div id='scrollDiv' style='visibility: collapse;'></div>
                        <script>
                            window.scrollTo(0,document.body.scrollHeight);
                        </script>
                        ";
                    }
                    ?>

                </div>
                <div id="zoeken" class="tab-pane fade">
                    <h3>Zoeken</h3>
                    <input type="text" id="search" placeholder="Zoek door bestaande voertuigen">

                    <!--    <input type="checkbox" id="schakeling" name="schakeling" value="Handmatig"> Handmatig <br>-->
                    <!--    <input type="checkbox" id="schakeling" name="schakeling" value="Automatisch"> Automatisch <br>-->

                    <table id="myTable1">
                        <tr class="header">
                            <th>Merk</th>
                            <th>Model</th>
                            <th>Schakeling</th>
                            <th>Brandstof</th>
                            <th>Type</th>
                            <th>Bouwjaar</th>
                            <th>Kilometerstand</th>
                            <th>Kleur</th>
                            <th>Aantal Zitplaatsen</th>
                            <th>Versnellingen</th>
                            <th>Prijs</th>
                        </tr>
                    </table>
                    <table id="myTable">

                        <?php

                        $sql = "SELECT * FROM voertuig ORDER BY idVoertuig";
                        $result = $conn->query($sql);
                        ?>

                        <?php
                        //                        echo $sql . "<br>";
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {

                                $sql2 = "SELECT b.merk FROM voertuigmerk AS a INNER JOIN merk AS b ON a.idMerk = b.idMerk WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                                $result2 = $conn->query($sql2);

                                $sql3 = "SELECT b.type FROM voertuigtype AS a INNER JOIN `type` AS b ON a.idType = b.idType WHERE a.idVoertuig = " . $row['idVoertuig'] . " ";
                                $result3 = $conn->query($sql3);

                                while ($row2 = $result2->fetch_assoc()) {
                                    while ($row3 = $result3->fetch_assoc()) {
                                        echo "
                            <tr>
                                    
                                <td> " . $row2['merk'] . " </td>
                                <td> " . $row['model'] . " </td>
                                <td> " . $row['schakeling'] . " </td>
                                <td> " . $row['brandstof'] . " </td>
                                <td> " . $row3['type'] . " </td>
                                <td> " . $row['bouwjaar'] . " </td>
                                <td> " . $row['kilometerstand'] . " </td>
                                <td> " . $row['kleur'] . " </td>
                                <td> " . $row['aantalZitplaatsen'] . " </td>
                                <td> " . $row['versnellingen'] . " </td>
                                <td> &euro; " . number_format($row['prijs'], 0, ',', '.') . " <br>
                                    <a href='index.php?content=voertuigPagina&idVoertuig=" . $row["idVoertuig"] . "'>
                                            <button type=\"button\" style='padding: 0px; margin: 0; min-width: 100px; ' class=\"btn btn-primary\">Meer<br>Informatie</button>
                                    </a>
                                </td>
                            </tr>
                        ";
                                    }

                                }
                            }
                        }
                        ?>
                    </table>

                    <script src="//cdnjs.cloudflare.com/ajax/libs/list.js/1.5.0/list.min.js"></script>

                    <script>
                        var $rows = $('#myTable tr');
                        $('#search').keyup(function () {
                            var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

                            $rows.show().filter(function () {
                                var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
                                return !~text.indexOf(val);
                            }).hide();
                        });
                    </script>
                </div>

            </div>
        </div>
    </div>


</div>