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
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Content, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]');" ;
                    break;
                case 'image':
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, PicUrl, MediaId, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]', '$param[4]');" ;
                    break;
                case 'voice':
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, MediaId, Format, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]', '$param[4]');" ;
                    break;
                case 'video':
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, MediaId, ThumbMediaId, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]', '$param[4]');" ;
                    break;
                case 'location':
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Location_X, Location_Y, Scale, Label, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]', '$param[4]', '$param[5]', '$param[6]');" ;
                    break;
                case 'link':
                    $sql = 'insert into '.$this ->type."(FromUserName, CreateTime, Title, Description, Url, MsgId) values ('$param[0]', '$param[1]', '$param[2]', '$param[3]', '$param[4]', '$param[5]');" ;
                    break;
            }
            error_log($sql);
            return $this->dbResult($sql);
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
