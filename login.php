<?php
session_start(); //啟動Session

require_once("dbconnection.php");

$msg="";
if(isset($_POST["account"]) && isset($_POST["password"])){

    $query_TeacherLogin = "SELECT ID,account, password, name FROM teacher_account WHERE account=:account";
    $stmt=$conn->prepare($query_TeacherLogin, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':account' => $_POST["account"]));
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    $account=$result["account"];
    $password=$result["password"];
    $name=$result["name"];
    $teacher_ID = $result["ID"];
    $stmt->db=null;

    if($account ==$_POST["account"] && $password == $_POST["password"]){
        $msg= $name.'老師您好，請稍後...';
        //伺服器get教師ID
        $_SESSION['teacherID']=$teacher_ID;
        header("Refresh:0;url=teacher_page.php");
       
    }elseif( $account ==$_POST["account"] && $password != $_POST["password"]){
        $msg='密碼不正確，五秒後自動導回登入畫面...';
        header("Refresh:5;url=login.html");
        
    }else{
        $msg='查無此帳號，請洽系辦人員，五秒後自動導回登入畫面...';
        header("Refresh:5;url=login.html");
    }
}
echo $msg; 

?>