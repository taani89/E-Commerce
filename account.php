<?php require_once('Connections/link_db.php'); ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "home.html";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "/Ecom/account.html";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
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

$maxRows_address = 10;
$pageNum_address = 0;
if (isset($_GET['pageNum_address'])) {
  $pageNum_address = $_GET['pageNum_address'];
}
$startRow_address = $pageNum_address * $maxRows_address;

$colname_address = "-1";
if (isset($_SESSION['username'])) {
  $colname_address = $_SESSION['username'];
}
mysql_select_db($database_link_db, $link_db);
$query_address = sprintf("SELECT * FROM address WHERE name = %s", GetSQLValueString($colname_address, "text"));
$query_limit_address = sprintf("%s LIMIT %d, %d", $query_address, $startRow_address, $maxRows_address);
$address = mysql_query($query_limit_address, $link_db) or die(mysql_error());
$row_address = mysql_fetch_assoc($address);

if (isset($_GET['totalRows_address'])) {
  $totalRows_address = $_GET['totalRows_address'];
} else {
  $all_address = mysql_query($query_address);
  $totalRows_address = mysql_num_rows($all_address);
}
$totalPages_address = ceil($totalRows_address/$maxRows_address)-1;

$maxRows_profile = 10;
$pageNum_profile = 0;
if (isset($_GET['pageNum_profile'])) {
  $pageNum_profile = $_GET['pageNum_profile'];
}
$startRow_profile = $pageNum_profile * $maxRows_profile;

mysql_select_db($database_link_db, $link_db);
$query_profile = "SELECT * FROM personal WHERE id = (SELECT id FROM personal WHERE id = '{$_SESSION['MM_Username']}' )ORDER BY id ASC";
$profile = mysql_query($query_profile, $link_db) or die(mysql_error());
$row_profile = mysql_fetch_assoc($profile);

if (isset($_GET['totalRows_profile'])) {
  $totalRows_profile = $_GET['totalRows_profile'];
} else {
  $all_profile = mysql_query($query_profile);
  $totalRows_profile = mysql_num_rows($all_profile);
}
$totalPages_profile = ceil($totalRows_profile/$maxRows_profile)-1;

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">

<script type="text/javascript">
<!--
function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}
//-->
</script>

  
<head>
	<title>SHOPPER FRIEND</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="css/images/favicon.ico" />
	<link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
	<style type="text/css">
	#apDiv1 {
	position: absolute;
	width: 294px;
	height: 81px;
	z-index: 1;
	left: 200px;
	top: 233px;
}
    #apDiv2 {
	position: absolute;
	width: 553px;
	height: 115px;
	z-index: 1;
	left: 202px;
	top: 388px;
	color: #333;
}
    </style>
	<link href="jquery-mobile/jquery.mobile.structure-1.0.min.css" rel="stylesheet" type="text/css" />
	<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	body {
	background-image: url(css/images/background-kuning.jpg);
}
    body,td,th {
	color: #033;
	text-align: left;
}
input {
font-family:Arial;
font-size:14px;
}
label{
font-family:Arial;
font-size:14px;
color:#999999;
}
.tblSaveForm {
border-top:2px #999999 solid;
background-color: #f8f8f8;
}
.tableheader {
background-color: #fedc4d;
}
.btnSubmit {
background-color:#fd9512;
padding:5px;
border-color:#FF6600;
border-radius:4px;
color:white;
}
.message {
color: #FF0000;
text-align: center;
width: 100%;
}
.txtField {
padding: 5px;
border:#fedc4d 1px solid;
border-radius:4px;
}
.required {
color: #FF0000;
font-size:11px;
font-weight:italic;
padding-left:10px;
}
    </style>
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="media" />
		<script src="js/png-fix.js" type="text/javascript" charset="utf-8"></script>
	<![endif]-->
	<script src="js/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery-func.js" type="text/javascript" charset="utf-8"></script>
	<script src="jquery-mobile/jquery.mobile-1.0.min.js" type="text/javascript"></script>
