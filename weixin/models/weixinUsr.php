<?php
class weixinUsr {

    private $usrInfo;

        //construct function
        function __construct($info){
            $this ->usrInfo = $info;
        }


        //insert the message to db
        public function insertInfo(){

            $sql;
            $info = $this ->usrInfo;
	    $type = "userinfo";

	    $sql ='insert into '.$type. "(subscribe, openid, nickname, sex, language, city) values ('".$info['subscribe']."', '".$info['openid']."', '".$info['nickname']."', '".$info['sex']."', '".$info['language']."', '".$info['city']."');" ;
/*
	    $sql ='insert into '.$type. "(subscribe, openid, nickname, sex, language, city) values ('$info ->subscribe', '$info ->openid', '$info ->nickname', '$info ->sex', '$info ->language', '$info ->city');" ;
*/
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

