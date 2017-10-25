<!-- Web peking database -->


<?php

$dbhost="localhost";
$user="pekingco_jan";
$pass="pekingjan38";
$dbname="pekingco_data";

	function data_c($dbhost,$user,$pass,$dbname)
	{
	global $con;
	$con = mysql_connect($dbhost,$user,$pass);
	
		
		if (!$con)
		  {
		  die('Could not connect: ' . mysql_error());
		  }
				
		else {
			
				mysql_select_db($dbname, $con);
		mysql_query ("set character_set_results='utf8'"); 
		}
		
	
			
			
		
	}	
	
									
?>