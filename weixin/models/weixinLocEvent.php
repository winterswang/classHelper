<?php

require_once('weixinEvent.php');
class weixinLocEvent extends weixinEvent {

	protected $latitude;
	protected $longitude;


	//construct function
    function __construct($ct, $fu, $tu, $e, $lat, $long){
    	parent::__construct($ct, $fu, $tu, $e);
        
        $this ->latitude = $lat;
        $this ->longitude = $long;

        $this ->setTableName('location');
    }

	//insert the location to db
    public function insertLocation() {
	//$sql = 'insert into '.$this->tableName[strtolower($this ->event)]."(FromUserName, CreateTime, Location_X, Location_Y) values ('$this ->fromUser', '$this ->createTime', '11.1', '40.333');" ;
	$fu = $this ->fromUser;
	$t = $this ->createTime;
    $lat = $this ->latitude;
    $long = $this ->longitude;
        $sql = 'insert into '.$this ->tableName."(FromUserName, CreateTime, Location_X, Location_Y) values ('$fu', '$t', '$lat', '$long');" ;
        error_log($sql);
	
        return $this->dbResult($sql);
    }
}
?>