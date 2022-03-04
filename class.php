<?php
    include("dbconnection.php");
    $sqlfilter="";

    if (empty($_GET["kind"]))
        $kind_id=0;
    else
        $kind_id=$_GET["kind"];
        
    if (empty($_GET["class"]))
        $class_id=0;
    else
        $class_id=$_GET["class"];

    if ($kind_id>0 && $class_id>0)
        $sqlfilter = " where kind= ".$_GET["kind"]. " and getyear= ".$_GET["class"];
    elseif ($kind_id>0)
        $sqlfilter = " where kind= ".$_GET["kind"];
    else 
        $sqlfilter="";
    
    


    $query_page ="SELECT * FROM ( ";
    $query_courseInformation = "SELECT ROW_NUMBER() OVER (ORDER BY kind, getyear, course, kindyear, creditDN) as ROW_ID ,C.*, K.kind_name FROM curriculum C LEFT JOIN kind_info K ON C.kind= K.kind_ID".$sqlfilter;
    $stmt = $conn->prepare($query_courseInformation);
    $stmt->execute();
    //get 所有課程
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //get 總筆數
    $data_nums = $stmt->rowCount();

    //設定分頁
    $per = 25;
    $pages = ceil($data_nums/$per);
    if (!isset($_GET["page"])){ //假如$_GET["page"]未設置
        $page=1; //則在此設定起始頁數
    } else {
        $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
    }
    $start = ($page-1)*$per; //每一頁開始的資料序號
    $end = $start+$per;
    //每次撈25筆資料
    $query_page= $query_page.$query_courseInformation.' ) R WHERE ROW_ID>'.$start.' and ROW_ID<='.$end;
    $stmt = $conn->prepare($query_page);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
  
?>