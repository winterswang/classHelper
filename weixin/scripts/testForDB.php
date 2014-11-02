<?php
$dbhost  = 'localhost';    // Unlikely to require changing
$dbname  = 'curriculum';       // Modify these...
$dbuser  = 'root';   // ...variables according
$dbpass  = 'wanglong319';   // ...to your installation

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db($dbname) or die(mysql_error());
mysql_query("set names 'utf8'");

$sql = "select *from location where id = 24";
var_dump(queryMysql($sql));

// query sql to mysql
function queryMysql($query){
    $result = mysql_query($query) or die(mysql_error());
    return $result;
}
?>
