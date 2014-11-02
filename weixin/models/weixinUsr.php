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
            $tableName = "userinfo";

            $subscribe = $this ->usrInfo ->subscribe;
            $openid = $this ->usrInfo ->openid;
            $nickname = $this ->usrInfo ->nickname;
            $sex = $this ->usrInfo ->sex;
            $language = $this ->usrInfo ->language;
            $city = $this ->usrInfo ->city;
            $province = $this ->usrInfo ->province;
            $country = $this ->usrInfo ->country;
            $headimgurl = $this ->usrInfo ->headimgurl;
            $subscribe_time = $this ->usrInfo ->subscribe_time;
            $unionid = $this ->usrInfo ->unionid;

    	    $sql ='insert into '.$tableName. "(subscribe, openid, nickname, sex, language, city, province, country, headimgurl, subscribe_time, unionid) values ('$subscribe', '$openid', '$nickname', '$sex', '$language', '$city', '$province', '$country', '$headimgurl', '$subscribe_time', '$unionid');" ;
            
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

