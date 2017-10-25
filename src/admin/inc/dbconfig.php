<!-- database name:peking
username:admin
password:cosmonaut1 -->


<?php

$dbhost="localhost";
$user="admin";
$pass="test";
$dbname="peking";

	function data_c($dbhost,$user,$pass,$dbname)
	{
	global $con;
	$con = mysql_connect($dbhost,$user,$pass);
	
		
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
				
		
		
		mysql_select_db($dbname, $con);
			mysql_query ("set character_set_results='utf8'"); 
			
			
		
	}	
	
									
?>