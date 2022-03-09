<?php
include_once("dbconnection.php");
include("admin_page_function.php");

$sqlfilter = "";

if (isset($_GET["kind"]) && isset($_GET["class"])) {
    $kind_id = $_GET["kind"];
    $class_id = $_GET["class"];
    $sqlfilter = " where kind= " . $_GET["kind"] . " and getyear= " . $_GET["class"];
} elseif (isset($_GET["kind"])) {
    $kind_id = $_GET["kind"];
    $sqlfilter = " where kind= " . $_GET["kind"];
}

// if (empty($_GET["class_value"]))
//     $class_id = 0;
// else
//     $class_id = $_GET["class_value"];

// if ($kind_id > 0 && $class_id > 0)
//     $sqlfilter = " where kind= " . $_GET["kind_value"] . " and getyear= " . $_GET["class_value"];
// elseif ($kind_id > 0)
//     $sqlfilter = " where kind= " . $_GET["kind_value"];
// else
//     $sqlfilter = "";


$query_courseInformation = "SELECT * FROM ( 
    SELECT distinct ROW_NUMBER() OVER (ORDER BY C.ID DESC ) as ROW_ID, C.*, K.kind_name, CI.class_name FROM curriculum C 
    LEFT JOIN kind_info K ON C.kind= K.kind_ID LEFT JOIN class_info CI ON C.getyear= CI.class_ID and C.kind=CI.kind_ID " . $sqlfilter . "
    GROUP BY C.curriculum, C.kind, C.outkind, C.getyear, C.course, C.kindyear, C.ID, C.creditUP, C.creditDN, C.hourUP, C.hourTUP, C.hourTDN, C.hourDN, CI.class_name, K.kind_name ) R 
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
if (isset($_GET["changePage"])) { //假如$_GET["page"]未設置
    $page = intval($_GET["changePage"]); //確認頁數只能夠是數值資料
} else {
    $page = 1; //則在此設定起始頁數
}
$start = ($page - 1) * $per; //每一頁開始的資料序號
$end = $start + $per;
//每次撈25筆資料
$query_courseInformation .= "WHERE ROW_ID>" . $start . " and ROW_ID<=" . $end;
$stmt = $conn->prepare($query_courseInformation);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

$kind_sql = "SELECT * FROM kind_info";
$kind_result = query_sql($conn, $kind_sql);

if (!empty($_GET["kind_value"])) {
    $class_sql = "SELECT * FROM class_info WHERE kind_ID=" . $_GET["kind_value"];
    $class_result = query_sql($conn, $class_sql);
}
// if (isset($_GET["page"])) {
//     print_r(class_info_maker($result));
// }
$array = [];
if (isset($_GET["change"]) && $_GET["change"]) {
    echo json_encode(class_info_maker($result));
} elseif (isset($_GET["loadClassTable"])) {
    echo json_encode(class_info_maker($result));
}
if (isset($_GET["getPage"]) && $_GET["getPage"]) {
    print_r(page_makerByAjax($pages, 1));
} elseif (isset($_GET["CPage"]) && $_GET["CPage"]) {
    print_r(page_makerByAjax($pages, $_GET["changePage"]));
}
if (isset($_GET["kind"])) {
    echo json_encode(class_info_maker($result));
}