<?php
class WeixinMsg {

private $paramArr;

    //construct function
    function __construct($po){
        //完成对象到数组的转化，这里是全数组。没值的设置为空字符串
       $this ->paramArr = array(
            'FromUserName' => isset($postObj ->FromUserName) ? $postObj ->FromUserName : '',
            'CreateTime' => isset($postObj ->CreateTime) ? $postObj ->CreateTime : '',
            'MsgType' => isset($postObj ->MsgType) ? $postObj ->MsgType : '',
            'Content' => isset($postObj ->Content) ? $postObj ->Content : '',
            'PicUrl' => isset($postObj ->PicUrl) ? $postObj ->PicUrl : '',
            'MediaId' => isset($postObj ->MediaId) ? $postObj ->MediaId : '',
            'MsgId' => isset($postObj ->MsgId) ? $postObj ->MsgId : '',
            'Format' => isset($postObj ->Format) ? $postObj ->Format : '',
            'Recognition' => isset($postObj ->Recognition) ? $postObj ->Recognition : '',
            'ThumbMediaId' => isset($postObj ->ThumbMediaId) ? $postObj ->ThumbMediaId : '',
            'Location_X' => isset($postObj ->Location_X) ? $postObj ->Location_X : '',
            'Location_Y' => isset($postObj ->Location_Y) ? $postObj ->Location_Y : '',
            'Scale' => isset($postObj ->Scale) ? $postObj ->Scale : '',
            'Label' => isset($postObj ->Label) ? $postObj ->Label : '',
            'Title' => isset($postObj ->Title) ? $postObj ->Title : '',
            'Description' => isset($postObj ->Description) ? $postObj ->Description : '',
            'Url' => isset($postObj ->Url) ? $postObj ->Url : '',
        );
    }

    //save the message to db
    public function saveMsg(){
        $param = $this ->paramArr;
        $sql = '';
        switch ($param['MsgType']) {
            case 'text':
                $sql = "insert into text (FromUserName, CreateTime, Content, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Content']."', '".$param['MsgId']."');" ;
                break;

            case 'image':
                $sql = "insert into image (FromUserName, CreateTime, PicUrl, MediaId, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['PicUrl']."', '".$param['MediaId']."', '".$param['MsgId']."');" ;
                break;

            case 'voice':
                $sql = "insert into voice (FromUserName, CreateTime, MediaId, Format, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['MediaId']."', '".$param['Format']."', '".$param['MsgId']."');" ;
                break;

            case 'video':
                $sql = "insert into  video (FromUserName, CreateTime, MediaId, ThumbMediaId, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['MediaId']."', '".$param['ThumbMediaId']."', '".$param['MsgId']."');" ;
                break;

            case 'location':
                $sql = "insert into location (FromUserName, CreateTime, Location_X, Location_Y, Scale, Label, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Location_X']."', '".$param['Location_Y']."', '".$param['Scale']."', '".$param['Label']."', '".$param['MsgId']."');" ;

                break;
            case 'link':
                $sql = "insert into link (FromUserName, CreateTime, Title, Description, Url, MsgId) values ('".$param['FromUserName']."', '".$param['CreateTime']."', '".$param['Title']."', '".$param['Description']."', '".$param['Url']."', '".$param['MsgId']."');" ;
                break;
        }
        return $this->dbResult($sql);
    }

    //执行db操作，返回结果
    private function dbResult($sql){
        error_log($sql);
        $con = mysql_connect("localhost","root","wanglong319");

        if(! $con){
            error_log('mysql connect failed');
            return false;
        }
        mysql_select_db("curriculum", $con);
        $re = mysql_query($sql);

        $num = mysql_num_rows($re);
        for ($i=0; $i < $num; $i++)
        {
            $row=mysql_fetch_row($re);
            $arr[$i] = $row;
        }

        $arr['num'] = $num;
        mysql_close($con);
        error_log('mysql operation successful');
        return $arr;
    }
}
?>
