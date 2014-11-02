<?php


/**
*@author winterswang
*思路还没有很清晰，这个类应该作为微信事件的基类，还分菜单事件，关注事件，扫描事件，再继续继承，DB操作需要封装，这只是demo
*/

class weixinEvent {

protected $postObj; 


    //construct function
    function __construct($po){

       $this ->postObj = $po;
    }

    public function eventRoute() {
        $eventType = $this ->postObj ->Event;
        $eventKey;
        $result;
        switch ($eventType) {
            case 'CLICK':
                $result = $this ->eventClick(); 
                $a = array('num' => 0);
                return $result;
        }
    }

    //insert the event to db
    public function saveWxEvent(){

    }
    //执行db操作，返回结果
    private function dbResult($sql){
        $con = mysql_connect("localhost","root","wanglong319");
        $num ;

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
        error_log($sql);
        error_log('mysql select successful');
        return $arr;
    }
}
?>
