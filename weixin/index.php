<?php
/**
* @author winterswang
* @version 0,1
* 新版的入口文件，存储xml信息，引入weixinController，处理推送事件信息，存入DB，简单回复消息给微信
*/
define('__ROOT__', dirname(dirname(__FILE__)));
require_once(__ROOT__.'/weixin/models/weixinEvent.php');
require_once(__ROOT__.'/weixin/models/weixinLoc.php');
require_once(__ROOT__.'/weixin/models/weixinMsg.php');
require_once(__ROOT__.'/weixin/models/weixinUsr.php');
require_once(__ROOT__.'/weixin/controller/WeixinController.php');
require_once(__ROOT__.'/weixin/util/WxApiTools.php');

//最新方法操作
$wc  = new WeixinController();
$msgType = $wc ->getMsgType();

//error_log(' msgType: '.$msgType .'eventType : '.$eventType,3,'/tmp/classHelper.log');

if(!$msgType){
    error_log('get type failed',3,'/tmp/classHelper.log');
    return false;
}
//$wc ->eventRoute($eventType);

?>
