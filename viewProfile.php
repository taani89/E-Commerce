
<?php
if (!isset($_SESSION)) {
  session_start();
}
// Connects to your Database
mysql_connect("localhost", "root", "") or die(mysql_error());
mysql_select_db("shopper") or die(mysql_error());

//checks cookies to make sure they are logged in
if(isset($_SESSION['MM_Username']))
{
$username = $_SESSION['MM_Username'];
$pass = $_SESSION['password'];
$check = mysql_query("SELECT * FROM register WHERE username = '$username'")or die(mysql_error());
while($info = mysql_fetch_array( $check ))
{

//if the cookie has the wrong password, they are taken to the login page
if ($pass != $info['password'])
{ header("Location: login.php");
}

//otherwise they are shown the admin area
else
{



//this selects everything for the current USER ready to be used in the script below
$result = mysql_query("SELECT * FROM register WHERE username = '$username' LIMIT 1");

//this function will take the above query and create an array
while($row = mysql_fetch_array($result))
  {

//with the array created above, I can create variables (left) with the outputted array (right)

// USER VARIABLES
$email = $row['email'];
$password = $row['password'];
$username = $row['username'];
  }

  
}
}
}
else

//if the cookie does not exist, they are taken to the login screen
{
header("Location: login.php");
}
?>
