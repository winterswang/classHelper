<?php

/**
*@author winterswang
*思路还没有很清晰，这个类应该作为微信事件的基类，还分菜单事件，关注事件，扫描事件，再继续继承，DB操作需要封装，这只是demo
*/

class wexinEvent {
private $dbname = '';//固定的DB name
private $tableName = array('subscribe' =>'userinfo','unsubscribe' => 'userinfo','click' =>'userinfo');
private $createTime;//创建时间
private $fromUser;//来源openid
private $toUser;//目标openid
private $event;//事件类型

    //construct function
    function __construct($ct, $fu, $tu, $e){
        $this ->createTime = $ct;
        $this ->fromUser = $fu;
        $this ->toUser = $tu;
        $this ->event = $e;
    }
    //insert the event to db
    public function insertEvent(){
        //inset sql ;
        $type = strtolower($this ->event) == 'subscribe' ? 1 : 0;
        $sql = 'insert into '.$this->tableName[strtolower($this ->event)]."(subscribe,openid,subscribe_time) values ('$type','$this->toUser','$this->createTime');" ;
        error_log($sql);
        return $this->dbResult($sql);
    }

    //insert the menu event to db
    public function insertMenuEvent(){
        //
    }
    public function getCreateTime(){
        return $this->createTime;
    }
    public function setCreateTime($createTime){
        $this->createTime = $createTime;
    }
    //执行db操作，返回结果
    private function dbResult($sql){
        $con = mysql_connect("localhost","root","wanglong319");
        if(! $con){
            error_log('mysql connect failed');
            return false;
        }
        mysql_select_db("curriculum", $con);
        mysql_query($sql);
        mysql_close($con);
	    error_log('mysql insert successful');
        return true;
    }
}
?>
