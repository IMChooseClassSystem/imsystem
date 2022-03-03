<?php
//
  $kind_sql = "SELECT * FROM kind_info";
  $kind_result = query_sql($conn, $kind_sql);
  

  $class_sql = "SELECT * FROM class_info WHERE kind_ID=";
  $class_result = query_sql($conn, $class_sql);

  
?>