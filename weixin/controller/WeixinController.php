<?php

/**
*@author winterswang
*完成微信基类的处理工作，xml信息存储，xml信息解析，事件存储等
*消息验证，绑定
*/

class WeixinController {

	private $TOKEN = 'weixin';

	//绑定验证
    public function valid()
    {
    	if ($this ->checkSignature()) {
	        $echoStr = $_GET["echostr"];
	        if(isset($echoStr)){
		       echo $echoStr;
		       exit;
		    }
    	}
    }
    //签名验证
	private function checkSignature()
	{
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
		$token = $this ->TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );

		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}

	//获取微信事件类型
	private function getEventType(){
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$eventType = $postObj ->Event;
		if (isset($eventType)) {
			return $eventType;
		}
		return false;
	}

	//路由事件
	private function route($eventType, $postStr){

		if(!$eventType || !isset($postStr)){
			return false;
		}

		switch (strtoupper($eventType)) {
			//关注
			case 'SUBSCRIBE':

				break;
			//扫描二维码
			case 'SCAN':

				break;
			//地理位置
			case 'LOCATION':

				break;
			//菜单点击
			case 'CLICK':

				break;
			//菜单URL跳转
			case 'VIEW':

				break;
			//取消关注
			case 'UNSUBSCRIBE':

				break;
		}
	}

	//存储事件
	private function saveEvent($postStr){
		if(!isset($postStr)){
			error_log('postObj is empty');
			return false;
		}
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$we = new wexinEvent($postObj ->createTime,$postObj ->fromUser,$postObj ->toUser,$postObj ->Event);
		$we ->insertEvent();
	}
}
?>