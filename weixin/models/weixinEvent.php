<?php
class wexinEvent {
private $dbname = '';//固定的DB name
private $tableName = array('subscribe' =>'userinfo','unsubscribe' => 'userinfo',''=>'');
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
