<?php
$userrole = array("admin", "eigenaar");
require_once("./security.php");

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

?>
    <style>
        td {
            min-width: 280px;
        }

        .btn {
            float: right;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>Gebruiker Blokkeren</h2></div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <!--                    <li><a href="index.php?content=adminHomepage">Admin homepage</a></li>-->
                    <li><a href="index.php?content=voertuigToevoegen">Voertuigen toevoegen</a></li>
                    <!--                    <li><a href="index.php?content=voertuigenBeheren">Voertuigen beheren</a></li>-->
                    <li><a href="index.php?content=verwijderVoertuig">Voertuigen verwijderen</a></li>
                    <li><a href="index.php?content=rolWijzigen">Gebruikerrol veranderen</a></li>
                    <li><a href="index.php?content=blokkeren">Gebruiker blokkeren</a></li>
                    <li><a href="index.php?content=gebruikerVerwijderen">Gebruiker verwijderen</a></li>
                    <li><a href="index.php?content=berichtenBekijken">Berichten bekijken</a></li>
                    <li><a href="index.php?content=merkToevoegen">Merk toevoegen</a></li>
<!--                    <li><a href="index.php?content=typeToevoegen">Type toevoegen</a></li>-->
                </ul>
            </div>
        </div>


        <div class="col-md-6">

            <?php
            $sql = "SELECT * FROM `berichten` ORDER BY idBericht DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <table class='table table-responsive'>
                        <thead>
                        <tr>
                            <th>
                                Klant naam:
                            </th>
                            <th>
                                Klant E-mail adres:
                            </th>
                            <th>
                                Klant telefoon nummer:
                            </th>
                            <th>
                                Bericht:
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                " . $row['naam'] . "
                            </td>
                            <td>
                                " . $row['email'] . "
                            </td>
                            <td>
                                " . $row['telNummer'] . "
                            </td>
                            <td>
                                " . $row['bericht'] . "
                            </td>
                        </tr>
                        </tbody>
                        </table>
                     ";
                }
            } else {
                echo "Geen resultaten";
            }
            $conn->close();
            ?>
        </div>
    </div>
<?php
?>