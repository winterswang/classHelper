<?php

require_once('weixinEvent.php');
class weixinLocEvent extends weixinEvent {

	protected $latitude;
	protected $longitude;


	//construct function
    function __construct($ct, $fu, $tu, $e, $lat, $long){
    	parent::__construct($ct, $fu, $tu, $e);
        
        $this ->latitude = $lat;
        $this ->longitude = $long;

        $this ->setTableName('location');
    }

	//insert the location to db
    public function insertLocation() {
	//$sql = 'insert into '.$this->tableName[strtolower($this ->event)]."(FromUserName, CreateTime, Location_X, Location_Y) values ('$this ->fromUser', '$this ->createTime', '11.1', '40.333');" ;
    	$fu = $this ->fromUser;
    	$t = $this ->createTime;
        $lat = $this ->latitude;
        $long = $this ->longitude;
        $label = 'Location Event';
        
        $sql = 'insert into '.$this ->tableName."(FromUserName, CreateTime, Location_X, Location_Y, Label) values ('$fu', '$t', '$lat', '$long', '$label');" ;
        error_log($sql);
	
        return $this->dbResult($sql);
    }

    public function nearby() {

        $myLat = $this ->latitude;//接收到的当前位置的纬度  
        $myLng = $this ->longitude;//接收到的当前位置的经度  
        
        //以下为核心代码  
        $range = 180 / pi() * 1 / 6372.797;     //里面的 1 就代表搜索 1km 之内，单位km  
        $lngR = $range / cos($myLat * pi() / 180);  
        
        $maxLat = $myLat + $range;//最大纬度  
        $minLat = $myLat - $range;//最小纬度  
        $maxLng = $myLng + $lngR;//最大经度  
        $minLng = $myLng - $lngR;//最小经度  
        //得出这四个值以后，就可以根据你数据库里存的经纬度信息查找记录了~  
    }
}
?>