<?php require_once('Connections/link_db.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  $MM_dupKeyRedirect="login.php";
  $loginUsername = $_POST['username'];
  $LoginRS__query = sprintf("SELECT username FROM register WHERE username=%s", GetSQLValueString($loginUsername, "text"));
  mysql_select_db($database_link_db, $link_db);
  $LoginRS=mysql_query($LoginRS__query, $link_db) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    $MM_qsChar = "?";
    //append the username to the redirect page
    if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    $MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    header ("Location: $MM_dupKeyRedirect");
    exit;
  }
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "create")) {
  $insertSQL = sprintf("INSERT INTO register (email, password, username) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_link_db, $link_db);
  $Result1 = mysql_query($insertSQL, $link_db) or die(mysql_error());
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "create")) {
  $insertSQL = sprintf("INSERT INTO register (email, password,  username) VALUES (%s, %s, %s)",
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['username'], "text"));

  mysql_select_db($database_link_db, $link_db);
  $Result1 = mysql_query($insertSQL, $link_db) or die(mysql_error());
// Email the new password to the person.
$message = "G'Day!
 
Your personal account for the Shopper Friend
has been created! To log in, proceed to the
following address:
 
http://localhost/Ecom/login.php
 
Your personal login ID and password are as follows:
 
username: $_POST[username]
password: $_POST[password]
 
You aren't stuck with this password! You can change it at any time after you have logged in.
 
If you have any problems, feel free to contact me at <Taani-facilitator-1@hotmail.my>.
 
-SF
Shopper Friends
";
 
