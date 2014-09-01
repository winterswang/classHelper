<?php
/**
* this is a test php script
* @author winterswang
*/

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/models/weixinEvent.php');
test();
function test(){
	//use of error_log function
	error_log(__METHOD__.' this is a test');
	$we = new wexinEvent('1111','222','xxx','333');
	$we ->insertEvent();
	//echo $we->getCreateTime();

}
?>