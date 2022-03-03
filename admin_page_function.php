<?php

  $kind_sql = "SELECT * FROM kind_info";
  $kind_result = query_sql($conn, $kind_sql);

  if (!empty($_GET["kind"])){
    $class_sql = "SELECT * FROM class_info WHERE kind_ID=".$_GET["kind"];
    $class_result = query_sql($conn, $class_sql);
  }


  
?>