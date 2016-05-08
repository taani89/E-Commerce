<?php
if (!isset($_SESSION)) {
  session_start();
  include_once("link_db.php");
}


mysql_query("SET names UTF8");
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $name = $_POST['name'];
    if(empty($email)){
        echo "Please key in your email address!";
    }else{
        @mysql_query("INSERT INTO newsletter SET email='$email',name='$name'");
        $message = "G'Day!
 
You have subscribe to our newsletter,
Let's start shopping at our store,
Search for your right brands for laptops and smartphones :
 
http://localhost/Ecom/home.html
 
If you have any problems, feel free to contact me at <Taani@hotmail.my>.
 
-SF
Shopper Friends
";
 
if(mail($_POST['email'],"Thank you for subscribing",
$message, "From:Shopper Friend <Taani@hotmail.my>"))
{echo "<center><b>THANK YOU</b> <br>FOR SUBSCRIBING TO OUR NEWSLETTER,WE WILL EMAIL YOU FROM TIME TO TIME FOR ANY UPDATES.</center>";}
	}
}
?>  