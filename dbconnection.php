<?php
//DB_Server, DB_Name, DB_Username, DB_Password	
try {
    $conn = new PDO("sqlsrv:Server=localhost;Database=IM_choose_class", "sa", "1qaz@WSX");
    if($conn)
        echo 'success<br>';
} catch (PDOException $e) {
    print "資料庫連接失敗，訊息:{$e -> getMessage()}<br/>";
    die();
}
?>