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


	//获取微信消息类型
	public function getMsgType(){

		$msgType = $this ->postObj ->MsgType;
		$eventType;
		
		
		if (isset($msgType)) {

			//获取微信事件类型
			if ($msgType == 'event') {
				$eventType = $this ->postObj ->Event;
				$this ->eventRoute($eventType);
				return $eventType;
			}
			else $this ->msgRoute($msgType);

			return $msgType;
		}
		return false;
	}

	//路由事件
	public function eventRoute($eventType){

		$api = new WxApiTools();
		$access_token = $api ->getAccessToken('wxbc46f36b6bd23611','96bdbea6d82db5c3a2349dac7e46bc72');
		
		switch (strtoupper($eventType)) {
			//关注
			case 'SUBSCRIBE':
<<<<<<< HEAD
=======
				$this ->responseTextMsg('Welcome to join us!');
				//存储用户信息
				$result = $api ->getUserInfo($this ->postObj ->FromUserName, $access_token);
				if (isset($result->errcode))
				
					$this ->responseTextMsg($result ->errmsg);
				else
					$this ->saveUsrInfo($result);	
>>>>>>> 3bf8803c25c83811138e15158924eeee1ac14073
				break;
			//扫描二维码
			case 'SCAN':

				break;
			//地理位置
			case 'LOCATION':
				//$this ->responseTextMsg('We will access your location data.');
				$this ->saveEvent();
				$this ->responseTextMsg('We will access your location data.');
				break;
			//菜单点击
			case 'CLICK':
				error_log('ON CLICK',3,'/tmp/classHelper.log');
				//存储事件
				$this ->saveEvent();
				$this ->responseTextMsg('on click');
				break;
			//菜单URL跳转
			case 'VIEW':

				break;
			//取消关注
			case 'UNSUBSCRIBE':

				break;
		}
	}
	//信息路由
	public function msgRoute($msgType){
		$result;
		$msgParam;
		$api = new WxApiTools();
		$access_token = $api ->getAccessToken('wxbc46f36b6bd23611','96bdbea6d82db5c3a2349dac7e46bc72');
		$ticket;
		$qrImg;
		switch (strtoupper($msgType)) {

			case 'TEXT':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->Content, 
						  $this ->postObj ->MsgId
						);
				break;
			
			case 'IMAGE':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->PicUrl, 
						  $this ->postObj ->MediaId, 
						  $this ->postObj ->MsgId
						);
				$ticket = $api ->getTicket($access_token, 2);
				if (isset($ticket)) {
					$qrImg = $api ->getQRImage($ticket, '1');
					$this ->responseTextMsg($ticket);
					$msgParam[2] = $qrImg;	
				}
				else
					$this ->responseTextMsg('Ticket is empty.');
				break;
			
			case 'VOICE':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->MediaId, 
						  $this ->postObj ->Format, 
						  $this ->postObj ->MsgId
						);
				
				break;
			
			case 'VIDEO':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->MediaId, 
						  $this ->postObj ->ThumbMediaId, 
						  $this ->postObj ->MsgId
						);

				break;
			
			case 'LOCATION':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->Location_X, 
						  $this ->postObj ->Location_Y, 
						  $this ->postObj ->Scale, 
						  $this ->postObj ->Label, 
						  $this ->postObj ->MsgId
						);

				break;
			
			case 'LINK':
				$msgParam = array($this ->postObj ->FromUserName, 
						  $this ->postObj ->CreateTime, 
						  $this ->postObj ->Title, 
						  $this ->postObj ->Description, 
						  $this ->postObj ->Url, 
						  $this ->postObj ->MsgId
						);
				
				break;
		}
		$this ->saveMsg($msgType, $msgParam);
		$this ->responseTextMsg($msgType." have saved ^^");
	}
	//存储事件
	private function saveEvent(){
<<<<<<< HEAD
		echo 'time : '.$this ->postObj->createTime;
		$we = new wexinEvent($this ->postObj ->createTime,$this ->postObj ->fromUser,$this ->postObj ->toUser,$this ->postObj ->Event);
		$we ->insertEvent();
=======
		$event = new weixinEvent($this ->postObj ->CreateTime,$this ->postObj ->FromUserName,$this ->postObj ->ToUserName, $this ->postObj ->Event);
		if ($this ->postObj ->Event == 'CLICK')
			$event ->insertEvent();
		else 
			$event ->insertLocation($this ->postObj ->Latitude, $this ->postObj ->Longitude);
	}

	private function saveMsg($t, $p){
		$msg = new weixinMsg($t, $p);
		$msg ->insertMsg();
	}

	private function saveUsrInfo($re){
		$info = new weixinUsr($re);
		$info ->insertInfo();
		$this ->responseTextMsg('saved');
>>>>>>> 3bf8803c25c83811138e15158924eeee1ac14073
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
