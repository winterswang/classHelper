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
        $event;

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
                $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Title, Description, Url, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Title']."', '".$param['Description']."', '".$param['Url']."', '".$param['MsgId']."');" ;
                break;
        }
        error_log($sql);
        return $this->dbResult_ins($sql);
    }

    public function voice() {
      $param = $this ->param;
      
      //description中包含了所有课程信息，包括模糊称呼
      $sql="SELECT courseid, coursename, time, room, teacher, type, term, description FROM course WHERE description LIKE '%".$param['Recognition']."%';" ;

      error_log($sql);
      $arr = $this ->dbResult($sql);
      return $arr;
    }

    //search
    public function search() {
      $param = $this ->param;
      //$sql="SELECT courseid, coursename, time, room, teacher, type, term, description FROM course WHERE courseid LIKE '%".$arr['Content']."%' or coursename LIKE '%".$arr['Content']."%' or room LIKE '%".$arr['Content']."%' or teacher LIKE '%".$arr['Content']."%'or type LIKE '%".$arr['Content']."%' or description LIKE '%".$arr['Content']."%';" ;
      
      //description中包含了所有课程信息，包括模糊称呼
      $sql="SELECT courseid, coursename, time, room, teacher, type, term, description FROM course WHERE description LIKE '%".$param['Content']."%';" ;

      error_log($sql);
      $arr = $this ->dbResult($sql);
      return $arr;
    }

    private function dbResult_ins($sql){
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
        error_log('mysql select successful');
        return $arr;
    }
}
?>
