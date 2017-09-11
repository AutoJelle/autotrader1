<?php
$userrole = array("admin");
require_once("./security.php");
?>
<div class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-9"><h2>Admin Homepage</h2></div>
        </div>
        <br>
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
                </ul>
            </div>
        </div>
    </div>
</div>