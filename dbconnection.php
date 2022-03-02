<?php
/*
    $db_host="localhost";
    $db_user="root";
    $db_pwd="";
    $db_name="kindergarten";

    try{
        $db_link= new PDO("mysql:host={$db_host};dbname={$db_name};charset=utf8",$db_user,$db_pwd);
    }catch(PDOException $e){
        print "資料庫連接失敗，訊息:{$e -> getMessage()}<br/>";
        die();
    }
*/
?>

<?php
//DB_Server, DB_Name, DB_Username, DB_Password	
try {
    $conn = new PDO("sqlsrv:Server=localhost;Database=kindergarten", "sa", "1qaz@WSX");
    if($conn)
        echo 'success';
} catch (PDOException $e) {
    echo $e->getMessage();
}