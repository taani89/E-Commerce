<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_link_db = "localhost";
$database_link_db = "shopper";
$username_link_db = "root";
$password_link_db = "";
$link_db = mysql_pconnect($hostname_link_db, $username_link_db, $password_link_db) or trigger_error(mysql_error(),E_USER_ERROR); 
?>