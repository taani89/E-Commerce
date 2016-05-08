<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
  include_once("link_db.php");

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

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>View shopping cart</title>
<link href="file:///C|/xampp/htdocs/shoppingcart/style/style.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="css/styleLaptops.css" type="text/css" media="all" />
    
	</script>
	<style type="text/css">
	body,td,th {
	color: #033;
}
    body {
	background-image: url(css/images/background-kuning.jpg);
}
    </style>
</head>
<body>
<div id="top">
			<!-- Shell -->
			<div class="shell">
				<div class="top-nav">
					<ul>
					    <li class="first nobg"><a href="home.php" target="_self">Welcome
				        <?php echo $_SESSION['MM_Username']; ?>!</a></li>
					    <li class="first nobg"><a href="<?php echo $logoutAction ?>" target="_self">Log out</a></li>
                                      <li></li>
					    <li><a href="account.php" target="_self" title="My Account">My Account</a></li>
					    <li class="nobg"><a href="view_cart.php"  target="_self" class="bag" title="My Bag">My Bag</a></li>
				  </ul>
			  </div>
				
				<div class="cl">&nbsp;</div>
		  </div>
			<!-- End Shell -->
</div>
        
        
<div id="products-wrapper">
 <h1>&nbsp;</h1>
 <h1>&nbsp;</h1>
 <h1>&nbsp;</h1>
 <h1>View Cart</h1>
 <h1>&nbsp;</h1>
 <p>Items in your shopping cart.</p>
 <h1>&nbsp;</h1>
 <h1>&nbsp;</h1>
 <div class="viewCart">
 	<?php
    $current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	if(isset($_SESSION["products"]))
    {
	    $total = 0;
		echo '<form  method="post" action="process.php">';
		echo '<ul>';
		$cart_items = 0;
		foreach ($_SESSION["products"] as $cart_itm)
        {
           $product_code = $cart_itm["code"];
		   $results = $mysqli->query("SELECT product_name,product_desc, price FROM products WHERE product_code='$product_code' LIMIT 1");
		 
		   $obj = $results->fetch_object();
		    echo '<table >';
			echo '<tr>';
			echo '<td>';
            echo '<div class="product-info">';
			echo '<h3>'.$obj->product_name.' (Code :'.$product_code.')</h3> ';
			echo '</td>';
			echo '<td>';
			echo '<li class="cart-itm">';
			echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>';
            echo '<div >'.$obj->product_desc.'</div>';
			echo '</td>';
			echo '<td>';
			echo '</td>';
			echo '</tr>';
			echo '<tr>';
			echo '<td>';
			echo '<div class="p-qty">Quantity : '.$cart_itm["qty"].'</div>';
			echo '</td>';
			echo '<td><div class="p-price">Product Price:'.$currency.$obj->price.'</div></td>';
			echo '</tr>';
            
			echo '</div>';
            echo '</li>';
			echo '<tr>';
						$subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
			$total = ($total + $subtotal);

			echo '<input type="hidden" name="item_name['.$cart_items.']" value="'.$obj->product_name.'" />';
			echo '<input type="hidden" name="item_code['.$cart_items.']" value="'.$product_code.'" />';
			echo '<input type="hidden" name="item_desc['.$cart_items.']" value="'.$obj->product_desc.'" />';
			echo '<input type="hidden" name="item_qty['.$cart_items.']" value="'.$cart_itm["qty"].'" />';
			$cart_items ++;
			
        }
    	echo '</ul>';
		echo '<span class="check-out-txt">';
		echo '<td>';
		echo '</td>';
		echo '<td><strong>Sub Total :'.$currency.$total.'</strong></td>  ';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo '</td>';
		echo '<td>';
		echo '<input type="image" src="css/images/candy_paypal_checkout.gif" alt="submit" />';
		echo '</td>';
		echo '</tr>';
		echo '<tr>';
		echo '<td>';
		echo '</td>';
		echo '<td>';
		echo '</td>';
		echo '</tr>';
		echo '</span>';
		echo '</form>';
		echo '</table>';
    }else{
		echo 'Your Cart is empty';
	}
	
    ?>
    
    </div>
    <a href="laptops.php" target="_self"><img src="css/images/btnContinueShopping.png" width="170" height="30" longdesc="css/images/btnContinueShopping.png"></a>
   
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p>&nbsp;</p>
 <p></p>


</div>
<div id="footer-push" class="cl">&nbsp;</div>
	
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
