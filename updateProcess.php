<?php
include('link_db.php');
$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$dob = $_POST['dob'];
$address = $_POST['address'];
$landmark = $_POST['landmark'];
$zip = $_POST['zip'];
$state = $_POST['state'];
$city = $_POST['city'];
$country = $_POST['country'];

$query = "UPDATE personal SET name ='$name',email='$email',mobile='$mobile',dob='$dob',address='$address',landmark='$landmark',zip='$zip',state='$state',city='$city',country='$country'";
mysql_query($query);
header('Location:http://localhost/Ecom/addprofile.php');
echo "<a href=\"account.php\">list</a>";
mysql_close();

?>