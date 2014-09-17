<?php

/**
*@author winterswang
*完成微信基类的处理工作，xml信息存储，xml信息解析，事件存储等
*消息验证，绑定
*/

class WeixinController {

	private $TOKEN = 'weixin';
	private $postObj ;

	//构造方法
	public function __construct(){
		$this ->init();
	}

	//初始化方法
	private function init(){
		//验证通过再接入XML存储
		//$this ->valid();
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		//$postStr = '<xml><ToUserName><![CDATA[gh_6e55df1a2209]]></ToUserName><FromUserName><![CDATA[oNsk5uLjoXbpUf1Tqr8xs_trQ_9A]]></FromUserName><CreateTime>1409667870</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[CLICK]]></Event><EventKey><![CDATA[5672]]></EventKey></xml>';
		if (!empty($postStr)){
		    file_put_contents("/tmp/weixin_yingz.log", $postStr,FILE_APPEND);
		    $this ->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}else{
		    error_log('postStr is empty',3,'/tmp/classHelper.log');
		    return false;
		}
	}

	//获取微信事件类型
	public function getEventType(){

		$eventType = $this ->postObj ->Event;
		if (isset($eventType)) {
			return $eventType;
		}
		return false;
	}

	//获取微信消息类型
	public function getMsgType(){

	}

	//路由事件
	public function eventRoute($eventType){

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
				error_log('ON CLICK',3,'/tmp/classHelper.log');
				$this ->responseTextMsg('on click');
				//存储事件
				$this ->saveEvent();
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
	private function saveEvent(){
		echo 'time : '.$this ->postObj->createTime;
		$we = new wexinEvent($this ->postObj ->createTime,$this ->postObj ->fromUser,$this ->postObj ->toUser,$this ->postObj ->Event);
		$we ->insertEvent();
	}

	//回复消息
	private function responseTextMsg($contentStr){

        $fromUsername = $this ->postObj->FromUserName;
        $toUsername = $this ->postObj->ToUserName;
        $textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";
        $resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), 'text', $contentStr);
        echo $resultStr;

	}
	//绑定验证
    private function valid(){
    	if ($this ->checkSignature()) {
	        $echoStr = $_GET["echostr"];
	        if(isset($echoStr)){
		       echo $echoStr;
		       return false;
		    }
		    return true;
    	}
    	return false;
    }
    //签名验证
	private function checkSignature(){
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
}
?>