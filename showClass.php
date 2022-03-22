<?php
include_once("dbconnection.php");
include("teacher_page_function.php");

$sqlfilter = "";

if (!empty($_GET["kind"]) && !empty($_GET["class"])) {
    $sqlfilter = " where kind= " . $_GET["kind"] . " and getyear= " . $_GET["class"];
    $class_sql = "SELECT * FROM class_info WHERE kind_ID=" . $_GET["kind"];
    $class_result = query_sql($conn, $class_sql);
} elseif (!empty($_GET["kind"])) {
    if ($_GET["kind"] != 0) {
        $sqlfilter = " where kind= " . $_GET["kind"];
        $class_sql = "SELECT * FROM class_info WHERE kind_ID=" . $_GET["kind"];
        $class_result = query_sql($conn, $class_sql);
    }
}

$query_courseInformation = "SELECT * FROM ( 
    SELECT distinct ROW_NUMBER() OVER (ORDER BY C.kind,C.getyear, C.kindyear, C.creditUP  DESC ) as ROW_ID, C.*, K.kind_name, CI.class_name FROM curriculum C 
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
if (isset($_GET["turnPage"])) { //假如$_GET["page"]未設置
    $page = intval($_GET["turnPage"]); //確認頁數只能夠是數值資料
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


// if (isset($_GET["page"])) {
//     print_r(class_info_maker($result));
// }
// $array = [];
// if (isset($_GET["change"]) && $_GET["change"]) {
//     echo json_encode(class_info_maker($result));
// } elseif (isset($_GET["loadClassTable"])) {
//     echo json_encode(class_info_maker($result));
// }
// if (isset($_GET["getPage"]) && $_GET["getPage"]) {
//     print_r(page_makerByAjax($pages, 1));
// } elseif (isset($_GET["CPage"]) && $_GET["CPage"]) {
//     print_r(page_makerByAjax($pages, $_GET["changePage"]));
// }
// if (isset($_GET["kind"])) {
//     echo json_encode(class_info_maker($result));
// }
$task = "";
if (isset($_GET["ajaxPost"])) {
    $task = $_GET["ajaxPost"];
}
switch ($task) {
    case 'pageLoading':
        # code...
        echo json_encode(["classTable" => class_info_maker($result), "pages" => page_makerByAjax($pages, $page)]);
        break;
    case "changePage":
        echo json_encode(["classTable" => class_info_maker($result), "pages" => page_makerByAjax($pages, $_GET["turnPage"])]);
        break;
    case "clickKind":
        if ($_GET["kind"] != 0) {
            echo json_encode(["classTable" => class_info_maker($result), "pages" => page_makerByAjax($pages, $page), "class" => changeClass($class_result,  0)]);
        } else {
            echo json_encode(["classTable" => class_info_maker($result), "pages" => page_makerByAjax($pages, $page), "class" => "<option value=0 selected>--</option>"]);
        }
        break;
    case "clickClass":
        echo json_encode(["classTable" => class_info_maker($result), "pages" => page_makerByAjax($pages, $page), "class" => changeClass($class_result,  $_GET["class"])]);
        break;
}