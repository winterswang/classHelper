<?php
/**
* this is a test php script
* @author winterswang
*/

define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/models/weixinEvent.php');
require_once(__ROOT__.'/controller/WeixinController.php');

//testWeixinEvent();

testWeixinController();
/**
* @method test for insert into db
*/
function testWeixinEvent(){
	//use of error_log function
	$we = new wexinEvent('1111','222','汉子行嘛？','subscribe');
	$we ->insertEvent();
	//echo $we->getCreateTime();
}

/**
*@method test WeixinController
*/
function testWeixinController(){

	$wc  = new WeixinController();
	$eventType = $wc ->getEventType();
	if(!$eventType){
		error_log('get event type failed',3,'/tmp/classHelper.log');
		return false;
	}

	$wc ->eventRoute($eventType);

}
?>
