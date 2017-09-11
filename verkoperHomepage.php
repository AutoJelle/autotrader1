<?php
$userrole = array("admin", "verkoper");
require_once("./security.php");
?>
<div class="section">

    <div class="container">
        <div class="row">
            <div class="col-md-12"><h2>Verkoper homepage</h2></div>
        </div>
        <div class="row">
            <div class="col-md-9">
                <ul class="list-group">
                    <li class="list-group-item"><a href="index.php?content=voertuigToevoegen">Voertuigen toevoegen</a></li>
<!--                    <li class="list-group-item"><a href="index.php?content=voertuigenBeheren">Voertuigen beheren</a></li>-->
                    <li class="list-group-item"><a href="index.php?content=verwijderVoertuig">Voertuigen bekijken / verwijderen</a></li>
                    <li class="list-group-item"><a href="index.php?content=merkToevoegen">Merk toevoegen</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>