<?php
class weixinMsg {

private $type;
private $param;

    //construct function
    function __construct($msgType, $msgParam){
        $this ->type = $msgType;
        $this ->param = $msgParam;
    }


    //insert the message to db
    public function insertMsg(){

        $sql;
        $param = $this ->param;

        switch ($this ->type) {
            case 'text':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Content, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Content']."', '".$param['MsgId']."');" ;
                break;
            case 'image':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, PicUrl, MediaId, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['PicUrl']."', '".$param['MediaId']."', '".$param['MsgId']."');" ;
                break;
            case 'voice':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, MediaId, Format, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['MediaId']."', '".$param['Format']."', '".$param['MsgId']."');" ;
                break;
            case 'video':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, MediaId, ThumbMediaId, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['MediaId']."', '".$param['ThumbMediaId']."', '".$param['MsgId']."');" ;
                break;
            case 'location':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Location_X, Location_Y, Scale, Label, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Location_X']."', '".$param['Location_Y']."', '".$param['Scale']."', '".$param['Label']."', '".$param['MsgId']."');" ;
                break;
            case 'link':
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Title, Description, Url, MsgId) values ('".$param[0]."', '".$param[1]."', '".$param[2]."', '".$param[3]."', '".$param[4]."', '".$param[5]."');" ;
                break;
        }
        error_log($sql);
        return $this->dbResult($sql);
    }

    //search
    public function search() {
      $arr = $this ->param;
      $sql="SELECT courseid, coursename, time, room, teacher, type, term FROM course WHERE courseid LIKE '%".$arr['Content']."%' or coursename LIKE '%".$arr['Content']."%' or room LIKE '%".$arr['Content']."%' or teacher LIKE '%".$arr['Content']."%'";
      $arr = $this ->dbResult($sql);
      return $arr;
    }

    
    
    //执行db操作，返回结果
    private function dbResult($sql){
        $con = mysql_connect("localhost","root","wanglong319");
        $re;
        if(! $con){
            error_log('mysql connect failed');
            return false;
        }
        mysql_select_db("curriculum", $con);
        $re = mysql_query($sql);
        $row=mysql_fetch_row($re);
        mysql_close($con);
        error_log('mysql insert successful');
        return $row;
    }
}
?>
