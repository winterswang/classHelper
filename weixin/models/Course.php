<?php

/**
* @author winterswang
* course数据表的模型层实现
*
*/
class Course {
    //search course
    public function search($content) {

      $sql = " SELECT courseid, coursename, time, room, teacher, type, term, description FROM course WHERE description LIKE '%".$content."%';" ;

      $arr = $this ->dbResult($sql);
      return $arr;
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