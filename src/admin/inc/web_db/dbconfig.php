<!-- Web peking database -->


<?php
$dbhost = 'localhost';
$user = 'pekingco_jan';
$pass = 'pekingjan38';
$dbname = 'pekingco_data';

function data_c($dbhost, $user, $pass, $dbname)
{
    global $con;
    $con = mysql_connect($dbhost, $user, $pass);

    if (!$con) {
        error_log('DEPRECATED: Legacy mysql_ functions used. Database connection failed.');

        throw new Exception('Database connection failed. Please use modern Database class.');
    } else {
        mysql_select_db($dbname, $con);
        mysql_query("set character_set_results='utf8'");
    }
}

?>
