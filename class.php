<?php
    include("dbconnection.php");
    $query_courseInformation = "SELECT * FROM curriculum";
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
    $query_courseInformation= $query_courseInformation.' where ID>'.$start.' and ID<='.$end;
    $stmt = $conn->prepare($query_courseInformation);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    
?>