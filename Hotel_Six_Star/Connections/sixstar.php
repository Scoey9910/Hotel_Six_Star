<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_sixstar = "localhost";
$database_sixstar = "sixstar";
$username_sixstar = "root";
$password_sixstar = "root";
$sixstar = mysql_pconnect($hostname_sixstar, $username_sixstar, $password_sixstar) or trigger_error(mysql_error(),E_USER_ERROR); 
?>