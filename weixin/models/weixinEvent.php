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

    protected function eventClick() {
        $eventKey = $this ->postObj ->EventKey;
        $content;
        $sql;
        $result;
        
        switch ($eventKey) {
            case 'V1001_MON': $content = '周一'; break;
            case 'V1001_TUE': $content = '周二'; break;
            case 'V1001_WED': $content = '周三'; break;
            case 'V1001_THU': $content = '周四'; break;
            case 'V1001_FRI': $content = '周五'; break;
                
            case 'V1002_201': $content = '专业必修'; break;
            case 'V1002_202': $content = '专业任意选修'; break;
            case 'V1002_203': $content = '公共选修'; break;

            case 'V1003_301':
                # code...
                break;

            case 'V1003_302':
                # code...
                break;

            case 'V1003_303':
                # code...
                break;

           
            default:
                # code...
                break;
        }
        $sql = "SELECT courseid, coursename, time, room, teacher, type, term FROM course WHERE description LIKE '%".$content."%' ;" ;
        $result = $this ->dbResult($sql);
        return $result;
        
    }

    //insert the event to db
    public function insertEvent(){
        //inset sql ;
        $type = strtolower($this ->event) == 'subscribe' ? 1 : 0;
        $sql = 'insert into '.$this->tableName."(subscribe, subscribe_time) values ('$type', '$this->createTime');" ;
        error_log($sql);
        return $this->dbResult($sql);
    }

    public function setTableName($tn){
        $this ->tableName = $tn;
    }

    public function getTableName(){
        return $this ->tableName;
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

protected function sdbResult($sql){
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
