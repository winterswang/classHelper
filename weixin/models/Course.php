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
}

?>