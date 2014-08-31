<?php
class wexinEvent {
private $dbname = '';//固定的DB name
private $tableName = '';
private $createTime;//创建时间
private $fromUser;//来源openid
private $toUser;//目标openid
private $event;//事件类型

    //construct function 
    public __construct($ct, $fu, $tu, $e){
        $this ->$createTime = $ct;
        $this ->$fromUser = $fu;
        $this ->$toUser = $tu;
        $this ->$event = $e;
    }
    //insert the event to db 
    public function insertEvent(){
        //inset sql ;
        $sql = 'insert into'. $this->$dbname.'.'.$this->$tablename.'' ;
        return $this->dbResult($sql);
    }
    public function getCreateTime(){
        return $this->$createTime;
    }
    public function setCreateTime($createTime){
        $this->$createTime = $createTime;
    }
    //执行db操作，返回结果
    private function dbResult($sql){
    
    }
}
?>
