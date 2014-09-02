<?php
/**
* this is a test php script
* @author winterswang
*/

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/models/weixinEvent.php');
test();
/**
* @method test for insert into db
*/
function test(){
	//use of error_log function
	$we = new wexinEvent('1111','222','汉子行嘛？','subscribe');
	$we ->insertEvent();
	//echo $we->getCreateTime();
}
?>