<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script>
function validatePassword() {
var currentpassword,newPassword,confirmPassword,output = true;

currentPassword = document.frmChange.currentPassword;
newPassword = document.frmChange.newPassword;
confirmPassword = document.frmChange.confirmPassword;

if(!currentPassword.value) {
	currentPassword.focus();
	document.getElementById("currentpassword").innerHTML = "required";
	output = false;
}
else if(!newPassword.value) {
	newPassword.focus();
	document.getElementById("newPassword").innerHTML = "required";
	output = false;
}
else if(!confirmPassword.value) {
	confirmPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "required";
	output = false;
}
if(newPassword.value != confirmPassword.value) {
	newPassword.value="";
	confirmPassword.value="";
	newPassword.focus();
	document.getElementById("confirmPassword").innerHTML = "not same";
	output = false;
} 	
return output;
}
</script>
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
				        <?php echo $_SESSION['MM_Username']; ?>!</li>
                        <li><a href="<?php echo $logoutAction ?>" target="_self">Log out</a></li>
					    
				      <li><a href="account.php" target="_self" title="My Account">My Account</a></li>
					   
					    <li class="nobg"><a href="view_cart.php" target="_self" class="bag" title="My Bag">My Bag</a></li>
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
					<h1 id="logo"><a href="home.php" class="notext" title="Shopper Friend">Shopper Friend</a></h1>
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
					

                  <p>&nbsp;</p>
                      <p>&nbsp;                      
  <div data-role="page" id="page">
                        <div data-role="header">
                        <table width="697">
                        <tr>
                        <td width="133"></td>
                        <td width="388">
                          <h1>&nbsp;</h1>
                          <h1>Your Account</h1>
                          </td>
                          </tr>  
                          <tr>
                          <td></td>
                          <td>                     
                             <p>&nbsp;</p>
                          <p>Where you can add profile into your personal account.<br />
                            And change your current password</p>
                            </td>
                           </tr> 
                        
                        </table>
                        <p>&nbsp;</p>
          </div>
                        <div data-role="content">Personal
                    </div>      
				<p><!-- End Slider -->
				  <!-- Content -->
			  </p>
				<div id="personal" class="CollapsiblePanel">
				  <div class="CollapsiblePanelTab" tabindex="0">Profile</div>
				  <div class="CollapsiblePanelContent">
				    <table width="575" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				        <td width="138"><img src="css/images/Profile-Icon.png" width="70" height="70" longdesc="css/images/Profile-Icon.png" /></td>
				        <td width="437"><h1>&nbsp;</h1>
				          <h1>&nbsp;</h1>
				          <h1>Profile</h1>
                            <p>&nbsp;</p>
			            <p>You can fill up some basic details such as your name, </p>
			            <p>e-mail ID and phone number on this page.Entering a billing address helps in smoother and faster check out.</p>
			            <p>&nbsp;</p>
			            <p>&nbsp;</p></td>
			          </tr>
                      <tr>
                      <td>&nbsp;</td>
                      <td>
                      <form>
                                <p>
			 					<input type="button" class="first" onclick="MM_openBrWindow('addprofile.php','ADDRESS','scrollbars=yes,width=480,height=640')" value="ADD NEW PROFILE" />
                        </p>
                      </form>
                      </td>
                      </tr>
                       
                     
			        </table>
				    <p>&nbsp;</p>
				    <p>
		
				  </div>
				  </div>
				<div id="content">
			      
				<!-- End Content -->
	  </div>
      </div>
			<!-- End Shell -->
</div>
</div>
		<!-- End Main -->
		<div id="footer-push" class="cl">&nbsp;</div>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
		<p>&nbsp;</p>
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
				    					    	<a href="aboutus.html" target="new" class="more-link" title="Read More">Read More >></a>

				    </li>
				    <li class="col social">
				    	<h4>get social</h4>
				    	<ul>
				    	    <li><a href="https://www.facebook.com/" target="new" class="fb-link" title="Facebook">facebook</a></li>
				    	    <li><a href="https://twitter.com/" target="new" class="twitter-link" title="Twitter">twitter</a></li>				    	   					 <li><a href="https://www.blogger.com/" target="new" class="blogger-link" title="Blogger">blogger</a></li>
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
<script type="text/javascript">
var CollapsiblePanel1 = new Spry.Widget.CollapsiblePanel("personal");
var CollapsiblePanel2 = new Spry.Widget.CollapsiblePanel("address");
</script>
</body>
</html>
<?php
mysql_free_result($profile);

mysql_free_result($address);

mysql_free_result($profile);
?>
