<?php
	require_once("./classes/SessionClass.php");
	$session->logout();
    header("location:index.php?content=inloggen_Registreren");
?>