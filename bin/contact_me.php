<?php
// Check for empty fields
if(empty($_POST['name'])      ||
   empty($_POST['email'])     ||
   empty($_POST['phone'])     ||
   empty($_POST['message'])   ||
   !filter_var($_POST['email'],FILTER_VALIDATE_EMAIL))
   {
   echo "Niet genoeg gegevens ingevoerd!";
   return false;
   }

$name = strip_tags(htmlspecialchars($_POST['name']));
$email_address = strip_tags(htmlspecialchars($_POST['email']));
$phone = strip_tags(htmlspecialchars($_POST['phone']));
$message = strip_tags(htmlspecialchars($_POST['message']));

// Create the email and send the message
$to = 'jellevandenbroek@gmail.com';
$email_subject = "Contact formulier autotrader van:  $name";
$email_body = "U heeft het volgende bericht ontvangen van de website autotrader.nl.\n\n"."Naam: $name\n\nEmail: $email_address\n\nTelefoon: $phone\n\nBericht:\n$message";
$headers = "From: noreply@autotrader.com\n";
$headers .= "Reply-To: $email_address";   
mail($to,$email_subject,$email_body,$headers);
return true;

?>
