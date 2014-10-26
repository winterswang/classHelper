<?php

/**
*@author winterswang
*完成微信基类的处理工作，xml信息存储，xml信息解析，事件存储等
*消息验证，绑定
*/

class WeixinController {

	protected $TOKEN = 'weixin';
	protected $postObj ;
	protected $statusCode = 1; //系统状态码

	//构造方法
	public function __construct(){
		//验证通过再接入XML存储
		//$this ->valid();
		$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
		//$postStr = '<xml><ToUserName><![CDATA[gh_6e55df1a2209]]></ToUserName><FromUserName><![CDATA[oNsk5uLjoXbpUf1Tqr8xs_trQ_9A]]></FromUserName><CreateTime>1409667870</CreateTime><MsgType><![CDATA[event]]></MsgType><Event><![CDATA[CLICK]]></Event><EventKey><![CDATA[5672]]></EventKey></xml>';
		if (isset($postStr))
		{
		    file_put_contents("/tmp/weixin_yingz.log", $postStr,FILE_APPEND);
		    $this ->postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		}
	}

	/**
	* run函数是入口函数，完成状态码的验证，分发消息到具体业务的controller中
	*/
	public function run(){

		$wxType = $this ->postObj ->msgType;
		if(isset($wxType)){
			$msgArr = array('text','voice','location');//消息类的具体类型
			if(in_array($msgArr, $wxType)){
				//说明类型是消息类型
				$msgController = new WxMsgController();
				$msgController ->run();
			}
			else if($wxType == 'event'){
				//说明类型是事件类型
				$eventController = new WxEventController();
				$eventController ->run();
			}
		}

		$this ->checkStatusCode();
	}

	/**
	* 对每一个数据流的结果，都标定一个状态码，最后打印出状态码对应的提示语
	*
	*
	*/
	protected function checkStatusCode(){
		if($this ->statusCode == 1){
			return ;
		}
		//TODO 待设计
		//$this ->responseTextMsg('errorMsg');
		exit();
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
