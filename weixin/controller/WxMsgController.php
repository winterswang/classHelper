<?php
/**
* @author winterswang
* 消息类控制器
* 承担消息类业务的具体实现，包括文本消息，语音消息，地理位置消息
* 该类继承WeixinController，主要实现查询功能，信息流的存储功能
*/

class WxMsgController extends WeixinController {

	private $wxMsgModel;
	private $courseModel;
	//构造方法
	public function __construct($postObj){
		//model层的对象，是负责数据库交互的
		$this ->postObj = $postObj;
		$this ->wxMsgModel = new WeixinMsg($this ->postObj);
		$this ->courseModel = new Course();
	}

	/**
	* 消息controller的业务逻辑入口
	* 1.存储来源消息
	* 2.分发任务到不同的函数
	*/
	public function run(){
		//统一完成推送消息的存储
		$this ->wxMsgModel ->saveMsg();
		$fun = $this ->postObj ->MsgType.'Fun';
		$this ->$fun();
	}

	/**
	* 文本消息处理函数
	* 1.完成课程信息的查询
	*/
	private function textFun(){

		//根据文本信息 查询课程信息
		$result = $this ->courseModel ->search($this ->postObj ->Content);
		if ($result['num'] != 0 && $result['num'] != 36)
			$this ->responseNews($result);
		else {
			//表示课程查询无结果
			$this ->statusCode = 1004;
			$this ->responseTextMsg('查询无结果，请您确认是否输入正确。如果需要查询课程的话您最好输入与课程相关的信息，如课程名，课程序号，教师姓名，教室等等。');
		}
		return ;
	}

	/**
	* 音频信息处理函数
	*
	*/
	private function voiceFun(){

		$result = $this ->courseModel ->search($this ->postObj ->Recognition);
		//TODO 这里的36 是什么含义？？
		if ($result['num'] != 0 && $result['num'] != 36)
			$this ->responseNews($result);
		else {
			//表示课程查询无结果
			$this ->statusCode = 1004;
			$this ->responseTextMsg('查询无结果，请您确认是否输入正确。如果需要查询课程的话您最好输入与课程相关的信息，如课程名，课程序号，教师姓名，教室等等。');
		}
		return ;
	}

	/**
	* 地理位置信息处理函数
	*
	*/
	private function locationFun(){

		$this ->responseTextMsg($this ->postObj ->msgType." have saved ^^");
	}

	/**
	* 图像信息处理函数
	*
	*/
	private function imageFun(){

		$this ->responseTextMsg($this ->postObj ->msgType." have saved ^^");
	}

	/**
	* 链接信息处理函数
	*
	*/
	private function linkFun(){

		$this ->responseTextMsg($this ->postObj ->msgType." have saved ^^");
	}
}
?>