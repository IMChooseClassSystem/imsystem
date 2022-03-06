<?php
    include_once("dbconnection.php");
    if($_POST != null){
        $query_courseInformation = "SELECT * FROM curriculum where ID = ";
        $stmt = $conn->prepare($query_courseInformation);
        $stmt->execute();
        //get 所有課程
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
?>