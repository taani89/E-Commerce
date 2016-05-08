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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html lang="en-US" xmlns="http://www.w3.org/1999/xhtml" dir="ltr">
<head>
	<title>SHOPPER FRIEND</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="shortcut icon" href="css/images/favicon.ico" />
    <link rel="stylesheet" href="css/styleLaptops.css" type="text/css" media="all" />
    <link href="css/styleCart.css" rel="stylesheet" type="text/css">
	<style type="text/css">
	body {
	background-image: url(css/images/background-kuning.jpg);
}
    body,td,th {
	color: #003;
}
    </style>
	<!--[if IE 6]>
		<link rel="stylesheet" href="css/ie6.css" type="text/css" media="media" />
		<script src="js/png-fix.js" type="text/javascript" charset="utf-8"></script>
	<![endif]-->
	<script src="js/jquery-1.6.2.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery.jcarousel.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="js/jquery-func.js" type="text/javascript" charset="utf-8"></script>	
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
				        <?php echo $_SESSION['MM_Username']; ?>!</a></li>
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
					<h1 id="logo"><a href="home.php" target="_self" class="notext" title="Shopper Friend">Shopper Friend</a></h1>
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
					    	<img src="css/images/21c5a54.jpg" alt="Slider Image 1" /></li>
						    <li>
						    	<img src="css/images/iphone-5-banner.jpg" alt="Slider Image 1" />
						    </li>
						    <li>
						    	<img src="css/images/Celcom_FIRST.png" alt="Slider Image 1" />
						    	
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
				<!-- Content -->
		<div id="products-wrapper">
    <h1>Products</h1>
    <div class="products">
    <?php
    //current URL of the Page. cart_update.php redirects back to this URL
	$current_url = base64_encode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
    
	$results = $mysqli->query("SELECT * FROM products WHERE product_code LIKE '%PIDS%' ORDER BY id ASC");
    if ($results) { 
	
        //fetch results set as object and output HTML
        while($obj = $results->fetch_object())
        {
			echo '<div class="product">'; 
            echo '<form method="post" action="cart_update.php">';
			echo '<div class="product-thumb"><img src="images/'.$obj->product_img_name.'"></div>';
            echo '<div class="product-content"><h3>'.$obj->product_name.'</h3>';
            echo '<div class="product-desc">'.$obj->product_desc.'</div>';
            echo '<div class="product-info">';
			echo 'Price '.$currency.$obj->price.' | ';
            echo 'Qty <input type="text" name="product_qty" value="1" size="3" />';
			echo '<button class="add_to_cart">Add To Cart</button>';
			echo '</div></div>';
            echo '<input type="hidden" name="product_code" value="'.$obj->product_code.'" />';
            echo '<input type="hidden" name="type" value="add" />';
			echo '<input type="hidden" name="return_url" value="'.$current_url.'" />';
            echo '</form>';
            echo '</div>';
        }
    
    }
    ?>
    </div>
    
<div class="shopping-cart">
<h2>Your Shopping Cart</h2>
<?php
if(isset($_SESSION["products"]))
{
    $total = 0;
    echo '<ol>';
    foreach ($_SESSION["products"] as $cart_itm)
    {
        echo '<li class="cart-itm">';
        echo '<span class="remove-itm"><a href="cart_update.php?removep='.$cart_itm["code"].'&return_url='.$current_url.'">&times;</a></span>';
        echo '<h3>'.$cart_itm["name"].'</h3>';
        echo '<div class="p-code">P code : '.$cart_itm["code"].'</div>';
        echo '<div class="p-qty">Qty : '.$cart_itm["qty"].'</div>';
        echo '<div class="p-price">Price :'.$currency.$cart_itm["price"].'</div>';
        echo '</li>';
        $subtotal = ($cart_itm["price"]*$cart_itm["qty"]);
        $total = ($total + $subtotal);
    }
    echo '</ol>';
    echo '<span class="check-out-txt"><strong>Total : '.$currency.$total.'</strong> <a href="view_cart.php">Check-out!</a></span>';
	echo '<span class="empty-cart"><a href="cart_update.php?emptycart=1&return_url='.$current_url.'">Empty Cart</a></span>';
}else{
    echo 'Your Cart is empty';
}
?>
</div>
    
</div>

                    <!-- End Case -->
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
<a href="aboutus.html" class="more-link" title="Read More" target="new">Read More >></a>				    </li>
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