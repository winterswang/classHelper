<?php

require_once('weixinEvent.php');
date_default_timezone_set("PRC"); 

class weixinLocEvent extends weixinEvent {

	protected $latitude;
	protected $longitude;


	//construct function
    function __construct($ct, $fu, $e, $lat, $long){
    	parent::__construct($ct, $fu, $e);
        
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

        $wk_day;
        $WeekDay = '周';

        $myLat = (double)$this ->latitude;//接收到的当前位置的纬度  
        $myLng = (double)$this ->longitude;//接收到的当前位置的经度  
        
        //以下为核心代码  
        $range = 180 / pi() * 1 / 6372.797;     //里面的 1 就代表搜索 1km 之内，单位km  
        $lngR = $range / cos($myLat * pi() / 180);  
        
        $maxLat = $myLat + $range;//最大纬度  
        $minLat = $myLat - $range;//最小纬度  
        $maxLng = $myLng + $lngR;//最大经度  
        $minLng = $myLng - $lngR;//最小经度  
        //得出这四个值以后，就可以根据你数据库里存的经纬度信息查找记录了~  

        //得到当前为“周几”，从而获取当日课程
        $wk_day = date("w"); 
        $wkday_array = array("日","一","二","三","四","五","六");
        $WeekDay = $WeekDay.$wkday_array[$wk_day];


        //寻找1km范围内的教学楼
        $sql = "SELECT courseid, coursename, time, room, teacher, type, term FROM course WHERE latitude > '$minLat' and latitude < '$maxLat' and longitude > '$minLng' and longitude < '$maxLng' and time LIKE '%".$WeekDay."%' ;" ;
        $arr = $this ->dbResult($sql);//返回值为教学楼名称；

        $num = $arr['num'];

        error_log($sql);
        $result = $this ->dbResult($sql);

        //$result = array($myLat - $range, $myLat + $range, $minLng, $maxLng);
        //$result = array($range, $lngR);
        return $result;
    }

    protected function dbResult($sql){
        $con = mysql_connect("localhost","root","wanglong319");
        $num = 0;

        if(! $con){
            error_log('mysql connect failed');
            return false;
        }
        mysql_select_db("curriculum", $con);

        $re = mysql_query($sql);
        $num = mysql_num_rows($re);
        for ($i=0; $i < $num; $i++) { 
            # code...
            $row=mysql_fetch_row($re);
            $arr[$i] = $row;
        }
        
        $arr['num'] = $num;
        mysql_close($con);
        error_log('mysql insert successful');
        return $arr;
    }
}
?>