if(mail($_POST['email'],"Your Password for Your Shopper Friend Online Shopping",
$message, "From:Shopper Friend <Taani-facilitator-1@hotmail.my>"))
{echo "<center><b>THANK YOU</b> <br>Your password is posted to your emil address .Please check your mail after some time.</center>";}
	

  $insertGoTo = "login.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "home.php";
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_link_db, $link_db);
  
  $LoginRS__query=sprintf("SELECT username, password FROM register WHERE username=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $link_db) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<script type="text/javascript">
  function myClose() {
    close();
  }
</script>
<head>
	<title>SHOPPER FRIENDS</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="css/images/favicon.ico" />
     <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
     <link rel="stylesheet" href="css/normalize.css">
      <link rel="stylesheet" href="css/styleLogin.css">
      <style type="text/css">
      body {
	background-image: url(css/images/background-kuning.jpg);
}
      </style>
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="media" />
		<script src="js/png-fix.js" type="text/javascript" charset="utf-8"></script>
	<![endif]-->
<script src="js/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
<script src="js/jquery-func.js" type="text/javascript" charset="utf-8"></script>
<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>	
<script src="js/index.js"></script>
</head>
<body>
	<!-- Wrapper -->
	<div id="wrapper">
		<!-- Header -->
		<div id="top">
			<!-- Shell -->
			<div class="shell">
				<div class="top-nav">
					<ul>
					    <li class="first nobg"><a href="home.php" target="_self">Welcome
				        message!</a></li>
					    <li><a href="login.php" target="_self" title="Login">Login</a></li>
					    <li><a href="account.php" target="_self" title="My Account">My Account</a></li>
					 
					    <li class="nobg"><a href="view_cart.php" class="bag" title="My Bag">My Bag</a></li>
					</ul>
				</div>
				
				<div class="cl">&nbsp;</div>
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Top -->
		<!-- Main -->
		<div id="main">
			<!-- Shell -->
			<div class="shell">
				<!-- Header -->
				<div id="header">
					<h1 id="logo"><a href="#" class="notext" title="Shopper Friend">Shopper Friend</a></h1>
					<div id="navigation">
						<ul>
						    <li><a href="laptops.php" target="_self"><span>Laptops</span></a></li>
						    <li><a href="smartphones.php" target="_self"><span>Smartphones</span></a></li>
						</ul>
					</div>
					<div class="cl">&nbsp;</div>
				</div>
				<!-- End Header -->
				<!-- Slider -->
				<div id="main-slider">
					<div id="slider-holder">
						<ul>
						    <li>
					    	<img src="css/images/BANNERa.jpg" alt="Slider Image 1" /></li>
						    <li>
						    	<img src="css/images/banner2a.jpg" alt="Slider Image 1" />
						    </li>
						    <li>
						    	<img src="css/images/slider-image-1.jpg" alt="Slider Image 1" />
						    	<div class="cnt">
					    		  <h4>iMac</h4>
						    		<h2>Performance and design. Taken right to the edge.</h2>
						    		<p>21.5-inch starting at RM4091.80</br>27-inch starting at RM6698.04</p>
						    		
						    	</div>
						    </li>
						</ul>
					</div>
					<div class="nav">
						<a href="#" title="First Slide">&nbsp;</a>
						<a href="#" title="Second Slide">&nbsp;</a>
						<a href="#" title="Third Slide">&nbsp;</a>
					</div>
				</div>
				<!-- End Slider -->
				<div class="logmod">
  <div class="logmod__wrapper">
    <span class="logmod__close"> Close</span>
    <div class="logmod__container">
      <ul class="logmod__tabs">
        <li data-tabtar="lgm-2"><a href="#">Login</a></li>
        <li data-tabtar="lgm-1"><a href="#">Sign Up</a></li>
      </ul>
      <div class="logmod__tab-wrapper">
      <div class="logmod__tab lgm-1">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Enter your personal details <strong>to create an acount</strong></span>
        </div>
        <div class="logmod__form">
          <form method="POST" name="create" action="<?php echo $editFormAction; ?>" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" >Email*</label>
                <input class="string optional" maxlength="255" name="email"  placeholder="Email" type="email" size="50" />
              </div>
              <div class="input full">
                <label class="string optional" >Username*</label>
                <input class="string optional" maxlength="255" name="username" placeholder="Username" type="username" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input string optional">
                <label class="string optional" >Password *</label>
                <input class="string optional" maxlength="255" name="password" placeholder="Password" type="password" size="50" />
              </div>
            </div>
            <div class="simform__actions">
              <input class="submit" name="submit" type="submit" value="Create Account" />
              <span class="simform__actions-sidetext">By creating an account you agree to our <a class="special" href="term&con.html" target="_blank" role="link">Terms & Privacy</a></span>
            </div>
            <input type="hidden" name="MM_insert" value="create" /> 
          </form>
        </div> 
       
      </div>
      <div class="logmod__tab lgm-2">
        <div class="logmod__heading">
          <span class="logmod__heading-subtitle">Enter your Username and password <strong>to sign in</strong></span>
        </div> 
        <div class="logmod__form">
          <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" name="login" class="simform">
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" >Username*</label>
                <input class="string optional" maxlength="255" id="username" name="username" placeholder="Username" type="username" size="50" />
              </div>
            </div>
            <div class="sminputs">
              <div class="input full">
                <label class="string optional" >Password *</label>
                <input class="string optional" maxlength="255" id="password" name="password" placeholder="Password" type="password" size="50" />
                						<span class="hide-password">Show</span>
              </div>
            </div>
            <div class="simform__actions">
              <input class="submit" name="submit" type="submit" value="Log In" id="Submit" />
              <span class="simform__actions-sidetext"><a class="special" role="link" href="forgot.php" target="new">Forgot your password?<br>Click here</a></span>
            </div> 
          </form>
        </div> 
          </div>
      </div>
    </div>
  </div>
</div>
 
			</div>
			<!-- End Shell -->
		</div>
		<!-- End Main -->
		<div id="footer-push" class="cl">&nbsp;</div>
	</div>
	<!-- End Wrapper -->
	<!-- Footer -->
	<div id="footer">
		<!-- Shell -->
		<div class="shell">
			<!-- Cols -->
			<div class="cols">
				<ul>
				    <li class="col">
				    	<h4>About Shopper Friend</h4>
				    	<p>Shopper friend is a company that doing online-business and parcel delivery.Shopper Friend located in Tanjung Malim, Perak. 
Generally, we’re selling products that are mostly about brand new quality of Laptops and Smartphones.Customers don’t 
have to waste fuel for a ride to our company but they have to open our website, review our products and order if they are 
willing to buy our product.</p>
<a href="#" class="more-link" title="Read More"  onclick="MM_openBrWindow('aboutus.html','About us','scrollbars=yes,width=480,height=640')">Read More >></a>				    </li>
				    <li class="col social">
				    	<h4>get social</h4>
				    	<ul>
				    	    <li><a href="https://www.facebook.com/" class="fb-link" title="Facebook">facebook</a></li>
				    	    <li><a href="https://twitter.com/" class="twitter-link" title="Twitter">twitter</a></li>				    	   					 <li><a href="https://www.blogger.com/" class="blogger-link" title="Blogger">blogger</a></li>
				    	</ul>
				    </li>
				    <li class="col partners">
				    	<h4>partners</h4>
				    	<ul>
			    	      <li><a href="http://www.upsi.edu.my/" target="new" title="upsi">Universiti Pendidikan Sultan Idris</a></li>
				    	    <li><a href="http://www.ipmart.com.my/main/index.php" target="new" title="ipmart">ipmart.com.my</a></li>
				    	    <li><a href="http://www.lazada.com.my/shop-computers-laptops/" target="new" title="lazada">Lazada.com.my</a></li>
				    	    <li><a href="http://www.redcom.com.my/" target="new" title="redcom">Redcom Computer</a></li>
				    	</ul>
				    </li>
				    <li class="col contact">
				    	<h4>newsletter</h4>
				    	<p>Feel Free to Subscribe to our newsletter</p>
				    	<form action="newsprocess.php" method="post" target="_blank">
				    		<div class="field-wrapper">
				    			<input type="text" class="field" name="name" value="Name" title="Name" />
				    		</div>
				    		<div class="field-wrapper">
				    			<input type="text" class="field" name="email" value="Email" title="Email" />
				    		</div>
				    		<input type="submit" value="Submit" name="submit" class="submit-btn" title="Submit" />
				    		<div class="cl">&nbsp;</div>
				    	</form>
				    </li>
				</ul>
				<div class="cl">&nbsp;</div>
			</div>
			<!-- End Cols -->
			<p class="copy">&copy; http://localhost/Ecom/home.html Design by TLS Group</p>
			<a href="home.html" title="Shopper Friend" target="_self" class="logo"><img src="css/images/footer-logo.png" alt="Shopper Friend" /></a>
			<div class="cl">&nbsp;</div>
		</div>
		<!-- End Shell -->
	</div>
	<!-- End Footer -->
</body>
</html>