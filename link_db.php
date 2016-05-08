<?php
$currency = 'MYR';
$server = 'localhost';
$userid = 'root';
$password = '';
$dbname = 'shopper';

$conn = mysql_connect("$server", "$userid", "$password");
mysql_select_db("$dbname", $conn) or die(mysql_error());
$mysqli = new mysqli($server, $userid, $password,$dbname);
//echo 'database connected';

//paypal settings
$PayPalMode         = 'sandbox'; // sandbox or live
$PayPalApiUsername  = 'Taani-facilitator-1_api1.hotmail.my'; //PayPal API Username
$PayPalApiPassword  = '2H5V7QH64VG8CJ72'; //Paypal API password
$PayPalApiSignature     = 'AFcWxV21C7fd0v3bYYYRCpSSRl31AWnhMI9dalJYNkReBwjvO7YTRRcr'; //Paypal API Signature
$PayPalCurrencyCode     = 'MYR'; //Paypal Currency Code
$PayPalReturnURL    = 'http://localhost/Ecom/process.php'; //Point to process.php page
$PayPalCancelURL    = 'http://localhost/Ecom/cancel_url.html'; //Cancel URL if user clicks cancel

?>