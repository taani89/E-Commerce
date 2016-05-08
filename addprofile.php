
<?php require_once('Connections/link_db.php'); ?>
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "profile")) {
  $insertSQL = sprintf("INSERT INTO personal (id, name, email, dob, mobile, address, landmark, zip, city, `state`, country) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['dob'], "date"),
                       GetSQLValueString($_POST['mobile'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['landmark'], "text"),
                       GetSQLValueString($_POST['zip'], "int"),
                       GetSQLValueString($_POST['city'], "text"),
                       GetSQLValueString($_POST['state'], "text"),
                       GetSQLValueString($_POST['country'], "text"));

  mysql_select_db($database_link_db, $link_db);
  $Result1 = mysql_query($insertSQL, $link_db) or die(mysql_error());

  $insertGoTo = "account.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
	$message = "Data have been added";
  }
  header(sprintf("Location: %s", $insertGoTo));
  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ADDRESS</title>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script src="jquery-mobile/jquery-1.6.4.min.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
</head>

<body>

<h1>FILL IN YOUR PROFILE INFORMATION IN THIS FORM</h1>
<form action="<?php echo $editFormAction; ?>" method="POST" name="profile">
  <p><span id="id">
    <label for="id3">ID: </label>
      <input type="text" name="id" id="id3" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
      <p><span id="email">
      <label for="email">Email: </label>
      <input name="email" type="text" id="email" value="" />
  <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
      <p><span id="sprytextfield3">
      <label for="name">Name: </label>
      <input type="text" name="name" id="name" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldMaxCharsMsg">Exceeded maximum number of characters.</span></span></p>
      <p><span id="sprytextfield4">
      <label for="mobile">Mobile:</label>
      <input type="text" name="mobile" id="mobile" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></p>
      <p><span id="sprytextfield5">
      <label for="dob">Date of Birth:</label>
      <input type="date" name="dob" id="dob" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
      <p><span id="sprytextfield7">
      <label for="address">Address:</label>
      <input name="address" type="text" id="address" value="" />
      <span class="textfieldRequiredMsg">A value is required.</span></span></p>
      <p><span id="sprytextfield8">
        <label for="landmark">Landmark:</label>
        <input type="text" name="landmark" id="landmark" />
</span>   </p>
      <p><span id="sprytextfield9">
      <label for="zip">ZIP CODE:</label>
      <input type="text" name="zip" id="zip" />
      <span class="textfieldRequiredMsg">A value is required.</span><span class="textfieldInvalidFormatMsg">Invalid format.</span></span></p>
      <p><span id="spryselect1">
        <label for="city">City:</label>
        <select name="city" id="city">
          <option>Alor Setar</option>
          <option>George Town</option>
          <option>Ipoh</option>
          <option>Bentung</option>
          <option>Shah Alam</option>
          <option>Johor Bahru</option>
          <option>Kuantan</option>
          <option>Kuala Terengganu</option>
          <option>Kota Baharu</option>
          <option>Kuching</option>
          <option>Serian</option>
          <option>Sri Aman</option>
          <option>Sibu</option>
          <option>Kapit</option>
          <option>Bintulu</option>
          <option>Miri</option>
          <option>Pensiangan</option>
          <option>Kota Kinabalu</option>
          <option>Sandakan</option>
          <option>Melaka</option>
          <option>Petaling Jaya</option>
          <option>Kangar</option>
          <option>Seremban</option>
          <option>Victoria</option>
        </select>
        <span class="selectRequiredMsg">Please select an item.</span></span></p>
      <p><span id="spryselect2">
        <label for="state">State:</label>
        <select name="state" id="state">
          <option>Kuala Lumpur</option>
          <option>Labuan</option>
          <option>Putrajaya</option>
          <option>Johor</option>
          <option>Kedah</option>
          <option>Kelantan</option>
          <option>Melaka</option>
          <option>Negeri Sembilan</option>
          <option>Pahang</option>
          <option>Perak</option>
          <option>Perlis</option>
          <option>Penang</option>
          <option>Sabah</option>
          <option>Sarawak</option>
          <option>Terengganu</option>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></p>
      <p><span id="spryselect3">
        <label for="country">Country:</label>
        <select name="country" id="country">
          <option>Malaysia</option>
        </select>
      <span class="selectRequiredMsg">Please select an item.</span></span></p>
  <p>&nbsp;
        <input type="submit" name="submit" id="submit" value="SAVE" />
        <input type="reset" name="Reset" id="button" value="RESET" />
  </p>
  <input type="hidden" name="MM_insert" value="profile" />
</form>

<script type="text/javascript">
var sprytextfield2 = new Spry.Widget.ValidationTextField("id", "social_security_number", {format:"ssn_custom", pattern:"SF000", useCharacterMasking:true, hint:"SF000", validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("email", "email", {validateOn:["change"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {maxChars:250, validateOn:["blur"]});
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "none", {hint:"+60123456789", validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "date", {format:"dd/mm/yyyy", hint:"dd/mm/yyyy", validateOn:["blur"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("id", "social_security_number", {format:"ssn_custom", validateOn:["blur"], useCharacterMasking:true, pattern:"SF000", hint:"SF000"});
var sprytextfield7 = new Spry.Widget.ValidationTextField("sprytextfield7", "none", {validateOn:["blur"]});
var sprytextfield8 = new Spry.Widget.ValidationTextField("sprytextfield8", "none", {isRequired:false});
var sprytextfield9 = new Spry.Widget.ValidationTextField("sprytextfield9", "zip_code", {format:"zip_custom", pattern:"00000", validateOn:["blur"], useCharacterMasking:true});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur"]});
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2", {validateOn:["blur"]});
var spryselect3 = new Spry.Widget.ValidationSelect("spryselect3");
</script>
</body>
</html>

