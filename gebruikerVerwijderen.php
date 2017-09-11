<?php
$userrole = array("admin");
require_once("./security.php");

?>

<style>
    td {
        min-width: 200px;
    }

    .btn {
        float: right;
    }
</style>


<div class="container">

    <?php

    require_once("classes/LoginClass.php");
    if (isset($_POST['removeUser'])) {
        include('connect_db.php');

        $sql = "DELETE FROM	`login` WHERE `idKlant` = " . $_POST['idKlant'] . " ";


        //echo $sql;
        $database->fire_query($sql);
        //$result = mysqli_query($connection, $sql);

        header("refresh:4;url=index.php?content=adminHomepage");
        echo "<h3 style='text-align: center;' >Uw wijzigingen zijn verwerkt.</h3>";

    } else {
    ?>
    <div class="row">
        <div class="col-md-12"><h2>Gebruiker verwijderen</h2></div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <ul class="breadcrumb">
<!--                <li><a href="index.php?content=adminHomepage">Admin homepage</a></li>-->
                <li><a href="index.php?content=voertuigToevoegen">Voertuigen toevoegen</a></li>
                <!--                    <li><a href="index.php?content=voertuigenBeheren">Voertuigen beheren</a></li>-->
                <li><a href="index.php?content=verwijderVoertuig">Voertuigen verwijderen</a></li>
                <li><a href="index.php?content=rolWijzigen">Gebruikerrol veranderen</a></li>
                <li><a href="index.php?content=blokkeren">Gebruiker blokkeren</a></li>
                <li><a href="index.php?content=gebruikerVerwijderen">Gebruiker verwijderen</a></li>
                <li><a href="index.php?content=berichtenBekijken">Berichten bekijken</a></li>
                <li><a href="index.php?content=merkToevoegen">Merk toevoegen</a></li>
<!--                <li><a href="index.php?content=typeToevoegen">Type toevoegen</a></li>-->
            </ul>
        </div>
    </div>

    <div class="col-md-12">
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

        $sql = "SELECT * FROM `login`";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                echo "
                    <table class=\"table table - responsive\">
                        <thead>
                        <tr>
                            <th>
                                    Naam:
                            </th>
                            <th>
                                    E-mail:
                            </th>
                            <th>
                                    Rol:
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td>
                                    " . $row["naam"] . "
                            </td>
                            <td>
                                    " . $row['email'] . "
                            </td>
                            <td>
                                    " . $row['userrole'] . "
                            </td>
                            <td>
                                <form role=\"form\" action='' method='post'>
                                    <input type='submit' class=\"btn btn-info\" name='removeUser' value='Verwijder Gebruiker'>
                                    <input type='hidden' class=\"btn btn-info\" name='idKlant' value='" . $row['idKlant'] . "'/>
                                </form>
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

        <br><br>
    </div>
</div>
<?php

}
?>
