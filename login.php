<?php
session_start(); //啟動Session

require_once("dbconnection.php");
$gotopage="login.html";
$msg="您已登出";
if(isset($_POST["account"]) && isset($_POST["password"])){

    $query_TeacherLogin = "SELECT * FROM teacher_account WHERE account=:account";
    $stmt=$conn->prepare($query_TeacherLogin, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
    $stmt->execute(array(':account' => $_POST["account"]));
    $result=$stmt->fetch(PDO::FETCH_ASSOC);
    if(!empty($result) && $result["password"] == $_POST["password"]){
        $account=$result["account"];
        $password=$result["password"];
        $name=$result["name"];
        $teacher_ID = $result["ID"];
        $permission=$result["permission"];    
        if ($permission==1){
            $msg= $name.'老師您好，請稍後...';
            $gotopage="teacher_page.php";
        }
            
        elseif($permission==0){
            $msg='轉換至網管頁面請稍後...';
            $gotopage="admin_page.php";
        }
            
        $_SESSION['teacherID']=$teacher_ID;
        $_SESSION['account']=$account;
        $_SESSION['password']=$password;
        $_SESSION['permission']=$permission;
        header("Refresh:0;url=".$gotopage);
    }
    else{
        $msg='查無此帳號或密碼不正確，三秒後自動導回登入畫面...';
        header("Refresh:3;url=login.html");
    }
}

if(isset($_POST["old_passwd"]) && isset($_POST["new_passwd"]) && isset($_POST["new_passwd_again"])){
    if($_POST["new_passwd"]!=$_POST["new_passwd_again"]){
        $msg='更改失敗，新密碼與再次確認新密碼不相符';
        header("Refresh:3;url=".$gotopage);
    }
    elseif($_POST["old_passwd"]!=$_SESSION["password"] ){
        $msg='更改失敗，輸入舊密碼錯誤';
        header("Refresh:3;url=".$gotopage);
    }
    else{
        try{
            $query_updatePwd="UPDATE teacher_account SET password=:password WHERE account=:account";
            $stmt=$conn->prepare($query_updatePwd);
            $stmt->execute(array(':account' => $_SESSION["account"], ':password' => $_POST["new_passwd"]));
            session_destroy();
            $msg='更改成功，三秒後自動導回登入畫面...';
            header("Refresh:3;url=login.html");
        } catch(Exception $e){
            echo 'Caught exception: ',  $e->getMessage(), "\n";
        }
    }
}
 
if (isset($_GET["logout"])){
    session_destroy();
    $msg='您已登出，三秒後自動導回登入畫面...';
    header("Refresh:0;url=login.html");
}
echo $msg;