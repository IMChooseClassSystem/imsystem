<?php
session_start();
include_once("dbconnection.php");
include("teacher_page_function.php");
if (isset($_GET['getOrderlist']) && $_GET['getOrderlist']) {
    $sql = "select C.* ,O.sequence,O.curriculum_ID,k.kind_name,ci.class_name from curriculum C , orderlist O ,kind_info k,class_info ci where C.ID = O.curriculum_ID and O.teacher_ID=" . $_SESSION["teacherID"] . " and k.kind_ID=C.kind and ci.kind_ID = C.kind and ci.class_ID = C.getyear order by O.sequence";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($result);
    $sql_remark = "select remark,over_class from orderlist_remark where teacher_ID = " . $_SESSION["teacherID"];
    $stmt = $conn->prepare($sql_remark);
    $stmt->execute();
    $result_remark = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $remark = "";
    $overClass = null;
    foreach ($result_remark as $row) {
        $remark = $row["remark"];
        $overClass = $row["over_class"];
    }
    orderlistTable($result, $remark, $overClass);
} else if (isset($_GET["classIDArray"])) {
    //每次儲存都清空
    $sql = "DELETE FROM orderlist WHERE teacher_ID =" . $_SESSION["teacherID"];
    //Prepare the SQL query.
    $statement = $conn->prepare($sql);
    //Execute the statement.
    $statement->execute();

    $sql = "INSERT INTO orderlist (teacher_ID,curriculum_ID,sequence) VALUES (?,?,?)";

    $stmt = $conn->prepare($sql);
    foreach ($_GET["classIDArray"] as $key => $value) {
        $stmt->execute([$_SESSION["teacherID"], $value["classID"], $value["sequence"]]);
    }
    //每次儲存都清空
    $sql = "DELETE FROM orderlist_remark WHERE teacher_ID =" . $_SESSION["teacherID"];
    //Prepare the SQL query.
    $statement = $conn->prepare($sql);
    //Execute the statement.
    $statement->execute();
    $sql = "Insert into orderlist_remark(remark,over_class,teacher_ID) values(?,?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$_GET["otherClass"], $_GET["overClass"], $_SESSION["teacherID"]]);
    echo json_encode(["classIDArray" => $_GET["classIDArray"], "remark" => $_GET["otherClass"]]);
    // print_r($_GET["classIDArray"], $_GET["otherClass"]);
}
function orderlistTable($result, $remark, $overClass)
{
    $str = "";
    $array = [];
    $class_UP = 0;
    $class_DN = 0;
    foreach ($result as $row) {
        $str .= "<tr onclick='trClick(this)'>";
        $str .= "<td><button type='button' class='btn btn-sm bg-transparent'><img src='pic/close.png' alt='Flower' onclick='deleteRow(this)'></button></td>";
        $str .= "<td>" . $row["sequence"] . "</td>";
        $str .= "<td>" . $row["course"] . "</td>";
        $str .= "<td>" . $row["outkind"] . "</td>";
        $str .= "<td>" . $row["kind_name"] . "</td>";
        $str .= "<td>" . $row["class_name"] . "</td>";
        $str .= "<td>" . $row["curriculum"] . "</td>";
        $str .= sem_credit_maker($row["kindyear"], $row["creditUP"], $row["creditDN"], $row["hourUP"], $row["hourDN"], $row["hourTUP"], $row["hourTDN"]);
        $str .= "</tr>";
        $class_UP = $row["creditUP"];
        $class_DN = $row["creditDN"];
        array_push($array, ["sequence" => $row["sequence"], "classID" => $row["curriculum_ID"], "classUp" => $class_UP, "classDn" => $class_DN]);
    }
    echo json_encode(["orderListTable" => $str, "classIDArray" => $array, "remark" => $remark, "overClass" => $overClass]);
}