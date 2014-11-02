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

	/**
	* run 是来具体实现wxEventController的业务的
	* 通过run函数，来完成业务的验证，分发
	*/
	public function run(){
		$wxEvent = $this ->postObj ->Event;
		if(isset($wxEvent)){
			$fun = $wxEvent.'Fun';
			$res = $this ->$fun();
		}
	}

	//关注
	private function subscribeFun(){

	}
	//取消关注
	private function unSubscribeFun(){

	}

	//扫描
	private function scanFun(){

	}

	//地理位置
	private function locationFun(){

	}

	//点击菜单 按照条件查询课程
	private function clickFun(){

        $eventKey = $this ->postObj ->EventKey;
        if (!isset($eventKey)) {
        	error_log('miss eventKey in '.__METHOD__);
        	return ;
        }

        //这里回来要好好设计，首先是一个key和value的对应菜单数组，最好是在配置文件中配置
        //1.方便更新菜单，2.方便在代码实现过程中可以自动更新菜单项

        $menuArr = array(
        	'V1001_MON' => '周一',
        	'V1001_TUE' => '周二',
        	'V1001_WED' => '周三',
        	'V1001_THU' => '周四',
        	'V1001_FRI' => '周五',
        	'V1002_201' => '专业必修',
        	'V1002_202' => '专业任意选修',
        	'V1002_203' => '公共选修',
        	);
        $content = $menuArr[$eventKey];
        $res = $this ->courseModel ->search($content);
        return $res;
	}

	//跳转网页
	private function viewFun(){

	}
}
?>