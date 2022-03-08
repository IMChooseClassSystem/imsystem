<?php
include("dbconnection.php");
include("admin_page_function.php");

$sqlfilter = "";

if (empty($_GET["kind_value"]))
    $kind_id = 0;
else
    $kind_id = $_GET["kind_value"];

if (empty($_GET["class_value"]))
    $class_id = 0;
else
    $class_id = $_GET["class_value"];

if ($kind_id > 0 && $class_id > 0)
    $sqlfilter = " where kind= " . $_GET["kind_value"] . " and getyear= " . $_GET["class_value"];
elseif ($kind_id > 0)
    $sqlfilter = " where kind= " . $_GET["kind_value"];
else
    $sqlfilter = "";

if (empty($_GET["sort"]) || $_GET["sort"] == "false")
    $column = "kind, getyear, course, kindyear";
elseif ($_GET["sort"] == "kind_year")
    $column = "kindyear, creditUP";
else
    $column = $_GET["sort"];


if (empty($_GET["ascdesc"]) || $_GET["sort"] == "false")
    $asc_or_desc = "ASC";
else
    $asc_or_desc = $_GET["ascdesc"];


$query_page = "SELECT * FROM ( ";
$query_courseInformation = "SELECT distinct ROW_NUMBER() OVER (ORDER BY " . $column . " " . $asc_or_desc . " ) as ROW_ID, C.*, K.kind_name, CI.class_name, 
    stuff((
        SELECT ',' + Convert(varchar,T.name) + '(' + Convert(varchar,OA.sequence) + ') '
        FROM orderlist OA,teacher_account T
        WHERE OA.curriculum_ID = O.curriculum_ID and T.ID = OA.teacher_ID and OA.curriculum_ID = C.ID
        FOR XML PATH('')
        ),1,1,'') AS teacherList
    FROM curriculum C 
    LEFT JOIN orderlist O on C.ID = O.curriculum_ID 
    LEFT JOIN kind_info K ON C.kind= K.kind_ID 
    LEFT JOIN class_info CI ON C.getyear= CI.class_ID and C.kind=CI.kind_ID
    " . $sqlfilter . " GROUP BY C.curriculum, C.kind, C.outkind, C.getyear, C.course, C.kindyear, C.ID, C.creditUP, C.creditDN, C.hourUP, C.hourTUP, C.hourTDN, C.hourDN, CI.class_name, K.kind_name,	O.curriculum_ID
    ";
$stmt = $conn->prepare($query_courseInformation);
$stmt->execute();
//get 所有課程
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
//print_r($result);
//get 總筆數
$data_nums = $stmt->rowCount();
//print_r($result);
//設定分頁
$per = 25;
$pages = ceil($data_nums / $per);
if (!isset($_GET["page"])) { //假如$_GET["page"]未設置
    $page = 1; //則在此設定起始頁數
} else {
    $page = intval($_GET["page"]); //確認頁數只能夠是數值資料
}
$start = ($page - 1) * $per; //每一頁開始的資料序號
$end = $start + $per;
//每次撈25筆資料
$query_page .= $query_courseInformation . ' ) R WHERE ROW_ID>' . $start . ' and ROW_ID<=' . $end;
$stmt = $conn->prepare($query_page);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$kind_sql = "SELECT * FROM kind_info";
$kind_result = query_sql($conn, $kind_sql);

if (!empty($_GET["kind_value"])) {
    $class_sql = "SELECT * FROM class_info WHERE kind_ID=" . $_GET["kind_value"];
    $class_result = query_sql($conn, $class_sql);
}
    /*if(isset($_GET["sort"])){
        echo class_info_maker($result);
    }*/