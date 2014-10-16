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
				$this ->eventOp($eventType);
				return $eventType;
			}
			else $this ->msgRoute($msgType);

			return $msgType;
		}
		return false;
	}

	//路由事件
	public function eventOp($eventType){

		$event;
		$msg;

		if ($eventType == 'LOCATION') 
			$this ->nearbyCourse();

		else {
			$event = new weixinEvent($this ->postObj);
			$msg = $event ->eventRoute();

			if ($msg['num']) {
				if ($msg['num'] > 10) $msg['num'] = 10;
				$this ->responseNews($msg);
			}
			else $this ->responseTextMsg('今日无课程。');

		}
		
	}
	//信息路由
	public function msgRoute($msgType){
		$result;
		$msgParam;
		$api = new WxApiTools();
		$access_token = $api ->getAccessToken('wxbc46f36b6bd23611','96bdbea6d82db5c3a2349dac7e46bc72');

		switch (strtoupper($msgType)) {

			case 'TEXT':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'Content' => $this ->postObj ->Content, 
						  			'MsgId' => $this ->postObj ->MsgId
								);
				$this ->searchCourse($msgType, $msgParam);
				break;
			
			case 'IMAGE':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'PicUrl' => $this ->postObj ->PicUrl, 
						  			'MediaId' => $this ->postObj ->MediaId, 
						  			'MsgId' => $this ->postObj ->MsgId
								);
				$this ->responseTextMsg($msgType." have saved ^^");
				break;
			
			case 'VOICE':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'MediaId' => $this ->postObj ->MediaId, 
						  			'Format' => $this ->postObj ->Format, 
						  			'MsgId' => $this ->postObj ->MsgId,
						  			'Recognition' => $this ->postObj ->Recognition
								);
				$this ->voiceCourse($msgType, $msgParam);
				break;
			
			case 'VIDEO':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'MediaId' => $this ->postObj ->MediaId, 
						  			'ThumbMediaId' => $this ->postObj ->ThumbMediaId, 
						  			'MsgId' => $this ->postObj ->MsgId
								);
				$this ->responseTextMsg($msgType." have saved ^^");
				break;
			
			case 'LOCATION':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'Location_X' => $this ->postObj ->Location_X, 
						  			'Location_Y' => $this ->postObj ->Location_Y, 
						  			'Scale' => $this ->postObj ->Scale, 
						  			'Label' => $this ->postObj ->Label, 
						  			'MsgId' => $this ->postObj ->MsgId
								);
				$this ->nearbyCourse($msgType, $msgParam);
				break;
			
			case 'LINK':
				$msgParam = array(	'FromUserName' => $this ->postObj ->FromUserName, 
								  	'CreateTime' => $this ->postObj ->CreateTime, 
						  			'Title' => $this ->postObj ->Title, 
						  			'Description' => $this ->postObj ->Description, 
						  			'Url' => $this ->postObj ->Url, 
						 			'MsgId' => $this ->postObj ->MsgId
								);
				$this ->responseTextMsg($msgType." have saved ^^");
				break;
		}
		
		
		$this ->saveMsg($msgType, $msgParam);
		//$this ->responseTextMsg($result);
		
	}
	//存储事件
	private function saveEvent(){

		$event;
		if ($this ->postObj ->Event == 'CLICK') {
			$event = new weixinEvent($this ->postObj ->CreateTime, $this ->postObj ->FromUserName, $this ->postObj ->Event, $this ->postObj ->EventKey);
			$event ->insertEvent();
		}
		else {
			$event = new weixinLocEvent($this ->postObj ->CreateTime, $this ->postObj ->FromUserName, $this ->postObj ->Event, $this ->postObj ->Latitude, $this ->postObj ->Longitude);
			$event ->insertLocation();
			$result = $event ->nearby();
			if ($result['num'])
				$this ->responseNews($result);
			else $this ->responseTextMsg('您附近今日无课程。');
		}
	}

	private function saveMsg($t, $p){
		$msg = new weixinMsg($t, $p);
		$msg ->insertMsg();
	}

	private function saveUsrInfo($re){
		$info = new weixinUsr($re);
		$info ->insertInfo();
	}

	private function voiceCourse($msgType, $msgParam) {

		$msgOp = new weixinMsg($msgType, $msgParam);
		$result = $msgOp ->voice();
		if ($result['num'] != 0 && $result['num'] != 36)
			$this ->responseNews($result);
		else $this ->responseTextMsg('语音识别暂时无法识别出您的搜索词。');
		//$this ->responseTextMsg($result['num']);
		
	}

	private function searchCourse($msgType, $msgParam) {

		$msgOp = new weixinMsg($msgType, $msgParam);
		$result = $msgOp ->search();
		if ($result['num'] != 0 && $result['num'] != 36)
			$this ->responseNews($result);
		else $this ->responseTextMsg('查询无结果，请您确认是否输入正确。如果需要查询课程的话您最好输入与课程相关的信息，如课程名，课程序号，教师姓名，教室等等。');
		//$this ->responseTextMsg($result['num']);
		
	}

	private function nearbyCourse() {

		$locOp = new weixinLoc($this ->postObj ->FromUserName, $this ->postObj ->CreateTime, $this ->postObj ->Latitude, $this ->postObj ->Longitude);
		$locOp ->insertLocation();
		$result = $locOp ->nearby();
		if ($result['num'])
			$this ->responseNews($result);
		else $this ->responseTextMsg('您附近今日无课程。');
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

	private function responseNews($contentStr){
			$num = $contentStr['num'];

        	$fromUsername = $this ->postObj->FromUserName;
        	$toUsername = $this ->postObj->ToUserName;
        	$str ;

        	$title = 'course';
			$purl = 'http://mmbiz.qpic.cn/mmbiz/Z9rgwVAyPI3DPUTgvJJOoYJsw519KIc05lYamyNpaxXDDuBcVPs9EA0MZqIbKJbFLrUlUNiaicjvjDZm0n6HpWXw/0';
			$url = 'www.baidu.com';

        	$textTpl = "<xml>
						<ToUserName><![CDATA[%s]]></ToUserName>
						<FromUserName><![CDATA[%s]]></FromUserName>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<ArticleCount>$num</ArticleCount>
						<Articles>
						";
			for ($i=0; $i < $num; $i++) { 
				# code...
				$row = $contentStr[$i];
				$str = $row[0]."\n".$row[1]."\n".$row[2]."\n".$row[3]."\n".$row[4]."\n".$row[5]."\n".$row[6];
				$textTpl = $textTpl."<item>
						<Title><![CDATA[$row[1],$row[4],$row[3]]]></Title> 
						<Description><![CDATA[$str]]></Description>
						<PicUrl><![CDATA[$purl]]></PicUrl>
						<Url><![CDATA[$url]]></Url>
						</item>
						";
						
			}
			$textTpl = $textTpl."</Articles>
						</xml> ";
			
			
        	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, time(), 'news');
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
