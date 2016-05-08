
<?php
$_SESSION["MM_Username"] = "username";
$conn = mysql_connect("localhost","root","");
mysql_select_db("shopper",$conn);
if(count($_POST)>0) {
$result = mysql_query("SELECT *from register WHERE username='" . $_SESSION["MM_Username"] . "'");
$row=mysql_fetch_array($result);
if($_POST["currentPassword"] == $row["password"]) {
mysql_query("UPDATE register set password='" . $_POST["newPassword"] . "' WHERE username='" . $_SESSION["MM_Username"] . "'");
$message = "Password Changed";
} else $message = "Current Password is not correct";
}
?>