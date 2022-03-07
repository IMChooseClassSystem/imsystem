<?php
session_start();
include_once("dbconnection.php");
if (isset($_GET['getOrderlist']) && $_GET['getOrderlist']) {
    $sql = "select * from curriculum inner join orderlist on curriculum.ID = orderlist.curriculum_ID where orderlist.teacher_ID=" . $_SESSION["teacherID"] . " order by orderlist.sequence";
    $statement = $conn->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($result);
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
    print_r($_GET["classIDArray"]);
}