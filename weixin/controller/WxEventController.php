<?php
/**
* @author winterswang
* wxEventController
* 主要完成微信事件类的处理，包括，关注/取消关注 扫二维码 地理位置自动推送 菜单等
*/
class WxEventController extends WeixinController{

	protected $postObj; //微信消息XML对象
	protected $wxEventModel; //处理微信事件的模型层对象
	protected $course;
	//构造方法
	public function __construct($postObj){
		//model层的对象，是负责数据库交互的
		$this ->postObj = $postObj;
		$this ->wxEventModel = new weixinEvent($this ->postObj);
		$this ->courseModel = new Course();
	}
}
?>