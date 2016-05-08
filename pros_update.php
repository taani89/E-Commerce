
<?php 
include('link_db.php');
$id = $_POST['id'];
$username = $_POST['username'];
$email = $_POST['email'];
$mobile = $_POST['mobile'];
$dob = $_POST['dob'];

$query = "UPDATE profile SET username='$username',email='$email',mobile='$mobile',dob='$dob' WHERE id='$id'";
mysql_query($query);
header('Location:http://localhost/Ecom/account.php');
/*echo "Record Updated";
*/
mysql_close();

?>
