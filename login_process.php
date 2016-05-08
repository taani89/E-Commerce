<?PHP
 session_start();
 $username =$_POST['username'];
 $password =$_POST['password'];
 
 if ($username && $password)
 { // if 1
   
   $server='localhost';
   $userid2='root';
   $password2='';
   $dbname='shopper';

  $conn=mysql_connect("$server", "$userid2", "$password2");
   mysql_select_db("$dbname", $conn) or die(mysql_error()); 
   $query =  mysql_query("select username, password from registration where username = '$username'");
   
   $numrows = mysql_num_rows($query);
   
     if ($numrows !=0)
     { // if 2
   
   	     while ($row = mysql_fetch_assoc($query))
	    { // if 3
		$dbusername = $row['username'];
		$dbpassword = $row['password'];
	    } // if 3
	 
	      if ($username==$dbusername&&$password==$dbpassword)
	       {
		    //echo "You're in! <a href='header4.html'>click </a> here to enter";
		    $_SESSION['username']=$username;
			header( 'Location: account.php' ) ;
			echo " Welcome to member page";
		   }
	       else 
		      {echo " Incorrect Password!! <a href='login.php'> Click here to login </a>";}
	   } // if 2	
    else 
	  die (" That user dosen't exist");
	    
 } // if 1

  
  ?>
 